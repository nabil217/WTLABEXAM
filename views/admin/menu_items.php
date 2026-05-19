<!-- views/admin/menu_items.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu Items - <?= htmlspecialchars($restaurant['name']) ?> - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Nunito',sans-serif; background:#f4f6f9; color:#2d2d2d; }
        nav { background:#1a1a1a; padding:14px 40px; display:flex; align-items:center; gap:25px; }
        nav .brand { font-family:'Playfair Display',serif; font-size:1.3rem; color:#ff6b35; text-decoration:none; margin-right:auto; }
        nav a { color:#ccc; text-decoration:none; font-weight:600; font-size:0.9rem; }
        nav a:hover { color:#ff6b35; }
        nav .btn-nav { background:#ff6b35; color:white !important; padding:7px 18px; border-radius:20px; }

        .wrap { max-width:1000px; margin:0 auto; padding:35px 20px; }
        .flash { background:#d4edda; color:#155724; border:1px solid #c3e6cb; padding:12px 16px; border-radius:8px; margin-bottom:20px; }

        .rest-banner { background:linear-gradient(135deg,#1a1a1a,#2d1810); border-radius:14px; padding:25px 30px; margin-bottom:28px; color:white; }
        .rest-banner h1 { font-family:'Playfair Display',serif; font-size:1.6rem; margin-bottom:5px; }
        .rest-banner p { color:#aaa; font-size:0.88rem; }

        .sec-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; }
        .sec-header h2 { font-family:'Playfair Display',serif; font-size:1.3rem; }
        .btn-add { background:#ff6b35; color:white; padding:9px 20px; border-radius:25px; text-decoration:none; font-weight:700; font-size:0.88rem; }
        .btn-add:hover { background:#e55a24; }
        .btn-back { color:#888; text-decoration:none; font-size:0.88rem; display:inline-block; margin-bottom:20px; }
        .btn-back:hover { color:#ff6b35; }

        .table-wrap { background:white; border-radius:14px; box-shadow:0 3px 12px rgba(0,0,0,0.07); overflow:hidden; }
        table { width:100%; border-collapse:collapse; }
        thead { background:#1a1a1a; color:white; }
        th { padding:13px 16px; text-align:left; font-size:0.85rem; font-weight:700; }
        td { padding:13px 16px; border-bottom:1px solid #f0f0f0; font-size:0.9rem; vertical-align:middle; }
        tr:last-child td { border-bottom:none; }
        tr:hover td { background:#fffaf5; }

        .food-img { width:55px; height:45px; object-fit:cover; border-radius:8px; }
        .no-img { width:55px; height:45px; background:#f0f0f0; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:1.2rem; }
        .price { color:#ff6b35; font-weight:800; }

        .btn-edit { background:#3498db; color:white; padding:5px 14px; border-radius:15px; text-decoration:none; font-size:0.8rem; font-weight:700; margin-right:5px; }
        .btn-edit:hover { background:#2980b9; }
        .btn-del { background:none; border:2px solid #e74c3c; color:#e74c3c; padding:4px 13px; border-radius:15px; font-size:0.8rem; font-weight:700; cursor:pointer; }
        .btn-del:hover { background:#e74c3c; color:white; }
    </style>
</head>
<body>

<nav>
    <a href="index.php?page=home" class="brand">🍽 FoodBlog</a>
    <a href="index.php?page=admin">Dashboard</a>
    <a href="index.php?page=logout" class="btn-nav" style="margin-left:auto;">Logout</a>
</nav>

<div class="wrap">

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="flash"><?= htmlspecialchars($_SESSION['flash']) ?></div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <a href="index.php?page=admin" class="btn-back">← Back to Dashboard</a>

    <div class="rest-banner">
        <h1><?= htmlspecialchars($restaurant['name']) ?></h1>
        <p>📍 <?= htmlspecialchars($restaurant['location']) ?>, <?= htmlspecialchars($restaurant['area']) ?></p>
    </div>

    <div class="sec-header">
        <h2>Menu Items (<?= count($menuItems) ?>)</h2>
        <a href="index.php?page=admin-menu-item-create&restaurant_id=<?= $restaurant['id'] ?>" class="btn-add">+ Add Menu Item</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($menuItems)): ?>
                    <?php foreach ($menuItems as $item): ?>
                    <tr>
                        <td>
                            <?php if (!empty($item['image_path'])): ?>
                                <img src="public/uploads/menu/<?= htmlspecialchars($item['image_path']) ?>" class="food-img" alt="">
                            <?php else: ?>
                                <div class="no-img">🍽</div>
                            <?php endif; ?>
                        </td>
                        <td><strong><?= htmlspecialchars($item['name']) ?></strong></td>
                        <td style="max-width:250px;color:#666;"><?= htmlspecialchars(substr($item['description'], 0, 70)) ?>...</td>
                        <td><span class="price">৳<?= number_format($item['price'], 0) ?></span></td>
                        <td>
                            <a href="index.php?page=admin-menu-item-edit&id=<?= $item['id'] ?>" class="btn-edit">Edit</a>
                            <form method="POST" action="index.php?page=admin-menu-item-delete" style="display:inline;"
                                  onsubmit="return confirm('Delete \'<?= htmlspecialchars($item['name'], ENT_QUOTES) ?>\'?')">
                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                <input type="hidden" name="restaurant_id" value="<?= $restaurant['id'] ?>">
                                <button type="submit" class="btn-del">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center;color:#888;padding:30px;">No menu items yet. Add one!</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
