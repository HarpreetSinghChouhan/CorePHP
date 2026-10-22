<?php
require_once __DIR__ . '/../common/header.php';

require_once __DIR__ . '/../common/sidebar.php';
?>
  <script src="./../assets/js/cart.js" defer></script>
    <?php require_once __DIR__ . '/../common/navbar.php'; ?>

    <!-- <div class="admin-content"> -->
        <section class="vr-card">
    <div class="vr-card-head">
        <h2>Recent Added Cart Item Added</h2>
    </div>
        <div class="vr-table-wrap">
        <table class="vr-table vr-datatable" id="cart_datatable" >
            <thead>
                <tr>
                        <th>Serial No</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Cart Item</th>
                        <th>Total Quantity</th>
                        <th>Total Price</th>
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</section>

<?php require_once __DIR__ . '/../common/footer.php'; ?>