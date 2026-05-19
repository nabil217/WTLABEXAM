<?php
// controllers/ProfileController.php

class ProfileController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    // Show profile page (session required)
    public function showProfile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }
        $user = $this->userModel->findById($_SESSION['user_id']);
        include 'views/profile/profile.php';
    }

    // Handle profile update
    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $errors = [];
        $id    = $_SESSION['user_id'];
        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (empty($name))  $errors[] = "Name is required.";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email required.";

        // Handle profile picture upload
        $picture = null;
        if (!empty($_FILES['profile_picture']['name'])) {
            $file = $_FILES['profile_picture'];
            $allowed = ['image/jpeg', 'image/png'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            if (!in_array($file['type'], $allowed)) {
                $errors[] = "Only JPEG/PNG images allowed.";
            } elseif ($file['size'] > $maxSize) {
                $errors[] = "Image must be under 2MB.";
            } else {
                $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = 'user_' . $id . '_' . time() . '.' . $ext;
                move_uploaded_file($file['tmp_name'], 'public/uploads/' . $filename);
                $picture = $filename;
            }
        }

        // Handle password change
        $newPass = $_POST['new_password'] ?? '';
        $curPass = $_POST['current_password'] ?? '';

        if (!empty($newPass)) {
            $user = $this->userModel->findById($id);
            if (!password_verify($curPass, $user['password_hash'])) {
                $errors[] = "Current password is wrong.";
            } elseif (strlen($newPass) < 8) {
                $errors[] = "New password must be at least 8 characters.";
            }
        }

        if (!empty($errors)) {
            $user = $this->userModel->findById($id);
            include 'views/profile/profile.php';
            return;
        }

        $this->userModel->updateProfile($id, $name, $email, $picture);
        if (!empty($newPass)) {
            $this->userModel->updatePassword($id, $newPass);
        }

        // Update session name
        $_SESSION['name'] = $name;
        $_SESSION['flash'] = "Profile updated successfully!";
        header("Location: index.php?page=profile");
        exit;
    }
}
?>
