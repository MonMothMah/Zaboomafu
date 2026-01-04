<?php
// Admin site settings
require_once '../includes/functions.php';

$settings = loadSettings();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_title = trim($_POST['site_title']);
    $site_description = trim($_POST['site_description']);
    $site_keywords = trim($_POST['site_keywords']);
    $analytics_code = trim($_POST['analytics_code']);
    $maintenance_mode = isset($_POST['maintenance_mode']) ? 1 : 0;
    
    if (empty($site_title)) {
        $error = 'Site title is required.';
    } else {
        $new_settings = [
            'site_title' => $site_title,
            'site_description' => $site_description,
            'site_keywords' => $site_keywords,
            'analytics_code' => $analytics_code,
            'maintenance_mode' => $maintenance_mode
        ];
        
        if (saveSettings($new_settings)) {
            $message = 'Settings updated successfully!';
            $settings = $new_settings; // Update local variable
        } else {
            $error = 'Error saving settings.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Settings - <?php echo SITE_TITLE; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js"></script>
</head>
<body>
    <?php include '../pages/header.php'; ?>

    <main>
        <div class="admin-container">
            <div class="admin-header">
                <h1>Site Settings</h1>
                <a href="?page=admin&action=dashboard" class="admin-btn">Back to Dashboard</a>
            </div>
            
            <?php if ($message): ?>
                <div style="color: green; padding: 1rem; background: #d4edda; border-radius: 4px; margin: 1rem 0;"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div style="color: red; padding: 1rem; background: #f8d7da; border-radius: 4px; margin: 1rem 0;"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" class="admin-form">
                <div class="form-group">
                    <label for="site_title">Site Title</label>
                    <input type="text" id="site_title" name="site_title" value="<?php echo htmlspecialchars($settings['site_title'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="site_description">Site Description</label>
                    <textarea id="site_description" name="site_description"><?php echo htmlspecialchars($settings['site_description'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="site_keywords">Site Keywords (comma separated)</label>
                    <input type="text" id="site_keywords" name="site_keywords" value="<?php echo htmlspecialchars($settings['site_keywords'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="analytics_code">Analytics Code (if using Google Analytics or similar)</label>
                    <textarea id="analytics_code" name="analytics_code"><?php echo htmlspecialchars($settings['analytics_code'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="maintenance_mode" value="1" <?php echo ($settings['maintenance_mode'] ?? 0) ? 'checked' : ''; ?>> Maintenance Mode
                    </label>
                    <p style="font-size: 0.9em; color: #666; margin-top: 0.5rem;">When enabled, only admin users will be able to access the site</p>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="submit-btn">Save Settings</button>
                </div>
            </form>
        </div>
    </main>

    <?php include '../pages/footer.php'; ?>
</body>
</html>