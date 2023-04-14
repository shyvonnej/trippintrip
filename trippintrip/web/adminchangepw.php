<?php
session_start();
include_once("dbconnect.php");
$admin_id = $_SESSION['admin_id'];

if (isset($_POST['submit'])) {
    $admin_email = $_POST['email'];
    $new_password = sha1($_POST['newpassword']);
    $confirm_password = sha1($_POST['confirmnewpassword']);

    if ($new_password == $confirm_password) {
        $sql = "UPDATE tbl_admin SET admin_password = '$new_password' WHERE admin_email = '$admin_email'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('$admin_email, $new_password Password changed successfully!');</script>";
            echo "<script> window.location.replace('adminlogin.php')</script>";
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "<script>alert('New password and confirm password do not match!');</script>";
        echo "<script> window.location.replace('adminchangepw.php')</script>";
        exit();
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>TrippinTrip Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Raleway", sans-serif
        }

        body,
        html {
            height: 100%;
            line-height: 1.8;
        }

        /* Full height image header */
        .bgimg-1 {
            background-position: center;
            background-size: cover;
            background-image: url("/w3images/mac.jpg");
            min-height: 100%;
        }

        .w3-bar .w3-button {
            padding: 16px;
        }
    </style>
</head>

<body>

    <!-- Navbar (sit on top) -->
    <div class="w3-top">
        <div class="w3-bar w3-white w3-card" id="myNavbar">
            <a href="#home" class="w3-bar-item w3-button w3-wide">TRIPPINTRIP</a>
            <!-- Float links to the right. Hide them on small screens -->
            <div class="w3-right">
                <a href="adminlogin.php" class="w3-bar-item w3-button">Log In</a>
                <a href="adminregister.php" class="w3-bar-item w3-button">Sign Up</a>
            </div>
        </div>
    </div>

    <!-- Header with full-height image -->
    <header class="w3-display-container w3-content w3-wide" style="max-width:1500px;" id="home">
        <img class="w3-image w3-center"
            src="https://images.unsplash.com/photo-1499591934245-40b55745b905?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=872&q=80"
            alt="Homepage" style="width:1800px; height:400px; object-fit: cover; filter: brightness(90%);">
        <div class="w3-display-middle w3-margin-top w3-center">
            <h1 class="w3-xxlarge w3-text-white"><span
                    class="w3-padding w3-black w3-opacity-min"><b>TrippinTrip</b></span>
                <span class="w3-hide-small w3-text-light-grey"> Admin</span>
            </h1>
        </div>
    </header>

    <div style="display:flex; justify-content: center">
        <div class="w3-container w3-card w3-padding w3-margin"
            style="max-width:600px; width:100%; margin:auto; text-align:left;">
            <form name="changepwForm" action="adminchangepw.php" method="post">
                <p>
                    <label><b>Email</b></label>
                    <input class="w3-input w3-round w3-border" type="email" name="email" id="idemail"
                        placeholder="Your email" required>
                </p>
                <p>
                    <label><b>New Password</b></label>
                    <input class="w3-input w3-round w3-border" type="password" name="newpassword" id="idpass"
                        placeholder="Your new password" required>
                </p>
                <p>
                    <label><b>Confirm Password</b></label>
                    <input class="w3-input w3-round w3-border" type="password" name="confirmnewpassword" id="idpass"
                        placeholder="Comfirm your new password" required>
                </p>
                <div style="display:flex; justify-content: center">
                    <p style="text-align:center;">
                        <input class="w3-button w3-round w3-border w3-light-blue" type="submit" name="submit"
                            id="submit" value="Change Password" style="margin:0 auto;">
                    </p>
                </div>
            </form>
        </div>
    </div>
    </div>

    <!-- Footer -->
    <footer class="w3-center w3-white w3-padding-64">
        <div class="w3-xlarge w3-section">
            <a href="https://web.facebook.com/shyvonnejinshii/"><i
                    class="fa fa-facebook-official w3-hover-opacity"></i></a>
            <a href="https://www.instagram.com/shylx__/?hl=en"><i class="fa fa-instagram w3-hover-opacity"></i></a>
            <a href="https://www.linkedin.com/in/shyvonne-jinshi-016090189/"><i
                    class="fa fa-linkedin w3-hover-opacity"></i></a>
            <a href="https://pin.it/7v3QqJ6"><i class="fa fa-pinterest-p w3-hover-opacity"></i></a>
            <a href="https://twitter.com/ShyvonneH"><i class="fa fa-twitter w3-hover-opacity"></i></a>
            <a href="https://www.youtube.com/channel/UC7hYxt1VSU6ptQ94-wH-y_g/about"><i
                    class="fa fa-youtube w3-hover-opacity"></i></a>
        </div>
        <p>Powered by Shyvonne Ho Yue Lynn (279733) Final Year Project 2023</p>
    </footer>
</body>

</html>