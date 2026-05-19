<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../model/UserModel.php';


if (isLoggedIn()) {
    header("Location: ../view/food_experience/index.php");
    exit;
}

$errorMsg = '';

if (isset($_POST['login'])) {

    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    
    if (empty($email) || empty($password)) {
        $errorMsg = "Email and password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = "Invalid email format.";
    } else {
        $userModel = new UserModel();
        $user      = $userModel->getUserByEmail($email);

        
        if ($user && password_verify($password, $user['password_hash'])) {
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['role']    = $user['role'];

            
            if (isset($_POST['remember_me'])) {
                $token = bin2hex(random_bytes(32));
                setcookie('remember_me', $token, time() + (30 * 24 * 3600), '/', '', false, true);
            }

            header("Location: ../view/food_experience/index.php");
            exit;
        } else {
            $errorMsg = "Invalid email or password.";
        }
    }
}
?>
