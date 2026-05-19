<!-- views/partials/navbar.php -->
<nav style="background:#333; padding:10px; color:white;">
    <a href="index.php?page=home" style="color:white; margin-right:15px;">🍽 Food Blog</a>
    <a href="index.php?page=restaurants" style="color:white; margin-right:15px;">Restaurants</a>

    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Logged in user -->
        <span style="margin-right:15px;">Hello, <?= htmlspecialchars($_SESSION['name']) ?></span>

        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="index.php?page=admin" style="color:yellow; margin-right:15px;">Admin Panel</a>
        <?php endif; ?>

        <a href="index.php?page=profile" style="color:white; margin-right:15px;">My Profile</a>
        <a href="index.php?page=logout" style="color:white;">Logout</a>

    <?php else: ?>
        <!-- Visitor -->
        <a href="index.php?page=login" style="color:white; margin-right:15px;">Login</a>
        <a href="index.php?page=register" style="color:white;">Register</a>
    <?php endif; ?>
</nav>
