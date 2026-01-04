<?php
// Admin categories management
require_once '../includes/functions.php';

$categories = getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - <?php echo SITE_TITLE; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js"></script>
</head>
<body>
    <?php include '../pages/header.php'; ?>

    <main>
        <div class="admin-container">
            <div class="admin-header">
                <h1>Manage Categories</h1>
                <a href="?page=admin&action=add_category" class="admin-btn">Add New</a>
            </div>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo $category['id']; ?></td>
                            <td><?php echo htmlspecialchars($category['name']); ?></td>
                            <td><?php echo htmlspecialchars($category['description']); ?></td>
                            <td class="admin-table-actions">
                                <a href="?page=admin&action=edit_category&id=<?php echo $category['id']; ?>" class="edit-link">Edit</a>
                                <a href="?page=admin&action=delete_category&id=<?php echo $category['id']; ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this category? This will change all bookmarklets in this category to \'Uncategorized\'.')">Delete</a>
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