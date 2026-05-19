<!-- views/browse/menu_item_detail.php -->
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($item['name']) ?> - Food Blog</title>
    <style>
        body { font-family: Arial; max-width: 700px; margin: 0 auto; padding: 20px; }
        .item-img { width: 100%; max-height: 300px; object-fit: cover; border-radius: 10px; }
        .info-box { background: #f9f9f9; padding: 15px; border-radius: 8px; margin: 15px 0; }
        .review-note { background: #fff3cd; padding: 10px; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <?php include 'views/partials/navbar.php'; ?>

    <?php if (!empty($item['image_path'])): ?>
        <img src="public/uploads/menu/<?= htmlspecialchars($item['image_path']) ?>" class="item-img" alt="">
    <?php endif; ?>

    <h2><?= htmlspecialchars($item['name']) ?></h2>

    <div class="info-box">
        <p><?= htmlspecialchars($item['description']) ?></p>
        <p><strong>Price: ৳<?= number_format($item['price'], 2) ?></strong></p>
        <p>From: <a href="index.php?page=restaurant&id=<?= $restaurant['id'] ?>">
            <?= htmlspecialchars($restaurant['name']) ?>
        </a></p>
    </div>

    <!-- Review section — only shown to members (posting handled in Task 3) -->
    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'member'): ?>
        <div class="review-note">
            <p>⭐ As a member, you can post reviews on this item. (Review form is in Task 3)</p>
        </div>
    <?php elseif (!isset($_SESSION['user_id'])): ?>
        <div class="review-note">
            <p>🔒 <a href="index.php?page=login">Login</a> or <a href="index.php?page=register">Register</a>
               to post reviews.</p>
        </div>
    <?php endif; ?>

    <br><a href="index.php?page=restaurant&id=<?= $restaurant['id'] ?>">← Back to Restaurant</a>
</body>
</html>
