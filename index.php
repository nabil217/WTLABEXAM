<?php

require_once 'config/config.php';
require_once 'app/models/Database.php';
require_once 'app/models/Restaurant.php';

$dbObj = new Database();
$db = $dbObj->connect();

$restaurantModel = new Restaurant($db);

$restaurants = $restaurantModel->getAllRestaurants();

include 'app/views/layouts/header.php';
?>

<div class="container">

    <h1>Browse Restaurants</h1>

    <div class="search-box">
        <input type="text" id="search" placeholder="Search restaurant">

        <input type="text" id="location" placeholder="Location">

        <input type="text" id="area" placeholder="Area">
    </div>

    <div id="restaurant-list">

        <?php foreach($restaurants as $restaurant): ?>

            <div class="card">
                <h3><?= htmlspecialchars($restaurant['name']) ?></h3>
                <p><?= htmlspecialchars($restaurant['location']) ?></p>
                <p><?= htmlspecialchars($restaurant['area']) ?></p>

                <a href="restaurant.php?id=<?= $restaurant['id'] ?>">
                    View Restaurant
                </a>
            </div>

        <?php endforeach; ?>

    </div>

</div>

<?php include 'app/views/layouts/footer.php'; ?>