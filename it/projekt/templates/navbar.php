<?php
$isLoggedIn = !empty($_SESSION['user']) || !empty($_SESSION['logged_in']);
?>
<nav class="nav">
    <div class="nav-inner">
        <ul class="nav-left">
            <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
            <li><a href="<?php echo BASE_URL; ?>menu">Menu</a></li>
            <li><a href="<?php echo BASE_URL; ?>about">About Us</a></li>
            <li><a href="<?php echo BASE_URL; ?>contact">Contact</a></li>
        </ul>
        <ul class="nav-right">
            <?php if ($isLoggedIn): ?>
                <?php if (!empty($_SESSION['logged_in']) && ($_SESSION['role']) === 'admin') : ?>
                    <li><a href="<?php echo BASE_URL; ?>admin/orders.php" class="btn">Orders</a></li>
                    <li><a href="<?php echo BASE_URL; ?>admin/products.php" class="btn">Products</a></li>
                <?php endif; ?>
                <li><a href="<?php echo BASE_URL; ?>logout" class="btn">Log Out</a></li>
            <?php else: ?>
                <li><a href="<?php echo BASE_URL; ?>login" class="btn">Log In</a></li>
                <li><a href="<?php echo BASE_URL; ?>register" class="btn">Sign Up</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>