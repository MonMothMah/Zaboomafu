<?php
// Core functions for the bookmarklet platform

/**
 * Load bookmarklets from JSON file
 */
function loadBookmarklets() {
    if (!file_exists(BOOKMARKLETS_FILE)) {
        return [];
    }
    $data = file_get_contents(BOOKMARKLETS_FILE);
    return json_decode($data, true) ?: [];
}

/**
 * Save bookmarklets to JSON file
 */
function saveBookmarklets($bookmarklets) {
    return file_put_contents(BOOKMARKLETS_FILE, json_encode($bookmarklets, JSON_PRETTY_PRINT));
}

/**
 * Load categories from JSON file
 */
function loadCategories() {
    if (!file_exists(CATEGORIES_FILE)) {
        return [];
    }
    $data = file_get_contents(CATEGORIES_FILE);
    return json_decode($data, true) ?: [];
}

/**
 * Save categories to JSON file
 */
function saveCategories($categories) {
    return file_put_contents(CATEGORIES_FILE, json_encode($categories, JSON_PRETTY_PRINT));
}

/**
 * Load settings from JSON file
 */
function loadSettings() {
    if (!file_exists(SETTINGS_FILE)) {
        return [];
    }
    $data = file_get_contents(SETTINGS_FILE);
    return json_decode($data, true) ?: [];
}

/**
 * Save settings to JSON file
 */
function saveSettings($settings) {
    return file_put_contents(SETTINGS_FILE, json_encode($settings, JSON_PRETTY_PRINT));
}

/**
 * Get bookmarklet by ID
 */
function getBookmarkletById($id) {
    $bookmarklets = loadBookmarklets();
    foreach ($bookmarklets as $bookmarklet) {
        if ($bookmarklet['id'] == $id) {
            return $bookmarklet;
        }
    }
    return null;
}

/**
 * Get all active bookmarklets
 */
function getActiveBookmarklets() {
    $bookmarklets = loadBookmarklets();
    return array_filter($bookmarklets, function($b) {
        return $b['active'] === true;
    });
}

/**
 * Get bookmarklets by category
 */
function getBookmarkletsByCategory($category) {
    $bookmarklets = getActiveBookmarklets();
    return array_filter($bookmarklets, function($b) use ($category) {
        return $b['category'] == $category;
    });
}

/**
 * Get all categories
 */
function getAllCategories() {
    return loadCategories();
}

/**
 * Get category by ID
 */
function getCategoryById($id) {
    $categories = loadCategories();
    foreach ($categories as $category) {
        if ($category['id'] == $id) {
            return $category;
        }
    }
    return null;
}

/**
 * Get category by name
 */
function getCategoryByName($name) {
    $categories = loadCategories();
    foreach ($categories as $category) {
        if ($category['name'] == $name) {
            return $category;
        }
    }
    return null;
}

/**
 * Increment view count for a bookmarklet
 */
function incrementBookmarkletViews($id) {
    $bookmarklets = loadBookmarklets();
    foreach ($bookmarklets as &$bookmarklet) {
        if ($bookmarklet['id'] == $id) {
            $bookmarklet['views'] = isset($bookmarklet['views']) ? $bookmarklet['views'] + 1 : 1;
            $bookmarklet['last_updated'] = date('Y-m-d');
            saveBookmarklets($bookmarklets);
            break;
        }
    }
}

/**
 * Add or update rating for a bookmarklet
 */
function rateBookmarklet($id, $rating, $ip) {
    // Check if this IP has already rated this bookmarklet
    $ratings_file = DATA_DIR . 'ratings.json';
    $ratings = [];
    if (file_exists($ratings_file)) {
        $data = file_get_contents($ratings_file);
        $ratings = json_decode($data, true) ?: [];
    }
    
    $key = $id . '_' . $ip;
    if (isset($ratings[$key])) {
        return false; // Already rated
    }
    
    // Record the rating
    $ratings[$key] = [
        'bookmarklet_id' => $id,
        'rating' => $rating,
        'ip' => $ip,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    file_put_contents($ratings_file, json_encode($ratings, JSON_PRETTY_PRINT));
    
    // Update the average rating
    $bookmarklets = loadBookmarklets();
    $total_rating = 0;
    $count = 0;
    
    foreach ($ratings as $rating_record) {
        if ($rating_record['bookmarklet_id'] == $id) {
            $total_rating += $rating_record['rating'];
            $count++;
        }
    }
    
    if ($count > 0) {
        $avg_rating = $total_rating / $count;
        foreach ($bookmarklets as &$bookmarklet) {
            if ($bookmarklet['id'] == $id) {
                $bookmarklet['rating'] = round($avg_rating, 1);
                $bookmarklet['last_updated'] = date('Y-m-d');
                break;
            }
        }
        saveBookmarklets($bookmarklets);
    }
    
    return true;
}

/**
 * Check if IP has already rated a bookmarklet
 */
function hasRated($id, $ip) {
    $ratings_file = DATA_DIR . 'ratings.json';
    if (!file_exists($ratings_file)) {
        return false;
    }
    
    $data = file_get_contents($ratings_file);
    $ratings = json_decode($data, true) ?: [];
    
    $key = $id . '_' . $ip;
    return isset($ratings[$key]);
}

/**
 * Get top rated bookmarklets
 */
function getTopRatedBookmarklets($limit = 5) {
    $bookmarklets = getActiveBookmarklets();
    usort($bookmarklets, function($a, $b) {
        return $b['rating'] <=> $a['rating'];
    });
    return array_slice($bookmarklets, 0, $limit);
}

/**
 * Get most viewed bookmarklets
 */
function getMostViewedBookmarklets($limit = 5) {
    $bookmarklets = getActiveBookmarklets();
    usort($bookmarklets, function($a, $b) {
        return $b['views'] <=> $a['views'];
    });
    return array_slice($bookmarklets, 0, $limit);
}

/**
 * Search bookmarklets
 */
function searchBookmarklets($query, $category = null, $sort = 'popular') {
    $bookmarklets = getActiveBookmarklets();
    
    // Filter by search query
    if (!empty($query)) {
        $bookmarklets = array_filter($bookmarklets, function($b) use ($query) {
            return stripos($b['title'], $query) !== false || 
                   stripos($b['description'], $query) !== false;
        });
    }
    
    // Filter by category
    if (!empty($category)) {
        $bookmarklets = array_filter($bookmarklets, function($b) use ($category) {
            return $b['category'] == $category;
        });
    }
    
    // Sort results
    switch ($sort) {
        case 'rating':
            usort($bookmarklets, function($a, $b) {
                return $b['rating'] <=> $a['rating'];
            });
            break;
        case 'newest':
            usort($bookmarklets, function($a, $b) {
                return strtotime($b['published_date']) <=> strtotime($a['published_date']);
            });
            break;
        case 'updated':
            usort($bookmarklets, function($a, $b) {
                return strtotime($b['last_updated']) <=> strtotime($a['last_updated']);
            });
            break;
        case 'views':
            usort($bookmarklets, function($a, $b) {
                return $b['views'] <=> $a['views'];
            });
            break;
        case 'alpha':
            usort($bookmarklets, function($a, $b) {
                return strcasecmp($a['title'], $b['title']);
            });
            break;
        case 'popular':
        default:
            usort($bookmarklets, function($a, $b) {
                return ($b['views'] * $b['rating']) <=> ($a['views'] * $a['rating']);
            });
            break;
    }
    
    return $bookmarklets;
}

/**
 * Get bookmarklets for admin listing
 */
function getBookmarkletsForAdmin() {
    return loadBookmarklets();
}

/**
 * Add a new bookmarklet
 */
function addBookmarklet($data) {
    $bookmarklets = loadBookmarklets();
    $id = count($bookmarklets) > 0 ? max(array_column($bookmarklets, 'id')) + 1 : 1;
    
    $new_bookmarklet = [
        'id' => $id,
        'title' => $data['title'],
        'description' => $data['description'],
        'code' => $data['code'],
        'category' => $data['category'],
        'rating' => 0,
        'views' => 0,
        'published_date' => date('Y-m-d'),
        'last_updated' => date('Y-m-d'),
        'active' => isset($data['active']) ? (bool)$data['active'] : true
    ];
    
    $bookmarklets[] = $new_bookmarklet;
    saveBookmarklets($bookmarklets);
    return $id;
}

/**
 * Update a bookmarklet
 */
function updateBookmarklet($id, $data) {
    $bookmarklets = loadBookmarklets();
    
    foreach ($bookmarklets as &$bookmarklet) {
        if ($bookmarklet['id'] == $id) {
            $bookmarklet['title'] = $data['title'];
            $bookmarklet['description'] = $data['description'];
            $bookmarklet['code'] = $data['code'];
            $bookmarklet['category'] = $data['category'];
            $bookmarklet['active'] = isset($data['active']) ? (bool)$data['active'] : true;
            $bookmarklet['last_updated'] = date('Y-m-d');
            
            // Update rating if provided
            if (isset($data['rating'])) {
                $bookmarklet['rating'] = floatval($data['rating']);
            }
            
            saveBookmarklets($bookmarklets);
            return true;
        }
    }
    
    return false;
}

/**
 * Delete a bookmarklet
 */
function deleteBookmarklet($id) {
    $bookmarklets = loadBookmarklets();
    $bookmarklets = array_filter($bookmarklets, function($b) use ($id) {
        return $b['id'] != $id;
    });
    
    // Also remove ratings for this bookmarklet
    $ratings_file = DATA_DIR . 'ratings.json';
    if (file_exists($ratings_file)) {
        $data = file_get_contents($ratings_file);
        $ratings = json_decode($data, true) ?: [];
        
        $ratings = array_filter($ratings, function($r) use ($id) {
            return $r['bookmarklet_id'] != $id;
        });
        
        file_put_contents($ratings_file, json_encode($ratings, JSON_PRETTY_PRINT));
    }
    
    return saveBookmarklets($bookmarklets);
}

/**
 * Add a new category
 */
function addCategory($data) {
    $categories = loadCategories();
    $id = count($categories) > 0 ? max(array_column($categories, 'id')) + 1 : 1;
    
    $new_category = [
        'id' => $id,
        'name' => $data['name'],
        'description' => $data['description']
    ];
    
    $categories[] = $new_category;
    return saveCategories($categories);
}

/**
 * Update a category
 */
function updateCategory($id, $data) {
    $categories = loadCategories();
    
    foreach ($categories as &$category) {
        if ($category['id'] == $id) {
            $category['name'] = $data['name'];
            $category['description'] = $data['description'];
            return saveCategories($categories);
        }
    }
    
    return false;
}

/**
 * Delete a category
 */
function deleteCategory($id) {
    $categories = loadCategories();
    $categories = array_filter($categories, function($c) use ($id) {
        return $c['id'] != $id;
    });
    
    // Update all bookmarklets that used this category
    $bookmarklets = loadBookmarklets();
    foreach ($bookmarklets as &$bookmarklet) {
        if ($bookmarklet['category_id'] == $id) {
            $bookmarklet['category'] = 'Uncategorized'; // Default fallback
        }
    }
    saveBookmarklets($bookmarklets);
    
    return saveCategories($categories);
}

/**
 * Get all bookmarklets in a category with count
 */
function getCategoryCounts() {
    $bookmarklets = getActiveBookmarklets();
    $counts = [];
    
    foreach ($bookmarklets as $bookmarklet) {
        $cat = $bookmarklet['category'];
        if (!isset($counts[$cat])) {
            $counts[$cat] = 0;
        }
        $counts[$cat]++;
    }
    
    return $counts;
}

/**
 * Generate star rating HTML
 */
function generateStars($rating, $id = null, $allowRating = false) {
    $full_stars = floor($rating);
    $half_star = ($rating - $full_stars) >= 0.5;
    $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
    
    $html = '<div class="rating-stars">';
    
    // Full stars
    for ($i = 0; $i < $full_stars; $i++) {
        $html .= '<span class="star full">★</span>';
    }
    
    // Half star
    if ($half_star) {
        $html .= '<span class="star half">★</span>';
    }
    
    // Empty stars
    for ($i = 0; $i < $empty_stars; $i++) {
        $html .= '<span class="star empty">★</span>';
    }
    
    $html .= ' <span class="rating-value">' . number_format($rating, 1) . '</span>';
    
    if ($allowRating && $id) {
        $html .= '<div class="rating-form" data-id="' . $id . '">';
        for ($i = 1; $i <= 5; $i++) {
            $html .= '<span class="star-option" data-rating="' . $i . '">' . ($i <= $rating ? '★' : '☆') . '</span>';
        }
        $html .= '</div>';
    }
    
    $html .= '</div>';
    
    return $html;
}
?>