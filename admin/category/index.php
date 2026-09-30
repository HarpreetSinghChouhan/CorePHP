<?php
require_once __DIR__ . '/../common/header.php';
require_once __DIR__ . '/../common/sidebar.php';
?>

<div class="admin-main">
    <script src="../assets/js/category.js" defer></script>
    <?php require_once __DIR__ . '/../common/navbar.php'; ?>

    <div class="admin-content">
        <div class="panel">
            <div class="table-header">
                <h1 class="center">Category List</h1>
                <button class="btn create-link-btn">Add New Category</button>
            </div>
            <table id="category_datatable">
                <thead>
                    <tr>
                        <th>Serial No</th>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
<?php require_once __DIR__ . '/../common/footer.php'; ?>