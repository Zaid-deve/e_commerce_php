<?php

// get best selling products from db
$bestselling_qry = $conn->query("SELECT
                                 SUM(o.order_pid) AS units_saled, p.pid,
                                 p.ptitle,p.pimgs,p.pcurr_price,p.pold_price,p.pstatus,f.fid
                                 FROM products p
                                 JOIN orders o
                                 ON o.order_pid = p.pid
                                 LEFT JOIN favorites f ON f.fpid = p.pid
                                 GROUP BY o.order_pid
                                 ORDER BY units_saled DESC
                                 LIMIT 4");

if ($bestselling_qry and $bestselling_qry->num_rows > 0) {

    // best selling products list
    $bestselling_id = [];

    // prepare html best selling block
    $output = "<div class='container-header flex flex-bottom'>
                    <div class='contaier-heading'>
                        <div class='container-title flex flex-v-center gap-2'>
                            <div></div>
                            <span>This Month</span>
                        </div>
                        <h3>Best Selling Products</h3>
                    </div>
                    <a href='#' class='btn btn-view-all'><span>view all</span></a>
                </div>";

    // starting of beset selling container 
    $output .= "<div class='container-section container-section-3'>
                    <div class='container-section container-section-3'>
                        <div class='container-section-list flex'>";

    // get all best selling products from db
    while ($bestselling_item = $bestselling_qry->fetch_assoc()) {
        // get item info
        $pid = ($bestselling_item['pid']);
        $enc_pid = base64_encode($bestselling_item['pid']);
        $ptitle = $bestselling_item['ptitle'];
        $pimg = explode(',', $bestselling_item['pimgs'])[0];
        $pold_price = $bestselling_item['pold_price'];
        $pcurr_price = "";
        if ($bestselling_item['pcurr_price'] == 0) {
            $pcurr_price = "$" . $pold_price;
            $pold_price = "";
        } else {
            $pcurr_price = "$" . $bestselling_item['pcurr_price'];
            $pold_price = "$" . $pold_price;
        }
        // $ptitle = $bestselling_item['pstatus'];
        $bestselling_id[] = $pid;

        // active classes
        $fav_class = "";
        if (!empty($bestselling_item['fid'])) {
            $fav_class = 'active';
        }

        // display following items
        $output .=
            "<div class='container-section-card relative'>
                <a class='btn container-section-card-link' href='product/index?p={$enc_pid}'>
                    <div class='card-img flex'>
                        <div class='card-img-frame flex'>
                            <img src='$pimg' alt='#'>
                        </div>
                    </div>
                    <div class='card-info grid'>
                        <div class='card-title'>{$ptitle}</div>
                        <div class='card-pricing flex gap-2 flex-v-center'>
                            <h3 class='card-pricing-current'>{$pcurr_price}</h3>
                            <h3><del>{$pold_price}</del></h3>
                        </div>
                        <div class='card-rating flex flex-v-center gap-2'>
                            <div class='card-rating-stars flex gap-1'>
                                <div class='checked'><i class='ri-star-fill'></i></div>
                                <div class='checked'><i class='ri-star-fill'></i></div>
                                <div class='checked'><i class='ri-star-fill'></i></div>
                                <div class='checked'><i class='ri-star-fill'></i></div>
                                <div class='checked'><i class='ri-star-fill'></i></div>
                            </div>
                            <div class='card-ratings-count'><span>(65)</span></div>
                        </div>
                    </div>
                </a>
                <div class='card-btns grid gap-2'>
                    <button class='btn btn-card-favorite $fav_class' data-pid='{$enc_pid}'><i class='ri-heart-line'></i></button>
                    <button class='btn btn-card-view'><i class='ri-eye-line'></i></button>
                </div>
                <!-- <div class='card-discount'><span>35%</span></div> -->
                <button class='btn btn-addto-cart' data-pid='{$enc_pid}'><span>Add To Cart</span></button>
            </div>";
    }
    $bestselling_id = implode(',',$bestselling_id);

    // end bestselling section
    $output .= "                
                            </div>
                        <div class='container-section-line'></div>
                    </div>
                </div>
               ";
}

echo $output;
