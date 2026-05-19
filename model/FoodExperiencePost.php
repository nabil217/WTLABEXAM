<?php
// model/FoodExperiencePost.php
// Handles all DB operations for food_experience_posts table

require_once __DIR__ . '/../config/database.php';

class FoodExperiencePost {

    private $pdo;

    public function __construct() {
        $this->pdo = getDBConnection();
    }

    // Get all posts (newest first), join user name
    public function getAllPosts() {
        $sql = "SELECT fep.*, u.name AS author_name
                FROM food_experience_posts fep
                JOIN users u ON fep.user_id = u.id
                ORDER BY fep.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get single post by ID
    public function getPostById($id) {
        $sql = "SELECT fep.*, u.name AS author_name
                FROM food_experience_posts fep
                JOIN users u ON fep.user_id = u.id
                WHERE fep.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Create new post
    public function createPost($user_id, $title, $content, $post_type, $restaurant_id = null, $menu_item_id = null) {
        $sql = "INSERT INTO food_experience_posts 
                    (user_id, title, content, post_type, restaurant_id, menu_item_id, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $title, $content, $post_type, $restaurant_id, $menu_item_id]);
        return $this->pdo->lastInsertId();
    }

    // Update own post (author only)
    public function updatePost($id, $user_id, $title, $content, $post_type) {
        $sql = "UPDATE food_experience_posts
                SET title = ?, content = ?, post_type = ?, updated_at = NOW()
                WHERE id = ? AND user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$title, $content, $post_type, $id, $user_id]);
        return $stmt->rowCount();
    }

    // Delete a post — owner or admin
    public function deletePost($id, $user_id, $is_admin = false) {
        if ($is_admin) {
            $sql = "DELETE FROM food_experience_posts WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
        } else {
            $sql = "DELETE FROM food_experience_posts WHERE id = ? AND user_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id, $user_id]);
        }
        return $stmt->rowCount();
    }

    // Get posts by a specific user (for admin member management)
    public function getPostsByUser($user_id) {
        $sql = "SELECT * FROM food_experience_posts WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
}
?>
