<!-- views/browse/restaurants.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restaurants - FoodBlog</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Nunito',sans-serif; background:#fffaf5; color:#2d2d2d; }
        nav { background:#1a1a1a; padding:14px 40px; display:flex; align-items:center; gap:25px; position:sticky; top:0; z-index:100; box-shadow:0 2px 15px rgba(0,0,0,0.3); }
        nav .brand { font-family:'Playfair Display',serif; font-size:1.3rem; color:#ff6b35; text-decoration:none; margin-right:auto; }
        nav a { color:#ccc; text-decoration:none; font-weight:600; font-size:0.9rem; }
        nav a:hover { color:#ff6b35; }
        nav .btn-nav { background:#ff6b35; color:white ; padding:7px 18px; border-radius:20px; }

        .wrap { max-width:900px; margin:0 auto; padding:40px 20px; }
        .page-title { font-family:'Playfair Display',serif; font-size:1.9rem; margin-bottom:6px; }
        .page-title span { color:#ff6b35; }
        .page-sub { color:#888; font-size:0.9rem; margin-bottom:30px; }

        .cards-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:22px; }
        .card { background:white; border-radius:14px; overflow:hidden; box-shadow:0 3px 15px rgba(0,0,0,0.07); transition:transform 0.3s,box-shadow 0.3s; }
        .card:hover { transform:translateY(-5px); box-shadow:0 10px 30px rgba(0,0,0,0.12); }
        .card-img { width:100%; height:170px; object-fit:cover; }
        .card-body { padding:18px; }
        .card-body h3 { font-family:'Playfair Display',serif; font-size:1.15rem; margin-bottom:5px; }
        .card-meta { color:#999; font-size:0.82rem; margin-bottom:10px; }
        .card-body p { font-size:0.87rem; color:#666; line-height:1.55; margin-bottom:14px; }
        .card-link { color:#ff6b35; font-weight:700; text-decoration:none; font-size:0.87rem; }
        .card-link:hover { text-decoration:underline; }

        footer { background:#111; color:#666; text-align:center; padding:22px; font-size:0.85rem; margin-top:40px; }
        footer span { color:#ff6b35; }
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

<div class="wrap">
    <div class="page-title">All <span>Restaurants</span></div>
    <div class="page-sub">Browse all restaurants and explore their menus</div>

    <?php
    $cardImages = [
        'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=400&h=180&fit=crop',
        'https://images.unsplash.com/photo-1552566626-52f8b828add9?w=400&h=180&fit=crop',
        'https://images.unsplash.com/photo-1537047902294-62a40c20a6ae?w=400&h=180&fit=crop',
        'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=400&h=180&fit=crop',
        'https://images.unsplash.com/photo-1424847651672-bf20a4b0982b?w=400&h=180&fit=crop',
    ];
    ?>

    <?php if (!empty($restaurants)): ?>
        <div class="cards-grid">
            <?php $i = 0; foreach ($restaurants as $r): ?>
            <div class="card">
                <img src="<?= $cardImages[$i % count($cardImages)] ?>" class="card-img" alt="<?= htmlspecialchars($r['name']) ?>">
                <div class="card-body">
                    <h3><?= htmlspecialchars($r['name']) ?></h3>
                    <div class="card-meta">📍 <?= htmlspecialchars($r['location']) ?> · <?= htmlspecialchars($r['area']) ?></div>
                    <p><?= htmlspecialchars(substr($r['short_background'], 0, 85)) ?>...</p>
                    <a href="index.php?page=restaurant&id=<?= $r['id'] ?>" class="card-link">View Menu →</a>
                </div>
            </div>
            <?php $i++; endforeach; ?>
        </div>
    <?php else: ?>
        <p style="color:#888;">No restaurants found.</p>
    <?php endif; ?>
</div>

<footer>
    <p>© 2025 <span>FoodBlog</span> — Web Technologies Project | Made with ❤️ in Dhaka</p>
</footer>
</body>
</html>