<?php
// admin/navbar.php
$nbName  = $_SESSION['user_name'] ?? 'Admin';
$nbEmail = $_SESSION['email'] ?? $nbName;
?>
<header class="admin-navbar">
    <div class="nav-left">
        <button type="button" class="admin-burger" id="adminBurger" aria-label="Open menu">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="nav-welcome">
            <h1>Welcome back, <?php echo htmlspecialchars($nbName); ?> 👋</h1>
            <span><?php echo date('l, d F Y'); ?></span>
        </div>
    </div>

    <div class="navbar-right">
        <div class="search-box">
            <input type="text" placeholder="Search anything...">
        </div>
        <button type="button" class="nav-icon-btn" aria-label="Notifications">
            <i class="fa-solid fa-bell"></i>
        </button>
        <button type="button" class="nav-icon-btn" aria-label="Messages">
            <i class="fa-regular fa-envelope"></i>
        </button>
        <div class="admin-profile">
            <div class="avatar"><?php echo strtoupper(substr($nbEmail, 0, 1)); ?></div>
            <span class="profile-name"><?php echo htmlspecialchars($nbName); ?></span>
        </div>
    </div>
</header>

<script>
(function () {
    var sb = document.getElementById('adminSidebar'),
        ov = document.getElementById('adminOverlay'),
        bg = document.getElementById('adminBurger');
    if (!sb || !ov || !bg) return;
    function toggle(open) {
        sb.classList.toggle('open', open);
        ov.classList.toggle('show', open);
        document.body.classList.toggle('no-scroll', open);
    }
    bg.addEventListener('click', function () { toggle(!sb.classList.contains('open')); });
    ov.addEventListener('click', function () { toggle(false); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') toggle(false); });
    window.addEventListener('resize', function () { if (window.innerWidth > 900) toggle(false); });
})();
</script>