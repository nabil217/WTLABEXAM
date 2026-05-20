<?php

require_once '../config/config.php';
require_once '../app/models/Database.php';
require_once '../app/models/Review.php';

header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])) {

    echo json_encode([
        'success' => false
    ]);

    exit;
}

$review_id = $_POST['review_id'];

$dbObj = new Database();
$db = $dbObj->connect();

$model = new Review($db);

$model->deleteReview($review_id, $_SESSION['user_id']);

echo json_encode([
    'success' => true
]);