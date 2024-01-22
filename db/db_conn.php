<?php 

// db connection
$conn = new mysqli(host, username,password,db_name);

if($conn->connect_errno > 0){
    die("failed to connect to server [" . $conn->connect_errno . "]");
}

?>