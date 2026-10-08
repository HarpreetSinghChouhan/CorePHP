<?php
// admin/index.php
// $_SESSION_ROLE_OVERRIDE = 'Admin'; // demo only
require_once __DIR__ . '/../common/header.php';

require_once __DIR__ . '/../common/sidebar.php';
?>

<div class="admin-main">
    <script src="/CorePHP/admin/assets/js/vendor.js" defer></script>
    <?php require_once __DIR__ . '/../common/navbar.php'; ?>

    <div class="admin-content">
        <div class="panel">
            <div class="table-header" >
            <h1 class="center"> Vendor List</h1> <button class="btn create-link-btn"  >Add New Vendor</button>

            </div>
            <table id="vendor_datatable" >
                <thead>
                    <tr><th>Serial No</th><th>Name</th><th>Email</th><th>role</th><th>age</th><th>gender</th><th>Action</th></tr>
                </thead>
                <tbody class="vendor-body" >
                </tbody>
            </table>
        </div>

        
    </div>
<?php require_once __DIR__ . '/../common/footer.php'; ?>