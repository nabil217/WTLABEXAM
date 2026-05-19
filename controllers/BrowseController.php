<?php
// controllers/BrowseController.php

class BrowseController {
    private $restaurantModel;

    public function __construct($restaurantModel) {
        $this->restaurantModel = $restaurantModel;
    }

    // Home page
    public function home() {
        $restaurants = $this->restaurantModel->getAllRestaurants();
        include 'views/browse/home.php';
    }

    // All restaurants list
    public function restaurants() {
        $restaurants = $this->restaurantModel->getAllRestaurants();
        include 'views/browse/restaurants.php';
    }

    // Single restaurant page
    public function restaurantDetail() {
        $id = (int)($_GET['id'] ?? 0);
        $restaurant = $this->restaurantModel->getRestaurantById($id);
        if (!$restaurant) {
            echo "Restaurant not found."; return;
        }
        $menuItems = $this->restaurantModel->getMenuItems($id);
        include 'views/browse/restaurant_detail.php';
    }

    // Menu item detail page
    public function menuItemDetail() {
        $id   = (int)($_GET['id'] ?? 0);
        $item = $this->restaurantModel->getMenuItemById($id);
        if (!$item) {
            echo "Item not found."; return;
        }
        $restaurant = $this->restaurantModel->getRestaurantById($item['restaurant_id']);
        include 'views/browse/menu_item_detail.php';
    }

    // AJAX endpoint: check if email exists (for Task 1 AJAX requirement)
    public function checkEmail() {
        header('Content-Type: application/json');
        $email = trim($_GET['email'] ?? '');
        // This uses UserModel — pass it in a real scenario
        // For now we return a placeholder
        echo json_encode(['available' => true]);
        exit;
    }
}
?>
