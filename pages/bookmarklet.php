<?php
// Individual bookmarklet page
require_once './includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$bookmarklet = getBookmarkletById($id);

if (!$bookmarklet) {
    header('Location: ?page=home');
    exit;
}

// Increment view count
incrementBookmarkletViews($id);

// Check if user has already rated this bookmarklet
$has_rated = hasRated($id, $_SERVER['REMOTE_ADDR']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($bookmarklet['title']); ?> - <?php echo SITE_TITLE; ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($bookmarklet['description']); ?>">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="bookmarklet-detail">
            <h1><?php echo htmlspecialchars($bookmarklet['title']); ?></h1>
            
            <div class="bookmarklet-stats">
                <div class="stat-item">
                    <span class="stat-value"><?php echo number_format($bookmarklet['rating'], 1); ?></span>
                    <span>Rating</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value"><?php echo $bookmarklet['views']; ?></span>
                    <span>Views</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value"><?php echo $bookmarklet['category']; ?></span>
                    <span>Category</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value"><?php echo $bookmarklet['published_date']; ?></span>
                    <span>Published</span>
                </div>
            </div>
            
            <?php echo generateStars($bookmarklet['rating'], $id, !$has_rated); ?>
            
            <div class="bookmarklet-description">
                <p><?php echo htmlspecialchars($bookmarklet['description']); ?></p>
            </div>
            
            <div class="bookmarklet-actions">
                <a href="<?php echo htmlspecialchars($bookmarklet['code']); ?>" class="install-btn" onclick="handleInstallClick(event); return false;" data-code="<?php echo htmlspecialchars($bookmarklet['code']); ?>">Install Bookmarklet</a>
                <div class="install-help">
                    <a href="?page=install">How do I install this?</a>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>