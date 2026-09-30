<?php
// user/index.php
require_once  './../common/header.php';
require_once  './../common/sidebar.php';
// require "";
?>
<div class="user-main">
    <?php require_once './../common/navbar.php'; ?>
 <script src="./../assets/js/cartitem.js" defer ></script>

    <div class="user-content">
        <div class="table-div">
    <div class="table-wrapper">
        <table id="cart_datatable" class="cartitem-table">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="cartitem-tbody"></tbody>
        </table>
    </div>
</div>
    </div>
<?php require_once './../common/footer.php'; ?>
