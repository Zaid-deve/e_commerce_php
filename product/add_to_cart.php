<?php

if (isset($_POST)) {
    session_start();

    // defaults 
    $output = 'Something Went Wrong !';

    // check if user is loged in
    if (isset($_SESSION['user_id']) or empty($_SESSION['user_id'])) {
        // get user id 
        $uid = ($_SESSION['user_id']);

        // db connection
        require "../db/db_config.php";
        require "../db/db_conn.php";

        // get data
        $pid = base64_decode($conn->real_escape_string($_POST['pid']));

        // check if data is not empty
        if (!empty($pid)) {
            // check if product exists in db
            $qry1 = $conn->query("SELECT pid FROM products WHERE pid={$pid}");
            if (!$qry1 or !$qry1->num_rows > 0) $output = "product deleted or not found !";
            else {
                // check if product already exists in favorited
                $qry2 = $conn->query("SELECT * FROM cart WHERE cuid = '{$uid}' AND cpid = '{$pid}'");
                if ($qry2) {
                    if ($qry2->num_rows > 0) {
                        // remove product from favprites
                        $qry3 = $conn->query("DELETE FROM cart WHERE cuid = '{$uid}' AND cpid = '{$pid}'");
                        if ($qry3) $output = 'CART_REMOVED';
                    } else {
                        // add product to favprites
                        $qry4 = $conn->query("INSERT INTO cart (cuid,cpid) VALUES ('{$uid}','{$pid}')");
                        if ($qry4) $output = 'CART_ADDED';
                    }
                }
            }
        }
    } else $output = 'LOGIN_REQUIRED';

    // display result
    echo $output;
}
