<?php

// get current sales from db

$output = '';
$qry = $conn->query("SELECT `sales_starts`, `sales_ends`, `sales_status`, `sales_items` FROM sales");
$sales_timer = "";
if ($qry and $qry->num_rows > 0) {
    $data = $qry->fetch_assoc();

    // set timezone
    date_default_timezone_set('Asia/kolkata');

    // sales info
    $sales_starts = new DateTime($data['sales_starts']);
    $sales_ends = new DateTime($data['sales_ends']);
    $sales_status = $data['sales_status'];
    $sales_items = $data['sales_items'];

    // current time
    $curr_time = new DateTime();

    if ($curr_time <= $sales_ends) {
        // get items 
        $qry1 = $conn->query("SELECT * FROM sales_products
                              WHERE sales_id IN ({$sales_items});");
        if ($qry1) {
            // timer vars
            $interval = $curr_time->diff($sales_ends);
            $hrs = $interval->h;
            $mins = $interval->i;
            $sec = $interval->s;
            $days = $interval->d;

            $time = strtotime($data['sales_ends']);
            echo "<script>";
            echo "var saletime = $time";
            echo "</script>";

            if ($hrs < 10) $hrs = '0' . $hrs;
            if ($mins < 10) $mins = '0' . $mins;
            if ($sec < 10) $sec = '0' . $sec;
            if ($days < 10) $days = '0' . $days;


            // sales header
            $sales_timer = "<div class='container-count-down flex flex-v-center gap-2'>
                                <div>
                                    <span>Days</span>
                                    <h1 id='days'>$days</h1>
                                </div>
                                <h3>:</h3>
                                <div>
                                    <span>Hours</span>
                                    <h1 id='hrs'>$hrs</h1>
                                </div>
                                <h3>:</h3>
                                <div>
                                    <span>Minutes</span>
                                    <h1 id='mins'>$mins</h1>
                                </div>
                                <h3>:</h3>
                                <div>
                                    <span>Seconds</span>
                                    <h1 id='secs'>$sec</h1>
                                </div>
                            </div>";


            // get item rows
            if ($qry1->num_rows) {
                while ($items = $qry1->fetch_assoc()) {
                    // items info
                    $item_id = $items['sales_id'];
                    $enc_item_id = base64_encode($items['sales_id']);
                    $item_title = $items['sales_title'];
                    $item_img = explode(',', $items['sales_imgs'])[0];
                    $item_currprice = $items['sales_currprice'];
                    $item_orgprice = $items['sales_orgprice'];


                    // discount
                    $discount = '';
                    if ($item_currprice < $item_orgprice) {
                        $discount = round((($item_orgprice - $item_currprice) / $item_orgprice) * 100);
                    }

                    if (!empty($discount)) {
                        $discount = "<div class='card-discount'><span>{$discount}%</span></div>";
                    }

                    // fav class
                    $fav_class = "";

                    // display sales items
                    $output .= "<div class='container-section-card relative'>
                                    <a class='btn container-section-card-link' href='product/index?p={$enc_item_id}&type=sales'>
                                        <div class='card-img flex'>
                                            <div class='card-img-frame flex'>
                                                <img src='images/pimgs/$item_img' alt='#'>
                                            </div>
                                        </div>
                                        <div class='card-info grid'>
                                            <div class='card-title'>{$item_title}</div>
                                            <div class='card-pricing flex gap-2 flex-v-center'>
                                                <h3 class='card-pricing-current'>$$item_currprice</h3>
                                                <h3><del>$$item_orgprice</del></h3>
                                            </div>
                                            <div class='card-rating flex flex-v-center gap-2'>
                                                <div class='card-rating-stars flex gap-1'>
                                                    <div class='checked'><i class='ri-star-fill'></i></div>
                                                    <div class='checked'><i class='ri-star-fill'></i></div>
                                                    <div class='checked'><i class='ri-star-fill'></i></div>
                                                    <div class='checked'><i class='ri-star-fill'></i></div>
                                                    <div class='checked'><i class='ri-star-fill'></i></div>
                                                </div>
                                                <div class='card-ratings-count'><span>(62)</span></div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class='card-btns grid gap-2'>
                                        <button class='btn btn-card-favorite $fav_class' data-pid='{$enc_item_id}'><i class='ri-heart-line'></i></button>
                                        <button class='btn btn-card-view'><i class='ri-eye-line'></i></button>
                                    </div>
                                    $discount
                                    <button class='btn btn-addto-cart' data-pid='{$enc_item_id}'><span>Add To Cart</span></button>
                                </div>";
                }
            }
        }
    } else {
        echo "<!--";
        goto __add_comment_end__;
    }
} else {
    echo "<!--";
    goto __add_comment_end__;
}
?>

<div class="container-section">
    <div class="container-header flex flex-bottom">
        <div class="contaier-heading">
            <div class="container-title flex flex-v-center gap-2">
                <div></div>
                <span>Todays</span>
            </div>

            <h3>Flash Sales</h3>
        </div>

        <?php echo $sales_timer; ?>

        <div class="container-header-btns flex gap-2">
            <button class="btn btn-move-left"><i class="ri-arrow-left-line"></i></button>
            <button class="btn btn-move-right"><i class="ri-arrow-right-line"></i></button>
        </div>
    </div>

    <!-- ++++++++++++++++++++
                
            FLASH SALES TODAYS CONAINER 
        
            ++++++++++++++++++++ -->

    <div class="container-section container-section-1">
        <div class="container-section-list flex">
            <?php echo $output; ?>
        </div>
    </div>

    <button class="btn btn-v-viewall"><span>view all products</span></button>
    <div class="container-section-line"></div>
</div>

<?php
__add_comment_end__:
echo "-->";
?>