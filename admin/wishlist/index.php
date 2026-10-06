<?php
require_once __DIR__ . '/../common/header.php';
require_once __DIR__ . '/../common/sidebar.php';
?>

<div class="admin-main">
    <script src="../assets/js/wishlist.js" defer></script>
    <?php require_once __DIR__ . '/../common/navbar.php'; ?>

    <div class="admin-content">
        <div class="panel">
            <div class="table-header">
                <h1 class="center">User Wishlist List</h1>
            </div>
            <table id="wishlist_datatable">
                <thead>
                    <tr>
                        <th>Serial No</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Wishlist Item</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
<?php require_once __DIR__ . '/../common/footer.php'; ?>