<!-- views/admin/menu_item_form.php -->
<!-- Used for both CREATE and EDIT — $mode = 'create' or 'edit' -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $mode === 'edit' ? 'Edit' : 'Add' ?> Menu Item - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Nunito',sans-serif; background:#f4f6f9; color:#2d2d2d; }
        nav { background:#1a1a1a; padding:14px 40px; display:flex; align-items:center; gap:25px; }
        nav .brand { font-family:'Playfair Display',serif; font-size:1.3rem; color:#ff6b35; text-decoration:none; margin-right:auto; }
        nav a { color:#ccc; text-decoration:none; font-weight:600; font-size:0.9rem; }
        nav a:hover { color:#ff6b35; }
        nav .btn-nav { background:#ff6b35; color:white !important; padding:7px 18px; border-radius:20px; }

        .wrap { max-width:600px; margin:40px auto; padding:0 20px; }
        .form-card { background:white; border-radius:16px; padding:35px; box-shadow:0 4px 20px rgba(0,0,0,0.08); }
        .form-title { font-family:'Playfair Display',serif; font-size:1.5rem; margin-bottom:5px; }
        .form-title span { color:#ff6b35; }
        .form-sub { color:#888; font-size:0.88rem; margin-bottom:25px; }
        .rest-tag { display:inline-block; background:#fff3e0; color:#ff6b35; padding:4px 12px; border-radius:12px; font-size:0.8rem; font-weight:700; margin-bottom:20px; }

        .error-box { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; padding:12px 16px; border-radius:8px; margin-bottom:20px; }
        .error-box p { margin:2px 0; font-size:0.88rem; }

        label { display:block; font-weight:700; font-size:0.88rem; margin-bottom:5px; color:#444; }
        input[type=text], input[type=number], input[type=file], textarea {
            width:100%; padding:10px 14px; border:1.5px solid #ddd; border-radius:8px;
            font-family:'Nunito',sans-serif; font-size:0.92rem; margin-bottom:18px;
            transition:border-color 0.2s;
        }
        input:focus, textarea:focus { outline:none; border-color:#ff6b35; }
        textarea { resize:vertical; min-height:80px; }

        .field-err { color:#e74c3c; font-size:0.78rem; margin-top:-14px; margin-bottom:12px; display:block; }

        .img-hint { color:#888; font-size:0.78rem; margin-top:-14px; margin-bottom:16px; display:block; }
        .current-img { margin-bottom:15px; }
        .current-img img { width:100px; height:80px; object-fit:cover; border-radius:8px; border:2px solid #ff6b35; }
        .current-img p { color:#888; font-size:0.78rem; margin-top:5px; }

        /* Live image preview */
        #imgPreview { width:100%; max-height:180px; object-fit:cover; border-radius:10px; margin-bottom:16px; display:none; border:2px solid #ff6b35; }

        .btn-submit { background:#ff6b35; color:white; padding:12px 30px; border:none; border-radius:25px; font-family:'Nunito',sans-serif; font-size:0.95rem; font-weight:700; cursor:pointer; }
        .btn-submit:hover { background:#e55a24; }
        .btn-cancel { color:#888; text-decoration:none; font-size:0.88rem; margin-left:15px; }
        .btn-cancel:hover { color:#ff6b35; }
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
        <div class="form-title"><?= $mode === 'edit' ? 'Edit' : 'Add' ?> <span>Menu Item</span></div>
        <div class="form-sub"><?= $mode === 'edit' ? 'Update menu item details.' : 'Add a new item to the menu.' ?></div>
        <div class="rest-tag">🍴 <?= htmlspecialchars($restaurant['name']) ?></div>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $e): ?>
                    <p>⚠ <?= htmlspecialchars($e) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST"
              action="index.php?page=<?= $mode === 'edit' ? 'admin-menu-item-edit' : 'admin-menu-item-create' ?>"
              enctype="multipart/form-data"
              id="itemForm">

            <input type="hidden" name="restaurant_id" value="<?= $restaurant['id'] ?>">
            <?php if ($mode === 'edit'): ?>
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
            <?php endif; ?>

            <label>Item Name *</label>
            <input type="text" name="name" id="itemName"
                   value="<?= htmlspecialchars($item['name'] ?? $_POST['name'] ?? '') ?>"
                   placeholder="e.g. Kacchi Biryani" required>
            <span class="field-err" id="nameErr"></span>

            <label>Description *</label>
            <textarea name="description" id="itemDesc" placeholder="Describe the dish..." required><?= htmlspecialchars($item['description'] ?? $_POST['description'] ?? '') ?></textarea>
            <span class="field-err" id="descErr"></span>

            <label>Price (৳) *</label>
            <input type="number" name="price" id="itemPrice" min="1" step="0.01"
                   value="<?= htmlspecialchars($item['price'] ?? $_POST['price'] ?? '') ?>"
                   placeholder="e.g. 350" required>
            <span class="field-err" id="priceErr"></span>

            <label>Image (JPEG/PNG, max 2MB)</label>

            <?php if ($mode === 'edit' && !empty($item['image_path'])): ?>
                <div class="current-img">
                    <img src="public/uploads/menu/<?= htmlspecialchars($item['image_path']) ?>" alt="Current">
                    <p>Current image — upload a new one to replace it.</p>
                </div>
            <?php endif; ?>

            <!-- Live preview -->
            <img id="imgPreview" src="" alt="Preview">
            <input type="file" name="image" id="imageInput" accept="image/jpeg,image/png">
            <span class="img-hint">Optional. JPEG or PNG only, max 2MB.</span>
            <span class="field-err" id="imgErr"></span>

            <button type="submit" class="btn-submit"><?= $mode === 'edit' ? '💾 Update Item' : '➕ Add Item' ?></button>
            <a href="index.php?page=admin-menu-items&restaurant_id=<?= $restaurant['id'] ?>" class="btn-cancel">Cancel</a>
        </form>
    </div>
</div>

<script>
// Live image preview
document.getElementById('imageInput').addEventListener('change', function() {
    const file    = this.files[0];
    const preview = document.getElementById('imgPreview');
    const imgErr  = document.getElementById('imgErr');

    if (!file) { preview.style.display = 'none'; return; }

    // Client-side type and size check
    const allowed = ['image/jpeg', 'image/png'];
    if (!allowed.includes(file.type)) {
        imgErr.textContent = 'Only JPEG/PNG images allowed.';
        preview.style.display = 'none';
        this.value = '';
        return;
    }
    if (file.size > 2 * 1024 * 1024) {
        imgErr.textContent = 'Image must be under 2MB.';
        preview.style.display = 'none';
        this.value = '';
        return;
    }

    imgErr.textContent = '';
    const reader = new FileReader();
    reader.onload = e => {
        preview.src = e.target.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
});

// JS form validation
document.getElementById('itemForm').addEventListener('submit', function(e) {
    let valid = true;

    const name  = document.getElementById('itemName');
    const desc  = document.getElementById('itemDesc');
    const price = document.getElementById('itemPrice');

    [
        { el: name,  errId: 'nameErr',  msg: 'Item name is required.' },
        { el: desc,  errId: 'descErr',  msg: 'Description is required.' },
    ].forEach(f => {
        const err = document.getElementById(f.errId);
        if (!f.el.value.trim()) {
            err.textContent = f.msg;
            f.el.style.borderColor = '#e74c3c';
            valid = false;
        } else {
            err.textContent = '';
            f.el.style.borderColor = '#ddd';
        }
    });

    // Price validation
    const priceErr = document.getElementById('priceErr');
    if (!price.value || parseFloat(price.value) <= 0) {
        priceErr.textContent = 'Price must be a positive number.';
        price.style.borderColor = '#e74c3c';
        valid = false;
    } else {
        priceErr.textContent = '';
        price.style.borderColor = '#ddd';
    }

    if (!valid) e.preventDefault();
});
</script>
</body>
</html>
