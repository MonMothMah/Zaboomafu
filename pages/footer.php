<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h3><?php echo SITE_TITLE; ?></h3>
            <p><?php echo SITE_DESCRIPTION; ?></p>
        </div>
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="?page=home">Home</a></li>
                <li><a href="?page=search">Browse Tools</a></li>
                <li><a href="?page=install">How to Install</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Categories</h3>
            <ul>
                <?php foreach (getAllCategories() as $category): ?>
                    <li><a href="?page=category&name=<?php echo urlencode($category['name']); ?>"><?php echo htmlspecialchars($category['name']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</footer>