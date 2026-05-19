<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../model/FoodExperienceComment.php';
require_once __DIR__ . '/../model/FoodExperiencePost.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add_comment') {
    if (!isLoggedIn()) {
        echo json_encode(['success' => false, 'error' => 'Login required.']);
        exit;
    }
    $post_id = (int)($_POST['post_id'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');

    
    if ($post_id <= 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid post.']);
        exit;
    }
    if (empty($comment)) {
        echo json_encode(['success' => false, 'error' => 'Comment cannot be empty.']);
        exit;
    }
    if (strlen($comment) > 1000) {
        echo json_encode(['success' => false, 'error' => 'Comment too long (max 1000 chars).']);
        exit;
    }

    $model = new FoodExperienceComment();
    $new_id = $model->addComment($post_id, getCurrentUserId(), htmlspecialchars($comment, ENT_QUOTES, 'UTF-8'));

    echo json_encode([
        'success'     => true,
        'comment_id'  => $new_id,
        'author_name' => getCurrentUserName(),
        'comment'     => htmlspecialchars($comment, ENT_QUOTES, 'UTF-8'),
        'created_at'  => date('Y-m-d H:i:s'),
        'user_id'     => getCurrentUserId(),
    ]);
    exit;
}


if ($action === 'delete_comment') {
    if (!isLoggedIn()) {
        echo json_encode(['success' => false, 'error' => 'Login required.']);
        exit;
    }
    $comment_id = (int)($_POST['comment_id'] ?? 0);
    if ($comment_id <= 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid comment.']);
        exit;
    }

    $model = new FoodExperienceComment();
    $rows = $model->deleteComment($comment_id, getCurrentUserId(), isAdmin());

    if ($rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Not authorised or comment not found.']);
    }
    exit;
}


if ($action === 'delete_post') {
    if (!isLoggedIn()) {
        echo json_encode(['success' => false, 'error' => 'Login required.']);
        exit;
    }
    $post_id = (int)($_POST['post_id'] ?? 0);
    if ($post_id <= 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid post.']);
        exit;
    }

    $model = new FoodExperiencePost();
    $rows = $model->deletePost($post_id, getCurrentUserId(), isAdmin());

    if ($rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Not authorised or post not found.']);
    }
    exit;
}

echo json_encode(['success' => false, 'error' => 'Unknown action.']);
?>
