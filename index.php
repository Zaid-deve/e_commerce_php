<?php


// start session
session_start();

// db connection
require "db/db_config.php";
require "db/db_conn.php";

// user id
if (isset($_SESSION['user_id']) and !empty($_SESSION['user_id'])) {
    $uid = base64_encode($_SESSION['user_id']);
}
$bestselling_id = "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Home Page</title>

    <!-- local stylesheets -->
    <link rel="stylesheet" href="./config.css">

    <!-- font family poppins / inter -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- remixicons and fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- include stylsheets -->
    <link rel="stylesheet" href="./css/layout/header.css">
    <link rel="stylesheet" href="./css/home/home.css">
    <link rel="stylesheet" href="./css/home/catagorie.css">
    <link rel="stylesheet" href="./css/home/banner.css">
    <link rel="stylesheet" href="./css/home/content.css">
    <link rel="stylesheet" href="./css/layout/footer.css">
</head>

<body>

    <!-- START OF BODY -->

    <!-- start of header -->
    <?php include "includes/layout/header.php"; ?>
    <!-- end of header -->

    <!-- start of home page content --catagorie section and --scrollable banner -->
    <div class="section-home">
        <div class="container flex home-sections">
            <?php include "./includes/home/catagorie.php"; ?>
            <?php include "./includes/home/banner.php"; ?>
        </div>
    </div>

    <!-- start of product container -->

    <div class="container">
        <!-- recent sales -->
        <?php include "includes/home/sections/sales.php" ?>

        <!-- top catagories products -->
        <div class="container-section">
            <div class="container-header flex flex-bottom">
                <div class="contaier-heading">
                    <div class="container-title flex flex-v-center gap-2">
                        <div></div>
                        <span>catagories</span>
                    </div>
                    <h3>Browse By Category</h3>
                </div>
                <div class="container-header-btns flex gap-2">
                    <button class="btn btn-move-left"><i class="ri-arrow-left-line"></i></button>
                    <button class="btn btn-move-right"><i class="ri-arrow-right-line"></i></button>
                </div>
            </div>
            <div class="container-content content-2 container-section continer-section-2">
                <div class="content-2-list flex flex-v-center">
                    <a class="content-2-list-item flex" href="#">
                        <img src="./images/cimgs/Category-CellPhone.png" alt="#">
                        <span>Phones</span>
                    </a>
                    <a class="content-2-list-item flex" href="#">
                        <img src="./images/cimgs/Category-Computer.png" alt="#">
                        <span>Computers</span>
                    </a>
                    <a class="content-2-list-item flex" href="#">
                        <img src="./images/cimgs/Category-SmartWatch.png" alt="#">
                        <span>SmartWatch</span>
                    </a>
                    <a class="content-2-list-item flex" href="#">
                        <img src="./images/cimgs/Category-Camera.png" alt="#">
                        <span>Cameras</span>
                    </a>
                    <a class="content-2-list-item flex" href="#">
                        <img src="./images/cimgs/Category-Headphone.png" alt="#">
                        <span>Headphones</span>
                    </a>
                    <a class="content-2-list-item flex" href="#">
                        <img src="./images/cimgs/Category-Gamepad.png" alt="#">
                        <span>Gampad</span>
                    </a>
                </div>
            </div>
            <div class="container-section-line"></div>
        </div>


        <!-- best selling items -->
        <?php include "includes/home/sections/bestselling.php"; ?>

        <div class="container-section container-section-4">
            <div class="container-banner flex">
                <div class="container-banner-info grid">
                    <span class="container-banner-text">Categories</span>
                    <h1>Enhance Your <br> Music Experience</h1>
                    <div class="container-banner-countdown flex flex-v-center">
                        <div class="banner-count-down-item count-down-item1">
                            <span>Days</span>
                            <h3>03</h3>
                        </div>
                        <div class="banner-count-down-item count-down-item1">
                            <span>Hours</span>
                            <h3>12</h3>
                        </div>
                        <div class="banner-count-down-item count-down-item1">
                            <span>Minutes</span>
                            <h3>08</h3>
                        </div>
                        <div class="banner-count-down-item count-down-item1">
                            <span>Seconds</span>
                            <h3>58</h3>
                        </div>
                    </div>
                    <button class="btn btn-banner-buynow"><span>Buy Now!</span></button>
                </div>
                <div class="container-banner-img">
                    <img src="images/JBL_BOOMBOX_2_HERO_020_x1 (1) 1.png" alt="">
                </div>
            </div>
        </div>

        <?php include "includes/home/sections/explore.php"; ?>

        <div class="container-section container-section-6">
            <div class="container-header flex flex-bottom">
                <div class="contaier-heading">
                    <div class="container-title flex flex-v-center gap-2">
                        <div></div>
                        <span>Featured</span>
                    </div>
                    <h3>New Arrival</h3>
                </div>
            </div>

            <!-- NEW ARRIVALS 2 MAIN COLUMNS AND 3 ROWS IN SECONDS GRID -->
            <div class="new-arrivals grid">
                <div class="col-1 relative flex flex-bottom flex-h-center">
                    <div class="col-1-img">
                        <img src="images/new_arrival/ps5-slim-goedkope-playstation_large 1.png" alt="#">
                    </div>
                    <div class="col-info grid col-1-info">
                        <h3>PlayStation 5</h3>
                        <span>Black and White version of the PS5 coming out on sale.</span>
                        <a href="#" class="btn btn-shopnow">Shop Now</a>
                    </div>
                </div>
                <div class="col-2 grid">
                    <div class="row-1 relative flex flex-bottom flex-h-center">
                        <div class="row-1-img">
                            <img src="images/new_arrival/attractive-woman-wearing-hat-posing-black-background 1.png" alt="#">
                        </div>
                        <div class="col-info grid row-1-info">
                            <h3>Women’s Collections</h3>
                            <span>Black and White version of the PS5 coming out on sale.</span>
                            <a href="#" class="btn btn-shopnow">Shop Now</a>
                        </div>
                    </div>
                    <div class="row-2 grid">
                        <div class="row-2-col row-2-col-1 relative flex flex-v-center flex-h-center">
                            <div class="row-img">
                                <img src="images/new_arrival/69-694768_amazon-echo-png-clipart-transparent-amazon-echo-png 1.png" alt="#">
                            </div>
                            <div class="col-info grid row-1-info">
                                <h3>Speakers</h3>
                                <span>Amazon wireless speakers</span>
                                <a href="#" class="btn btn-shopnow">Shop Now</a>
                            </div>
                        </div>
                        <div class="row-2-col row-2-col-2 relative flex flex-v-center flex-h-center">
                            <div class="row-img">
                                <img src="images/new_arrival/652e82cd70aa6522dd785109a455904c.png" alt="#">
                            </div>
                            <div class="col-info grid row-1-info">
                                <h3>Perfume</h3>
                                <span>GUCCI INTENSE OUD EDP</span>
                                <a href="#" class="btn btn-shopnow">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-section">
            <div class="features-group flex flex-h-center flex-v-center">
                <div class="feature-box">
                    <div class="feature-img flex flex-h-center flex-v-center relative">
                        <img src="images/features/icon-delivery.png" alt="#" class="fimg-icon">
                        <img src="images/features/Group 1000005938.png" alt="#" class="fimg-bg">
                    </div>
                    <div class="feature-info grid text-center gap-2">
                        <h3>FREE AND FAST DELIVERY</h3>
                        <span>Free delivery for all orders over $140</span>
                    </div>
                </div>

                <div class="feature-box">
                    <div class="feature-img flex flex-h-center flex-v-center relative">
                        <img src="images/features/Icon-Customer service.png" alt="#" class="fimg-icon">
                        <img src="images/features/Group 1000005938.png" alt="#" class="fimg-bg">
                    </div>
                    <div class="feature-info grid text-center gap-2">
                        <h3>24/7 CUSTOMER SERVICE</h3>
                        <span>Friendly 24/7 customer support</span>
                    </div>
                </div>

                <div class="feature-box">
                    <div class="feature-img flex flex-h-center flex-v-center relative">
                        <img src="images/features/Icon-secure.png" alt="#" class="fimg-icon">
                        <img src="images/features/Group 1000005938.png" alt="#" class="fimg-bg">
                    </div>
                    <div class="feature-info grid text-center gap-2">
                        <h3>MONEY BACK GUARANTEE</h3>
                        <span>We reurn money within 30 days</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- WEBPAGE FOOTER -->
    <?php include "includes/layout/footer.php"; ?>
    <?php $conn->close(); ?>

    <!-- END OF BODY -->

    <!-- SCRIPTS -->

    <script src="js/header.js"></script>
    <script src="js/search.js"></script>
    <script src="js/product/add_to_fav.js"></script>
    <script src="js/product/add_to_cart.js"></script>
    <script src="js/product/sales.js"></script>
    <script src="js/form-func.js"></script>
    <script src="js/account/newslister.js"></script>


</body>

</html>