<?php
// models/RestaurantModel.php

class RestaurantModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Get all restaurants
    public function getAllRestaurants() {
        $stmt = $this->pdo->prepare("SELECT * FROM restaurants ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get one restaurant by ID
    public function getRestaurantById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM restaurants WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get menu items for a restaurant
    public function getMenuItems($restaurantId) {
        $stmt = $this->pdo->prepare("SELECT * FROM menu_items WHERE restaurant_id = ?");
        $stmt->execute([$restaurantId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single menu item
    public function getMenuItemById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM menu_items WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
