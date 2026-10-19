<?php
include "../../../config/config.php";
include "../../../config/database.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /CorePHP/login.php");
    exit;
}

if (!isset($_GET['session_id']) || $_GET['session_id'] === '') {
    echo "<h1>No session ID found.</h1>";
    exit;
}

function addrevenue($conn, $target_id, $target_role, $amount)
{
    $target_id   = (int) $target_id;
    $amount      = (float) $amount;
    $target_role = mysqli_real_escape_string($conn, $target_role);

    $sql       = "SELECT * FROM `revenue` WHERE user_id = '$target_id' LIMIT 1";
    $resultsql = mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultsql) == 0) {
        $sqlquery = "INSERT INTO `revenue` (user_id, role, revenue) VALUES ('$target_id', '$target_role', '$amount')";
        mysqli_query($conn, $sqlquery);
    } else {
        $resultsqlrevenue = mysqli_fetch_assoc($resultsql);
        $revenue          = $resultsqlrevenue['revenue'] + $amount;
        $sqlquery         = "UPDATE `revenue` SET revenue = '$revenue' WHERE user_id = '$target_id'";
        mysqli_query($conn, $sqlquery);
    }
}

function distributerevenue($conn, $owner_id, $amount, $admin_id)
{
    $amount = (float) $amount;

    if (empty($owner_id)) {
        addrevenue($conn, $admin_id, 'admin', $amount);
        return;
    }

    $owner_id      = (int) $owner_id;
    $onwerquery    = "SELECT id, role FROM `user` WHERE id = '$owner_id' LIMIT 1";
    $runonwerquery = mysqli_query($conn, $onwerquery);
    $resultonwer   = mysqli_fetch_assoc($runonwerquery);

    if (!$resultonwer || $resultonwer['role'] === 'admin') {
        addrevenue($conn, $admin_id, 'admin', $amount);
    } else {
        $admin_share  = round($amount * 0.20, 2);
        $vendor_share = $amount - $admin_share;

        addrevenue($conn, $owner_id, $resultonwer['role'], $vendor_share);
        addrevenue($conn, $admin_id, 'admin', $admin_share);
    }
}

$session_id = mysqli_real_escape_string($conn, $_GET['session_id']);
$user_id    = (int) $_SESSION['user_id'];
$isPaid     = false;

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL            => 'https://api.stripe.com/v1/checkout/sessions/' . urlencode($_GET['session_id']),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => ["Authorization: Bearer $secret_key"],
    CURLOPT_HTTPGET        => true,
    CURLOPT_TIMEOUT        => 15,
]);
$response = curl_exec($curl);

if ($response === false) {
    $err = curl_error($curl);
    curl_close($curl);
    die("Curl error: " . htmlspecialchars($err));
}
curl_close($curl);

$session = json_decode($response, true);

if (isset($session['payment_status']) && $session['payment_status'] === 'paid') {
    $isPaid = true;

    $selectorder   = "SELECT * FROM `order` WHERE session_id = '$session_id'";
    $runorderquery = mysqli_query($conn, $selectorder);

    if (mysqli_num_rows($runorderquery) == 0) {

        $adminquery  = "SELECT id FROM `user` WHERE role = 'admin' LIMIT 1";
        $adminresult = mysqli_query($conn, $adminquery);
        $adminrow    = mysqli_fetch_assoc($adminresult);
        $admin_id    = (int) $adminrow['id'];

        $maxidquery  = "SELECT MAX(order_id) as max_id FROM `order`";
        $maxidresult = mysqli_query($conn, $maxidquery);
        $maxidrow    = mysqli_fetch_assoc($maxidresult);

        if ($maxidrow['max_id'] == null) {
            $order_id = 1001;
        } else {
            $order_id = $maxidrow['max_id'] + 1;
        }

        $total_amount     = $session['amount_total'] / 100;
        $product_quantity = 0;

        if (!empty($session['metadata']['product_id']) && !empty($session['metadata']['sku'])) {

            $meta_product_id = (int) $session['metadata']['product_id'];
            $selectproduct   = "SELECT * FROM product WHERE id = '$meta_product_id'";
            $result          = mysqli_query($conn, $selectproduct);
            while ($row = mysqli_fetch_assoc($result)) {
                $product_id     = (int) $row["id"];
                $product_sku    = $row["sku"];
                $product_qty1   = 1;
                $product_name   = mysqli_real_escape_string($conn, $row["name"]);
                $product_price  = $row["price"];
                $product_quantity += $product_qty1;
                $stock    = $row["stock_quantity"] - $product_qty1;
                $onwer_id = $row['user_id'];

                distributerevenue($conn, $onwer_id, $product_price * $product_qty1, $admin_id);

                $productquery = "UPDATE `product` SET stock_quantity='$stock' WHERE sku='$product_sku'";
                mysqli_query($conn, $productquery);

                $insertorderitem = "INSERT INTO `order_item` (order_id, product_id, user_id, product_name, product_quantity, product_price)
                                    VALUES ('$order_id','$product_id','$user_id','$product_name','$product_qty1','$product_price')";
                mysqli_query($conn, $insertorderitem);
            }

            $insertquery = "INSERT INTO `order` (order_id, user_id, total_amount, product_quantity, session_id, status)
                            VALUES ('$order_id', '$user_id', '$total_amount', '$product_quantity', '$session_id', 'paid')";
            mysqli_query($conn, $insertquery);
        } else {
            $selectcart = "SELECT cart.product_id, cart.quantity, product.name, product.price, product.stock_quantity, product.sku, product.user_id AS owner_id
                           FROM cart
                           JOIN product ON cart.product_id = product.id
                           WHERE cart.user_id = '$user_id'";
            $result = mysqli_query($conn, $selectcart);

            while ($row = mysqli_fetch_assoc($result)) {
                $product_id     = (int) $row["product_id"];
                $product_sku    = $row["sku"];
                $product_qty1   = (int) $row["quantity"];
                $product_name   = mysqli_real_escape_string($conn, $row["name"]);
                $product_price  = $row["price"];
                $product_quantity += $product_qty1;
                $stock    = $row["stock_quantity"] - $product_qty1;
                $onwer_id = $row['owner_id'];

                distributerevenue($conn, $onwer_id, $product_price * $product_qty1, $admin_id);

                $productquery = "UPDATE `product` SET stock_quantity='$stock' WHERE sku='$product_sku'";
                mysqli_query($conn, $productquery);

                $insertorderitem = "INSERT INTO `order_item` (order_id, product_id, user_id, product_name, product_quantity, product_price)
                                    VALUES ('$order_id','$product_id','$user_id','$product_name','$product_qty1','$product_price')";
                mysqli_query($conn, $insertorderitem);
            }

            $insertquery = "INSERT INTO `order` (order_id, user_id, total_amount, product_quantity, session_id, status)
                            VALUES ('$order_id', '$user_id', '$total_amount', '$product_quantity', '$session_id', 'paid')";
            mysqli_query($conn, $insertquery);

            $DeleteCart = "DELETE FROM cart WHERE user_id = '$user_id'";
            mysqli_query($conn, $DeleteCart);
        }
    }
}
?>

<style>
._failed { border-bottom: solid 4px red !important; }
._failed i { color: red !important; }

._success {
    box-shadow: 0 15px 25px #00000019;
    padding: 45px;
    width: 450px;
    text-align: center;
    margin: 40px auto;
    border-bottom: solid 4px #28a745;
}

._success i {
    font-size: 55px;
    color: #28a745;
}

a { text-decoration: none; }

._success h2 {
    margin-bottom: 12px;
    font-size: 40px;
    font-weight: 500;
    line-height: 1.2;
    margin-top: 10px;
}

._success p {
    margin-bottom: 0;
    font-size: 18px;
    color: #495057;
    font-weight: 500;
}
</style>

<?php if ($isPaid) { ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                    <h2>Your payment was successful</h2>
                    <p>Thank you for your payment. We will<br>be in contact with more details shortly</p>
                    <h3><a href="/CorePHP/home.php">Back to Home Page</a></h3>
                </div>
            </div>
        </div>
    </div>
<?php  } else { ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success _failed">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                    <h2>Your payment failed</h2>
                    <p>Try again later</p>
                    <h3><a href="/CorePHP/home.php">Back To Home Page</a></h3>
                </div>
            </div>
        </div>
    </div>
<?php  } ?> 