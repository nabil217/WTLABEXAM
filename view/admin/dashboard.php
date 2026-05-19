<?php

require_once __DIR__ . '/../../config/auth.php';
requireAdmin();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Food Blog</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
<?php

$base = '../../';
require_once __DIR__ . '/../partials/navbar.php';
?>

<div class="container">
    <div class="page-header">
        <h1>⚙ Admin Dashboard</h1>
        <p>Manage members, posts, comments, and reviews.</p>
    </div>

    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= $counts['members'] ?></div>
            <div class="stat-label">Members</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $counts['posts'] ?></div>
            <div class="stat-label">Food Exp. Posts</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $counts['comments'] ?></div>
            <div class="stat-label">Post Comments</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $counts['reviews'] ?></div>
            <div class="stat-label">Food Item Reviews</div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-title">Quick Actions</div>
        <div class="flex-row mt-1">
            <a href="../../control/admin_controller.php?action=members"
               class="btn btn-primary">👥 Manage Members</a>
            <a href="../../control/admin_controller.php?action=reviews"
               class="btn btn-accent">🗑 Manage Food Reviews</a>
            <a href="../../control/food_experience_controller.php?action=list"
               class="btn btn-outline">🌟 Food Experience Posts</a>
        </div>
    </div>
</div>
</body>
</html>
