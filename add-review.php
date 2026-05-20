<?php

require_once '../config/config.php';
require_once '../app/models/Database.php';
require_once '../app/models/Review.php';

header('Content-Type: application/json');

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'member') {

    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized'
    ]);

    exit;
}

$menu_item_id = $_POST['menu_item_id'];
$comment = trim($_POST['comment']);

if(empty($comment)) {

    echo json_encode([
        'success' => false,
        'message' => 'Comment required'
    ]);

    exit;
}

$dbObj = new Database();
$db = $dbObj->connect();

$model = new Review($db);

$model->addReview($menu_item_id, $_SESSION['user_id'], htmlspecialchars($comment));

echo json_encode([
    'success' => true,
    'message' => 'Review Added'
]);