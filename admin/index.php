<?php
// admin/index.php
$_SESSION_ROLE_OVERRIDE = 'Admin'; 
require_once __DIR__ . '/common/header.php';
require_once __DIR__ . '/common/sidebar.php';
$query = "SELECT * FROM user WHERE role='user' AND is_deleted !='1'";
 $result = mysqli_query($conn,$query);
   $total_users = mysqli_num_rows($result);
?>
<div class="admin-main">
    <script src="/CorePHP/admin/assets/js/script.js" defer></script>
    <?php require_once __DIR__ . '/common/navbar.php'; ?>

    <div class="admin-content">
        <h1>Admin Dashboard</h1>
        <p class="subtitle">Overview of platform activity and statistics.</p>

        <div class="stat-cards">
            <div class="stat-card"  >
                <h3 class="user-link-btn" ><?php echo $total_users  ?></h3>
                <p class="user-link-btn" >Total Users</p>
            </div>
            <div class="stat-card orange">
                <?php
                $orderquery = "SELECT COUNT(*) AS total_count FROM `order` WHERE is_deleted !='1'";
                $result = mysqli_query($conn,$orderquery);
                $mysqlresult = mysqli_fetch_assoc($result); 
                ?>
                <h3 class="order-link-btn" ><?php echo $mysqlresult["total_count"] ?></h3>
                <p class="order-link-btn" >Pending Orders</p>
            </div>
            <div class="stat-card green">
                <h3 class="order-link-btn"  >$48,290</h3>
                <p class="order-link-btn" > Total Revenue</p>
            </div>
            <div class="stat-card red">
                <h3>8</h3>
                <p>Reported Issues</p>
            </div>
        </div>

        <!-- <div class="panel">
            <h2>Recent Users</h2>
            <table>
                <thead>
                    <tr><th>Serial No</th><th>Name</th><th>Email</th><th>role</th><th>age</th><th>gender</th> </tr>
                </thead>
                <tbody>
                 <?php 
                 $SerialNo = 1;
                 while($row = mysqli_fetch_assoc($result)){
                    echo "<tr> <td> ". $SerialNo . "</td>
                    <td> ". $row["name"] . "</td>
                    <td> ". $row["email"] . "</td>
                    <td> ". $row["role"] . "</td>
                    <td> ". $row["age"] . "</td>
                    <td> ". $row["gender"] . "</td>
                    
                    </tr>";
                    $SerialNo ++;
                 }
                 
                 ?>
                </tbody>
            </table>
        </div> -->
    </div>

<?php require_once __DIR__ . '/common/footer.php'; ?>
