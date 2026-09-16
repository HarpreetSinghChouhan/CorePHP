<?php
// admin/user/edit.php
require_once __DIR__ . '../../common/header.php';
require_once __DIR__ . '../../common/sidebar.php';

?>


<div class="admin-main">
    <?php require_once __DIR__ . '../../common/navbar.php'; ?>
    <script src="../assets/js/category.js"; defer ></script>
    <div class="model-content">
        <div class="user-content">


        <div class=" ">

            <div class="card profile-details">

                
                    <!-- <div class="alert-success" style="display:none" >Profile Are Updated</div> -->
                <div class="profile-details-header">
                    <div>
                        <h3>Create New Category </h3>
                        <!-- <p></p> -->
                    </div>
                </div>

                <form method="POST" id="AddCategoryForm">
                    <div class="form">
                        <div class="field">
                            <label>Category Name</label>
                            <input type="text" name="CategoryName" id="CategoryName" placeholder="Enter Category Name" class="full-width"  >
                           <div class="CategoryNameError" style="color:red" ></div>
                        </div>
                        
</div>
                    <div class="form-actions" id="formActions">
                        <button type="button" class="btn btn-ghost btn-back">Back</button>
                        <button type="submit" class="btn btn-primary">Create Category</button>
                    </div>

                </form>
            </div>

        </div>
             
    </div>
   
<?php require_once __DIR__ . '../../common/footer.php'; ?>
