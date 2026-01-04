<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?php echo SITE_TITLE; ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../pages/header.php'; ?>

    <main>
        <div class="login-container">
            <h2>Admin Login</h2>
            <?php if (isset($login_error)): ?>
                <p style="color: red; text-align: center;"><?php echo $login_error; ?></p>
            <?php endif; ?>
            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>
    </main>

    <?php include '../pages/footer.php'; ?>
</body>
</html>