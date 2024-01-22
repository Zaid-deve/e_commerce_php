<?php

// defaults
$output = "no results found";

if(isset($_POST['search'])){

    // db connection
    require "../../db/db_config.php";
    require "../../db/db_conn.php";

    $search = $conn->real_escape_string($_POST['search']);
    if(!empty($search)){
        $qry=$conn->query("SELECT pid,ptitle FROM products WHERE ptitle LIKE '%$search%'");
        if($qry){
            if($qry->num_rows > 0){
                $output = '';

                while ($res = $qry->fetch_assoc()){
                    $ptitle = substr($res['ptitle'],0, 20) . '...';
                    $pid = base64_encode($res['pid']);
                    $output .= "<a class='header-search-item btn' href='product/index?p={$pid}'>
                                    <i class='ri-search-line'></i>
                                    <span class='header-search-text' style='color:var(--color-secondary3)'>{$ptitle}</span>
                                    <button class='btn btn-addtext-to-search'><i class='ri-arrow-right-up-line'></i></button>
                                </a>";
                }
            }
        }
    }
}

echo $output;

?>