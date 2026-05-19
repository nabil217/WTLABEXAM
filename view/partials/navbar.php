<?php
if (session_status() === PHP_SESSION_NONE) session_start();


$scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']);
$docRoot    = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$relative   = str_replace($docRoot, '', $scriptPath);       
$parts      = explode('/', trim($relative, '/'));              
$depth      = count($parts) - 1;                              
$base       = str_repeat('../', $depth);                      
$t4         = $base . $parts[0] . '/';                        
?>
<nav class="navbar">
    <a class="navbar-brand" href="<?= $t4 ?>view/food_experience/index.php">🍽 Food Blog</a>
    <ul class="navbar-links">
        <li><a href="<?= $t4 ?>view/food_experience/index.php">Food Experience</a></li>

        <?php if (isLoggedIn()): ?>
            <?php if (isAdmin()): ?>
                <li><a href="<?= $t4 ?>control/admin_controller.php?action=dashboard">⚙ Admin Panel</a></li>
            <?php endif; ?>
            <li style="color:#c8e6c9;font-size:0.9rem;padding:0 0.3rem;">
                👤 <?= htmlspecialchars($_SESSION['name'] ?? 'User') ?>
                <span style="font-size:0.75rem;opacity:0.75;">(<?= $_SESSION['role'] ?? '' ?>)</span>
            </li>
            <li><a href="<?= $t4 ?>control/logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="<?= $t4 ?>view/login.php">Login</a></li>
            <li><a href="<?= $t4 ?>view/register.php" class="btn-nav">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>
