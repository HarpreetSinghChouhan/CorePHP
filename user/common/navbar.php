<?php // user/navbar.php ?>
<header class="user-navbar">
    <div class="welcome-text">
        <h2>Welcome back, <?php echo htmlspecialchars(explode(' ', $_SESSION['user_name'])[0]); ?> 👋</h2>
        <span><?php echo date('l, d F Y'); ?></span>
    </div>
    <div class="navbar-right">
        <div class="icon-btn"><i class="fa-solid fa-bell"></i></div>
        <div class="icon-btn"><i class="fa-solid fa-search"></i></div>
        <div class="icon-btn"><i class="fa-regular fa-envelope"></i></div>
    </div>
</header>
