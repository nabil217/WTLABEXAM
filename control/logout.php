<?php

if (session_status() === PHP_SESSION_NONE) session_start();

$_SESSION = [];
session_destroy();

if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/');
}

header("Location: ../view/food_experience/index.php");
exit;
?>
