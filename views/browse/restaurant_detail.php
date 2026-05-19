<!-- views/browse/restaurant_detail.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($restaurant['name']) ?> - FoodBlog</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Nunito',sans-serif; background:#fffaf5; color:#2d2d2d; }
        nav { background:#1a1a1a; padding:14px 40px; display:flex; align-items:center; gap:25px; position:sticky; top:0; z-index:100; box-shadow:0 2px 15px rgba(0,0,0,0.3); }
        nav .brand { font-family:'Playfair Display',serif; font-size:1.3rem; color:#ff6b35; text-decoration:none; margin-right:auto; }
        nav a { color:#ccc; text-decoration:none; font-weight:600; font-size:0.9rem; }
        nav a:hover { color:#ff6b35; }
        nav .btn-nav { background:#ff6b35; color:white !important; padding:7px 18px; border-radius:20px; }

        .page-wrap { max-width:900px; margin:0 auto; padding:40px 20px; }

        .rest-header { background:linear-gradient(135deg,#1a1a1a,#2d1810); border-radius:16px; padding:35px; margin-bottom:35px; color:white; }
        .rest-header h1 { font-family:'Playfair Display',serif; font-size:2rem; margin-bottom:10px; }
        .rest-header .meta { color:#aaa; font-size:0.9rem; }
        .rest-header .meta span { color:#ff6b35; }

        .menu-title { font-family:'Playfair Display',serif; font-size:1.6rem; margin-bottom:5px; color:#1a1a1a; }
        .menu-title span { color:#ff6b35; }
        .menu-sub { color:#888; font-size:0.88rem; margin-bottom:25px; }

        .menu-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:18px; margin-bottom:35px; }
        .menu-card { background:white; border-radius:14px; overflow:hidden; box-shadow:0 3px 12px rgba(0,0,0,0.07); transition:transform 0.3s,box-shadow 0.3s; }
        .menu-card:hover { transform:translateY(-4px); box-shadow:0 8px 25px rgba(0,0,0,0.12); }
        .menu-card-body { padding:14px; }
        .menu-card-body h4 { font-family:'Playfair Display',serif; font-size:1rem; margin-bottom:8px; color:#1a1a1a; }
        .price { font-size:1.1rem; font-weight:800; color:#ff6b35; }

        .back-link { display:inline-block; color:#ff6b35; font-weight:700; text-decoration:none; font-size:0.9rem; }
        .back-link:hover { text-decoration:underline; }

        footer { background:#111; color:#666; text-align:center; padding:22px; font-size:0.85rem; margin-top:40px; }
        footer span { color:#ff6b35; }

        @media(max-width:700px) { .menu-grid { grid-template-columns:repeat(2,1fr); } nav { padding:12px 20px; gap:12px; } }
        @media(max-width:450px) { .menu-grid { grid-template-columns:1fr; } }
    </style>
</head>
<body>

<nav>
    <a href="index.php?page=home" class="brand">🍽 FoodBlog</a>
    <a href="index.php?page=restaurants">Restaurants</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <span style="color:#aaa;font-size:0.88rem;">Hi, <?= htmlspecialchars($_SESSION['name']) ?> 👋</span>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="index.php?page=admin" style="color:#ff6b35;">Admin</a>
        <?php endif; ?>
        <a href="index.php?page=profile">Profile</a>
        <a href="index.php?page=logout" class="btn-nav">Logout</a>
    <?php else: ?>
        <a href="index.php?page=login">Login</a>
        <a href="index.php?page=register" class="btn-nav">Join Free</a>
    <?php endif; ?>
</nav>

<div class="page-wrap">

    <!-- Restaurant Header -->
    <div class="rest-header">
        <h1><?= htmlspecialchars($restaurant['name']) ?></h1>
        <div class="meta">
            <span>📍 <?= htmlspecialchars($restaurant['location']) ?>, <?= htmlspecialchars($restaurant['area']) ?></span>
        </div>
    </div>

    <!-- Menu Items — name + price only -->
    <div class="menu-title">Our <span>Menu</span></div>
    <div class="menu-sub">Delicious items to choose from</div>

    <?php if (!empty($menuItems)): ?>
        <div class="menu-grid">
            <?php foreach ($menuItems as $item): ?>
            <div class="menu-card">
                <div class="menu-card-body">
                    <h4><?= htmlspecialchars($item['name']) ?></h4>
                    <span class="price">৳<?= number_format($item['price'], 0) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="color:#888;margin-bottom:25px;">No menu items yet.</p>
    <?php endif; ?>

    <a href="index.php?page=restaurants" class="back-link">← Back to Restaurants</a>
</div>

<footer>
    <p>© 2025 <span>FoodBlog</span> — Web Technologies Project | Made with ❤️ in Dhaka</p>
</footer>
</body>
</html>