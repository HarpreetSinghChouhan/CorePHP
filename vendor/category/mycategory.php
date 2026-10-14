<?php
require_once __DIR__ . '/../common/header.php';

require_once __DIR__ . '/../common/sidebar.php';
?>

    <?php require_once __DIR__ . '/../common/navbar.php'; ?>
    <script src="../assets/js/category.js" defer></script>

    <!-- <div class="admin-content"> -->
        <section class="vr-card">
    <div class="vr-card-head">
        <h2>Category</h2>
        <a class="create-link-btn vr-btn">
            <i class="fa-solid fa-plus"></i> Add Category
        </a>
    </div>
        <div class="vr-table-wrap">
        <table class="vr-table vr-datatable"  id="mycategory_datatable">
            <thead>
                <tr>
                  <th>Serial No</th>
                  <th>Name</th>
                  <th>Created At</th>
                  <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody  class="category-body" >
              
            </tbody>
        </table>
    </div>
</section>

<?php require_once __DIR__ . '/../common/footer.php'; ?>