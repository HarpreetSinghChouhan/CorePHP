<?php
require_once __DIR__ . '/../common/header.php';

require_once __DIR__ . '/../common/sidebar.php';
?>

<div class="admin-main">
    <script src="../assets/js/cart.js"; defer ></script>
    <?php require_once __DIR__ . '/../common/navbar.php'; ?>

    <div class="admin-content">
        <div class="panel">
          <div class="table-header" >   
        <h1 class="center"> Cart List</h1>
            </div>
            <table>
                <thead> 
                    <tr><th>Serial No</th><th>User Name</th><th>User Email</th><th>Cart Item</th><th>Total Quantity</th><th>Total Price</th><th>Action</th></tr>
                </thead>
                <tbody class="cart-tbody" >
                </tbody>
            </table>
            <div id="pagination" class="pagination-container"></div>
        </div>

       
    </div>
<?php require_once __DIR__ . '/../common/footer.php'; ?>