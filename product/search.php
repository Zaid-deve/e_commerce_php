<?php


// start session
session_start();

// db connection
require "../db/db_config.php";
require "../db/db_conn.php";

$sq = "";
$results_count = 0;
$output = "";

if (!empty($_GET['qry'])) {
    $sq = htmlentities($_GET['qry']);
} else {
    header("Location: ../") or die();
}

$qry = $conn->query("SELECT ptitle,pimgs,pcurr_price FROM products WHERE ptitle LIKE '%{$sq}%'");
if (!$qry) die("something went wrong !");

if ($qry->num_rows > 0) {
    $output = "<div class='search-results-grid'>";
    while ($result = $qry->fetch_assoc()) {
        // pinfo
        $pname = $result['ptitle'];
        $pimg = explode(',', $result['pimgs'])[0];
        $pcurr = $result['pcurr_price'];

        $output .= "<div class='search-results-item'>
                         <div class='search-result-img'>
                             <img src='http://localhost/e_commerce_design/$pimg' alt='#'>
                         </div>
                     
                         <div class='search-result-body'>
                             <h3 class='product_title'>$pname</h3>
                             <p class='product_curr_price'>$ $pcurr</p>
                         </div>
                    </div>";
    }
    $output .= "</div>";
} else {
    $output =
        "<div class='empty-results'>
            <h1>No Results Found !</h1>
    
            <p>try searching with product catagories, with specified product name,or try searching with specifig work from an product title</p>
        </div>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $sq ?></title>

    <!-- local stylesheets -->
    <link rel="stylesheet" href="./config.css">

    <!-- font family poppins / inter -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- remixicons and fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- include stylsheets -->
    <link rel="stylesheet" href="../config.css">
    <link rel="stylesheet" href="../css/layout/header.css">
    <link rel="stylesheet" href="../css/layout/footer.css">
    <link rel="stylesheet" href="../css/product/search.css">
</head>

<body>

    <!-- START OF BODY -->

    <!-- start of header -->
    <?php include "../includes/layout/header.php"; ?>
    <!-- end of header -->

    <!-- search results -->

    <div class="results-con">
        <div class="container">
            <div class="search-qry">
                <h3>Results For: <?php echo $sq ?></h3>
                <p><?php echo $results_count ?> results found</p>
            </div>

            <div class="search-results">
                <?php echo $output; ?>
            </div>
        </div>
    </div>

    <!-- WEBPAGE FOOTER -->
    <?php include "../includes/layout/footer.php"; ?>
    <?php $conn->close(); ?>

    <!-- END OF BODY -->

    <!-- SCRIPTS -->

    <script src="../js/header.js"></script>
    <script src="../js/search.js"></script>
    <script src="../js/product/add_to_fav.js"></script>
    <script src="../js/product/add_to_cart.js"></script>


</body>

</html>