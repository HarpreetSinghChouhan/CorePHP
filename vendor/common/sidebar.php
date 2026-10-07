<?php
// $activePage se current menu highlight hota hai
function vr_active($name, $current) { return $name === $current ? 'active' : ''; }
?>
<div class="vr-overlay" id="vrOverlay"></div>

<aside class="vr-sidebar" id="vrSidebar">
    <a href="/CorePHP/vendor/dashboard.php" class="vr-logo">VendorHub</a>

    <div class="vr-profile-chip">
        <div class="vr-avatar">V</div>
        <div>
            <strong><?= htmlspecialchars($_SESSION['name'] ?? 'Vendor Name') ?></strong>
            <small>Vendor</small>
        </div>
    </div>

    <nav class="vr-menu">
        <a href="/CorePHP/vendor/dashboard.php" class="<?= vr_active('dashboard', $activePage) ?>">
            <i class="fa-solid fa-house"></i> Dashboard
        </a>
        <a href="/CorePHP/vendor/profile.php" class="<?= vr_active('profile', $activePage) ?>">
            <i class="fa-solid fa-user"></i> My Profile
        </a>
        <a href="/CorePHP/vendor/product/add-product.php" class="<?= vr_active('add-product', $activePage) ?>">
            <i class="fa-solid fa-square-plus"></i> Add Product
        </a>
        <a href="/CorePHP/vendor/product/products.php" class="<?= vr_active('products', $activePage) ?>">
            <i class="fa-solid fa-box"></i> My Products
        </a>
        <a href="/CorePHP/vendor/cart/cart.php" class="<?= vr_active('cart', $activePage) ?>">
            <i class="fa-solid fa-cart-shopping"></i> Cart Items
        </a>
        <a href="/CorePHP/vendor/wishlist/wishlist.php" class="<?= vr_active('wishlist', $activePage) ?>">
            <i class="fa-solid fa-heart"></i> Wishlist Items
        </a>
        <a href="/CorePHP/auth/logout.php">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </nav>
</aside>