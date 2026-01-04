<?php
// Main index file for the bookmarklet platform
require_once 'config.php';
require_once 'includes/functions.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch($page) {
    case 'home':
        include 'pages/home.php';
        break;
    case 'bookmarklet':
        include 'pages/bookmarklet.php';
        break;
    case 'category':
        include 'pages/category.php';
        break;
    case 'search':
        include 'pages/search.php';
        break;
    case 'install':
        include 'pages/install.php';
        break;
    case 'admin':
        include 'admin/index.php';
        break;
    case 'rate':
        include 'pages/rate.php';
        break;
    default:
        include 'pages/home.php';
        break;
}
?>