<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>

    <!-- local stylesheets -->
    <link rel="stylesheet" href="http://localhost/e_commerce_design/config.css">

    <!-- font family poppins / inter -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- remixicons and fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <link rel="stylesheet" href="http://localhost/e_commerce_design/css/layout/header.css">
    <link rel="stylesheet" href="http://localhost/e_commerce_design/css/layout/footer.css">
    <link rel="stylesheet" href="http://localhost/e_commerce_design/css/error404.css">
    <link rel="stylesheet" href="http://localhost/e_commerce_design/css/pageHistory.css">

</head>

<body>

    <?php include 'includes/layout/header.php' ?>
    <div class="container error404-con">
        <div class="page-history flex gap-1">
            <p>
                <a href="http://localhost/e_commerce_design">home</a>
                <span>/</span>
                <a href="#" class='active'>error404</a>
            </p>
        </div>
        <div class="error404-text">
            <h1>404 Not Found</h1>
            <p>Your visited page not found. You may go home page.</p>
            <a class="btn btn-back" href="http://localhost/e_commerce_design">Back to home page</a>
        </div>
    </div>
    <?php include 'includes/layout/footer.php' ?>

    <!-- scripts -->
    <script src="js/header.js"></script>
</body>

</html>