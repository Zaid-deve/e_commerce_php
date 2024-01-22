<?php

// validate signup

if (isset($_POST)) {

    // get contents
    require "../../db/db_config.php";
    require "../../db/db_conn.php";

    // defaults 
    $output = 'something went wrong !';

    // get fields
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $conn->real_escape_string($_POST['pass']);

    if (empty($email)) $output = 'please enter a valid email address';
    else if (empty($pass)) $output = 'please enter your account password !';
    else {
        // encode data
        $enc_email = base64_encode($email);
        $enc_pass = base64_encode($pass);

        // select user data from db
        $qry = $conn->query("SELECT user_id,user_password FROM users WHERE user_email = '{$enc_email}'");

        if ($qry) {
            if ($qry->num_rows > 0) {
                $user = $qry->fetch_assoc();
                // validate password
                if($user['user_password'] == $enc_pass){
                    session_start();
                    $uid = $user['user_id'];
                    $_SESSION['user_id'] = $uid;
                    $output = 'success';
                }
                else $output = 'please enter valid account details !';
            }
            else $output = 'no user found !';
        } 
    }
}

echo $output;

?>