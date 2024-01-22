<?php

session_start();
if (!isset($_SESSION['user_id']) and empty($_SESSION['user_id'])) {
    header('Location: ../auth/signup.php') or die("something went wrong !");
}

// db connection and 
$uid = $_SESSION['user_id'];
require "../db/db_config.php";
require "../db/db_conn.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>

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
    <link rel="stylesheet" href="../css/pageHistory.css">
    <link rel="stylesheet" href="../css/account/main.css">
</head>

<body>

    <?php include "../includes/layout/header.php"; ?>

    <!-- MAIN CONTENT -->
    <div class="container account-con">
        <?php require "account-info.php" ?>
        <div class="page-history flex">
            <p>
                <a href="#">Home</a>
                <span>/</span>
                <a href="#" class="active">Account</a>
            </p>
            <div class="acc-name flex flex-v-center gap-1">welcome <p><?php echo $fname . ' ' . $lname; ?></p>
            </div>
        </div>

        <!-- main content -->
        <div class="content">
            <?php require "account-menu.php" ?>

            <!-- profile info -->
            <div class="profile-info grid">
                <h3>Edit Your Profile</h3>

                <!-- editable profile info form -->

                <!-- fields -->
                <div class="profile-info-fields flex">
                    <!-- first name -->
                    <div class="profile-info-field">
                        <label for="fname">First Name</label>
                        <input type="text" class="inp info-field" id="fname" placeholder="Your Starting Name" value="<?php echo $fname; ?>">
                        <div class="err"></div>
                    </div>

                    <!-- last name -->
                    <div class="profile-info-field">
                        <label for="lname">Last Name</label>
                        <input type="text" class="inp info-field" id="lname" placeholder="Your Ending Name" value="<?php echo $lname; ?>">
                        <div class="err"></div>
                    </div>
                </div>

                <div class="profile-info-fields flex">
                    <!-- email address -->
                    <div class="profile-info-field">
                        <label for="email">Email</label>
                        <input type="text" class="inp info-field" id="email" placeholder="Your Email/Gmail" value="<?php echo $uemail; ?>">
                        <div class="err"></div>
                    </div>

                    <!-- last name -->
                    <div class="profile-info-field">
                        <label for="address">Address</label>
                        <input type="text" class="inp info-field" id="address" placeholder="Your Current Living Place" value="<?php echo $address; ?>">
                        <div class="err"></div>
                    </div>
                </div>

                <!-- password field -->
                <div class="profile-info-fields pass-change-fields grid">
                    <label for="#">Password Changes</label>

                    <!-- current password -->
                    <div class="field">
                        <input type="password" class="inp" id="curr_pass" placeholder="Current Password">
                        <div class="err"></div>
                    </div>

                    <!-- new password -->
                    <div class="field">
                        <input type="password" class="inp" id="new_pass" placeholder="New Password">
                        <div class="err"></div>
                    </div>

                    <!-- confirm password -->
                    <div class="field">
                        <input type="text" class="inp" id="confirm_pass" placeholder="Confirm Password">
                        <div class="err"></div>
                    </div>
                </div>

                <!-- profile info btns -->
                <div class="profile-info-btns flex">
                    <button class="btn btn-cancel">Cancel</button>
                    <button class="btn btn-change" disabled title="nothing to change in your account">Save Changes</button>
                </div>

            </div>
        </div>
    </div>

    <?php include "../includes/layout/footer.php"; ?>

    <!-- scripts -->
    <script src="../js/header.js"></script>
    <script src="../js/form-func.js"></script>
    <script src="../js/account/change.js"></script>
    <script src="../js/account/change_pass.js"></script>
</body>

</html>