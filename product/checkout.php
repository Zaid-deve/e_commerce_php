<?php



// prepare checkout statement

session_start();
$output = 'Something Went Wrong !';
if (isset($_SESSION['user_id']) and !empty($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
} else header("Location: ../auth/login") or die($output);

// db connection
require "../db/db_config.php";
require "../db/db_conn.php";

// check if product is added
if (!empty($_GET['pid']) and base64_decode($_GET['pid'], true)) {
    $pid = $conn->real_escape_string($_GET['pid']);
    $pid = base64_decode($pid);
} 
else header("Location: ../error404.php") or die($output);

// get product info 
$qry = $conn->query("SELECT pimgs,ptitle, pcurr_price cp,pold_price orgp FROM products WHERE pid = '{$pid}'");
if (!$qry or !$qry->num_rows > 0) die('Product Deleted Or Not Found !');
$data = $qry->fetch_assoc();

// item info
$pimg = explode(",", $data['pimgs'])[0];
$ptitle = $data['ptitle'];
if (strlen($ptitle) > 10) {
    $ptitle = substr($ptitle, 0, 10) . '...';
}
$curr_price = $data['cp'];
$org_price = $data['orgp'];

$price = $org_price;
if ($curr_price != 0 and $curr_price != $org_price) {
    $price = $curr_price;
}

// get quantity
$quantity = 1;
if (!empty($_GET['quantity'])) {
    $quantity = $conn->real_escape_string($_GET['quantity']);
    $price = $price * $quantity;
}

// get user presaved address and email and user info
$qry1 = $conn->query("SELECT
                      u.fname,u.user_address,u.user_phone uphone,u.user_email uemail,
                      b.bid billing_id,b.fname,b.bcompany,b.bstreet,b.bstreet2,b.town_city,b.user_phone bphone,b.user_email bemail
                      FROM users u 
                      LEFT JOIN billing_info b
                      ON b.buid = u.user_id
                      WHERE u.user_id = '{$uid}'");


$fname = $company =  $street_address = $apartment = $town_city =  $email =  $phone = "";

if ($qry1) {
    if ($qry1->num_rows > 0) {
        $user_info = $qry1->fetch_assoc();

        if (empty($user_info['billing_id'])) {
            // set billing info
            $fname = $user_info['fname'];
            $company = $user_info['bcompany'];
            $street_address = $user_info['bstreet'];
            $apartment = $user_info['bstreet2'];
            $town_city = $user_info['town_city'];
            $email = $user_info['bemail'];
            $phone = $user_info['bphone'];
        } else {
            $fname = base64_decode($user_info['fname']);
            $email = base64_decode($user_info['uemail']);
            $phone = base64_decode($user_info['uphone']);
            $street_address = base64_decode($user_info['user_address']);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $ptitle; ?></title>

    <!-- local stylesheets -->
    <link rel="stylesheet" href="../config.css">

    <!-- font family poppins / inter -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- remixicons and fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- include stylsheets -->
    <link rel="stylesheet" href="../css/layout/header.css">
    <link rel="stylesheet" href="../css/layout/footer.css">
    <link rel="stylesheet" href="../css/pageHistory.css">
    <link rel="stylesheet" href="../css/product/checkout.css">
</head>

<body>

    <!-- BODY -->

    <?php include "../includes/layout/header.php" ?>

    <!-- CONTENT -->
    <div class="container checkout-container">
        <div class="page-history">
            <p>
                <a href="#">product</a>
                <span>/</span>
                <a href="#" class="active"><?php echo $ptitle; ?></a>
            </p>
        </div>

        <div class="content flex">
            <!-- billing address contact form -->
            <div class="checkout-form">
                <h1>Billing Details</h1>
                <div class="form grid">
                    <div class="field field-1">
                        <label for="fname">First Name*</label>
                        <input type="text" id="fname" data-required='1' value="<?php echo $fname; ?>">
                        <div class="err"></div>
                    </div>
                    <div class="field field-1">
                        <label for="company_name">Company Name</label>
                        <input type="text" id="company_name" data-required='0' value="<?php echo $company; ?>">
                        <div class="err"></div>
                    </div>
                    <div class="field field-1">
                        <label for="street_add">Street Address*</label>
                        <input type="text" id="street_add" data-required='1' value="<?php echo $street_address; ?>">
                        <div class="err"></div>
                    </div>
                    <div class="field field-1">
                        <label for="street_add_2">Apartment, floor, etc. (optional)</label>
                        <input type="text" id="street_add_2" data-required='0' value="<?php echo $apartment; ?>">
                        <div class="err"></div>
                    </div>
                    <div class="field field-1">
                        <label for="town_city_add">Town/City*</label>
                        <input type="text" id="town_city_add" data-required='1' value="<?php echo $town_city; ?>">
                        <div class="err"></div>
                    </div>
                    <div class="field field-1">
                        <label for="phone">Phone Number*</label>
                        <input type="text" id="phone" data-required='1' value="<?php echo $phone; ?>">
                        <div class="err"></div>
                    </div>
                    <div class="field field-1">
                        <label for="email">Email Address*</label>
                        <input type="text" id="email" data-required='1' value="<?php echo $email; ?>">
                        <div class="err"></div>
                    </div>
                </div>
                <label class="remember-details-label" for="remember-details"><input type="checkbox" checked id="remember-details"> <span>Save this information for faster check-out next time</span></label>
            </div>

            <!-- item checkout and payment options -->
            <div class="item-overview">

                <input type="text" value="<?php echo $pid; ?>" id="pid" hidden>
                <input type="text" value="<?php echo $quantity; ?>" id="quantity" hidden>
                <div class="item-overview-content grid">
                    <!-- item image title and price info -->
                    <div class="items-preview grid">
                        <div class="item-preview flex">
                            <img src="../<?php echo $pimg; ?>" alt="#">
                            <span><?php echo $ptitle; ?></span>
                            <b>$<?php echo $price; ?></b>
                        </div>
                    </div>

                    <!-- items price info -->
                    <div class="price-info grid">
                        <div class="flex">
                            <span>Sub-Total</span>
                            <strong>$<?php echo $price; ?></strong>
                        </div>
                        <div class="flex">
                            <span>Shipping</span>
                            <strong>free</strong>
                        </div>
                        <div class="flex">
                            <span>Total</span>
                            <strong>$<?php echo $price; ?></strong>
                        </div>
                    </div>

                    <!-- item payment info -->
                    <div class="payment-info grid">
                        <div class="flex">
                            <label for="pay_bank">
                                <input type="radio" class="pay_mode" id="pay_bank" name="pay_mode" disabled>
                                <span>Bank</span>
                            </label>
                            <div class="imgs flex flex-v-center gap-2">
                                <img src="../images/image 32.png" alt="#">
                                <img src="../images/image 31.png" alt="#">
                                <img src="../images/image 30.png" alt="#">
                                <img src="../images/image 33.png" alt="#">
                            </div>
                        </div>

                        <div class="flex">
                            <label for="pay_cash">
                                <input type="radio" class="pay_mode" id="pay_cash" name="pay_mode" checked>
                                <span>Cash On Delivery</span>
                            </label>
                        </div>
                    </div>

                    <!-- add coupon -->
                    <div class="coupon-info">
                        <div class="field flex">
                            <input type="text" id="coupon-code" placeholder="Coupon Code">
                            <button class="btn btn-verify-cuopen">Apply Coupon</button>
                        </div>
                    </div>

                    <!-- palce order button -->
                    <button class="btn btn-place-order">
                        Place Order
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include "../includes/layout/footer.php" ?>


    <!-- sctipts -->
    <script src="../js/header.js"></script>
    <script src="../js/form-func.js"></script>
    <script src="../js/product/billing.js"></script>
</body>

</html>