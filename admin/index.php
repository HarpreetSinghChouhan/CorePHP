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
    <script src="/CorePHP/admin/assets/js/chart.js" defer></script>
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
                <p class="order-link-btn" >Total Orders</p>
            </div>
            <div class="stat-card green">
                      <?php  
                      $user_id = $_SESSION['user_id'];
           $revenue = "SELECT id, user_id, revenue FROM `revenue` WHERE user_id ='$user_id' LIMIT 1";
           $revenuequery = mysqli_query($conn,$revenue);
           $totalcount = 0;
           if(!$revenuequery){
              $totalcount = 0;
           } else{
            $resultrevenue = mysqli_fetch_assoc($revenuequery);
            $totalcount = $resultrevenue['revenue'];
           }

           
$range = isset($_GET['range']) ? $_GET['range'] : '7days';
         ?>
                <h3 class="order-link-btn"  ><?php echo $totalcount; ?></h3>
                <p class="order-link-btn" > Total Revenue</p>
            </div>
          
        </div>
<div style="margin-bottom:10px;">
    <a href="?range=7days" class="vr-range-btn <?php echo ($range == '7days') ? 'active' : ''; ?>">Last 7 Days</a>
    <a href="?range=month" class="vr-range-btn <?php echo ($range == 'month') ? 'active' : ''; ?>">This Month</a>
</div>
<div style="padding:20px" >
    
<div  style=" display:flex; width:100%; gap:40px" >
   
 <div style="width:100%;max-width:500px;">
    <!-- <div style="display:flex;gap:8px;margin-bottom:8px;">
        <select id="stockFilter" class="vr-btn">
            <option value="all">All Products</option>
            <option value="hot">High Demand</option>
            <option value="low">Low Stock</option>
            <option value="out">Out of Stock</option>
            <option value="nodemand">No Demand</option>
        </select>
        <select id="stockPerPage" class="vr-btn">
            <option value="15">5</option>
            <option value="100">10</option>
            <option value="200">20</option>
        </select>
    </div> -->
        <canvas id="ChartItem"></canvas>
    <!-- <div style="display:flex;justify-content:space-between;margin-top:8px;">
        <button id="stockPrev" class="vr-btn">Prev</button>
        <span id="stockPageInfo"></span>
        <button id="stockNext" class="vr-btn">Next</button>
    </div> -->
        </div>
            <div style="width:100%;max-width:900px;" >
                <canvas id="ItemsSaled"></canvas>
            </div>

        </div>
    </div>
    </div>

    
<?php

if($range == 'month'){
    $start_date = date('Y-m-d', strtotime('-30 days'));   
    $days_count = date('t');        
} else {
    $start_date = date('Y-m-d', strtotime('-6 days')); 
    $days_count = 7;
}
$end_date = date('Y-m-d', strtotime("$start_date +" . ($days_count - 1) . " days"));
$totalcount =[];
$labels = [];
$counts = [];
for($i = 0; $i < $days_count; $i++){
    $day = date('Y-m-d', strtotime("$start_date +$i days"));
    $labels[] = date('d M', strtotime($day));
    $counts[$day] = 0;
    $totalcount[$day] = 0;
}

$query = "SELECT DATE(o.created_at) AS order_day, COUNT(DISTINCT o.id) AS total_orders,SUM(oi.product_quantity) AS totalcount, oi.product_id 
          FROM `order` AS o
          INNER JOIN order_item AS oi ON o.order_id = oi.order_id
          INNER JOIN `product` AS p ON p.id = oi.product_id
          WHERE o.is_deleted != '1'
          AND DATE(o.created_at) BETWEEN '$start_date' AND '$end_date'
          GROUP BY DATE(o.created_at)";

$result = mysqli_query($conn, $query);

if(!$result){
    echo json_encode(["error" => mysqli_error($conn)]);
    exit;
}

while($row = mysqli_fetch_assoc($result)){
    $counts[$row['order_day']] = (int)$row['total_orders'];
    $totalcount[$row['order_day']] =  (int)$row['totalcount'];
}
?>
<script>
    const labels = <?php echo json_encode($labels); ?>;
    const orderData = <?php echo json_encode(array_values($counts)); ?>;
    const TotalQuantity = <?php echo json_encode(array_values($totalcount)); ?>

    const data2 = {
        labels: labels,
        datasets: [{
            label: 'Total Orders',
            data: orderData,
            fill: false,
            backgroundColor: 'rgb(129, 23, 250)',
            borderColor: 'rgb(129, 23, 250)',
            tension: 0.4
        }
    ]
    };
    const config2 = {
        type: 'line',
        data: data2,
    };
    const chartTop3 = new Chart(
        document.getElementById('ItemsSaled'),
        config2
    );

</script>


<?php require_once __DIR__ . '/common/footer.php'; ?>
