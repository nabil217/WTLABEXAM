<?php
// model/AdminModel.php
// Handles admin-specific DB operations: manage members, delete reviews

require_once __DIR__ . '/../config/database.php';

class AdminModel {

    private $pdo;

    public function __construct() {
        $this->pdo = getDBConnection();
    }

    // Get all members (role = 'member')
    public function getAllMembers() {
        $sql = "SELECT id, name, email, created_at FROM users WHERE role = 'member' ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get single user by ID
    public function getUserById($id) {
        $sql = "SELECT id, name, email, role FROM users WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Delete a member and cascade their content
    public function deleteMember($user_id) {
        $pdo = $this->pdo;
        $pdo->beginTransaction();
        try {
            // Delete food experience comments
            $pdo->prepare("DELETE FROM food_experience_comments WHERE user_id = ?")->execute([$user_id]);
            // Delete food experience posts (comments on those posts also cascade if FK set, else manual)
            $pdo->prepare("DELETE FROM food_experience_comments WHERE post_id IN 
                           (SELECT id FROM food_experience_posts WHERE user_id = ?)")->execute([$user_id]);
            $pdo->prepare("DELETE FROM food_experience_posts WHERE user_id = ?")->execute([$user_id]);
            // Delete food item reviews
            $pdo->prepare("DELETE FROM reviews WHERE user_id = ?")->execute([$user_id]);
            // Delete user
            $pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'member'")->execute([$user_id]);
            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }

    // Get all food item reviews (for admin removal)
    public function getAllReviews() {
        $sql = "SELECT r.*, u.name AS member_name, mi.name AS item_name
                FROM reviews r
                JOIN users u ON r.user_id = u.id
                JOIN menu_items mi ON r.menu_item_id = mi.id
                ORDER BY r.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Delete a food item review
    public function deleteReview($review_id) {
        $sql = "DELETE FROM reviews WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$review_id]);
        return $stmt->rowCount();
    }

    // Dashboard counts
    public function getDashboardCounts() {
        $counts = [];
        $tables = [
            'members'  => "SELECT COUNT(*) FROM users WHERE role = 'member'",
            'posts'    => "SELECT COUNT(*) FROM food_experience_posts",
            'comments' => "SELECT COUNT(*) FROM food_experience_comments",
            'reviews'  => "SELECT COUNT(*) FROM reviews",
        ];
        foreach ($tables as $key => $sql) {
            try {
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $counts[$key] = $stmt->fetchColumn();
            } catch (Exception $e) {
                $counts[$key] = 0;
            }
        }
        return $counts;
    }
}
?>
