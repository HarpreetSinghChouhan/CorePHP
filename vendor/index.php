<?php
$pageTitle  = 'Dashboard';
$activePage = 'dashboard';

include __DIR__ . '/common/header.php';
include __DIR__ . '/common/sidebar.php';
include __DIR__ . '/common/navbar.php';
?>
    <script src="./assets/js/index.js"; defer ></script>

<section class="vr-stats">
    <div class="vr-stat">
        <div class="vr-stat-icon"><i class="fa-solid fa-box"></i></div>
         <?php  
           $sql = "SELECT id, user_id, is_deleted FROM `product` WHERE user_id ='$user_id' AND is_deleted !='1'";
           $sqlquery = mysqli_query($conn,$sql);
         ?>
        <div class="product-page" ><b class="product-count" ><?php  echo mysqli_num_rows($sqlquery)  ?></b><span>My Products</span></div>
    </div>
    <div class="vr-stat">
        <div class="vr-stat-icon"><i class="fa-solid fa-layer-group"></i></div>
         <?php  
           $revenue = "SELECT id, user_id, revenue FROM `revenue` WHERE user_id ='$user_id' LIMIT 1";
           $revenuequery = mysqli_query($conn,$revenue);
           $totalcount = 0;
           if(!$revenuequery){
              $totalcount = 0;
           } else{
            $resultrevenue = mysqli_fetch_assoc($revenuequery);
            $totalcount = $resultrevenue['revenue'];
           }
         ?>
        <div><b class="total-revenue" ><?php echo $totalcount;?></b><span>Total Revenue</span></div>
    </div>
    <div class="vr-stat">
        <div class="vr-stat-icon"><i class="fa-solid fa-cart-shopping"></i></div>
        
        <div class="order-page"  ><b class="total-order-Item" >0</b><span>Total Order</span></div>
    </div>
    <!-- <div class="vr-stat">
        <div class="vr-stat-icon"><i class="fa-solid fa-heart"></i></div>
        <div><b class="total-wishlist" >0</b><span>Wishlisted Product</span></div>
    </div> -->
</section>
 <!-- <canvas id="chartShippers"></canvas> -->

<?php
$range = isset($_GET['range']) ? $_GET['range'] : '7days';

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
          AND p.user_id = '$user_id'
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

<!-- Buttons -->
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
        <canvas id="TopChartItem"></canvas>
    <!-- <div style="display:flex;justify-content:space-between;margin-top:8px;">
        <button id="stockPrev" class="vr-btn">Prev</button>
        <span id="stockPageInfo"></span>
        <button id="stockNext" class="vr-btn">Next</button>
    </div> -->
        </div>
            <div style="width:100%;max-width:900px;" >
                <canvas id="chartTop3"></canvas>
            </div>

        </div>
    </div>


<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
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
    // const data3 = {
    //     labels: labels,
    //     datasets:[{
    //         label: 'Product Saled',
    //         data:SaledProduct,
    //         fill: false,
    //         backgroundColor: 'rgb(53, 212, 240)',
    //         borderColor: 'rgb(53, 212, 240)',
    //         tension: 0.1
    //     },{
    //         label:'Product stock',
    //         data:Totalproductquantity,
    //         fill:false,
    //         backgroundColor:'rgb(38, 245, 65)',
    //         borderColor:'rgb(245, 65, 65)'.
    //         tension:0.5
    //     }
    // ]
    // }

    const config2 = {
        type: 'line',
        data: data2,
    };
//     const config3 = {
//         type: 'line',
//         data: data3,
//     };
//     const TopChartItem = new Chart(
//         document.getElementById('TopChartItem'),
//         config3
// );
    const chartTop3 = new Chart(
        document.getElementById('chartTop3'),
        config2
    );

</script>

<!-- Recent products -->
<section class="vr-card">
    <div class="vr-card-head">
        <h2>Recent orders</h2>
        <a href="/CorePHP/vendor/product/create.php" class="vr-btn">
            <i class="fa-solid fa-plus"></i> Add Product
        </a>
    </div>

        <div class="vr-table-wrap">
            <table class="vr-table vr-datatable" id='index_datatable'>
                <thead>
                    <tr>
                      <th>Serial No</th>
                <th>Order Id</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>Total Quantity</th>
                <th>Total Amount</th>
                <th>Order Item</th>
                <th>Perchange At</th>
                <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
</section>

<?php include __DIR__ . '/common/footer.php'; ?>