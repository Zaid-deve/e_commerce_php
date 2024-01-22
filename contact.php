<?php

session_start();
if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
} else header('Location: auth/login');

require "db/db_config.php";
require "db/db_conn.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact us</title>

    <!-- local stylesheets -->
    <link rel="stylesheet" href="config.css">

    <!-- font family poppins / inter -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- remixicons and fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <link rel="stylesheet" href="css/layout/header.css">
    <link rel="stylesheet" href="css/layout/footer.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="css/pageHistory.css">
</head>

<body>

    <?php include 'includes/layout/header.php' ?>
    <div class="container contact-con">
        <div class="page-history">
            <p class="flex gap-1">
                <a href="http://localhost/e_commerce_design" class="btn">Home</a>/
                <a href="#" class="btn">Contact</a>
            </p>
        </div>
        <div class="content flex">
            <div class="contact-info grid">
                <div class="contact-info-1 grid">
                    <div class="flex flex-v-center gap-3 contact-info-header">
                        <img src="images/icons-phone.png" alt="#">
                        <h3>Call To Us</h3>
                    </div>
                    <p>We are available 24/7, 7 days a week.</p>
                    <p>Phone: <a href="#" class="btn">+8801611112222</a></p>
                </div>
                <div class="contact-info-devider"></div>
                <div class="contact-info-2 grid">
                    <div class="flex flex-v-center gap-3 contact-info-header">
                        <img src="images/icons-phone.png" alt="#">
                        <h3>Write To US</h3>
                    </div>
                    <p>Fill out our form and we will contact you within 24 hours.</p>
                    <p>Email: <a href="#" class="btn"> customer@exclusive.com</a></p>
                    <p>Email: <a href="#" class="btn">support@exclusive.com</a></p>
                </div>
            </div>
            <div class="contact-form grid">
                <div class="field-1 flex">
                    <div class="field">
                        <input type="text" class="inp" id="name" placeholder="Your Name *" autofocus>
                        <div class="err"></div>
                    </div>
                    <div class="field">
                        <input type="text" class="inp" id="email" placeholder="Your Email *">
                        <div class="err"></div>
                    </div>
                    <div class="field">
                        <input type="number" class="inp" id="phone" placeholder="Your Phone *">
                        <div class="err"></div>
                    </div>
                </div>
                <div class="field-2">
                    <div class="field">
                        <textarea placeholder="Your Message" id="des" class="inp" rows="3"></textarea>
                        <div class="err"></div>
                    </div>
                </div>
                <button class="btn btn-contact" type="button">Send a Message</button>
            </div>
        </div>
    </div>
    <?php include 'includes/layout/footer.php' ?>

    <!-- scripts -->
    <script src="js/header.js"></script>
    <script src="js/form-func.js"></script>
    <script src="js/contact.js"></script>

</body>

</html>