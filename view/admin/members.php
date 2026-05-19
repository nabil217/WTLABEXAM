<?php

require_once __DIR__ . '/../../config/auth.php';
requireAdmin();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members | Food Blog Admin</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
<?php
$base = '../../';
require_once __DIR__ . '/../partials/navbar.php';
?>

<div class="container">
    <div class="page-header">
        <h1>👥 Manage Members</h1>
        <p>Remove members and all their content (posts, comments, reviews).</p>
    </div>

    <div class="mb-2">
        <a href="../../control/admin_controller.php?action=dashboard" class="btn btn-outline btn-sm">← Dashboard</a>
    </div>

    <div id="action-message" class="flash flash-success" style="display:none;"></div>

    <?php if (empty($members)): ?>
        <div class="empty-state">
            <h3>No members found</h3>
        </div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Joined</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="members-table-body">
                <?php foreach ($members as $member): ?>
                    <tr id="member-row-<?= $member['id'] ?>">
                        <td><?= $member['id'] ?></td>
                        <td><?= htmlspecialchars($member['name']) ?></td>
                        <td><?= htmlspecialchars($member['email']) ?></td>
                        <td><?= date('d M Y', strtotime($member['created_at'])) ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm"
                                    onclick="deleteMember(<?= $member['id'] ?>, '<?= htmlspecialchars(addslashes($member['name'])) ?>', this)">
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
