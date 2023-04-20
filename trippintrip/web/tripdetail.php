<?php
session_start();
include_once("dbconnect.php");

if (!isset($_SESSION['sessionid'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('adminlogin.php')</script>";
} else {
    $email = $_SESSION['email'];
}

if (isset($_GET['id'])) {
    $tripid = $_GET['id'];

    $sql = "SELECT tt.*, a.*, ta.*
    FROM tbl_trips tt
    INNER JOIN trip_attraction ta ON tt.trip_id = ta.trip_id
    INNER JOIN tbl_attraction a ON ta.att_id = a.att_id
    WHERE tt.trip_id = $tripid";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();

    if ($number_of_result > 0) {
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();

        $trip_name = $rows[0]['trip_name'];
    } else {
        echo "<script>alert('Users' Trip Not Found');</script>";
        echo "<script>window.location.replace('users.php');</script>";
    }
} else {
    echo "<script>alert('Page Error');</script>";
    echo "<script>window.location.replace('mainpage.php');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>TrippinTrip Portal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Noto Sans' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

        .note {
            background-color: #F8F8FF;
            border: 1px solid #000080;
            border-radius: 10px;
            box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);
            margin-left: auto;
            margin-right: auto;
            margin-top: 40px;
            margin-bottom: 40px;
            padding-top: 20px;
            padding-bottom: 20px;
            text-align: center;
            width: 80%;
        }

        .note h1 {
            color: #36454F;
            font-size: 40px;
            margin-bottom: 20px;
            font-weight: bold;
            font-family: "Noto Sans";
        }

        .note p {
            color: #646D7E;
            font-size: 16px;
            margin-top: 10px;
        }

        .note .attraction {
            background-color: #FFF;
            border: 1px solid #DDD;
            border-radius: 5px;
            box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
            margin: 10px auto;
            padding: 10px;
            width: 80%;
        }

        .note .attraction .name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
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
            src="https://images.unsplash.com/photo-1504672281656-e4981d70414b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
            alt="Homepage" style="width:1800px; height:300px; object-fit: cover; filter: brightness(50%);">
        <div class="w3-display-middle w3-margin-top w3-center">
            <h1>
                <span class="w3-hide-small w3-text-light-grey"><b>User's Trip Plan</b></span>
            </h1>
        </div>
    </header>

    <div class="note" style="text-align: center;">
        <h1><b>
                <?php echo strtoupper($trip_name) ?>
            </b></h1>
        <?php if ($number_of_result > 0): ?>
            <?php $current_date = ''; ?>
            <?php for ($i = 0; $i < $number_of_result; $i++): ?>
                <?php $row = $rows[$i]; ?>
                <?php if ($current_date != $row['date']): ?>
                    <?php $current_date = $row['date']; ?>
                    <div class="note-section">
                        <h3>
                            <?php echo date('F j, Y', strtotime($row['date'])); ?>
                        </h3>
                    <?php endif; ?>
                    <div class="note-row">
                        <div class="note-col-1">
                            <p>
                                <?php echo $row['att_name']; ?>
                            </p>
                        </div>
                    </div>
                    <?php if ($current_date != $rows[min($i + 1, $number_of_result - 1)]['date']): ?>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        <?php else: ?>
            <p>No attractions have been chosen for this package yet.</p>
        <?php endif; ?>
    </div>
    </div>
</body>

<!-- Footer -->
<footer class="w3-center w3-white w3-padding-64">
    <div class="w3-xlarge w3-section">
        <a href="https://web.facebook.com/shyvonnejinshii/"><i class="fa fa-facebook-official w3-hover-opacity"></i></a>
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
</html>
