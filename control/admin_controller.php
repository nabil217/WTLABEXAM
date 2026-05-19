<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../model/AdminModel.php';

requireAdmin('../view/food_experience/index.php');

$action = $_GET['action'] ?? 'dashboard';
$adminModel = new AdminModel();


if ($action === 'dashboard') {
    $counts = $adminModel->getDashboardCounts();
    require_once __DIR__ . '/../view/admin/dashboard.php';
    exit;
}


if ($action === 'members') {
    $members = $adminModel->getAllMembers();
    require_once __DIR__ . '/../view/admin/members.php';
    exit;
}


if ($action === 'delete_member') {
    header('Content-Type: application/json');
    $user_id = (int)($_POST['user_id'] ?? 0);
    if ($user_id <= 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid user.']);
        exit;
    }
    $result = $adminModel->deleteMember($user_id);
    echo json_encode(['success' => $result]);
    exit;
}


if ($action === 'reviews') {
    $reviews = $adminModel->getAllReviews();
    require_once __DIR__ . '/../view/admin/reviews.php';
    exit;
}


if ($action === 'delete_review') {
    header('Content-Type: application/json');
    $review_id = (int)($_POST['review_id'] ?? 0);
    if ($review_id <= 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid review.']);
        exit;
    }
    $rows = $adminModel->deleteReview($review_id);
    echo json_encode(['success' => $rows > 0]);
    exit;
}
?>
