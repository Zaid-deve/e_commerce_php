<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // defaults 
    $output = "something went wrong !";

    session_start();
    if (empty($_SESSION['user_id'])) die('LOGIN_REQUIRED');

    $uid = $_SESSION['user_id'];

    // db connection
    require "../../db/db_config.php";
    require "../../db/db_conn.php";

    // check if oid is set
    if (!empty($_POST['order_id']) OR !base64_decode($_POST['order_id'], true)) {
        $oid = $conn->real_escape_string(base64_decode($_POST['order_id']));
        // query
        $qry = $conn->query("SELECT order_id FROM orders WHERE order_id = '{$oid}'");
        if (!$qry or !$qry->num_rows > 0) die($output);

        // delete if found
        $qry1 = $conn->query("DELETE FROM orders WHERE order_id = '{$oid}'");
        if ($qry1) $output = 'success';
    }
}

// display result
echo $output;

?>