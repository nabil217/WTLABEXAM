<?php

require_once __DIR__ . '/../../config/auth.php';

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);


if (!isset($posts)) {
    require_once __DIR__ . '/../../model/FoodExperiencePost.php';
    $model = new FoodExperiencePost();
    $posts = $model->getAllPosts();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Experience | Food Blog</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container">
    <div class="page-header">
        <h1> Food Experience</h1>
        <p>Discover descriptive food stories shared by our community.</p>
    </div>

    <?php if ($flash): ?>
        <div class="flash flash-success"><?= htmlspecialchars($flash) ?></div>
    <?php endif; ?>

    <?php if (isMember()): ?>
        <div class="mb-2">
            <a href="../../control/food_experience_controller.php?action=create" class="btn btn-primary">
                + Write a Food Experience
            </a>
        </div>
    <?php else: ?>
        <div class="visitor-notice">
             <strong>Want to share your experience?</strong>
            <a href="../login.php">Login</a> or <a href="../register.php">Register</a> to post.
        </div>
    <?php endif; ?>

    <?php if (empty($posts)): ?>
        <div class="empty-state">
            <h3>No posts yet</h3>
            <p>Be the first to share a food experience!</p>
        </div>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <div class="card">
                <div class="card-title">
                    <a href="../../control/food_experience_controller.php?action=view&id=<?= $post['id'] ?>">
                        <?= htmlspecialchars($post['title']) ?>
                    </a>
                </div>
                <div class="card-meta">
                    <span> <?= htmlspecialchars($post['author_name']) ?></span>
                    <span> <?= date('d M Y', strtotime($post['created_at'])) ?></span>
                    <span>
                        <span class="badge badge-<?= $post['post_type'] ?>">
                            <?= ucfirst($post['post_type']) ?>
                        </span>
                    </span>
                </div>
                <div class="card-excerpt">
                    <?= htmlspecialchars(substr($post['content'], 0, 180)) ?>
                    <?= strlen($post['content']) > 180 ? '...' : '' ?>
                </div>
                <div class="flex-row mt-1">
                    <a href="../../control/food_experience_controller.php?action=view&id=<?= $post['id'] ?>"
                       class="btn btn-outline btn-sm">Read More</a>

                    <?php if (isLoggedIn() && ($post['user_id'] == getCurrentUserId() || isAdmin())): ?>
                        <a href="../../control/food_experience_controller.php?action=edit&id=<?= $post['id'] ?>"
                           class="btn btn-accent btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm"
                                onclick="deletePost(<?= $post['id'] ?>, this)">Delete</button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script src="../../public/js/food_experience.js"></script>
</body>
</html>
