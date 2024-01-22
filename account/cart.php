<?php

// defaults
$output = 'something went wrong !';

session_start();
if (empty($_SESSION['user_id'])) header("Location: ../auth/login?r=true") or die($output);
$uid = $_SESSION['user_id'];

// db connection
require "../db/db_config.php";
require "../db/db_conn.php";

// qry
$qry = $conn->query("SELECT
                     c.cid,p.ptitle title, p.pimgs imgs, p.pcurr_price active_price,
                     p.pold_price org_price,c.cquantity quantity
                     FROM cart c
                     JOIN products p ON p.pid = c.cpid
                     WHERE c.cuid = '{$uid}'");

if ($qry and $qry->num_rows > 0) {
    // item rows/header start
    $output = "<div class='cart-grid grid'>
                    <div class='cart-grid-header cart-grid-item grid'>
                        <span>Product</span>
                        <span>Price</span>
                        <span>Quantity</span>
                        <span>Subtotal</span>
                    </div>";

    // fetch cart items
    $total_price = $subtotal_price = 0;
    while ($item = $qry->fetch_assoc()) {
        // cart item info
        $cid = base64_encode($item['cid']);
        $title = substr($item['title'], 0, 10) . '...';
        $img = explode(',', $item['imgs'])[0];
        $active_price = $item['active_price'];
        $org_price = $item['org_price'];
        $quantity = $item['quantity'];


        // calculate price 
        $price = ($active_price > 0) ? $active_price : $org_price;
        $price = (int) $price;
        $subtotal = 0;
        if ($quantity > 1) {
            $subtotal = (int) ($price * $quantity);
        } else $subtotal = $price;

        $total_price = $total_price + $price;
        $subtotal_price = ($subtotal + $subtotal);

        // item row
        $output .= "<div class='cart-grid-item cart-grid-row grid'>
                        <div class='cart-item-info flex flex-v-center gap-2' onclick='removeItem(this,`{$cid}`)'>
                            <div class='cart-item-img relative'>
                                <img src='../{$img}' alt='#'>
                                <div class='remove-icon'><i class='ri-close-circle-fill'></i></div>
                            </div>
                            <span>{$title}</span>
                        </div>
                
                        <div class='cart-item-price' data-price='{$price}'><span>$$price</span></div>
                
                        <div class='cart-quantity-change'>
                            <input type='number' class='inp' id='quantity-change-inp' min='1' max='999' value='{$quantity}' data-cid='{$cid}'>
                        </div>
                
                        <div class='cart-subtotal-price'><span>$$subtotal</span></div>
                    </div>";
    }

    // row btns
    $output .= "    <div class='cart-btns flex'>
                        <a class='btn btn-return' style='color:#000;border-radius:4px;'>Return To Shop</a>
                        <button class='btn btn-update' disabled>Update Cart</button>
                    </div>
                </div>";

    // cart toatl and subtotal
    $output .= "<div class='cart-bottom flex'>
                    <div class='add-coupon-field flex flex-v-center gap-4'>
                        <input type='text' class='inp' id='coupon-code' placeholder='Coupon Code'>
                        <button class='btn btn-add-coupon'>Apply Coupon !</button>
                    </div>
                
                    <div class='price-grid grid'>
                        <h3>Cart Total</h3>
                        <div class='price-grid-row flex'>
                            <span>Total</span>
                            <span class='price-grid-total' data-price='{$total_price}'>$$total_price</span>
                        </div>
                        <div class='price-grid-row flex'>
                            <span>Shipping</span>
                            <span>0</span>
                        </div>
                        <div class='price-grid-row flex'>
                            <span>Sub Total</span>
                            <span class='price-grid-subtotal' data-cart-subtotal='{$subtotal_price}'>$$subtotal_price</span>
                        </div>
                        <button class='btn btn-redto-checkout'>Procees to checkout</button>
                    </div>
                </div>";
} else $output = 'no products found !';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favorites</title>

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
    <link rel="stylesheet" href="../css/account/cart.css">
</head>

<body>

    <?php include '../includes/layout/header.php' ?>

    <div class="container cart-container">
        <div class="page-history">
            <p class="flex flex-v-center gap-1">
                <a href="../../" class="btn">home</a>
                <span>/</span>
                <a href="#" class="btn active">cart</a>
            </p>
        </div>
        <?php echo $output ?>
    </div>


    <?php include '../includes/layout/footer.php' ?>

    <!-- scripts -->
    <script src="../js/header.js"></script>
    <script src="../js/product/remove_fav.js"></script>
    <script src="../js/product/add_to_cart.js"></script>
    <script src="../js/account/update_cart.js"></script>

</body>

</html>