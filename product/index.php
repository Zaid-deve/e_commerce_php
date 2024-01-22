<?php

// defaults
$output = "something went wrong !";

session_start();
if (empty($_SESSION['user_id'])) {
    header("location: ../auth/login?r=true");
} else {
    $uid = $_SESSION['user_id'];

    // db connection
    require "../db/db_config.php";
    require "../db/db_conn.php";

    // get product id
    if (empty($_GET['p']) or !base64_decode($_GET['p'], true)) header("Location: ../error404") or die($output);
    else $pid = $conn->real_escape_string(base64_decode($_GET['p']));

    // get ptype 
    $ptype = "products";
    if (!empty($_GET['type']) and $_GET['type'] == 'sales') $ptype = 'sales';

    // fetch item as per products

    if ($ptype == 'sales') {
        $qry = "SELECT sales_title title,sales_imgs imgs,sales_currprice active_price, sales_orgprice org_price,sales_des pdes
                FROM sales_products 
                WHERE sales_id = '{$pid}'";
    } else {
        $qry = "SELECT ptitle title,pimgs imgs,pcurr_price active_price, pold_price org_price, pdes
                FROM products
                WHERE pid = '{$pid}'";
    }

    // run query
    $res = $conn->query($qry);
    if ($res and $res->num_rows > 0) {
        $data = $res->fetch_assoc();
        $title = $data['title'];
        $active_price = $data['active_price'];
        $org_price = $data['org_price'];
        $des = $data['pdes'];
        $pimgs = explode(',', $data['imgs']);
        $discount = $fav_class = "";

        // discount and money format
        if ($active_price > 0) {
            $discount = ceil((($org_price - $active_price) / $org_price) * 100) . '%';
            $active_price = '$' . $active_price;
        } else $active_price = '$' . $org_price;

        // imgs
        $item_imgs = "";
        foreach ($pimgs as $img_src) {
            $item_imgs .= "<div class='item-img'>
                              <img src='../{$img_src}' alt='#'>
                          </div>";
        }
    } else die("product delted or not found !");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>

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
    <link rel="stylesheet" href="../css/error404.css">
    <link rel="stylesheet" href="../css/pageHistory.css">
    <link rel="stylesheet" href="../css/product/view.css">
</head>

<body>

    <?php include '../includes/layout/header.php' ?>

    <div class="container view-con">
        <div class="page-history flex gap-1">
            <p>
                <a href="http://localhost/e_commerce_design" class="btn">Account</a>
                <span>/</span>
                <a href="#" class="btn">Gaming</a>
                <span>/</span>
                <a href="#" class="active btn">Havic HV G-92 Gamepad</a>
            </p>
        </div>

        <!-- product content -->
        <div class="item-container flex flex-top">
            <!-- product images and preview of image -->
            <div class="item-imgs-section grid">
                <?php
                echo "<div class='item-imgs flex'>
                        {$item_imgs}
                      </div>";
                ?>

                <div class="item-img-preview">
                    <img src="../<?php echo $pimgs[0] ?>" alt="#">
                </div>
            </div>
            <div class="item-info">
                <!-- item details -->
                <div class="item-info-1 grid">
                    <input type="text" id="pid" value="<?php echo base64_encode($pid); ?>" hidden>
                    <div>
                        <h3 class="item-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="flex flex-v-center item-overview gap-2">
                        <div class="item-rating-stars flex gap-1">
                            <span class="fill"><i class="ri-star-fill"></i></span>
                            <span class="fill"><i class="ri-star-fill"></i></span>
                            <span class="fill"><i class="ri-star-fill"></i></span>
                            <span class="fill"><i class="ri-star-fill"></i></span>
                            <span><i class="ri-star-line"></i></span>
                        </div>
                        <h3 class="item-review-count">(150 Reviews)</h3>
                        <span>|</span>
                        <p class="item-availiblity valid">in stock</p>
                    </div>
                    <div class="item-price">
                        <?php echo $active_price; ?>
                    </div>
                    <div class="item-des"><?php echo $des; ?></div>
                </div>

                <!-- item varients -->
                <div class="item-info-2 grid">
                    <div class="item-colors flex">
                        <span>Colors: </span>
                        <div class="flex flex-v-center gap-1">
                            <button class="btn btn-color-varient-1 active"><span></span></button>
                            <button class="btn btn-color-varient-2"><span></span></button>
                        </div>
                    </div>
                    <div class="item-size flex flex-v-center">
                        <span>Size: </span>
                        <div class="flex flex-v-center size-chart">
                            <button class="btn btn-size-varient">XS</button>
                            <button class="btn btn-size-varient">S</button>
                            <button class="btn btn-size-varient selected">M</button>
                            <button class="btn btn-size-varient">L</button>
                            <button class="btn btn-size-varient">XL</button>
                        </div>
                    </div>
                    <div class="item-info-btns flex">
                        <div class="range-selector grid">
                            <button class="btn btn-dec-range">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="2" viewBox="0 0 18 2" fill="none">
                                    <path d="M17 1H1" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </button>
                            <div class="range-count">
                                <h3 class="quantity-count">1</h3>
                            </div>
                            <button class="btn btn-inc-range">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 20V12M12 12V4M12 12H20M12 12H4" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </button>
                        </div>
                        <button class="btn btn-buynow">Buy Now</button>
                        <button class="btn btn-addto-wishlist <?php echo $fav_class; ?> flex flex-v-center flex-h-center" onclick="add_to_favorite(this, '<?php echo $pid; ?>')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
                                <path d="M6 1C3.239 1 1 3.216 1 5.95C1 8.157 1.875 13.395 10.488 18.69C10.6423 18.7839 10.8194 18.8335 11 18.8335C11.1806 18.8335 11.3577 18.7839 11.512 18.69C20.125 13.395 21 8.157 21 5.95C21 3.216 18.761 1 16 1C13.239 1 11 4 11 4C11 4 8.761 1 6 1Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="feature-info grid">
                    <div class="feature-info-1 feature-info-box flex flex-v-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                            <g clip-path="url(#clip0_261_4843)">
                                <path d="M11.6673 31.6667C13.5083 31.6667 15.0007 30.1743 15.0007 28.3333C15.0007 26.4924 13.5083 25 11.6673 25C9.82637 25 8.33398 26.4924 8.33398 28.3333C8.33398 30.1743 9.82637 31.6667 11.6673 31.6667Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M28.3333 31.6667C30.1743 31.6667 31.6667 30.1743 31.6667 28.3333C31.6667 26.4924 30.1743 25 28.3333 25C26.4924 25 25 26.4924 25 28.3333C25 30.1743 26.4924 31.6667 28.3333 31.6667Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8.33398 28.3335H7.00065C5.89608 28.3335 5.00065 27.4381 5.00065 26.3335V21.6668M3.33398 8.3335H19.6673C20.7719 8.3335 21.6673 9.22893 21.6673 10.3335V28.3335M15.0007 28.3335H25.0007M31.6673 28.3335H33.0007C34.1052 28.3335 35.0007 27.4381 35.0007 26.3335V18.3335M35.0007 18.3335H21.6673M35.0007 18.3335L30.5833 10.9712C30.2218 10.3688 29.5708 10.0002 28.8683 10.0002H21.6673" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8 28H6.66667C5.5621 28 4.66667 27.1046 4.66667 26V21.3333M3 8H19.3333C20.4379 8 21.3333 8.89543 21.3333 10V28M15 28H24.6667M32 28H32.6667C33.7712 28 34.6667 27.1046 34.6667 26V18M34.6667 18H21.3333M34.6667 18L30.2493 10.6377C29.8878 10.0353 29.2368 9.66667 28.5343 9.66667H21.3333" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5 11.8182H11.6667" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M1.81836 15.4545H8.48503" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5 19.0909H11.6667" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                            <defs>
                                <clipPath id="clip0_261_4843">
                                    <rect width="40" height="40" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <div class="feature-info-text grid">
                            <h3>Free Delivery</h3>
                            <span><a href="#">Enter your postal code for Delivery Availability</a></span>
                        </div>
                    </div>
                    <div class="sep"></div>
                    <div class="feature-info-2 feature-info-box flex flex-v-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                            <g clip-path="url(#clip0_261_4865)">
                                <path d="M33.3327 18.3334C32.9251 15.4004 31.5645 12.6828 29.4604 10.5992C27.3564 8.51557 24.6256 7.18155 21.6888 6.80261C18.752 6.42366 15.7721 7.02082 13.208 8.5021C10.644 9.98337 8.6381 12.2666 7.49935 15M6.66602 8.33335V15H13.3327" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M6.66602 21.6667C7.07361 24.5997 8.43423 27.3173 10.5383 29.4009C12.6423 31.4845 15.3731 32.8185 18.3099 33.1974C21.2467 33.5764 24.2266 32.9792 26.7907 31.4979C29.3547 30.0167 31.3606 27.7335 32.4994 25M33.3327 31.6667V25H26.666" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                            <defs>
                                <clipPath id="clip0_261_4865">
                                    <rect width="40" height="40" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <div class="feature-info-text grid">
                            <h3>Return Delivery</h3>
                            <span>Free 30 Days Delivery Returns. <a href="#">Details</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- recommended products -->
        <div class="rec-products">
            <div class="rec-header flex flex-v-center">
                <div class="box"></div>
                <h3>Related Item</h3>
            </div>
            <div class="rec-products-list grid">
                <div class="rec-products-card relative">
                    <a class="btn rec-products-card-link" href="#">
                        <div class="card-img flex flex-v-center flex-h-center">
                            <div class="card-img-frame flex">
                                <img src="../images/pimgs/672462_ZAH9D_5626_002_100_0000_Light-The-North-Face-x-Gucci-coat 1.png" alt="#">
                            </div>
                        </div>
                        <div class="card-info grid">
                            <div class="card-title">The north coat</div>
                            <div class="card-pricing flex gap-2 flex-v-center">
                                <h3 class="card-pricing-current">$260</h3>
                                <h3><del>$360</del></h3>
                            </div>
                            <div class="card-rating flex flex-v-center gap-2">
                                <div class="card-rating-stars flex gap-1">
                                    <div class="checked"><i class="ri-star-fill"></i></div>
                                    <div class="checked"><i class="ri-star-fill"></i></div>
                                    <div class="checked"><i class="ri-star-fill"></i></div>
                                    <div class="checked"><i class="ri-star-fill"></i></div>
                                    <div class="checked"><i class="ri-star-fill"></i></div>
                                </div>
                                <div class="card-ratings-count"><span>(65)</span></div>
                            </div>
                        </div>
                    </a>
                    <div class="card-btns grid gap-2">
                        <button class="btn btn-card-favorite"><i class="ri-heart-line"></i></button>
                        <button class="btn btn-card-view"><i class="ri-eye-line"></i></button>
                    </div>
                    <div class="card-discount"><span>35%</span></div>
                    <button class="btn btn-addto-cart"><span>Add To Cart</span></button>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/layout/footer.php' ?>

    <!-- scripts -->
    <script src="../js/header.js"></script>
    <script src="../js/product/main.js"></script>
    <script src="../js/product/add_to_fav.js"></script>

</body>

</html>