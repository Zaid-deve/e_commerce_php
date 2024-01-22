<?php

session_start();
if (!empty($_SESSION['user_id'])) $uid = $_SESSION['user_id'];
else die('LOGIN_REQUIRED');

// defaults 
$output = 'something went wrong !';
if (!isset($_POST)) die($output);

// db connection
require "../db/db_config.php";
require "../db/db_conn.php";

// get vars
$fname = $conn->real_escape_string($_POST['fname']);
$company = $conn->real_escape_string($_POST['company']);
$street_address = $conn->real_escape_string($_POST['street_address']);
$apartment = $conn->real_escape_string($_POST['apartment']);
$town_city = $conn->real_escape_string($_POST['town_city']);
$phone = $conn->real_escape_string($_POST['phone']);
$email = $conn->real_escape_string($_POST['email']);
$save_info = $conn->real_escape_string($_POST['save_info']);
$pid = $conn->real_escape_string($_POST['pid']);
$quantity = $conn->real_escape_string($_POST['quantity']) ?: 1;

// validate product id
if (empty($pid)) die($output);
else {
    $dec_pid = ($pid);
}

// validate data
$req_fields = [
    [
        $fname,
        'please enter your name'
    ],
    [
        $street_address,
        'please enter your street address'
    ],
    [
        $town_city,
        'please enter your town or city address'
    ],
    [
        $phone,
        'please enter your contact phone number'
    ],
    [
        $email,
        'please enter your contact eamil number'
    ],
];

for ($row = 0; $row < count($req_fields); $row++) {
    if (empty($req_fields[$row][0])) {
        die($req_fields[$row][1]);
        break;
    }
}

// validate user info
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $output = "please enter a valid email address";
} else if (!filter_var($phone, FILTER_VALIDATE_INT)) {
    $output = "please enter a valid contact number";
} else {
    // select product from db
    $qry = $conn->query("SELECT pcurr_price curr,pold_price org FROM products WHERE pid = '{$dec_pid}'");
    if (!$qry or !$qry->num_rows > 0) die('product deleted or not found');
    $p = $qry->fetch_assoc();
    $curr_price = $p['curr'];
    $org_price = $p['org'];

    $price = $org_price;
    $price = $price * $quantity;

    // add billing info to db
    $billing_columns = '`order_billing_fname`, `order_billing_company`, `order_billing_street`, `order_billing_apartment`, `order_billing_town`, `order_billing_phone`, `order_billing_email`';
    $qry1 = $conn->query("INSERT INTO order_billing ($billing_columns)
                          VALUES ('{$fname}','{$company}','{$street_address}','{$apartment}','{$town_city}', '{$phone}', '{$email}')");


    if (!$qry1) die($output);
    $billing_id = $conn->insert_id;


    // add order info to db
    $qry2 = $conn->query("INSERT INTO `orders` (`order_uid`, `order_pid`,`order_price`, `order_billing`,`order_quantity`)
                          VALUES ('{$uid}', '{$dec_pid}','{$price}','{$billing_id}','{$quantity}')");


    // save info if checked
    if ($qry2) $output = 'success';
}

// display output
echo $output;
