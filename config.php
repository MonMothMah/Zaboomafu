<?php
// Configuration file for the bookmarklet platform

// Database configuration (flat file)
define('DATA_DIR', __DIR__ . '/data/');
define('BOOKMARKLETS_FILE', DATA_DIR . 'bookmarklets.json');
define('CATEGORIES_FILE', DATA_DIR . 'categories.json');
define('SETTINGS_FILE', DATA_DIR . 'settings.json');
define('USERS_FILE', DATA_DIR . 'users.json');

// Site settings
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
define('SITE_TITLE', 'Bookmarklet Hub');
define('SITE_DESCRIPTION', 'A collection of useful bookmarklets for web developers and power users');

// Create data directory if it doesn't exist
if (!is_dir(DATA_DIR)) {
    mkdir(DATA_DIR, 0755, true);
}

// Admin credentials (change these after installation)
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', password_hash('admin123', PASSWORD_DEFAULT)); // Change this to a strong password

// Initialize data files if they don't exist
$default_bookmarklets = [
    [
        'id' => 1,
        'title' => 'CSS Viewer',
        'description' => 'View the CSS classes and IDs of any element by hovering over it',
        'code' => 'javascript:(function(){var%20s=document.createElement(\'script\');s.src=\'https://cssviewer.s3.amazonaws.com/cssviewer.js\';document.body.appendChild(s);})();',
        'category' => 'Development',
        'rating' => 4.5,
        'views' => 1250,
        'published_date' => '2023-01-15',
        'last_updated' => '2023-09-20',
        'active' => true
    ],
    [
        'id' => 2,
        'title' => 'Image Downloader',
        'description' => 'Download all images from the current page with one click',
        'code' => 'javascript:(function(){var%20images=document.getElementsByTagName(\'img\');for(var%20i=0;i<images.length;i++){var%20link=document.createElement(\'a\');link.href=images[i].src;link.download=\'\';link.click();}})();',
        'category' => 'Utilities',
        'rating' => 4.2,
        'views' => 980,
        'published_date' => '2023-02-10',
        'last_updated' => '2023-08-15',
        'active' => true
    ],
    [
        'id' => 3,
        'title' => 'Text Only Mode',
        'description' => 'Remove all formatting and images to read text only',
        'code' => 'javascript:(function(){var%20styles=document.getElementsByTagName(\'style\');var%20links=document.getElementsByTagName(\'link\');for(var%20i=0;i<styles.length;i++){styles[i].parentNode.removeChild(styles[i]);}for(var%20i=0;i<links.length;i++){if(links[i].rel==\'stylesheet\'){links[i].parentNode.removeChild(links[i]);}}var%20images=document.getElementsByTagName(\'img\');while(images[0]){images[0].parentNode.removeChild(images[0]);}})();',
        'category' => 'Reading',
        'rating' => 4.0,
        'views' => 750,
        'published_date' => '2023-03-05',
        'last_updated' => '2023-07-22',
        'active' => true
    ]
];

$default_categories = [
    ['id' => 1, 'name' => 'Development', 'description' => 'Tools for web developers'],
    ['id' => 2, 'name' => 'Utilities', 'description' => 'General utility tools'],
    ['id' => 3, 'name' => 'Reading', 'description' => 'Tools to improve reading experience'],
    ['id' => 4, 'name' => 'Social', 'description' => 'Social media related tools'],
    ['id' => 5, 'name' => 'Productivity', 'description' => 'Tools to boost productivity']
];

$default_settings = [
    'site_title' => 'Bookmarklet Hub',
    'site_description' => 'A collection of useful bookmarklets for web developers and power users',
    'site_keywords' => 'bookmarklets, javascript, tools, utilities',
    'analytics_code' => '',
    'maintenance_mode' => false
];

if (!file_exists(BOOKMARKLETS_FILE)) {
    file_put_contents(BOOKMARKLETS_FILE, json_encode($default_bookmarklets, JSON_PRETTY_PRINT));
}

if (!file_exists(CATEGORIES_FILE)) {
    file_put_contents(CATEGORIES_FILE, json_encode($default_categories, JSON_PRETTY_PRINT));
}

if (!file_exists(SETTINGS_FILE)) {
    file_put_contents(SETTINGS_FILE, json_encode($default_settings, JSON_PRETTY_PRINT));
}

if (!file_exists(USERS_FILE)) {
    file_put_contents(USERS_FILE, json_encode([], JSON_PRETTY_PRINT));
}
?>