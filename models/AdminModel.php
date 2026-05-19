<?php
// models/AdminModel.php
// All database queries for Admin CRUD (Task 2)

class AdminModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // ── DASHBOARD COUNTS ──────────────────────────────────────
    public function countRestaurants() {
        return $this->pdo->query("SELECT COUNT(*) FROM restaurants")->fetchColumn();
    }
    public function countMenuItems() {
        return $this->pdo->query("SELECT COUNT(*) FROM menu_items")->fetchColumn();
    }
    public function countReviews() {
        return $this->pdo->query("SELECT COUNT(*) FROM reviews")->fetchColumn();
    }
    public function countPosts() {
        return $this->pdo->query("SELECT COUNT(*) FROM food_experience_posts")->fetchColumn();
    }

    // ── RESTAURANTS ───────────────────────────────────────────
    public function getAllRestaurants() {
        $stmt = $this->pdo->query("SELECT * FROM restaurants ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRestaurantById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM restaurants WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createRestaurant($name, $location, $area, $background, $goals) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO restaurants (name, location, area, short_background, goals, created_at)
             VALUES (?, ?, ?, ?, ?, NOW())"
        );
        return $stmt->execute([$name, $location, $area, $background, $goals]);
    }

    public function updateRestaurant($id, $name, $location, $area, $background, $goals) {
        $stmt = $this->pdo->prepare(
            "UPDATE restaurants SET name=?, location=?, area=?, short_background=?, goals=? WHERE id=?"
        );
        return $stmt->execute([$name, $location, $area, $background, $goals, $id]);
    }

    public function deleteRestaurant($id) {
        // menu_items deleted automatically via ON DELETE CASCADE
        $stmt = $this->pdo->prepare("DELETE FROM restaurants WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ── MENU ITEMS ────────────────────────────────────────────
    public function getMenuItemsByRestaurant($restaurantId) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM menu_items WHERE restaurant_id = ? ORDER BY created_at DESC"
        );
        $stmt->execute([$restaurantId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMenuItemById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM menu_items WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createMenuItem($restaurantId, $name, $description, $price, $imagePath) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO menu_items (restaurant_id, name, description, price, image_path, created_at)
             VALUES (?, ?, ?, ?, ?, NOW())"
        );
        return $stmt->execute([$restaurantId, $name, $description, $price, $imagePath]);
    }

    public function updateMenuItem($id, $name, $description, $price, $imagePath = null) {
        if ($imagePath) {
            $stmt = $this->pdo->prepare(
                "UPDATE menu_items SET name=?, description=?, price=?, image_path=? WHERE id=?"
            );
            return $stmt->execute([$name, $description, $price, $imagePath, $id]);
        } else {
            $stmt = $this->pdo->prepare(
                "UPDATE menu_items SET name=?, description=?, price=? WHERE id=?"
            );
            return $stmt->execute([$name, $description, $price, $id]);
        }
    }

    public function deleteMenuItem($id) {
        $stmt = $this->pdo->prepare("DELETE FROM menu_items WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
