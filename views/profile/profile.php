<!-- views/profile/profile.php -->
<!DOCTYPE html>
<html>
<head>
    <title>My Profile - Food Blog</title>
    <style>
        body { font-family: Arial; max-width: 600px; margin: 50px auto; }
        input { width: 100%; padding: 8px; margin: 5px 0 10px; box-sizing: border-box; }
        button { background: #e44d26; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .error  { color: red;   background: #ffe0e0; padding: 8px; margin-bottom: 10px; }
        .flash  { color: green; background: #e0ffe0; padding: 8px; margin-bottom: 10px; }
        img.avatar { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; }
        hr { margin: 20px 0; }
    </style>
</head>
<body>
    <?php include 'views/partials/navbar.php'; ?>

    <h2>My Profile</h2>

    <!-- Flash message -->
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="flash"><?= htmlspecialchars($_SESSION['flash']) ?></div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <!-- Errors -->
    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $e): ?>
                <p><?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Current profile picture -->
    <?php if (!empty($user['profile_picture'])): ?>
        <img src="public/uploads/<?= htmlspecialchars($user['profile_picture']) ?>" class="avatar">
    <?php else: ?>
        <img src="https://via.placeholder.com/100" class="avatar">
    <?php endif; ?>

    <form method="POST" action="index.php?page=profile" enctype="multipart/form-data" id="profileForm">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Profile Picture (JPEG/PNG, max 2MB):</label>
        <input type="file" name="profile_picture" accept="image/jpeg,image/png">

        <hr>
        <h3>Change Password (optional)</h3>

        <label>Current Password:</label>
        <input type="password" name="current_password" id="curPass">

        <label>New Password (min 8 chars):</label>
        <input type="password" name="new_password" id="newPass">

        <button type="submit">Update Profile</button>
    </form>

    <!-- JS Validation -->
    <script>
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            const newPass = document.getElementById('newPass').value;
            const curPass = document.getElementById('curPass').value;
            if (newPass && !curPass) {
                alert("Please enter your current password to change it.");
                e.preventDefault();
            }
            if (newPass && newPass.length < 8) {
                alert("New password must be at least 8 characters.");
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
