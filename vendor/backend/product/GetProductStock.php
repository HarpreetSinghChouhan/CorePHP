<?php
include "../../../config/database.php";
include "../verify.php";
$user_id = $_SESSION['user_id'];
header('Content-Type: application/json');

$user_id = (int)$user_id;

$range   = (isset($_GET['range']) && $_GET['range'] === 'month') ? 'month' : '7days';
$status  = isset($_GET['status']) ? $_GET['status'] : 'all';
$page    = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 5;
if (!in_array($perPage, [15, 100, 200])) { $perPage = 15; }
$lowLimit = 10;

if ($range === 'month') {
    $start_date = date('Y-m-d', strtotime('-30 days'));
    $end_date   = date('Y-m-t');
} else {
    $start_date = date('Y-m-d', strtotime('-6 days'));
    $end_date   = date('Y-m-d');
}

switch ($status) {
    case 'hot':      $where = "t.sold > 0"; break;
    case 'low':      $where = "t.stock > 0 AND t.stock <= $lowLimit"; break;
    case 'out':      $where = "t.stock = 0"; break;
    case 'nodemand': $where = "t.sold = 0"; break;
    default:         $where = "1=1";
}

$base = "SELECT p.id, p.name, p.stock_quantity AS stock, COALESCE(s.sold, 0) AS sold
         FROM `product` p
         LEFT JOIN (
             SELECT oi.product_id, SUM(oi.product_quantity) AS sold
             FROM `order_item` oi
             INNER JOIN `order` o ON o.order_id = oi.order_id
             WHERE o.is_deleted != '1'
             AND DATE(o.created_at) BETWEEN '$start_date' AND '$end_date'
             GROUP BY oi.product_id
         ) s ON s.product_id = p.id
         WHERE p.user_id = '$user_id' AND p.is_deleted != '1'";

$countQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM ($base) t WHERE $where");
if (!$countQuery) {
    echo json_encode(["error" => mysqli_error($conn)]);
    exit;
}
$total = (int)mysqli_fetch_assoc($countQuery)['total'];

$offset = ($page - 1) * $perPage;

$sql = "SELECT t.* FROM ($base) t
        WHERE $where
        ORDER BY (t.sold > 0) DESC,
                 CASE WHEN t.sold > 0 THEN t.sold / (t.stock + 1) END DESC,
                 t.stock ASC
        LIMIT $perPage OFFSET $offset";

$result = mysqli_query($conn, $sql);
if (!$result) {
    echo json_encode(["error" => mysqli_error($conn)]);
    exit;
}
$rows = [];
$perchanged = 0;
$stock = 0;
while ($r = mysqli_fetch_assoc($result)) {
     $stock += (int)$r['stock'];
     $perchanged += (int)$r['sold']; 
$rows[] = [
        'id'    => (int)$r['id'],
        'name'  => $r['name'],
        'stock' => (int)$r['stock'],
        'sold'  => (int)$r['sold'],
    ];
};
$data = [
    [
        'sold' => $perchanged, 
        'name' => 'saled Product'
    ],
    [
        'sold' => $stock, 
        'name' => 'inStock Product'
    ]
];


echo json_encode([
    'data'  => $data,   
    'total' => $total,
    'page'  => $page,
    'pages' => max(1, (int)ceil($total / $perPage)),
]);