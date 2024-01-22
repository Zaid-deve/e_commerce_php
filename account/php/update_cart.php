<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // defaults
    $output = 'something went wrong !';

    // get data
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    if (empty($data)) die($output);

    session_start();
    if (empty($_SESSION['user_id'])) die('LOGIN_REQUIRED');

    $uid = $_SESSION['user_id'];

    // db connection
    require "../../db/db_config.php";
    require "../../db/db_conn.php";

    // get vars
    $to_change = $data['to_change'];
    $to_del = $data['to_delete'];
    $rows_to_delete = [];
    $cart_updated = $cart_deleted = false;


    // delete items
    if (!empty($to_del)) {
        foreach ($to_del as $del_item) {
            $rows_to_delete[] = base64_decode($del_item);
        }
        $rows_to_delete = implode(',', $rows_to_delete);

        $qry = $conn->query("DELETE FROM cart WHERE cid IN ($rows_to_delete)");
        if ($qry) $cart_deleted = true;
    }


    if (!empty($to_change)) {
        // update each rows
        foreach ($to_change as $row) {
            $cart_id = base64_decode($row['cid']);
            $cart_quantity = $row['quantity'];

            // update cart
            $qry1 = $conn->query("UPDATE cart SET cquantity = '{$cart_quantity}' WHERE cid = '{$cart_id}'");
            if ($qry1) $cart_updated++;
        }
    }

    // display result
    echo ($cart_updated > 0 OR $cart_deleted) ? 'success' : 'Something Went Wrong !';

    // close conn
    $conn->close();
}
