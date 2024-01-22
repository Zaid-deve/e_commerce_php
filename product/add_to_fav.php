<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // db connection
    require "../db/db_config.php";
    require "../db/db_conn.php";

    // defaults
    $output = 'something went wrong !';

    $pid = $conn->real_escape_string($_POST['pid']);

    // if pid is empty or not encoded
    if (empty($pid) or !base64_decode($pid, true)) die($output);

    // check if user is loged in
    session_start();
    if (!empty($_SESSION)) $uid = $_SESSION['user_id'];
    else die('LOGIN_REQUIRED');

    // select product from db
    $dec_pid = base64_decode($pid);
    $qry = $conn->query("SELECT f.fid FROM products p
                        LEFT JOIN favorites f
                        ON f.fpid = p.pid AND f.fuid = '{$uid}'
                        WHERE p.pid = '{$dec_pid}';");
    if ($qry and $qry->num_rows > 0) {
        // check if product exists in user favorites
        $data = $qry->fetch_assoc();
        if (!empty($data['fid'])) {
            $qry1 = $conn->query("DELETE FROM favorites WHERE fpid = '{$dec_pid}' AND fuid = '{$uid}'");
            if ($qry1) $output = "FAV_REMOVED";
        } else {
            $qry2 = $conn->query("INSERT INTO favorites (fpid,fuid)
                                  VALUES ('{$dec_pid}', '{$uid}')");
            if($qry2) $output = "FAV_ADDED";
        }
    }
}


echo $output;

?>