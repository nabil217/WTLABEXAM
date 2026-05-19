<?php
// model/FoodExperienceComment.php
// Handles all DB operations for food_experience_comments table

require_once __DIR__ . '/../config/database.php';

class FoodExperienceComment {

    private $pdo;

    public function __construct() {
        $this->pdo = getDBConnection();
    }

    // Get all comments for a post
    public function getCommentsByPost($post_id) {
        $sql = "SELECT fec.*, u.name AS author_name
                FROM food_experience_comments fec
                JOIN users u ON fec.user_id = u.id
                WHERE fec.post_id = ?
                ORDER BY fec.created_at ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id]);
        return $stmt->fetchAll();
    }

    // Add a comment (AJAX endpoint uses this)
    public function addComment($post_id, $user_id, $comment) {
        $sql = "INSERT INTO food_experience_comments (post_id, user_id, comment, created_at)
                VALUES (?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id, $user_id, $comment]);
        return $this->pdo->lastInsertId();
    }

    // Delete comment — owner or admin
    public function deleteComment($id, $user_id, $is_admin = false) {
        if ($is_admin) {
            $sql = "DELETE FROM food_experience_comments WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
        } else {
            $sql = "DELETE FROM food_experience_comments WHERE id = ? AND user_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id, $user_id]);
        }
        return $stmt->rowCount();
    }

    // Delete all comments by a user (used when admin removes a member)
    public function deleteCommentsByUser($user_id) {
        $sql = "DELETE FROM food_experience_comments WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->rowCount();
    }
}
?>
