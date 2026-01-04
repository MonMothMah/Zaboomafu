<?php
// Category page
require_once './includes/functions.php';

$category_name = isset($_GET['name']) ? $_GET['name'] : '';
$bookmarklets = getBookmarkletsByCategory($category_name);

if (empty($category_name)) {
    header('Location: ?page=home');
    exit;
}

$category = getCategoryByName($category_name);
if (!$category) {
    header('Location: ?page=home');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category['name']); ?> - <?php echo SITE_TITLE; ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($category['description']); ?>">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <h1><?php echo htmlspecialchars($category['name']); ?></h1>
        <p><?php echo htmlspecialchars($category['description']); ?></p>
        
        <?php if (!empty($bookmarklets)): ?>
            <div class="bookmarklets-grid">
                <?php foreach ($bookmarklets as $bookmarklet): ?>
                    <div class="bookmarklet-card">
                        <div class="bookmarklet-header">
                            <h3><?php echo htmlspecialchars($bookmarklet['title']); ?></h3>
                            <div class="bookmarklet-meta">
                                <span>Views: <?php echo $bookmarklet['views']; ?></span>
                                <span>Rating: <?php echo number_format($bookmarklet['rating'], 1); ?>/5</span>
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
            <p>No bookmarklets found in this category.</p>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>