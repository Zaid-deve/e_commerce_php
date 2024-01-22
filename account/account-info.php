<?php

if (isset($uid)) {
    $qry = $conn->query("SELECT fname,lname,user_address,user_email,user_password FROM users WHERE user_id = '{$uid}'");

    // un-expected error
    if (!$qry || !$qry->num_rows > 0) die("Something Went Wrong !");
    else {
        $data = $qry->fetch_assoc();

        // name and address
        $fname = base64_decode($data['fname']);
        $lname = base64_decode($data['lname']);
        $address = base64_decode($data['user_address']);

        // email phone and password
        $uemail = base64_decode($data['user_email']);
        $upass = base64_decode($data['user_password']);
    }
}
