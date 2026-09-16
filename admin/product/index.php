<?php
require_once __DIR__ . '/../common/header.php';

require_once __DIR__ . '/../common/sidebar.php';
?>

<div class="admin-main">
    <script src="../assets/js/product.js"; defer ></script>
    <?php require_once __DIR__ . '/../common/navbar.php'; ?>

    <div class="admin-content">
        <div class="panel">
          <div class="table-header" >   
        <h1 class="center"> Product List</h1> <button class="btn create-link-btn"  >Add New Product</button>
            </div>
            <table>
                <thead>
                    <tr><th>Serial No</th><th>Image</th><th>Name</th><th>Sku</th><th>Price</th><th>Category Name</th><th>Product Description</th><th>Stock</th><th>Action</th></tr>
                </thead>
                <tbody class="product-tbody" >
                </tbody>
            </table>
        </div>

        <!-- =========================
             EDIT USER MODAL
        ========================== -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <h2>Edit User</h2>

                <form id="editUserForm">
                    <input type="hidden" id="editUserId" name="id">

                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" id="editName" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" id="editEmail" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="editAge">Age</label>
                        <input type="number" id="editAge" name="age" required>
                    </div>

                    <div class="form-group">
                        <label for="editGender">Gender</label>
                        <select id="editGender" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
<?php require_once __DIR__ . '/../common/footer.php'; ?>