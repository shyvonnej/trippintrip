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
    $packid = $_GET['id'];

    $sql = "SELECT pp.*, a.*, pa.*
    FROM persona_package pp
    INNER JOIN package_attraction pa ON pp.package_id = pa.package_id
    INNER JOIN tbl_attraction a ON pa.att_id = a.att_id
    WHERE pp.package_id = $packid";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();

    if ($number_of_result > 0) {
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();

        $package_name = $rows[0]['package_name'];
    } else {
        echo "<script>alert('Persona Trip Not Found');</script>";
        echo "<script>window.location.replace('personas.php');</script>";
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

        table,
        td,
        th {
            padding: 10px;
            border: 1px solid black;
        }

        table {
            text-align: center;
            border-collapse: collapse;
            width: 50%;
        }

        .note {
            background-color: #f9f9f9;
            border-left: 6px solid #ccc;
            margin-bottom: 20px;
            padding: 15px;
        }

        .note h3 {
            font-size: 18px;
            margin-top: 0;
        }

        .note ul {
            list-style: none;
            padding-left: 0;
            margin-top: 10px;
        }

        .note li {
            margin-bottom: 5px;
            font-size: 16px;
        }

        .note p {
            margin-top: 10px;
            font-size: 16px;
            font-style: italic;
            color: #777;
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
            src="https://images.unsplash.com/photo-1681238339140-7fa1654fb6ad?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1213&q=80"
            alt="Homepage" style="width:1800px; height:300px; object-fit: cover; filter: brightness(50%);">
        <div class="w3-display-middle w3-margin-top w3-center">
            <h1>
                <span class="w3-hide-small w3-text-light-grey"><b>Personas Trip Package Dashboard</b></span>
            </h1>
        </div>
    </header>

    <div class="note" style="text-align: center;">
        <h2><b>
                <?php echo $package_name ?>
            </b></h2>
        <?php if ($number_of_result > 0): ?>
            <table style="margin: 0 auto;">
                <thead>
                    <tr>
                        <th>Attraction Name</th>
                        <th>Opening Hours</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_price = 0; // initialize total price to 0
                    foreach ($rows as $row):
                        $total_price += $row['att_price']; // add current attraction price to total price
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['att_name']; ?>
                            </td>
                            <td>
                                <?php echo $row['att_opening'] . ' - ' . $row['att_closing']; ?>
                            </td>
                            <td>
                                <?php echo $row['att_price']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td><strong>Total Price:</strong></td>
                        <td></td>
                        <td><strong>
                                <?php echo $total_price; ?>
                            </strong></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p>No attractions have been chosen for this package yet.</p>
        <?php endif; ?>
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

</html>
