<?php
// Admin area for the bookmarklet platform
require_once '../includes/functions.php';

// Simple authentication system
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    // Check if login form was submitted
    if (isset($_POST['username']) && isset($_POST['password'])) {
        if ($_POST['username'] === ADMIN_USER && password_verify($_POST['password'], ADMIN_PASS)) {
            $_SESSION['admin_logged_in'] = true;
            header('Location: ?page=admin');
            exit;
        } else {
            $login_error = "Invalid username or password";
        }
    }
    
    // Show login form
    include 'login.php';
    exit;
}

// If logged in, show admin dashboard
$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

switch($action) {
    case 'dashboard':
        include 'dashboard.php';
        break;
    case 'bookmarklets':
        include 'bookmarklets.php';
        break;
    case 'add_bookmarklet':
        include 'add_bookmarklet.php';
        break;
    case 'edit_bookmarklet':
        include 'edit_bookmarklet.php';
        break;
    case 'delete_bookmarklet':
        include 'delete_bookmarklet.php';
        break;
    case 'categories':
        include 'categories.php';
        break;
    case 'add_category':
        include 'add_category.php';
        break;
    case 'edit_category':
        include 'edit_category.php';
        break;
    case 'delete_category':
        include 'delete_category.php';
        break;
    case 'settings':
        include 'settings.php';
        break;
    case 'logout':
        session_destroy();
        header('Location: ?page=admin');
        exit;
    default:
        include 'dashboard.php';
        break;
}
?>