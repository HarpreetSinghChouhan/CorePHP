<div class="vr-main">
    <header class="vr-topbar">
        <button class="vr-burger" id="vrBurger" aria-label="Open menu">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="vr-welcome">
            <h1>Welcome back, <?= htmlspecialchars($_SESSION['name'] ?? 'Vendor') ?> 👋</h1>
            <span><?= date('l, d F Y') ?></span>
        </div>

        <div class="vr-top-actions">
            <button class="vr-icon-btn" aria-label="Notifications"><i class="fa-solid fa-bell"></i></button>
            <a href="/CorePHP/vendor/cart/cart.php" class="vr-icon-btn" aria-label="Cart">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="vr-badge">0</span>
            </a>
            <a href="/CorePHP/vendor/dashboard.php" class="vr-icon-btn" aria-label="Home"><i class="fa-solid fa-house"></i></a>
        </div>
    </header>

    <div class="vr-content">