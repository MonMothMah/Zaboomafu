<?php
// Admin edit bookmarklet
require_once '../includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$bookmarklet = getBookmarkletById($id);

if (!$bookmarklet) {
    header('Location: ?page=admin&action=bookmarklets');
    exit;
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $code = trim($_POST['code']);
    $category = trim($_POST['category']);
    $rating = trim($_POST['rating']);
    $active = isset($_POST['active']) ? 1 : 0;
    
    if (empty($title) || empty($description) || empty($code) || empty($category)) {
        $error = 'All fields are required.';
    } else {
        $data = [
            'title' => $title,
            'description' => $description,
            'code' => $code,
            'category' => $category,
            'rating' => $rating,
            'active' => $active
        ];
        
        if (updateBookmarklet($id, $data)) {
            $message = 'Bookmarklet updated successfully!';
            // Refresh the bookmarklet data
            $bookmarklet = getBookmarkletById($id);
        } else {
            $error = 'Error updating bookmarklet.';
        }
    }
}

$categories = getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bookmarklet - <?php echo SITE_TITLE; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js"></script>
</head>
<body>
    <?php include '../pages/header.php'; ?>

    <main>
        <div class="admin-container">
            <div class="admin-header">
                <h1>Edit Bookmarklet</h1>
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
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($bookmarklet['title']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($bookmarklet['description']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="code">Bookmarklet Code</label>
                    <textarea id="code" name="code" placeholder="javascript:(function(){...})();" required><?php echo htmlspecialchars($bookmarklet['code']); ?></textarea>
                    <p style="font-size: 0.9em; color: #666; margin-top: 0.5rem;">Enter the full bookmarklet code starting with 'javascript:'</p>
                </div>
                
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat['name']); ?>" <?php echo ($bookmarklet['category'] == $cat['name']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="rating">Rating (0-5)</label>
                    <input type="number" id="rating" name="rating" min="0" max="5" step="0.1" value="<?php echo $bookmarklet['rating']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="active" value="1" <?php echo $bookmarklet['active'] ? 'checked' : ''; ?>> Active
                    </label>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="submit-btn">Update Bookmarklet</button>
                </div>
            </form>
        </div>
    </main>

    <?php include '../pages/footer.php'; ?>
</body>
</html>