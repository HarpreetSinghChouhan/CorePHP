<?php
// admin/index.php
$_SESSION_ROLE_OVERRIDE = 'Admin'; // demo only
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/sidebar.php';
?>
<div class="admin-main">
    <?php require_once __DIR__ . '/navbar.php'; ?>

    <div class="admin-content">
        <h1>Admin Dashboard</h1>
        <p class="subtitle">Overview of platform activity and statistics.</p>

        <div class="stat-cards">
            <div class="stat-card">
                <h3>1,284</h3>
                <p>Total Users</p>
            </div>
            <div class="stat-card orange">
                <h3>342</h3>
                <p>Pending Orders</p>
            </div>
            <div class="stat-card green">
                <h3>$48,290</h3>
                <p>Total Revenue</p>
            </div>
            <div class="stat-card red">
                <h3>12</h3>
                <p>Reported Issues</p>
            </div>
        </div>

        <div class="panel">
            <h2>Recent Users</h2>
            <table>
                <thead>
                    <tr><th>Name</th><th>Email</th><th>Joined</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <tr><td>Ayesha Khan</td><td>ayesha@example.com</td><td>02 Sep 2026</td><td><span class="status active">Active</span></td></tr>
                    <tr><td>Rohan Verma</td><td>rohan@example.com</td><td>01 Sep 2026</td><td><span class="status pending">Pending</span></td></tr>
                    <tr><td>Sara Ali</td><td>sara@example.com</td><td>29 Aug 2026</td><td><span class="status blocked">Blocked</span></td></tr>
                    <tr><td>Vikram Singh</td><td>vikram@example.com</td><td>28 Aug 2026</td><td><span class="status active">Active</span></td></tr>
                </tbody>
            </table>
        </div>
    </div>

<?php require_once __DIR__ . '/footer.php'; ?>
