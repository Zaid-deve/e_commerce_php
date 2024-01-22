<?php

session_start();
if (empty($_SESSION['user_id'])) header("Location:../auth/login") or die();
$uid = $_SESSION['user_id'];

// db connection
require "../db/db_config.php";
require "../db/db_conn.php";

// get wishlist products
$qry = $conn->query("SELECT 
                     pid, p.ptitle title, p.pimgs imgs, p.pcurr_price active_price,p.pold_price org_price, c.cid
                     FROM favorites f
                     JOIN products p ON p.pid = f.fpid
                     LEFT JOIN cart c ON c.cpid = p.pid
                     WHERE f.fuid = '{$uid}'");
if (!$qry || !$qry->num_rows > 0) {
    $output = "no favorites yet !";
} else {
    // starting of wishlist block
    $output = "<div class='item-row'>";
    while ($data = $qry->fetch_assoc()) {
        // item info
        $pid = $data['pid'];
        $title = $data['title'];
        $img = explode(',', $data['imgs'])[0];
        $active_price = $data['active_price'];
        $org_price = $data['org_price'];
        $enc_pid = base64_encode($pid);
        $cart_status = empty($data['cid']) ? 'Add To Cart' : 'Remove From Cart';

        $discount = "";
        if ($active_price > 0) {
            $discount = round((($org_price - $active_price) / $org_price) * 100);
            $active_price = '$' . $active_price;
            $org_price = '$' . $org_price;
        } else {
            $active_price = '$' . $org_price;
        }

        if ($discount > 0) {
            $discount_block = "<div class='discount'><span>{$discount}%</span></div>";
        }

        $output .= "<div class='row-item relative'>
                        <div class='item-img'>
                            <img src='../$img' alt='#'>
                        </div>
                
                        <div class='item-info grid'>
                            <div class='item-title'>
                                <h3>$title</h3>
                            </div>
                            <div class='item-price flex gap-1'>
                                <h3 class='active-price'>$active_price</h3>
                                <h3 class='org-price'>$org_price</h3>
                            </div>
                        </div>
                
                        <button class='btn btn-addto-cart' data-pid='{$enc_pid}'><i class='ri-shopping-cart-2-line'></i> <span>{$cart_status}</span></button>
                        <button class='btn btn-del-item' data-pid='{$enc_pid}'><i class='ri-delete-bin-line'></i></button>
                        $discount_block
                    </div>";
    }

    // enc of item row
    $output .= "</div>";
}

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
    <link rel="stylesheet" href="../css/account/wishlist.css">
</head>

<body>

    <?php include '../includes/layout/header.php' ?>

    <div class="container wishlist-container">
        <!-- container wishlist items -->
        <div class="page-history">
            <p class="flex flex-v-center gap-1">
                <a href="#" class="btn">home</a>
                <span>/</span>
                <a href="#" class="btn active">wishlist</a>
            </p>
        </div>

        <!-- wishlist items -->
        <div class="container-block">
            <div class="block-header flex">
                <h3>Wishlist (4)</h3>
                <button class="btn btn-moveall">Move All To Bag</button>
            </div>

            <!-- wishlist item rows -->
            <?php echo $output; ?>
        </div>
    </div>
    </div>

    <?php include '../includes/layout/footer.php' ?>

    <!-- scripts -->
    <script src="../js/header.js"></script>
    <script src="../js/product/remove_fav.js"></script>
    <script src="../js/product/add_to_cart.js"></script>

</body>

</html>