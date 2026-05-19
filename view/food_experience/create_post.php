<?php

require_once __DIR__ . '/../../config/auth.php';
requireLogin();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write a Food Experience | Food Blog</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container">
    <div class="page-header">
        <h1> Write a Food Experience</h1>
        <p>Share your restaurant visit or food review with the community.</p>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="errors-box">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card" style="border-left-color:#F4A261">
        <form action="../../control/food_experience_controller.php?action=create"
              method="POST" id="post-form" novalidate>

            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" class="form-control"
                       placeholder="e.g. Amazing Biriyani at Restaurant X"
                       value="<?= htmlspecialchars($title ?? '') ?>" maxlength="255">
                <div class="form-error" id="title-error"></div>
            </div>

            <div class="form-group">
                <label for="post_type">Post Type *</label>
                <select id="post_type" name="post_type" class="form-control">
                    <option value="restaurant" <?= (isset($post_type) && $post_type==='restaurant') ? 'selected' : '' ?>>Restaurant Review</option>
                    <option value="food"       <?= (isset($post_type) && $post_type==='food')       ? 'selected' : '' ?>>Food Item Review</option>
                    <option value="both"       <?= (!isset($post_type) || $post_type==='both')      ? 'selected' : '' ?>>Both</option>
                </select>
            </div>

            <div class="form-group">
                <label for="content">Your Experience *</label>
                <textarea id="content" name="content" class="form-control" rows="8"
                          placeholder="Describe your experience in detail (at least 10 characters)..."><?= htmlspecialchars($content ?? '') ?></textarea>
                <div class="form-error" id="content-error"></div>
            </div>

            <div class="flex-row">
                <button type="submit" class="btn btn-primary">Publish Post</button>
                <a href="../../control/food_experience_controller.php?action=list"
                   class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="../../public/js/food_experience.js"></script>
</body>
</html>
