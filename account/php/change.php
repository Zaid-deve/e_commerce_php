<?php 

if(isset($_POST)) {
    session_start();

    // db connection
    require "../../db/db_config.php";
    require "../../db/db_conn.php";

    // defaults
    $output = "Something Went Wrong !";

    // get vars
    $fields = [];
    foreach($_POST as $field => $fieldvalue){
        $key = $field;
        if($key == 'email') $key = 'user_email';
        else if($key == 'address') $key = 'user_address';

        $fields[] = $key . "='" . base64_encode($fieldvalue) . "'";
    }

    // qry 
    $data = implode(',', $fields);
    $uid = $_SESSION['user_id'];
    $qry = "UPDATE users SET {$data} WHERE user_id = {$uid}";
    $result = $conn->query($qry);
    if($result){
        $output = 'success';
    } else if($conn->errno == 1064) $output = 'Email address already exists';


    // diaplay result
    echo $output;
}

?>