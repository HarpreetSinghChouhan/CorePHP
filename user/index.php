<?php
// user/index.php
require_once __DIR__ . '/common/header.php';
require_once __DIR__ . '/common/sidebar.php';
?>
<div class="user-main">
    <?php require_once __DIR__ . '/common/navbar.php'; ?>

    <div class="user-content">
        <div class="summary-cards">
            <div class="summary-card card-purple">
                <div class="top">
                    <div class="icon-circle"><i class="fa-solid fa-credit-card"></i></div>
                </div>
                <h3>8</h3>
                <p>Active Orders</p>
            </div>
            <div class="summary-card card-green">
                <div class="top">
                    <div class="icon-circle"><i class="fa-solid fa-check"></i></div>
                </div>
                <h3>24</h3>
                <p>Completed Tasks</p>
            </div>
            <div class="summary-card card-orange">
                <div class="top">
                    <div class="icon-circle"><i class="fa-regular fa-message"></i></div>
                </div>
                <h3>5</h3>
                <p>New Messages</p>
            </div>
        </div>

        <div class="card">
            <h2>Recent Activity</h2>
            <div class="activity-item">
                <span>Your order #1042 was shipped</span>
                <span class="tag success">Shipped</span>
            </div>
            <div class="activity-item">
                <span>Profile information updated</span>
                <span class="time">2 hours ago</span>
            </div>
            <div class="activity-item">
                <span>Payment for invoice #88 is due</span>
                <span class="tag warning">Pending</span>
            </div>
            <div class="activity-item">
                <span>New message from support team</span>
                <span class="time">Yesterday</span>
            </div>
        </div>
    </div>

<?php require_once __DIR__ . '/common/footer.php'; ?>
