<?php

// validate signup
if (isset($_POST)) {

    // get contents
    require "../../db/db_config.php";
    require "../../db/db_conn.php";

    // defaults 
    $output = 'something went wrong !';

    // get fields
    $uname = $conn->real_escape_string($_POST['uname']);
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $conn->real_escape_string($_POST['pass']);

    if (empty($uname)) {
        $output = 'please enter your name';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $output = 'please enter a valid email address';
    } else if (empty($pass)) {
        $output = 'please create your password to continue';
    } else {
        // prepare fname and lname
        $fname = $lname = '';
        $fullname = explode(' ', $uname, 2);
        $fname = $fullname[0];
        if (count($fullname) > 1) $lname = $fullname[1];

        // encode data
        $enc_email = base64_encode($email);
        $enc_pass = base64_encode($pass);
        $enc_fname = base64_encode($fname);
        $enc_lname = base64_encode($lname);


        // add data to db
        $result = $conn->query("INSERT INTO users (fname,lname, user_email,user_password)
                                VALUES ('{$enc_fname}','{$enc_lname}','{$enc_email}', '{$enc_pass}')");

        if ($result) {
            // set new session
            session_start();
            $uid = $conn->insert_id;
            $_SESSION['user_id'] = $uid;
            $output = 'success';
        } else {

            // unique id error
            if ($conn->errno == 1064) $output = 'Email or Phone Already Exists';
            else $output = 'Something went wrong ! [' . $conn->errno . ']';
        }
    }
}

echo $output;
