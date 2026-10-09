<?php

if (!isset($activePage) || $activePage === '') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    if (strpos($path, '/vendor/product/')  !== false) $activePage = 'product';
    elseif (strpos($path, '/vendor/cart/')     !== false) $activePage = 'cart';
    elseif (strpos($path, '/vendor/wishlist/') !== false) $activePage = 'wishlist';
    elseif (strpos($path, '/vendor/profile')   !== false) $activePage = 'profile';
    else $activePage = 'dashboard'; 
}

function vr_active($name, $current) {
    return $name === $current ? 'active' : '';
}
?>
<div class="vr-overlay" id="vrOverlay"></div>

<aside class="vr-sidebar" id="vrSidebar">
    <a href="/CorePHP/vendor/index.php" class="vr-logo">VendorHub</a>

    <div class="vr-profile-chip">
        <div class="vr-avatar">
            <?= strtoupper(substr($_SESSION['name'] ?? 'V', 0, 1)) ?>
        </div>
        <div>
            <strong><?= htmlspecialchars($_SESSION['name'] ?? 'Vendor Name') ?></strong>
            <small>Vendor</small>
        </div>
    </div>

    <nav class="vr-menu">
        <a href="/CorePHP/vendor/index.php" class="<?= vr_active('dashboard', $activePage) ?>">
            <i class="fa-solid fa-house"></i> Dashboard
        </a>
        <a href="/CorePHP/vendor/profile.php" class="<?= vr_active('profile', $activePage) ?>">
            <i class="fa-solid fa-user"></i> My Profile
        </a>
        <a href="/CorePHP/vendor/product/index.php" class="<?= vr_active('product', $activePage) ?>">
            <i class="fa-solid fa-box"></i> My Products
        </a>
        <a href="/CorePHP/vendor/cart/index.php" class="<?= vr_active('cart', $activePage) ?>">
            <i class="fa-solid fa-cart-shopping"></i> Cart Items
        </a>
        <a href="/CorePHP/vendor/wishlist/index.php" class="<?= vr_active('wishlist', $activePage) ?>">
            <i class="fa-solid fa-heart"></i> Wishlist Items
        </a>
        <a href="/CorePHP/auth/logout.php">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </nav>
</aside>