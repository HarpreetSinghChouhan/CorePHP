<?php
require_once __DIR__ . '/../common/header.php';

require_once __DIR__ . '/../common/sidebar.php';
?>

<div class="admin-main">
    <script src="../assets/js/order.js"; defer ></script>
    <?php require_once __DIR__ . '/../common/navbar.php'; ?>

    <div class="admin-content">
        <div class="panel">
          <div class="table-header" >   
        <!-- <h1 class="center"> Product List</h1> <button class="btn create-link-btn"  >Add New Product</button> -->
            </div>
            <table>
                <thead>
                    <tr><th>Serial No</th><th>Order Id</th><th>User Name</th><th>User Email</th><th>Total Quantity</th><th>Total Amount</th><th>Order Item</th><th>Perchange At</th><th>View</th></tr>
                </thead>
                <tbody class="order-tbody" >
                </tbody>
            </table>
            <div id="pagination" class="pagination-container"></div>
        </div>

       
    </div>
<?php require_once __DIR__ . '/../common/footer.php'; ?>