<?php
// Admin delete bookmarklet
require_once '../includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    if (deleteBookmarklet($id)) {
        $message = 'Bookmarklet deleted successfully!';
    } else {
        $error = 'Error deleting bookmarklet.';
    }
}

// Redirect back to bookmarklets list
header('Location: ?page=admin&action=bookmarklets');
exit;
?>