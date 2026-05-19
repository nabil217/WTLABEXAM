<?php

require_once __DIR__ . '/../../config/auth.php';
requireAdmin();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Food Reviews | Food Blog Admin</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
<?php
$base = '../../';
require_once __DIR__ . '/../partials/navbar.php';
?>

<div class="container">
    <div class="page-header">
        <h1>🗑 Manage Food Item Reviews</h1>
        <p>Remove any member review from food items.</p>
    </div>

    <div class="mb-2">
        <a href="../../control/admin_controller.php?action=dashboard" class="btn btn-outline btn-sm">← Dashboard</a>
    </div>

    <div id="action-message" class="flash flash-success" style="display:none;"></div>

    <?php if (empty($reviews)): ?>
        <div class="empty-state">
            <h3>No reviews found</h3>
        </div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Member</th>
                    <th>Food Item</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $r): ?>
                    <tr id="review-row-<?= $r['id'] ?>">
                        <td><?= $r['id'] ?></td>
                        <td><?= htmlspecialchars($r['member_name']) ?></td>
                        <td><?= htmlspecialchars($r['item_name']) ?></td>
                        <td><?= htmlspecialchars(substr($r['comment'], 0, 80)) ?><?= strlen($r['comment']) > 80 ? '...' : '' ?></td>
                        <td><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm"
                                    onclick="deleteReview(<?= $r['id'] ?>, this)">
                                Remove
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script src="../../public/js/admin.js"></script>
</body>
</html>
