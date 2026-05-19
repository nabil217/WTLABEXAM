<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../model/UserModel.php';

if (isLoggedIn()) {
    header("Location: ../view/food_experience/index.php");
    exit;
}

$errors  = [];
$success = false;


$formName  = '';
$formEmail = '';
$formRole  = 'member';

if (isset($_POST['register'])) {

    $formName  = trim($_POST['name'] ?? '');
    $formEmail = trim($_POST['email'] ?? '');
    $formRole  = $_POST['role'] ?? 'member';
    $password  = $_POST['password'] ?? '';
    $confirm   = $_POST['confirm_password'] ?? '';

    
    if (empty($formName)) {
        $errors[] = "Full name is required.";
    } elseif (strlen($formName) < 2) {
        $errors[] = "Name must be at least 2 characters.";
    }

    if (empty($formEmail)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($formEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }

    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    if (!in_array($formRole, ['admin', 'member'])) {
        $errors[] = "Invalid role selected.";
    }

    if (empty($errors)) {
        $userModel = new UserModel();

        if ($userModel->emailExists($formEmail)) {
            $errors[] = "This email is already registered.";
        } else {
        
            $newId = $userModel->createUser($formName, $formEmail, $password, $formRole);
            if ($newId) {
                $_SESSION['flash'] = "Registration successful! Please log in.";
                header("Location: ../view/login.php");
                exit;
            } else {
                $errors[] = "Registration failed. Please try again.";
            }
        }
    }
}
?>
