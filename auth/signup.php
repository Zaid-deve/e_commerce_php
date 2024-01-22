<?php 

session_start();

// db connection
require "../db/db_config.php";
require "../db/db_conn.php";

// user id
if (isset($_SESSION['user_id']) and !empty($_SESSION['user_id'])) {
    $uid = base64_encode($_SESSION['user_id']);
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
                    <h1>Create an account</h1>
                    <h5>Enter your details below</h5>
                </div>
                <div class="form-fields grid">
                    <div class="form-field">
                        <input type="text" class="inp" id="uname" placeholder="Name">
                        <div class="err"></div>
                    </div>
                    <div class="form-field">
                        <input type="text" class="inp" id="email" placeholder="Email Or Phone Number">
                        <div class="err"></div>
                    </div>
                    <div class="form-field">
                        <input type="password" class="inp" id="pass" placeholder="Password">
                        <div class="err"></div>
                    </div>
                </div>
                <button class="btn btn-submit btn-signup">Create Account</button>
                <div class="form-options grid">
                    <a href="#" class="btn btn-google-login flex flex-v-center flex-h-center gap-3"><img src="../images/Icon-Google.png" alt="#"> <span>Sign up with Google</span></a>
                    <p>Already Have An Account ? <a class="btn btn-have-login" href="login.php">Log In</a></p>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/layout/footer.php' ?>


    <!-- SCRIPTS -->
    <script src="../js/header.js"></script>
    <script src="../js/form-func.js"></script>
    <script src="../js/auth/signup.js"></script>
</body>

</html>