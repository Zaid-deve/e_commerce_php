<?php

// get explore products from db

$output = "";
$qry = "SELECT p.ptitle,p.pimgs,p.pcurr_price,p.pold_price,p.pid
        FROM products p ";
if(!empty($bestselling_id)){
    $qry .= "WHERE p.pid NOT IN ($bestselling_id)";
}
$res = $conn->query($qry);

// check if items found
if ($res and $res->num_rows > 0) {
    // starting explore items block
    $output = "<div class='container-section container-section-5'>";

    // explore section heading
    $output .= "<div class='container-header flex flex-bottom'>
                    <div class='contaier-heading'>
                        <div class='container-title flex flex-v-center gap-2'>
                            <div></div>
                            <span>Our Products</span>
                        </div>
                        <h3>Explore Our Products</h3>
                    </div>
                </div>";

    // explore section list grid
    $output .= "<div class='section-5-list container-section-list grid'>";

    while ($explore_items = $res->fetch_assoc()) {
        // get products info
        $exp_pid = base64_encode($explore_items['pid']);
        $exp_ptitle = $explore_items['ptitle'];
        $exp_pimg = explode(',', $explore_items['pimgs'])[0];
        $exp_currprice = $explore_items['pcurr_price'];
        $exp_oldprice = $explore_items['pold_price'];
        $discount = "";
        $fav_class = "";

        // calc discount
        if ($exp_currprice > 0) {
            $discount = round((($exp_oldprice - $exp_currprice) / $exp_oldprice) * 100);
            $discount = "<div class='card-discount section-5-discount'><span>{$discount}%</span></div>";
            $exp_currprice = '$' . $exp_currprice;
            $exp_oldprice = '$' . $exp_oldprice;
        } else {
            $exp_currprice = '$' . $exp_oldprice;
            $exp_oldprice = "";
        }

        // explore item
        $output .= "<div class='container-section-card relative'>
                        <a class='btn container-section-card-link' href='product/index?p={$exp_pid}'>
                            <div class='card-img flex'>
                                <div class='card-img-frame flex'>
                                    <img src='{$exp_pimg}' alt='#'>
                                </div>
                            </div>
                            <div class='card-info grid'>
                                <div class='card-title'>{$exp_ptitle}</div>
                                <div class='card-pricing flex gap-2 flex-v-center'>
                                    <h3 class='card-pricing-current'>{$exp_currprice}</h3>
                                    <h3><del>{$exp_oldprice}</del></h3>
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
                            <button class='btn btn-card-favorite $fav_class' data-pid='{$exp_pid}'><i class='ri-heart-line'></i></button>
                            <button class='btn btn-card-view'><i class='ri-eye-line'></i></button>
                        </div>
                        $discount
                        <button class='btn btn-addto-cart' data-pid='{$exp_pid}'><span>Add To Cart</span></button>
                    </div>";
    }

    // closing of explore items section
    $output .= "        </div>
                    <button class='btn btn-v-viewall'><span>View All Products</span></button>
                </div>";
}

echo $output;
