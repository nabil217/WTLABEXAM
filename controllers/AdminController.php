<?php
// controllers/AdminController.php
// Task 2 — Admin CRUD for Restaurants & Menu Items

class AdminController {
    private $adminModel;

    public function __construct($adminModel) {
        $this->adminModel = $adminModel;
    }

    // ── ADMIN GATE ────────────────────────────────────────────
    // Call this at the top of every admin method
    private function requireAdmin() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['flash'] = "Access denied. Admins only.";
            header("Location: index.php?page=login");
            exit;
        }
    }

    // ── DASHBOARD ─────────────────────────────────────────────
    public function dashboard() {
        $this->requireAdmin();
        $totalRestaurants = $this->adminModel->countRestaurants();
        $totalMenuItems   = $this->adminModel->countMenuItems();
        $totalReviews     = $this->adminModel->countReviews();
        $totalPosts       = $this->adminModel->countPosts();
        $restaurants      = $this->adminModel->getAllRestaurants();
        include 'views/admin/dashboard.php';
    }

    // ── RESTAURANTS ───────────────────────────────────────────
    public function showCreateRestaurant() {
    $this->requireAdmin();
    $mode = 'create';
    $restaurant = [];
    include 'views/admin/restaurant_form.php';
}

    public function createRestaurant() {
        $this->requireAdmin();
        $errors = [];
        $name       = trim($_POST['name'] ?? '');
        $location   = trim($_POST['location'] ?? '');
        $area       = trim($_POST['area'] ?? '');
        $background = trim($_POST['short_background'] ?? '');
        $goals      = trim($_POST['goals'] ?? '');

        if (empty($name))       $errors[] = "Restaurant name is required.";
        if (empty($location))   $errors[] = "Location is required.";
        if (empty($area))       $errors[] = "Area is required.";
        if (empty($background)) $errors[] = "Short background is required.";
        if (empty($goals))      $errors[] = "Goals are required.";

        if (!empty($errors)) {
            $mode = 'create';
            include 'views/admin/restaurant_form.php';
            return;
        }

        $this->adminModel->createRestaurant($name, $location, $area, $background, $goals);
        $_SESSION['flash'] = "Restaurant '$name' created successfully!";
        header("Location: index.php?page=admin");
        exit;
    }

    public function showEditRestaurant() {
    $this->requireAdmin();
    $id = (int)($_GET['id'] ?? 0);
    $restaurant = $this->adminModel->getRestaurantById($id);
    if (!$restaurant) { echo "Restaurant not found."; return; }
    $mode = 'edit';
    include 'views/admin/restaurant_form.php';
   }

    public function editRestaurant() {
        $this->requireAdmin();
        $errors = [];
        $id         = (int)($_POST['id'] ?? 0);
        $name       = trim($_POST['name'] ?? '');
        $location   = trim($_POST['location'] ?? '');
        $area       = trim($_POST['area'] ?? '');
        $background = trim($_POST['short_background'] ?? '');
        $goals      = trim($_POST['goals'] ?? '');

        if (empty($name))       $errors[] = "Restaurant name is required.";
        if (empty($location))   $errors[] = "Location is required.";
        if (empty($area))       $errors[] = "Area is required.";
        if (empty($background)) $errors[] = "Short background is required.";
        if (empty($goals))      $errors[] = "Goals are required.";

        if (!empty($errors)) {
            $restaurant = $this->adminModel->getRestaurantById($id);
            $mode = 'edit';
            include 'views/admin/restaurant_form.php';
            return;
        }

        $this->adminModel->updateRestaurant($id, $name, $location, $area, $background, $goals);
        $_SESSION['flash'] = "Restaurant updated successfully!";
        header("Location: index.php?page=admin");
        exit;
    }

    public function deleteRestaurant() {
        $this->requireAdmin();
        $id = (int)($_POST['id'] ?? 0);
        $restaurant = $this->adminModel->getRestaurantById($id);
        if ($restaurant) {
            $this->adminModel->deleteRestaurant($id);
            $_SESSION['flash'] = "Restaurant '{$restaurant['name']}' deleted.";
        }
        header("Location: index.php?page=admin");
        exit;
    }

    // ── MENU ITEMS ────────────────────────────────────────────
    public function showMenuItems() {
        $this->requireAdmin();
        $restaurantId = (int)($_GET['restaurant_id'] ?? 0);
        $restaurant   = $this->adminModel->getRestaurantById($restaurantId);
        if (!$restaurant) { echo "Restaurant not found."; return; }
        $menuItems = $this->adminModel->getMenuItemsByRestaurant($restaurantId);
        include 'views/admin/menu_items.php';
    }

    public function showCreateMenuItem() {
        $this->requireAdmin();
        $restaurantId = (int)($_GET['restaurant_id'] ?? 0);
        $restaurant   = $this->adminModel->getRestaurantById($restaurantId);
        if (!$restaurant) { echo "Restaurant not found."; return; }
        $mode = 'create';
        include 'views/admin/menu_item_form.php';
    }

    public function createMenuItem() {
        $this->requireAdmin();
        $errors = [];
        $restaurantId = (int)($_POST['restaurant_id'] ?? 0);
        $name         = trim($_POST['name'] ?? '');
        $description  = trim($_POST['description'] ?? '');
        $price        = $_POST['price'] ?? '';

        if (empty($name))        $errors[] = "Item name is required.";
        if (empty($description)) $errors[] = "Description is required.";
        if (!is_numeric($price) || (float)$price <= 0) $errors[] = "Price must be a positive number.";

        // Handle image upload
        $imagePath = null;
        if (!empty($_FILES['image']['name'])) {
            $file    = $_FILES['image'];
            $allowed = ['image/jpeg', 'image/png'];
            $maxSize = 2 * 1024 * 1024;

            if (!in_array($file['type'], $allowed)) {
                $errors[] = "Only JPEG/PNG images allowed.";
            } elseif ($file['size'] > $maxSize) {
                $errors[] = "Image must be under 2MB.";
            } else {
                $ext       = pathinfo($file['name'], PATHINFO_EXTENSION);
                $imagePath = 'item_' . time() . '_' . rand(100, 999) . '.' . $ext;
                $uploadDir = 'public/uploads/menu/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                move_uploaded_file($file['tmp_name'], $uploadDir . $imagePath);
            }
        }

        if (!empty($errors)) {
            $restaurant = $this->adminModel->getRestaurantById($restaurantId);
            $mode = 'create';
            include 'views/admin/menu_item_form.php';
            return;
        }

        $this->adminModel->createMenuItem($restaurantId, $name, $description, (float)$price, $imagePath);
        $_SESSION['flash'] = "Menu item '$name' added!";
        header("Location: index.php?page=admin-menu-items&restaurant_id=$restaurantId");
        exit;
    }

    public function showEditMenuItem() {
        $this->requireAdmin();
        $id   = (int)($_GET['id'] ?? 0);
        $item = $this->adminModel->getMenuItemById($id);
        if (!$item) { echo "Item not found."; return; }
        $restaurant = $this->adminModel->getRestaurantById($item['restaurant_id']);
        $mode = 'edit';
        include 'views/admin/menu_item_form.php';
    }

    public function editMenuItem() {
        $this->requireAdmin();
        $errors = [];
        $id           = (int)($_POST['id'] ?? 0);
        $restaurantId = (int)($_POST['restaurant_id'] ?? 0);
        $name         = trim($_POST['name'] ?? '');
        $description  = trim($_POST['description'] ?? '');
        $price        = $_POST['price'] ?? '';

        if (empty($name))        $errors[] = "Item name is required.";
        if (empty($description)) $errors[] = "Description is required.";
        if (!is_numeric($price) || (float)$price <= 0) $errors[] = "Price must be a positive number.";

        // Handle image upload
        $imagePath = null;
        if (!empty($_FILES['image']['name'])) {
            $file    = $_FILES['image'];
            $allowed = ['image/jpeg', 'image/png'];
            $maxSize = 2 * 1024 * 1024;

            if (!in_array($file['type'], $allowed)) {
                $errors[] = "Only JPEG/PNG images allowed.";
            } elseif ($file['size'] > $maxSize) {
                $errors[] = "Image must be under 2MB.";
            } else {
                $ext       = pathinfo($file['name'], PATHINFO_EXTENSION);
                $imagePath = 'item_' . time() . '_' . rand(100, 999) . '.' . $ext;
                $uploadDir = 'public/uploads/menu/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                move_uploaded_file($file['tmp_name'], $uploadDir . $imagePath);
            }
        }

        if (!empty($errors)) {
            $item       = $this->adminModel->getMenuItemById($id);
            $restaurant = $this->adminModel->getRestaurantById($restaurantId);
            $mode = 'edit';
            include 'views/admin/menu_item_form.php';
            return;
        }

        $this->adminModel->updateMenuItem($id, $name, $description, (float)$price, $imagePath);
        $_SESSION['flash'] = "Menu item updated!";
        header("Location: index.php?page=admin-menu-items&restaurant_id=$restaurantId");
        exit;
    }

    public function deleteMenuItem() {
        $this->requireAdmin();
        $id           = (int)($_POST['id'] ?? 0);
        $restaurantId = (int)($_POST['restaurant_id'] ?? 0);
        $item = $this->adminModel->getMenuItemById($id);
        if ($item) {
            $this->adminModel->deleteMenuItem($id);
            $_SESSION['flash'] = "Menu item '{$item['name']}' deleted.";
        }
        header("Location: index.php?page=admin-menu-items&restaurant_id=$restaurantId");
        exit;
    }

    // ── AJAX: Delete confirmation ──────────────────────────────
    public function ajaxDeleteConfirm() {
        $this->requireAdmin();
        header('Content-Type: application/json');
        $type = $_POST['type'] ?? '';
        $id   = (int)($_POST['id'] ?? 0);
        $name = '';
        if ($type === 'restaurant') {
            $r = $this->adminModel->getRestaurantById($id);
            $name = $r ? $r['name'] : '';
        } elseif ($type === 'menu_item') {
            $i = $this->adminModel->getMenuItemById($id);
            $name = $i ? $i['name'] : '';
        }
        echo json_encode(['name' => $name, 'id' => $id, 'type' => $type]);
        exit;
    }
}
?>
