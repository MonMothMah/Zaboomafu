<?php
// Home page for the bookmarklet platform
require_once './includes/functions.php';

// Get top rated and most viewed bookmarklets
$top_rated = getTopRatedBookmarklets(5);
$most_viewed = getMostViewedBookmarklets(5);
$categories = getAllCategories();
$category_counts = getCategoryCounts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_TITLE; ?> - Collection of Useful Bookmarklets</title>
    <meta name="description" content="<?php echo SITE_DESCRIPTION; ?>">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/main.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <section class="hero">
        <h1>Discover Amazing Bookmarklets</h1>
        <p>Bookmarklets are tiny JavaScript programs stored as bookmarks in your browser. They can automate tasks, enhance web pages, and save you time. Explore our collection of useful tools!</p>
        <a href="?page=search" class="admin-btn">Browse All Bookmarklets</a>
    </section>

    <main>
        <section class="categories">
            <h2>Categories</h2>
            <?php foreach ($categories as $category): ?>
                <div class="category-card">
                    <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                    <p><?php echo htmlspecialchars($category['description']); ?></p>
                    <span class="category-count"><?php echo isset($category_counts[$category['name']]) ? $category_counts[$category['name']] : 0; ?> tools</span>
                    <a href="?page=category&name=<?php echo urlencode($category['name']); ?>" class="admin-btn" style="margin-top: 1rem; display: inline-block;">Browse</a>
                </div>
            <?php endforeach; ?>
        </section>

        <section class="featured-bookmarklets">
            <h2>Most Popular Tools</h2>
            <div class="bookmarklets-grid">
                <?php foreach ($most_viewed as $bookmarklet): ?>
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
        </section>

        <section class="featured-bookmarklets">
            <h2>Top Rated Tools</h2>
            <div class="bookmarklets-grid">
                <?php foreach ($top_rated as $bookmarklet): ?>
                    <div class="bookmarklet-card">
                        <div class="bookmarklet-header">
                            <h3><?php echo htmlspecialchars($bookmarklet['title']); ?></h3>
                            <div class="bookmarklet-meta">
                                <span>Rating: <?php echo $bookmarklet['rating']; ?>/5</span>
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
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>