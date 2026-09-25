<?php 
function isActivePage($folder) {
    $currentUrl = $_SERVER['REQUEST_URI'];
    if ($folder === '') {
        return (rtrim($currentUrl, '/') === '/CorePHP/admin/index.php') ? 'active' : '';
    }
    return (strpos($currentUrl, '/admin/' . $folder . '/') !== false) ? 'active' : '';
}
?>
<aside class="admin-sidebar">
    <div class="brand">Admin<span>Panel</span></div>
    <ul>
        <li><a href="/CorePHP/admin/index.php" class="<?php echo isActivePage(''); ?>">
            <span class="icon"><i class="fa fa-tachometer fa-lg icon-manage" aria-hidden="true"></i></span> Dashboard
        </a></li>
        <li><a href="/CorePHP/admin/user/index.php" class="<?php echo isActivePage('user'); ?>">
            <span class="icon"><i class="fas fa-users"></i></span> All Users
        </a></li>
        <li><a href="/CorePHP/admin/product/index.php" class="<?php echo isActivePage('product'); ?>">
            <span class="icon"><i class="fa-solid fa-cart-shopping"></i></span> Product
        </a></li>
        <li><a href="/CorePHP/admin/category/index.php" class="<?php echo isActivePage('category'); ?>">
            <span class="icon"><i class="fa-solid fa-layer-group"></i></span> Category
        </a></li>
        <li><a href="/CorePHP/admin/order/index.php" class="<?php echo isActivePage('order'); ?>">
            <span class="icon"><i class="fa fa-clipboard-list"></i></span> Orders
        </a></li>
        <li><a href="/CorePHP/admin/cart/index.php" class="<?php echo isActivePage('cart'); ?>">
            <span class="icon"><i class="fa fa-clipboard-list"></i></span> Cart
        </a></li>
        <li><a href="/CorePHP/auth/logout.php">
            <span class="icon"><i class="fa fa-sign-out"></i></span> Logout
        </a></li>
    </ul>
    <div class="sidebar-footer">&copy; <?php echo date('Y'); ?> Admin</div>
</aside>