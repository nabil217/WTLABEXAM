<?php

require_once 'config/config.php';
require_once 'app/models/Database.php';
require_once 'app/models/MenuItem.php';

$dbObj = new Database();
$db = $dbObj->connect();

$menuModel = new MenuItem($db);

$restaurant_id = $_GET['id'];

$menuItems = $menuModel->getRestaurantMenu($restaurant_id);

include 'app/views/layouts/header.php';
?>

<div class="container">

<h1>Restaurant Menu</h1>

<?php foreach($menuItems as $item): ?>

<div class="card">
    <h3><?= htmlspecialchars($item['name']) ?></h3>
    <p><?= htmlspecialchars($item['description']) ?></p>
    <p>৳<?= $item['price'] ?></p>

    <a href="menu-item.php?id=<?= $item['id'] ?>">
        View Details
    </a>
</div>

<?php endforeach; ?>

</div>

<?php include 'app/views/layouts/footer.php'; ?>