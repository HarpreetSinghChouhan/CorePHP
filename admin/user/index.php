<?php
// admin/index.php
// $_SESSION_ROLE_OVERRIDE = 'Admin'; // demo only
require_once __DIR__ . '/../common/header.php';

require_once __DIR__ . '/../common/sidebar.php';
?>

<div class="admin-main">
    <script src="/CorePHP/admin/assets/js/user.js" defer></script>
    <?php require_once __DIR__ . '/../common/navbar.php'; ?>

    <div class="admin-content">
        <div class="panel">
            <div class="table-header" >
            <h1 class="center"> Users List</h1> <button class="btn create-link-btn"  >Add New User</button>

            </div>
            <table id="user_datatable" >
                <thead>
                    <tr><th>Serial No</th><th>Name</th><th>Email</th><th>role</th><th>age</th><th>gender</th><th>Action</th></tr>
                </thead>
                <tbody class="user-body" >
                </tbody>
            </table>
        </div>

        
    </div>
<?php require_once __DIR__ . '/../common/footer.php'; ?>