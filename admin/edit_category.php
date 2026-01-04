<?php
// Admin edit category
require_once '../includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$category = getCategoryById($id);

if (!$category) {
    header('Location: ?page=admin&action=categories');
    exit;
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    
    if (empty($name)) {
        $error = 'Category name is required.';
    } else {
        // Check if another category has the same name
        $categories = getAllCategories();
        $exists = false;
        foreach ($categories as $cat) {
            if ($cat['name'] === $name && $cat['id'] != $id) {
                $exists = true;
                break;
            }
        }
        
        if ($exists) {
            $error = 'A category with this name already exists.';
        } else {
            $data = [
                'name' => $name,
                'description' => $description
            ];
            
            if (updateCategory($id, $data)) {
                $message = 'Category updated successfully!';
                // Refresh the category data
                $category = getCategoryById($id);
            } else {
                $error = 'Error updating category.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category - <?php echo SITE_TITLE; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js"></script>
</head>
<body>
    <?php include '../pages/header.php'; ?>

    <main>
        <div class="admin-container">
            <div class="admin-header">
                <h1>Edit Category</h1>
                <a href="?page=admin&action=categories" class="admin-btn">Back to List</a>
            </div>
            
            <?php if ($message): ?>
                <div style="color: green; padding: 1rem; background: #d4edda; border-radius: 4px; margin: 1rem 0;"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div style="color: red; padding: 1rem; background: #f8d7da; border-radius: 4px; margin: 1rem 0;"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" class="admin-form">
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($category['description']); ?></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="submit-btn">Update Category</button>
                </div>
            </form>
        </div>
    </main>

    <?php include '../pages/footer.php'; ?>
</body>
</html>