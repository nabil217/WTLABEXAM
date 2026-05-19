<!-- views/auth/login.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Login - Food Blog</title>
    <style>
        body { font-family: Arial; max-width: 500px; margin: 50px auto; }
        /*input { width: 100%; padding: 8px; margin: 5px 0 10px; box-sizing: border-box; }*/
        input:not([type="checkbox"]) { width: 100%; padding: 8px; margin: 5px 0 10px; box-sizing: border-box; }
        button { background: #e44d26; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .error { color: red; background: #ffe0e0; padding: 8px; margin-bottom: 10px; }
        .flash { color: green; background: #e0ffe0; padding: 8px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <?php include 'views/partials/navbar.php'; ?>

    <h2>Login</h2>

    <!-- Flash message from registration -->
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="flash"><?= htmlspecialchars($_SESSION['flash']) ?></div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <!-- Errors -->
    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $e): ?>
                <p><?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=login">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <label>
            <input type="checkbox" name="remember_me"> Remember Me (30 days)
        </label>

        <button type="submit">Login</button>
        <p>No account? <a href="index.php?page=register">Register</a></p>
    </form>
</body>
</html>
