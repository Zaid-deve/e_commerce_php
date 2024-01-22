<?php

$output = 'something went wrong!';
session_start();
if (!isset($_SESSION['user_id'])) {
    die($output);
} else $uid = $_SESSION['user_id'];



if (isset($_POST)) {
    // db connection
    require "db/db_config.php";
    require "db/db_conn.php";

    // get vars
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $messege = $conn->real_escape_string($_POST['des']);

    // validate vars
    if(empty($name)) $output = 'Please enter name !';
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $output = 'Please enter a valid email address';
    if(empty($name) OR !filter_var($phone, FILTER_VALIDATE_INT)) $output = 'Please enter valid contact number !';
    else {
        $qry = $conn->query("INSERT INTO `contact` (`contact_uid`, `contact_name`, `contact_email`, `contact_phone`, `contact_messege`)
                             VALUES ('{$uid}', '{$name}', '{$email}', '{$phone}', '{$messege}')");
        if($qry) $output = 'success';
    }

    // close connection
    $conn->close();

    // display output
    echo $output;
}
