<!-- views/admin/dashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - FoodBlog</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Nunito',sans-serif; background:#f4f6f9; color:#2d2d2d; }

        /* NAVBAR */
        nav { background:#1a1a1a; padding:14px 40px; display:flex; align-items:center; gap:25px; position:sticky; top:0; z-index:100; box-shadow:0 2px 15px rgba(0,0,0,0.3); }
        nav .brand { font-family:'Playfair Display',serif; font-size:1.3rem; color:#ff6b35; text-decoration:none; margin-right:auto; }
        nav a { color:#ccc; text-decoration:none; font-weight:600; font-size:0.9rem; }
        nav a:hover { color:#ff6b35; }
        nav .btn-nav { background:#ff6b35; color:white !important; padding:7px 18px; border-radius:20px; }

        .wrap { max-width:1100px; margin:0 auto; padding:35px 20px; }

        /* Flash */
        .flash { background:#d4edda; color:#155724; border:1px solid #c3e6cb; padding:12px 16px; border-radius:8px; margin-bottom:20px; }
        .flash-err { background:#f8d7da; color:#721c24; border-color:#f5c6cb; }

        /* Page title */
        .page-title { font-family:'Playfair Display',serif; font-size:1.8rem; margin-bottom:5px; }
        .page-title span { color:#ff6b35; }
        .page-sub { color:#888; font-size:0.9rem; margin-bottom:30px; }

        /* Stat cards */
        .stats { display:grid; grid-template-columns:repeat(4,1fr); gap:18px; margin-bottom:35px; }
        .stat-card { background:white; border-radius:14px; padding:22px 20px; box-shadow:0 3px 12px rgba(0,0,0,0.07); border-left:4px solid #ff6b35; }
        .stat-card .num { font-family:'Playfair Display',serif; font-size:2.2rem; font-weight:700; color:#ff6b35; }
        .stat-card .lbl { color:#888; font-size:0.85rem; font-weight:600; margin-top:4px; }

        /* Section header */
        .sec-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; }
        .sec-header h2 { font-family:'Playfair Display',serif; font-size:1.4rem; }
        .btn-add { background:#ff6b35; color:white; padding:9px 20px; border-radius:25px; text-decoration:none; font-weight:700; font-size:0.88rem; transition:background 0.2s; }
        .btn-add:hover { background:#e55a24; }

        /* Table */
        .table-wrap { background:white; border-radius:14px; box-shadow:0 3px 12px rgba(0,0,0,0.07); overflow:hidden; margin-bottom:35px; }
        table { width:100%; border-collapse:collapse; }
        thead { background:#1a1a1a; color:white; }
        th { padding:13px 16px; text-align:left; font-size:0.85rem; font-weight:700; }
        td { padding:13px 16px; border-bottom:1px solid #f0f0f0; font-size:0.9rem; vertical-align:middle; }
        tr:last-child td { border-bottom:none; }
        tr:hover td { background:#fffaf5; }

        .badge { display:inline-block; padding:3px 10px; border-radius:12px; font-size:0.75rem; font-weight:700; background:#fff3e0; color:#ff6b35; }

        /* Action buttons */
        .btn-edit { background:#3498db; color:white; padding:5px 14px; border-radius:15px; text-decoration:none; font-size:0.8rem; font-weight:700; margin-right:5px; }
        .btn-edit:hover { background:#2980b9; }
        .btn-manage { background:#27ae60; color:white; padding:5px 14px; border-radius:15px; text-decoration:none; font-size:0.8rem; font-weight:700; margin-right:5px; }
        .btn-manage:hover { background:#219a52; }
        .btn-del { background:none; border:2px solid #e74c3c; color:#e74c3c; padding:4px 13px; border-radius:15px; font-size:0.8rem; font-weight:700; cursor:pointer; }
        .btn-del:hover { background:#e74c3c; color:white; }

        @media(max-width:800px) { .stats { grid-template-columns:repeat(2,1fr); } nav { padding:12px 20px; gap:12px; } }
        @media(max-width:500px) { .stats { grid-template-columns:1fr; } }
    </style>
</head>
<body>

<nav>
    <a href="index.php?page=home" class="brand">🍽 FoodBlog</a>
    <a href="index.php?page=home">Home</a>
    <a href="index.php?page=restaurants">Restaurants</a>
    <span style="color:#ff6b35;font-weight:700;">Admin Panel</span>
    <a href="index.php?page=profile" style="margin-left:auto;">👤 <?= htmlspecialchars($_SESSION['name']) ?></a>
    <a href="index.php?page=logout" class="btn-nav">Logout</a>
</nav>

<div class="wrap">

    <!-- Flash message -->
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="flash"><?= htmlspecialchars($_SESSION['flash']) ?></div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="page-title">Admin <span>Dashboard</span></div>
    <div class="page-sub">Manage all restaurants and menu items from here.</div>

    <!-- Stats -->
    <div class="stats">
        <div class="stat-card">
            <div class="num"><?= $totalRestaurants ?></div>
            <div class="lbl">🍴 Restaurants</div>
        </div>
        <div class="stat-card">
            <div class="num"><?= $totalMenuItems ?></div>
            <div class="lbl">🍽 Menu Items</div>
        </div>
        <div class="stat-card">
            <div class="num"><?= $totalReviews ?></div>
            <div class="lbl">⭐ Reviews</div>
        </div>
        <div class="stat-card">
            <div class="num"><?= $totalPosts ?></div>
            <div class="lbl">📝 Food Posts</div>
        </div>
    </div>

    <!-- Restaurants Table -->
    <div class="sec-header">
        <h2>All Restaurants</h2>
        <a href="index.php?page=admin-restaurant-create" class="btn-add">+ Add Restaurant</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Area</th>
                    <th>Menu Items</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($restaurants)): ?>
                    <?php foreach ($restaurants as $i => $r): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><strong><?= htmlspecialchars($r['name']) ?></strong></td>
                        <td><?= htmlspecialchars($r['location']) ?></td>
                        <td><span class="badge"><?= htmlspecialchars($r['area']) ?></span></td>
                        <td>
                            <a href="index.php?page=admin-menu-items&restaurant_id=<?= $r['id'] ?>" class="btn-manage">Manage Menu</a>
                        </td>
                        <td>
                            <a href="index.php?page=admin-restaurant-edit&id=<?= $r['id'] ?>" class="btn-edit">Edit</a>
                            <form method="POST" action="index.php?page=admin-restaurant-delete" style="display:inline;"
                                  onsubmit="return confirmDelete('<?= htmlspecialchars($r['name'], ENT_QUOTES) ?>', 'restaurant')">
                                <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                <button type="submit" class="btn-del">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center;color:#888;padding:30px;">No restaurants yet. Add one!</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<script>
function confirmDelete(name, type) {
    return confirm('Are you sure you want to delete "' + name + '"?\n' +
        (type === 'restaurant' ? 'All menu items will also be deleted!' : ''));
}
</script>

</body>
</html>
