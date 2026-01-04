<?php
// How to install bookmarklets page
require_once '../includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How to Install Bookmarklets - <?php echo SITE_TITLE; ?></title>
    <meta name="description" content="Learn how to install bookmarklets in your browser">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="bookmarklet-detail">
            <h1>How to Install Bookmarklets</h1>
            
            <p>Bookmarklets are small JavaScript programs stored as bookmarks in your web browser. They can enhance your browsing experience by adding new functionality to web pages. Here's how to install them:</p>
            
            <h2>Method 1: Drag & Drop (Recommended)</h2>
            <ol>
                <li>Navigate to a bookmarklet page on our site</li>
                <li>Look for the "Install Bookmarklet" button</li>
                <li>Drag the button directly to your browser's bookmarks bar</li>
                <li>Release the mouse button to drop the bookmarklet</li>
                <li>You can now use the bookmarklet by clicking it from your bookmarks bar</li>
            </ol>
            
            <h2>Method 2: Manual Installation</h2>
            <ol>
                <li>Copy the JavaScript code provided with each bookmarklet</li>
                <li>Open your browser's bookmarks manager</li>
                <li>Create a new bookmark</li>
                <li>Paste the JavaScript code into the URL field</li>
                <li>Give it a descriptive name</li>
                <li>Save the bookmark</li>
            </ol>
            
            <h2>Browser-Specific Instructions</h2>
            <h3>Chrome</h3>
            <p>To show the bookmarks bar: Press Ctrl+Shift+B (Cmd+Shift+B on Mac) or go to View > Always show bookmarks bar.</p>
            
            <h3>Firefox</h3>
            <p>To show the bookmarks toolbar: Press Ctrl+Shift+B (Cmd+Shift+B on Mac) or go to View > Toolbars > Bookmarks Toolbar.</p>
            
            <h3>Safari</h3>
            <p>To show the bookmarks bar: Go to View > Show Bookmarks Bar.</p>
            
            <h3>Edge</h3>
            <p>To show the favorites bar: Press Ctrl+Shift+B (Cmd+Shift+B on Mac) or go to Settings > View favorites bar.</p>
            
            <h2>Using Bookmarklets</h2>
            <p>Once installed, bookmarklets can be used by simply clicking on them from your bookmarks bar. They will execute their JavaScript code on the current webpage, providing their specific functionality.</p>
            
            <h2>Troubleshooting</h2>
            <ul>
                <li>If a bookmarklet doesn't work, make sure JavaScript is enabled in your browser</li>
                <li>Some websites may block certain JavaScript functionality</li>
                <li>Bookmarklets may not work on HTTPS pages if they try to access HTTP resources</li>
                <li>Make sure the bookmarklet is properly saved with the "javascript:" prefix in the URL</li>
            </ul>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>