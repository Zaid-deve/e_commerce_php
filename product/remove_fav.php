<?php

session_start();
$output = 'something went wrong !';

if (empty($_SESSION['user_id'])) die('LOGIN_REQUIRED');
$uid = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // db connection
    require "../db/db_config.php";
    require "../db/db_conn.php";

    // pid
    $fpid = base64_decode($_POST['pid'], true) or die($output);

    // query
    $qry = $conn->query("DELETE FROM favorites WHERE fuid = '{$uid}' AND fpid = '{$fpid}'");
    if($qry){
        if($conn->affected_rows > 0) $output = "success";
    }
}

// display output
echo $output;

?>