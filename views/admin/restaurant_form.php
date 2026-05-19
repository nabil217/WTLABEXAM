<!-- views/admin/restaurant_form.php -->
<!-- Used for both CREATE and EDIT — $mode = 'create' or 'edit' -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $mode === 'edit' ? 'Edit' : 'Add' ?> Restaurant - FoodBlog Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Nunito',sans-serif; background:#f4f6f9; color:#2d2d2d; }
        nav { background:#1a1a1a; padding:14px 40px; display:flex; align-items:center; gap:25px; }
        nav .brand { font-family:'Playfair Display',serif; font-size:1.3rem; color:#ff6b35; text-decoration:none; margin-right:auto; }
        nav a { color:#ccc; text-decoration:none; font-weight:600; font-size:0.9rem; }
        nav a:hover { color:#ff6b35; }
        nav .btn-nav { background:#ff6b35; color:white !important; padding:7px 18px; border-radius:20px; }

        .wrap { max-width:650px; margin:40px auto; padding:0 20px; }
        .form-card { background:white; border-radius:16px; padding:35px; box-shadow:0 4px 20px rgba(0,0,0,0.08); }
        .form-title { font-family:'Playfair Display',serif; font-size:1.6rem; margin-bottom:5px; }
        .form-title span { color:#ff6b35; }
        .form-sub { color:#888; font-size:0.88rem; margin-bottom:28px; }

        .error-box { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; padding:12px 16px; border-radius:8px; margin-bottom:20px; }
        .error-box p { margin:2px 0; font-size:0.88rem; }

        label { display:block; font-weight:700; font-size:0.88rem; margin-bottom:5px; color:#444; }
        input[type=text], textarea {
            width:100%; padding:10px 14px; border:1.5px solid #ddd; border-radius:8px;
            font-family:'Nunito',sans-serif; font-size:0.92rem; margin-bottom:18px;
            transition:border-color 0.2s;
        }
        input[type=text]:focus, textarea:focus { outline:none; border-color:#ff6b35; }
        textarea { resize:vertical; min-height:90px; }

        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:15px; }

        .btn-submit { background:#ff6b35; color:white; padding:12px 30px; border:none; border-radius:25px; font-family:'Nunito',sans-serif; font-size:0.95rem; font-weight:700; cursor:pointer; transition:background 0.2s; }
        .btn-submit:hover { background:#e55a24; }
        .btn-cancel { color:#888; text-decoration:none; font-size:0.88rem; margin-left:15px; }
        .btn-cancel:hover { color:#ff6b35; }

        .field-err { color:#e74c3c; font-size:0.78rem; margin-top:-14px; margin-bottom:12px; display:block; }
    </style>
</head>
<body>

<nav>
    <a href="index.php?page=home" class="brand">🍽 FoodBlog</a>
    <a href="index.php?page=admin">Dashboard</a>
    <a href="index.php?page=logout" class="btn-nav" style="margin-left:auto;">Logout</a>
</nav>

<div class="wrap">
    <div class="form-card">
        <div class="form-title"><?= $mode === 'edit' ? 'Edit' : 'Add New' ?> <span>Restaurant</span></div>
        <div class="form-sub"><?= $mode === 'edit' ? 'Update restaurant details below.' : 'Fill in the details to add a new restaurant.' ?></div>

        <!-- Server errors -->
        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $e): ?>
                    <p>⚠ <?= htmlspecialchars($e) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST"
              action="index.php?page=<?= $mode === 'edit' ? 'admin-restaurant-edit' : 'admin-restaurant-create' ?>"
              id="restForm">

            <?php if ($mode === 'edit'): ?>
                <input type="hidden" name="id" value="<?= $restaurant['id'] ?>">
            <?php endif; ?>

            <label>Restaurant Name *</label>
            <input type="text" name="name" id="name"
                   value="<?= htmlspecialchars($restaurant['name'] ?? $_POST['name'] ?? '') ?>"
                   placeholder="e.g. Kacchi Bhai" required>
            <span class="field-err" id="nameErr"></span>

            <div class="form-row">
                <div>
                    <label>Location *</label>
                    <input type="text" name="location" id="location"
                           value="<?= htmlspecialchars($restaurant['location'] ?? $_POST['location'] ?? '') ?>"
                           placeholder="e.g. Dhaka" required>
                    <span class="field-err" id="locationErr"></span>
                </div>
                <div>
                    <label>Area *</label>
                    <input type="text" name="area" id="area"
                           value="<?= htmlspecialchars($restaurant['area'] ?? $_POST['area'] ?? '') ?>"
                           placeholder="e.g. Dhanmondi" required>
                    <span class="field-err" id="areaErr"></span>
                </div>
            </div>

            <label>Short Background *</label>
            <textarea name="short_background" id="background" placeholder="Brief history of the restaurant..." required><?= htmlspecialchars($restaurant['short_background'] ?? $_POST['short_background'] ?? '') ?></textarea>
            <span class="field-err" id="bgErr"></span>

            <label>Goals *</label>
            <textarea name="goals" id="goals" placeholder="What are the restaurant's goals?" required><?= htmlspecialchars($restaurant['goals'] ?? $_POST['goals'] ?? '') ?></textarea>
            <span class="field-err" id="goalsErr"></span>

            <button type="submit" class="btn-submit"><?= $mode === 'edit' ? '💾 Update Restaurant' : '➕ Add Restaurant' ?></button>
            <a href="index.php?page=admin" class="btn-cancel">Cancel</a>
        </form>
    </div>
</div>

<script>
// JS Validation
document.getElementById('restForm').addEventListener('submit', function(e) {
    let valid = true;

    const fields = [
        { id: 'name',       errId: 'nameErr',     msg: 'Restaurant name is required.' },
        { id: 'location',   errId: 'locationErr', msg: 'Location is required.' },
        { id: 'area',       errId: 'areaErr',     msg: 'Area is required.' },
        { id: 'background', errId: 'bgErr',       msg: 'Short background is required.' },
        { id: 'goals',      errId: 'goalsErr',    msg: 'Goals are required.' },
    ];

    fields.forEach(f => {
        const el  = document.getElementById(f.id);
        const err = document.getElementById(f.errId);
        if (!el.value.trim()) {
            err.textContent = f.msg;
            el.style.borderColor = '#e74c3c';
            valid = false;
        } else {
            err.textContent = '';
            el.style.borderColor = '#ddd';
        }
    });

    if (!valid) e.preventDefault();
});
</script>
</body>
</html>
