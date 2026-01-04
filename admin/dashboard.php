<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo SITE_TITLE; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js"></script>
</head>
<body>
    <?php include '../pages/header.php'; ?>

    <main>
        <div class="admin-container">
            <div class="admin-header">
                <h1>Admin Dashboard</h1>
                <a href="?page=admin&action=logout" class="admin-btn">Logout</a>
            </div>
            
            <div class="admin-content">
                <h2>Quick Stats</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin: 1rem 0;">
                    <div style="background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
                        <h3>Total Bookmarklets</h3>
                        <p style="font-size: 2rem; font-weight: bold; color: #667eea;"><?php echo count(getActiveBookmarklets()); ?></p>
                    </div>
                    <div style="background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
                        <h3>Total Categories</h3>
                        <p style="font-size: 2rem; font-weight: bold; color: #667eea;"><?php echo count(getAllCategories()); ?></p>
                    </div>
                    <div style="background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
                        <h3>Total Views</h3>
                        <p style="font-size: 2rem; font-weight: bold; color: #667eea;"><?php 
                            $total_views = array_sum(array_column(getActiveBookmarklets(), 'views')); 
                            echo number_format($total_views); 
                        ?></p>
                    </div>
                </div>
                
                <h2>Quick Actions</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin: 1rem 0;">
                    <a href="?page=admin&action=bookmarklets" class="admin-btn" style="text-align: center; padding: 1.5rem; display: block;">Manage Bookmarklets</a>
                    <a href="?page=admin&action=categories" class="admin-btn" style="text-align: center; padding: 1.5rem; display: block;">Manage Categories</a>
                    <a href="?page=admin&action=settings" class="admin-btn" style="text-align: center; padding: 1.5rem; display: block;">Site Settings</a>
                </div>
            </div>
        </div>
    </main>

    <?php include '../pages/footer.php'; ?>
</body>
</html>