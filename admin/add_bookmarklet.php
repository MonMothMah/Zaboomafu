<?php
// Admin add bookmarklet
require_once '../includes/functions.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $code = trim($_POST['code']);
    $category = trim($_POST['category']);
    $active = isset($_POST['active']) ? 1 : 0;
    
    if (empty($title) || empty($description) || empty($code) || empty($category)) {
        $error = 'All fields are required.';
    } else {
        $data = [
            'title' => $title,
            'description' => $description,
            'code' => $code,
            'category' => $category,
            'active' => $active
        ];
        
        $id = addBookmarklet($data);
        if ($id) {
            $message = 'Bookmarklet added successfully!';
            // Reset form
            $title = $description = $code = $category = '';
            $active = 1;
        } else {
            $error = 'Error adding bookmarklet.';
        }
    }
} else {
    // Set default values
    $title = $description = $code = $category = '';
    $active = 1;
}

$categories = getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bookmarklet - <?php echo SITE_TITLE; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js"></script>
</head>
<body>
    <?php include '../pages/header.php'; ?>

    <main>
        <div class="admin-container">
            <div class="admin-header">
                <h1>Add New Bookmarklet</h1>
                <a href="?page=admin&action=bookmarklets" class="admin-btn">Back to List</a>
            </div>
            
            <?php if ($message): ?>
                <div style="color: green; padding: 1rem; background: #d4edda; border-radius: 4px; margin: 1rem 0;"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div style="color: red; padding: 1rem; background: #f8d7da; border-radius: 4px; margin: 1rem 0;"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" class="admin-form">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="code">Bookmarklet Code</label>
                    <textarea id="code" name="code" placeholder="javascript:(function(){...})();" required><?php echo htmlspecialchars($code); ?></textarea>
                    <p style="font-size: 0.9em; color: #666; margin-top: 0.5rem;">Enter the full bookmarklet code starting with 'javascript:'</p>
                </div>
                
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat['name']); ?>" <?php echo ($category == $cat['name']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="active" value="1" <?php echo $active ? 'checked' : ''; ?>> Active
                    </label>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="submit-btn">Add Bookmarklet</button>
                </div>
            </form>
        </div>
    </main>

    <?php include '../pages/footer.php'; ?>
</body>
</html>