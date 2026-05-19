<?php
// index.php — Main Router (Task 1 + Task 2 merged)

session_start();

// Load DB connection
require_once 'config/database.php';

// ── MODELS ────────────────────────────────────────────────────
require_once 'models/UserModel.php';
require_once 'models/RestaurantModel.php';
require_once 'models/AdminModel.php';          // Task 2

// ── CONTROLLERS ───────────────────────────────────────────────
require_once 'controllers/AuthController.php';
require_once 'controllers/ProfileController.php';
require_once 'controllers/BrowseController.php';
require_once 'controllers/AdminController.php'; // Task 2

// ── INSTANCES ─────────────────────────────────────────────────
$userModel       = new UserModel($pdo);
$restaurantModel = new RestaurantModel($pdo);
$adminModel      = new AdminModel($pdo);        // Task 2

$authController    = new AuthController($userModel);
$profileController = new ProfileController($userModel);
$browseController  = new BrowseController($restaurantModel);
$adminController   = new AdminController($adminModel); // Task 2

// Check remember me cookie on every request
$authController->checkRememberMe();

// ── ROUTER ────────────────────────────────────────────────────
$page = $_GET['page'] ?? 'home';

switch ($page) {

    // ── TASK 1: AUTH ──────────────────────────────────────────
    case 'home':
        $browseController->home();
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->register();
        } else {
            $authController->showRegister();
        }
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            $authController->showLogin();
        }
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'profile':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profileController->updateProfile();
        } else {
            $profileController->showProfile();
        }
        break;

    // ── TASK 1: BROWSE ────────────────────────────────────────
    case 'restaurants':
        $browseController->restaurants();
        break;

    case 'restaurant':
        $browseController->restaurantDetail();
        break;

    case 'menu-item':
        $browseController->menuItemDetail();
        break;

    // AJAX: email check
    case 'api-check-email':
        header('Content-Type: application/json');
        $email  = trim($_GET['email'] ?? '');
        $exists = $userModel->findByEmail($email) ? true : false;
        echo json_encode(['available' => !$exists]);
        exit;

    // ── TASK 2: ADMIN DASHBOARD ───────────────────────────────
    case 'admin':
        $adminController->dashboard();
        break;

    // ── TASK 2: RESTAURANT CRUD ───────────────────────────────
    case 'admin-restaurant-create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->createRestaurant();
        } else {
            $adminController->showCreateRestaurant();
        }
        break;

    case 'admin-restaurant-edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->editRestaurant();
        } else {
            $adminController->showEditRestaurant();
        }
        break;

    case 'admin-restaurant-delete':
        $adminController->deleteRestaurant();
        break;

    // ── TASK 2: MENU ITEM CRUD ────────────────────────────────
    case 'admin-menu-items':
        $adminController->showMenuItems();
        break;

    case 'admin-menu-item-create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->createMenuItem();
        } else {
            $adminController->showCreateMenuItem();
        }
        break;

    case 'admin-menu-item-edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->editMenuItem();
        } else {
            $adminController->showEditMenuItem();
        }
        break;

    case 'admin-menu-item-delete':
        $adminController->deleteMenuItem();
        break;

    // ── TASK 2: AJAX ──────────────────────────────────────────
    case 'api-admin-confirm':
        $adminController->ajaxDeleteConfirm();
        break;

    default:
        echo "404 - Page not found.";
}
?>
