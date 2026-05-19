<?php



require_once __DIR__ . '/../config/auth.php';
include __DIR__ . '/../control/registration_process.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Food Blog</title>
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
            max-width: 460px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        }
        .auth-logo { text-align: center; font-size: 2.5rem; margin-bottom: 0.3rem; }
        .auth-title {
            text-align: center; color: #2C6E49;
            font-size: 1.5rem; font-weight: 800; margin-bottom: 0.2rem;
        }
        .auth-subtitle {
            text-align: center; color: #888;
            font-size: 0.88rem; margin-bottom: 1.5rem;
        }
        .auth-footer { text-align: center; margin-top: 1.2rem; font-size: 0.88rem; color: #666; }
        .auth-footer a { color: #2C6E49; font-weight: 600; text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }
        .btn-full { width: 100%; padding: 11px; font-size: 1rem; }
        .role-select-hint { font-size: 0.78rem; color: #888; margin-top: 0.25rem; }
        .password-hint { font-size: 0.78rem; color: #888; margin-top: 0.25rem; }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo">🍽</div>
        <div class="auth-title">Create Account</div>
        <div class="auth-subtitle">Join the Food Blog community</div>

        <?php if (!empty($errors)): ?>
            <div class="errors-box">
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        
        <form action="" method="POST" id="register-form" novalidate>

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control"
                       placeholder="Your full name"
                       value="<?= htmlspecialchars($formName) ?>">
                <div class="form-error" id="name-error"></div>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control"
                       placeholder="you@example.com"
                       value="<?= htmlspecialchars($formEmail) ?>">
                <div class="form-error" id="email-error"></div>
            </div>

            <div class="form-group">
                <label for="role">Register As</label>
                <select id="role" name="role" class="form-control">
                    <option value="member" <?= $formRole === 'member' ? 'selected' : '' ?>>Member</option>
                    <option value="admin"  <?= $formRole === 'admin'  ? 'selected' : '' ?>>Admin</option>
                </select>
                <div class="role-select-hint">Members can post & comment. Admins can moderate everything.</div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control"
                       placeholder="At least 8 characters">
                <div class="password-hint">Minimum 8 characters.</div>
                <div class="form-error" id="password-error"></div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                       placeholder="Repeat your password">
                <div class="form-error" id="confirm-error"></div>
            </div>

            <button type="submit" name="register" class="btn btn-primary btn-full">
                Create Account
            </button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="login.php">Sign in</a>
        </div>
    </div>
</div>

<script src="../public/js/auth.js"></script>
</body>
</html>
