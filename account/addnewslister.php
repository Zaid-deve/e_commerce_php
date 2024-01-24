<?php 

if(!empty($_POST)){
    // db conn
    include "../db/db_config.php";
    include "../db/db_conn.php";


    $email = $conn->real_escape_string($_POST['email']);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $output = 'please enter a valid email address !';
    }else{
        // prepare data
        $enc_email = base64_encode($email);


        $qry =$conn->query("INSERT INTO nlisters (nemail) VALUES ('{$enc_email}')");
        if($qry)$output='success';
        else{
            if($conn->errno==1064) $output = "$email already exists !";
            else $output = 'something went wrong '.$conn->errno;
        }
    }

    echo $output;
}

?>