<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodBlog - Discover Amazing Food</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Nunito', sans-serif; background: #fffaf5; color: #2d2d2d; }

        /* NAVBAR */
        nav {
            background: #1a1a1a; padding: 14px 40px;
            display: flex; align-items: center; gap: 25px;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 2px 15px rgba(0,0,0,0.3);
        }
        nav .brand { font-family: 'Playfair Display', serif; font-size: 1.3rem; color: #ff6b35; text-decoration: none; margin-right: auto; }
        nav a { color: #ccc; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: color 0.2s; }
        nav a:hover { color: #ff6b35; }
        nav .btn-nav { background: #ff6b35; color: white ; padding: 7px 18px; border-radius: 20px; }

        /* HERO */
        .hero {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d1810 60%, #1a1a1a 100%);
            padding: 80px 20px 70px;
            text-align: center;
            position: relative; overflow: hidden;
        }
        .hero::before { content:''; position:absolute; inset:0; background: radial-gradient(ellipse at center, rgba(255,107,53,0.12) 0%, transparent 70%); }
        .hero-content { position: relative; z-index: 1; max-width: 600px; margin: 0 auto; }
        .hero h1 { font-family: 'Playfair Display', serif; font-size: 2.6rem; color: white; line-height: 1.2; margin-bottom: 16px; }
        .hero h1 span { color: #ff6b35; }
        .hero p { color: #aaa; font-size: 1rem; margin-bottom: 35px; line-height: 1.7; }
        .hero-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

        .btn-primary { background: #ff6b35; color: white; padding: 12px 30px; border-radius: 30px; text-decoration: none; font-weight: 700; font-size: 0.95rem; transition: all 0.3s; box-shadow: 0 4px 15px rgba(255,107,53,0.35); display: inline-block; }
        .btn-primary:hover { background: #e55a24; transform: translateY(-2px); }

        /* FOOD IMAGE STRIP */
        .food-strip { display: grid; grid-template-columns: repeat(4, 1fr); height: 200px; overflow: hidden; }
        .food-img { position: relative; overflow: hidden; }
        .food-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; filter: brightness(0.82); }
        .food-img:hover img { transform: scale(1.07); filter: brightness(1); }
        .food-img .label { position: absolute; bottom: 10px; left: 10px; background: rgba(0,0,0,0.6); color: white; padding: 4px 12px; border-radius: 15px; font-size: 0.78rem; font-weight: 700; }

        /* FEATURED RESTAURANTS */
        .section { padding: 60px 40px; }
        .section-title { font-family: 'Playfair Display', serif; font-size: 1.9rem; margin-bottom: 6px; color: #1a1a1a; }
        .section-title span { color: #ff6b35; }
        .section-sub { color: #888; font-size: 0.9rem; margin-bottom: 30px; }

        .cards-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .card { background: white; border-radius: 14px; overflow: hidden; box-shadow: 0 3px 15px rgba(0,0,0,0.07); transition: transform 0.3s, box-shadow 0.3s; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px white(0,0,0,0.12); }
        .card-img { width: 100%; height: 170px; object-fit: cover; }
        .card-body { padding: 18px; }
        .card-body h3 { font-family: 'Playfair Display', serif; font-size: 1.15rem; margin-bottom: 5px; }
        .card-meta { color: blue; font-size: 0.82rem; margin-bottom: 10px; }
        .card-body p { font-size: 0.87rem; color: #666; line-height: 1.55; margin-bottom: 14px; }
        .card-link { color:red; font-weight: 700; text-decoration: none; font-size: 0.87rem; }
        .card-link:hover { text-decoration: underline; }

        footer { background: #111; color: #666; text-align: center; padding: 22px; font-size: 0.85rem; }
        footer span { color: #ff6b35; }

        @media (max-width: 900px) { .cards-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) {
            .food-strip { grid-template-columns: repeat(2, 1fr); }
            .cards-grid { grid-template-columns: 1fr; }
            .section { padding: 40px 20px; }
            nav { padding: 12px 20px; gap: 12px; }
            .hero h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <a href="index.php?page=home" class="brand">🍽 FoodBlog</a>
    <a href="index.php?page=restaurants">Restaurants</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <span style="color:#aaa; font-size:0.88rem;">Hi, <?= htmlspecialchars($_SESSION['name']) ?> 👋</span>
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

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <h1>Discover the <span>Best Food</span> Around You</h1>
        <p>Explore top restaurants, browse delicious menus, and share your food experiences with food lovers across Bangladesh.</p>
        <div class="hero-btns">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="index.php?page=register" class="btn-primary">🚀 Join Now — It's Free</a>
            <?php else: ?>
                <a href="index.php?page=restaurants" class="btn-primary">🍴 Explore Restaurants</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- FOOD IMAGE STRIP -->
<div class="food-strip">
    <div class="food-img">
        <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=400&h=200&fit=crop" alt="Pizza">
        <span class="label">🍕 Pizza</span>
    </div>
    <div class="food-img">
        <img src="https://images.unsplash.com/photo-1589302168068-964664d93dc0?w=400&h=200&fit=crop" alt="Biryani">
        <span class="label">🍚 Biryani</span>
    </div>
    <div class="food-img">
        <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400&h=200&fit=crop" alt="Burger">
        <span class="label">🍔 Burger</span>
    </div>
    <div class="food-img">
        <img src="https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?w=400&h=200&fit=crop" alt="Curry">
        <span class="label">🍛 Curry</span>
    </div>
</div>

<!-- FEATURED RESTAURANTS — only 3 shown -->
<section class="section">
    <div class="section-title">Featured <span>Restaurants</span></div>
    <div class="section-sub">Hand-picked top restaurants for you to explore</div>
    <div class="cards-grid">
        <?php
        $cardImages = [
            'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=400&h=180&fit=crop',
            'https://images.unsplash.com/photo-1552566626-52f8b828add9?w=400&h=180&fit=crop',
            'https://images.unsplash.com/photo-1537047902294-62a40c20a6ae?w=400&h=180&fit=crop',
        ];
        // Show only first 3
        $i = 0;
        foreach (array_slice($restaurants, 0, 3) as $r):
            $img = $cardImages[$i % count($cardImages)]; $i++;
        ?>
        <div class="card">
            <img src="<?= $img ?>" alt="<?= htmlspecialchars($r['name']) ?>" class="card-img">
            <div class="card-body">
                <h3><?= htmlspecialchars($r['name']) ?></h3>
                <div class="card-meta">📍 <?= htmlspecialchars($r['location']) ?> · <?= htmlspecialchars($r['area']) ?></div>
                <p><?= htmlspecialchars(substr($r['short_background'], 0, 85)) ?>...</p>
                <a href="index.php?page=restaurant&id=<?= $r['id'] ?>" class="card-link">View Menu →</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- See All button → goes to restaurants page which shows all 5 -->
    <div style="text-align:center; margin-top:38px;">
        <a href="index.php?page=restaurants" class="btn-primary">See All Restaurants →</a>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <p>© 2025 <span>FoodBlog</span> — Web Technologies Project | Made with ❤️ in Dhaka</p>
</footer>

</body>
</html>