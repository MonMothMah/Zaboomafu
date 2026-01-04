<?php
// Admin bookmarklets management
require_once '../includes/functions.php';

$bookmarklets = getBookmarkletsForAdmin();
$categories = getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookmarklets - <?php echo SITE_TITLE; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js"></script>
</head>
<body>
    <?php include '../pages/header.php'; ?>

    <main>
        <div class="admin-container">
            <div class="admin-header">
                <h1>Manage Bookmarklets</h1>
                <a href="?page=admin&action=add_bookmarklet" class="admin-btn">Add New</a>
            </div>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Rating</th>
                        <th>Views</th>
                        <th>Published</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookmarklets as $bookmarklet): ?>
                        <tr>
                            <td><?php echo $bookmarklet['id']; ?></td>
                            <td><?php echo htmlspecialchars($bookmarklet['title']); ?></td>
                            <td><?php echo htmlspecialchars($bookmarklet['category']); ?></td>
                            <td><?php echo number_format($bookmarklet['rating'], 1); ?></td>
                            <td><?php echo $bookmarklet['views']; ?></td>
                            <td><?php echo $bookmarklet['published_date']; ?></td>
                            <td><?php echo $bookmarklet['active'] ? 'Active' : 'Inactive'; ?></td>
                            <td class="admin-table-actions">
                                <a href="?page=admin&action=edit_bookmarklet&id=<?php echo $bookmarklet['id']; ?>" class="edit-link">Edit</a>
                                <a href="?page=admin&action=delete_bookmarklet&id=<?php echo $bookmarklet['id']; ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this bookmarklet?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include '../pages/footer.php'; ?>
</body>
</html>