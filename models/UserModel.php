<?php
// models/UserModel.php
// All database queries related to users go here

class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Find user by email
    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Find user by ID
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create a new user (registration)
    public function createUser($name, $email, $password, $role) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (name, email, password_hash, role, created_at)
             VALUES (?, ?, ?, ?, NOW())"
        );
        return $stmt->execute([$name, $email, $hash, $role]);
    }

    // Update profile (name, email)
    public function updateProfile($id, $name, $email, $picture = null) {
        if ($picture) {
            $stmt = $this->pdo->prepare(
                "UPDATE users SET name=?, email=?, profile_picture=? WHERE id=?"
            );
            return $stmt->execute([$name, $email, $picture, $id]);
        } else {
            $stmt = $this->pdo->prepare(
                "UPDATE users SET name=?, email=? WHERE id=?"
            );
            return $stmt->execute([$name, $email, $id]);
        }
    }

    // Change password
    public function updatePassword($id, $newPassword) {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE users SET password_hash=? WHERE id=?");
        return $stmt->execute([$hash, $id]);
    }

    // Save remember me token
    public function saveRememberToken($id, $token) {
        $hash = hash('sha256', $token);
        $stmt = $this->pdo->prepare("UPDATE users SET remember_token=? WHERE id=?");
        return $stmt->execute([$hash, $id]);
    }

    // Find user by remember token
    public function findByRememberToken($token) {
        $hash = hash('sha256', $token);
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE remember_token=?");
        $stmt->execute([$hash]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
