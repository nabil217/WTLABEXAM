<?php

require_once '../config/config.php';
require_once '../app/models/Database.php';
require_once '../app/models/Restaurant.php';

header('Content-Type: application/json');

$dbObj = new Database();
$db = $dbObj->connect();

$model = new Restaurant($db);

$q = $_GET['q'] ?? '';
$location = $_GET['location'] ?? '';
$area = $_GET['area'] ?? '';

$data = $model->searchRestaurants($q, $location, $area);

echo json_encode($data);