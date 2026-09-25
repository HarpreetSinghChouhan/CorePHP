<?php
// admin/user/edit.php
require_once __DIR__ . '../../common/header.php';
require_once __DIR__ . '../../common/sidebar.php';
 $category = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM category WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $category['id'] = $row['id'];
    $category['name'] = $row['name'];
}
// $initial = strtoupper(substr($user['name'], 0, 1));
if (!$category) {
    header("Location: http://localhost/CorePHP/admin/index.php");
    exit;
}
?>
<div class="admin-main">
    <?php require_once __DIR__ . '../../common/navbar.php'; ?>
    <script src="../assets/js/category.js"; defer ></script>
    <div class="model-content">
        <div class="user-content">
        <div class="">
            <div class="card profile-details">
                <div class="profile-details-header">
                    <div>
                        <h3>Create New Category </h3>
                    </div>
                </div>
                <form method="POST" id="EditCategoryForm">
                    <div class="form">
                        <div class="field">
                            <label>Category Name</label>
                            <input type="text" name="CategoryName" id="CategoryName" value="<?php echo $category['name'] ?>" placeholder="Enter Category Name" class="full-width"  >
                            <input type="text" name="CategoryId" id="CategoryId" value="<?php echo $category['id'] ?>" placeholder="Enter Category Id" class="full-width" hidden >
                           
                            <div class="CategoryNameError" style="color:red" ></div>
                        </div>
                        
                    </div>
                    <div class="form-actions" id="formActions">
                        <button type="button" class="btn btn-ghost btn-back">Back</button>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>   
    </div>
<?php require_once __DIR__ . '../../common/footer.php'; ?>
