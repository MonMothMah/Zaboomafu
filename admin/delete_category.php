<?php
// Admin delete category
require_once '../includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    if (deleteCategory($id)) {
        $message = 'Category deleted successfully!';
    } else {
        $error = 'Error deleting category.';
    }
}

// Redirect back to categories list
header('Location: ?page=admin&action=categories');
exit;
?>