<?php
// model/UserModel.php
// Handles user login, registration, lookup — reusing teacher's pattern with PDO

require_once __DIR__ . '/../config/database.php';

class UserModel {

    private $pdo;

    public function __construct() {
        $this->pdo = getDBConnection();
    }

    // Find user by email (for login)
    public function getUserByEmail($email) {
        $sql = "SELECT id, name, email, password_hash, role FROM users WHERE email = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    // Check if email already exists (for registration)
    public function emailExists($email) {
        $sql = "SELECT id FROM users WHERE email = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch() !== false;
    }

    // Register a new user
    public function createUser($name, $email, $password, $role = 'member') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql  = "INSERT INTO users (name, email, password_hash, role, created_at)
                 VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $email, $hash, $role]);
        return $this->pdo->lastInsertId();
    }
}
?>
