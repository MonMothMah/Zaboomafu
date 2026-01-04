<?php
// Search page
require_once './includes/functions.php';

$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'popular';

$bookmarklets = searchBookmarklets($query, $category, $sort);
$categories = getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - <?php echo SITE_TITLE; ?></title>
    <meta name="description" content="Search results for bookmarklets">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="search-section">
            <form class="search-form" method="GET">
                <input type="hidden" name="page" value="search">
                <input type="text" name="q" class="search-input" placeholder="Search bookmarklets..." value="<?php echo htmlspecialchars($query); ?>">
                
                <select name="category" class="filter-select filter-category">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat['name']); ?>" <?php echo ($category == $cat['name']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <select name="sort" class="filter-select filter-sort">
                    <option value="popular" <?php echo ($sort == 'popular') ? 'selected' : ''; ?>>Most Popular</option>
                    <option value="rating" <?php echo ($sort == 'rating') ? 'selected' : ''; ?>>Highest Rated</option>
                    <option value="newest" <?php echo ($sort == 'newest') ? 'selected' : ''; ?>>Newest</option>
                    <option value="updated" <?php echo ($sort == 'updated') ? 'selected' : ''; ?>>Recently Updated</option>
                    <option value="views" <?php echo ($sort == 'views') ? 'selected' : ''; ?>>Most Views</option>
                    <option value="alpha" <?php echo ($sort == 'alpha') ? 'selected' : ''; ?>>A-Z</option>
                </select>
                
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div>
        
        <h2>Search Results</h2>
        <?php if (!empty($bookmarklets)): ?>
            <p>Found <?php echo count($bookmarklets); ?> bookmarklet(s)</p>
            <div class="bookmarklets-grid">
                <?php foreach ($bookmarklets as $bookmarklet): ?>
                    <div class="bookmarklet-card">
                        <div class="bookmarklet-header">
                            <h3><?php echo htmlspecialchars($bookmarklet['title']); ?></h3>
                            <div class="bookmarklet-meta">
                                <span>Views: <?php echo $bookmarklet['views']; ?></span>
                                <span><?php echo $bookmarklet['category']; ?></span>
                            </div>
                            <?php echo generateStars($bookmarklet['rating']); ?>
                        </div>
                        <div class="bookmarklet-description">
                            <p><?php echo htmlspecialchars($bookmarklet['description']); ?></p>
                        </div>
                        <div class="bookmarklet-actions">
                            <a href="?page=bookmarklet&id=<?php echo $bookmarklet['id']; ?>" class="install-btn">View Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No bookmarklets found matching your search criteria.</p>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>