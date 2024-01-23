<?php

session_start();
// user id
if (isset($_SESSION['user_id']) and !empty($_SESSION['user_id'])) {
    header("Location: ../account/index");
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login &bullet; Exclusive</title>

    <!-- local stylesheets -->
    <link rel="stylesheet" href="../config.css">

    <!-- font family poppins / inter -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- remixicons and fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <link rel="stylesheet" href="../css/layout/header.css">
    <link rel="stylesheet" href="../css/layout/footer.css">
    <link rel="stylesheet" href="../css/auth/auth.css">
</head>

<body>

    <?php include '../includes/layout/header.php' ?>
    <div class="container form-con">
        <div class="form-container flex flex-v-center">
            <div class="form-img">
                <img src="../images/dl.beatsnoop 1.png" alt="#">
            </div>
            <div class="form-data">
                <div class="form-header grid">
                    <h1>Log in to Exclusive</h1>
                    <h5>Enter your details below</h5>
                </div>
                <div class="form-err">
                   <p class="err-txt"></p>
                </div>
                <div class="form-fields grid">
                    <div class="form-field">
                        <input type="text" class="inp" id="email" placeholder="Email Or Phone Number">
                        <div class="err"></div>
                    </div>
                    <div class="form-field">
                        <input type="password" class="inp" id="pass" placeholder="Password">
                        <div class="err"></div>
                    </div>
                </div>
                <div class="form-btns flex flex-v-center">
                    <button class="btn btn-submit btn-login">Login</button>
                    <a href="#" class="btn btn-forgotten-password">Forgotten Password ?</a>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/layout/footer.php' ?>


    <!-- SCRIPTS -->
    <script src="../js/header.js"></script>
    <script src="../js/form-func.js"></script>
    <script src="../js/auth/login.js"></script>

</body>

</html>