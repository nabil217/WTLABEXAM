<?php
// controllers/AuthController.php

class AuthController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function showRegister() {
        include 'views/auth/register.php';
    }

    public function register() {
        $errors = [];

        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $pass  = $_POST['password'] ?? '';
        $pass2 = $_POST['confirm_password'] ?? '';
        $role  = $_POST['role'] ?? 'member';

        // Validate role value
        if (!in_array($role, ['admin', 'member'])) $role = 'member';

        // Server-side validation
        if (empty($name))  $errors[] = "Name is required.";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email required.";
        if (strlen($pass) < 8) $errors[] = "Password must be at least 8 characters.";
        if ($pass !== $pass2)  $errors[] = "Passwords do not match.";

        // Admin must use @foodblog.com email
        if ($role === 'admin' && !str_ends_with($email, '@foodblog.com')) {
            $errors[] = "Admin accounts must use a @foodblog.com email address.";
        }

        // Member must NOT use @foodblog.com email
        if ($role === 'member' && str_ends_with($email, '@foodblog.com')) {
            $errors[] = "Regular members cannot use a @foodblog.com email address.";
        }

        // Check unique email
        if (empty($errors) && $this->userModel->findByEmail($email)) {
            $errors[] = "Email already registered.";
        }

        if (!empty($errors)) {
            include 'views/auth/register.php';
            return;
        }

        $this->userModel->createUser($name, $email, $pass, $role);
        $_SESSION['flash'] = "Registration successful! Please login.";
        header("Location: index.php?page=login");
        exit;
    }

    public function showLogin() {
        include 'views/auth/login.php';
    }

    public function login() {
        $errors = [];
        $email  = trim($_POST['email'] ?? '');
        $pass   = $_POST['password'] ?? '';
        $remember = isset($_POST['remember_me']);

        if (empty($email) || empty($pass)) {
            $errors[] = "Email and password are required.";
            include 'views/auth/login.php';
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($pass, $user['password_hash'])) {
            $errors[] = "Invalid email or password.";
            include 'views/auth/login.php';
            return;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name']    = $user['name'];
        $_SESSION['role']    = $user['role'];

        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $this->userModel->saveRememberToken($user['id'], $token);
            setcookie('remember_token', $token, time() + 60 * 60 * 24 * 30, '/', '', false, true);
        }

        header("Location: index.php?page=home");
        exit;
    }

    public function logout() {
        session_destroy();
        setcookie('remember_token', '', time() - 3600, '/');
        header("Location: index.php?page=home");
        exit;
    }

    public function checkRememberMe() {
        if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
            $user = $this->userModel->findByRememberToken($_COOKIE['remember_token']);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name']    = $user['name'];
                $_SESSION['role']    = $user['role'];
            }
        }
    }
}
?>