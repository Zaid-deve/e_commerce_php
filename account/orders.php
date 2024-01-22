<?php

session_start();
if (!isset($_SESSION['user_id']) and empty($_SESSION['user_id'])) {
    header('Location: ../auth/signup.php') or die("something went wrong !");
}

// db connection and 
$uid = $_SESSION['user_id'];
require "../db/db_config.php";
require "../db/db_conn.php";
$output = "Something Went Wrong !";

// find orders
$qry = $conn->query("SELECT p.ptitle,p.pimgs,o.order_price,o.order_date,o.order_id FROM orders o
                     JOIN products p ON p.pid = o.order_pid
                     WHERE o.order_uid = '{$uid}';");
if($qry){
    if($qry->num_rows > 0){

        // starting of orders section
        $output = "<div class='orders-grid grid'>";

        // fetch orders
        while($order = $qry->fetch_assoc()){

            // item info
            $oid = base64_encode($order['order_id']);
            $ptitle = $order['ptitle'];
            $price = $order['order_price'];
            $pimg = explode(',', $order['pimgs'])[0];

            $price = "$" . $price; 

            // order block
            $output .= "<div class='order-item relative'>
                            <a href='#'>
                                <div class='order-item-img flex flex-v-center flex-h-center'>
                                    <img src='../{$pimg}' alt='#'>
                                </div>
                            </a>
                            <div class='order-info'>
                                <div class='order-item-title'>{$ptitle}</div>
                                <div class='order-item-price'>{$price}</div>
                            </div>
                            <button class='btn btn-cancel-item' data-oid='{$oid}'><i class='ri-delete-bin-6-line'></i></button>
                        </div>";
        }

        // ending of orders section
        $output .= "</div>";
    } else {
        $output  = "<div class='no-orders-text'>
                        <h1>No Orders Yet</h1>
                        <p>you have no active orders, start ordering items now click on the button</p>
                        <a class='btn btn-back' href='http://localhost/e_commerce_design'>Explore Products</a>
                    </div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>

    <!-- local stylesheets -->
    <link rel="stylesheet" href="../config.css">

    <!-- font family poppins / inter -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- remixicons and fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <link rel="stylesheet" href="../css/layout/header.css">
    <link rel="stylesheet" href="../css/layout/footer.css">
    <link rel="stylesheet" href="../css/pageHistory.css">
    <link rel="stylesheet" href="../css/account/orders.css">
</head>

<body>

    <?php include "../includes/layout/header.php"; ?>

    <!--  CONTENT -->
    <div class="container orders-container">
        <div class="page-history">
            <p class="flex gap-1">
                <a href="../">Account</a>
                <span>/</span>
                <a href="#" class="active">Orders</a>
            </p>
        </div>

        <h1>My Orders</h1>
        <?php echo $output; ?>
    </div>

    <?php include "../includes/layout/footer.php"; ?>

    <!-- scripts -->
    <script src="../js/header.js"></script>
    <script src="../js/account/del_order.js"></script>
</body>

</html>