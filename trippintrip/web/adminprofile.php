<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: adminlogin.php');
    exit;
}

include_once("dbconnect.php");

$email = $_SESSION['email'];

$sql = "SELECT admin_id, admin_name, admin_phone, admin_email, tbl_states.state_name 
        FROM tbl_admin 
        INNER JOIN tbl_states ON tbl_admin.state_id = tbl_states.state_id 
        WHERE admin_email = '$email'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$admin_id = $result['admin_id'];
$admin_name = $result['admin_name'];
$admin_phone = $result['admin_phone'];
$admin_email = $result['admin_email'];
$admin_state = $result['state_name'];

?>

<!DOCTYPE html>
<html>

<head>
    <title>TrippinTrip Portal</title>
    <link rel="shortcut icon" href="your-favicon-file.ico">
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

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        img {
            display: block;
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
    </style>
    </style>
</head>

<body>

    <!-- Navbar (sit on top) -->
    <div class="w3-top">
        <div class="w3-bar w3-white w3-card" id="myNavbar">
            <a href="mainpage.php" class="w3-bar-item w3-button w3-wide">TRIPPINTRIP</a>
            <!-- Float links to the right. Hide them on small screens -->
            <div class="w3-right">
                <a href="attraction.php" class="w3-bar-item w3-button">Attractions</a>
                <a href="personas.php" class="w3-bar-item w3-button">Personas</a>
                <a href="users.php" class="w3-bar-item w3-button">Users</a>
                <a href="admin.php" class="w3-bar-item w3-button">Admins</a>
                <a href="insights.php" class="w3-bar-item w3-button">Insights</a>
                <a href="adminprofile.php" class="w3-bar-item w3-button">Profile</a>
                <a href="adminlogout.php" class="w3-bar-item w3-button">Logout</a>
            </div>
        </div>
    </div>

    <!-- Header with full-height image -->
    <header class="w3-display-container w3-content w3-wide" style="max-width:1500px;" id="home">
        <img class="w3-image w3-center"
            src="https://images.unsplash.com/photo-1511367461989-f85a21fda167?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1031&q=80"
            alt="Homepage" style="width:1800px; height:300px; object-fit: cover; filter: brightness(50%);">
        <div class="w3-display-middle w3-margin-top w3-center">
            <h1>
                <span class="w3-hide-small w3-text-light-grey"><b>Profile</b></span>
            </h1>
        </div>
    </header>

    <div class="container" style="text-align:center;">
        <img src="../assets/admin/<?php echo $admin_id; ?>.png" alt="Profile picture" width="300" height="300"
            style="display:block; margin:auto;">
        <h3>
            <?php echo $admin_name; ?>
        </h3>
        <p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-dark-gray"></i>
            <?php echo $admin_phone; ?>
        </p>
        <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-dark-gray"></i>
            <?php echo $admin_email; ?>
        </p>
        <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-dark-gray"></i>
            <?php echo $admin_state; ?>
        </p>
        <input class="w3-button w3-round w3-border w3-light-blue" type="submit" value="Edit Profile"
            onclick="location.href='admineditprofile.php'">
        </p>
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