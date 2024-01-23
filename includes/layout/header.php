<?php

$fav_count = $cart_count = '';
if (isset($_SESSION['user_id']) and !empty($_SESSION['user_id'])) {
    $enc_uid = $_SESSION['user_id'];

    // get favorites and cart info if user is loged in
    $qry1 = $conn->query("SELECT count(*) AS favCount FROM favorites f WHERE f.fuid = '{$enc_uid}'");
    $qry1_res = $qry1->fetch_assoc();
    $fav_count = $qry1_res['favCount'];

    $qry2 = $conn->query("SELECT count(*) AS cartCount FROM cart c WHERE c.cuid = '{$enc_uid}'");
    $qry2_res = $qry2->fetch_assoc();
    $cart_count = $qry2_res['cartCount'];
}

?>

<div class="header">
    <div class="header-top">
        <div class="container flex flex-end header-top-content">
            <div class="header-top-text flex flex-top gap-2">
                <span>Summer Sale For All Swim Suits And Free Express Delivery - OFF 50%!</span>
                <a href="#">Shop Now</a>
            </div>
            <div class="header-top-dropdown relative">
                <div class="dropdown-btn flex gap-1 flex-v-center">
                    <span>English</span>
                    <i class="fa-solid fa-angle-down drop-icon"></i>
                </div>
                <div class="header-top-dropdown-menu"></div>
            </div>
        </div>
    </div>
    <div class="header-main relative">
        <div class="container header-container flex ">
            <div class="header-main-left flex flex-v-center relative">
                <div class="logo flex flex-v-center gap-2">
                    <button class="btn btn-nav-toggle"><i class="ri-menu-line"></i></button>
                    <h3>Exclusive</h3>
                </div>
                <div class="header-nav">
                    <ul class="nav grid gap-3">
                        <li><a href="http://localhost/e_commerce_design?page=home" id="home">Home</a></li>
                        <li><a href="http://localhost/e_commerce_design/contact?page=contact" id="contact">Contact</a></li>
                        <li><a href="#" id="about">About</a></li>
                        <li><a href="http://localhost/e_commerce_design/auth/signup?page=signup" id="signup">Sign up</a></li>
                    </ul>
                </div>
            </div>
            <div class="header-main-right flex gap-2 flex-v-center">
                <div class="header-search relative">
                    <div class="header-search-field grid">
                        <button class="btn btn-search-close"><i class="fa-solid fa-arrow-left"></i></button>
                        <input type="text" class="inp header-search-inp" placeholder="What are you looking for?">
                        <button class="btn btn-header-search" disabled='false'><i class="fa-solid fa-search"></i></button>
                    </div>
                    <div class="header-search-results"></div>
                </div>
                <div class="header-btns flex">
                    <button class="btn btn-favorites flex flex-bottom active">
                        <a href="http://localhost/e_commerce_design/account/wishlist"><i class="ri-heart-line"></i></a>
                        <span class="badge badge-fav-counts"><?php echo $fav_count ?></span>
                    </button>
                    <button class="btn btn-shop-cart flex flex-bottom">
                        <a href="http://localhost/e_commerce_design/account/cart"><i class="ri-shopping-cart-line"></i></a>
                        <span class="badge badge-cart-counts"><?php echo $cart_count ?></span>
                    </button>

                    <!-- link to user account if user is loged in -->
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <div class="user-account-menu relative">
                            <button class="btn btn-toggle-user-menu"><i class="ri-user-line"></i></button>
                            <div class="user-menu" tabindex="-1">
                                <ul class="user-menu-items grid">
                                    <li class="user-menu-item">
                                        <a href="http://localhost/e_commerce_design/account/index" class="flex gap-4">
                                            <i class="ri-user-line"></i>
                                            <span>Manage My Account</span>
                                        </a>
                                    </li>

                                    <li class="user-menu-item">
                                        <a href="http://localhost/e_commerce_design/account/orders.php" class="flex gap-4">
                                            <i class="ri-shopping-cart-line"></i>
                                            <span>My Order</span>
                                        </a>
                                    </li>

                                    <li class="user-menu-item">
                                        <a href="#" class="flex gap-4">
                                            <i class="ri-close-circle-line"></i>
                                            <span>My Cancelattion</span>
                                        </a>
                                    </li>

                                    <li class="user-menu-item">
                                        <a href="#" class="flex gap-4">
                                            <i class="ri-star-line"></i>
                                            <span>Manage Reviews</span>
                                        </a>
                                    </li>

                                    <li class="user-menu-item">
                                        <a href="http://localhost/e_commerce_design/logout.php" class="flex gap-4">
                                            <i class="ri-logout-box-line"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                    <button class="btn btn-toggle-search-bar"><i class="ri-search-line"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>