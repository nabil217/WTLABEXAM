<?php



require_once __DIR__ . '/../config/auth.php';
include __DIR__ . '/../control/login_process.php';

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Food Blog</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2C6E49 0%, #1b4332 100%);
            padding: 2rem;
        }
        .auth-card {
            background: #fff;
            border-radius: 12px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        }
        .auth-logo {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 0.3rem;
        }
        .auth-title {
            text-align: center;
            color: #2C6E49;
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 0.2rem;
        }
        .auth-subtitle {
            text-align: center;
            color: #888;
            font-size: 0.88rem;
            margin-bottom: 1.5rem;
        }
        .auth-footer {
            text-align: center;
            margin-top: 1.2rem;
            font-size: 0.88rem;
            color: #666;
        }
        .auth-footer a { color: #2C6E49; font-weight: 600; text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }
        .remember-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.2rem;
            font-size: 0.88rem;
            color: #555;
        }
        .remember-row input[type="checkbox"] { accent-color: #2C6E49; width: 16px; height: 16px; }
        .btn-full { width: 100%; padding: 11px; font-size: 1rem; }
        .error-banner {
            background: #fff0f1;
            border: 1.5px solid #e63946;
            border-radius: 6px;
            padding: 0.75rem 1rem;
            color: #e63946;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo">🍽</div>
        <div class="auth-title">Food Blog</div>
        <div class="auth-subtitle">Sign in to your account</div>

        <?php if ($flash): ?>
            <div class="flash flash-success"><?= htmlspecialchars($flash) ?></div>
        <?php endif; ?>

        <?php if (!empty($errorMsg)): ?>
            <div class="error-banner"><?= htmlspecialchars($errorMsg) ?></div>
        <?php endif; ?>

        <form action="" method="POST" id="login-form" novalidate>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control"
                       placeholder="you@example.com"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                <div class="form-error" id="email-error"></div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control"
                       placeholder="Your password">
                <div class="form-error" id="password-error"></div>
            </div>

            <div class="remember-row">
                <input type="checkbox" id="remember_me" name="remember_me">
                <label for="remember_me">Remember me for 30 days</label>
            </div>

            <button type="submit" name="login" class="btn btn-primary btn-full">
                Sign In
            </button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
        <div class="auth-footer" style="margin-top:0.5rem;">
            <a href="food_experience/index.php">← Browse as Visitor</a>
        </div>
    </div>
</div>

<script src="../public/js/auth.js"></script>
</body>
</html>
