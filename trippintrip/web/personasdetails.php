<?php
session_start();
include_once("dbconnect.php");

if (!isset($_SESSION['sessionid'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('adminlogin.php')</script>";
} else {
    $email = $_SESSION['email'];
}

if (isset($_POST['delete'])) {
    $pid = $_GET['id'];

    // Get the image URL from the database
    $sql_image = "SELECT image_url FROM tbl_personas WHERE persona_id = $pid";
    $result = $conn->query($sql_image);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $image_url = $row['image_url'];

    // Delete the persona from the database
    $sql = "DELETE FROM tbl_personas WHERE persona_id = $pid";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Delete the image file from the server
    if (file_exists($image_url)) {
        unlink($image_url);
    }

    echo "<script>alert('Persona has been deleted.');</script>";
    echo "<script>window.location.replace('personas.php');</script>";
    
} elseif (isset($_GET['id'])) {
    $pid = $_GET['id'];
    $sql = "SELECT * FROM tbl_personas
    WHERE persona_id = $pid
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();

    // Get the image URL from the database
    $sql_image = "SELECT image_url FROM tbl_personas WHERE persona_id = $pid";
    $result = $conn->query($sql_image);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $image_url = $row['image_url'];

    if ($number_of_result > 0) {
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();
    } else {
        echo "<script>alert('Attraction Not Found');</script>";
        echo "<script>window.location.replace('attraction.php');</script>";
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
            src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=815&q=80"
            alt="Homepage" style="width:1800px; height:300px; object-fit: cover; filter: brightness(50%);">
        <div class="w3-display-middle w3-margin-top w3-center">
            <h1>
                <span class="w3-hide-small w3-text-light-grey"><b>Personas Details Dashboard</b></span>
            </h1>
        </div>
    </header>

    <div class="w3-container w3-padding-15 w3-center" id="content">
        <div style="overflow-x:auto;">
            <div class="container" style="text-align:center;">
                <img src="<?php echo $image_url; ?>" alt="Personas" width="300" height="400"
                    style="display:block; margin:auto; margin-top: 40px; object-fit: cover;">
                <br>
                <table id="attractions" style="border:1px solid black;margin-left:auto;margin-right:auto;">
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($rows as $result) {
                            $i++;
                            $id = $result['persona_id'];
                            $name = $result['name'];
                            $type = $result['persona_type'];
                            $desc = $result['description'];
                            $activity = $result['prefered_activity'];
                            $image = $result['image_url'];
                            $created = $result['created_at'];
                            $updated = $result['updated_at'];
                        }

                        echo
                            "
                <tr>
                  <th class='w3-indigo'>Name</th>
                  <td style='width:60%'>$name</td>
                </tr>
                <tr>
                  <th class='w3-indigo'>Type</th>
                  <td style='width:60%'>$type</td>
                </tr>
                <tr>
                  <th class='w3-indigo'>Description</th>
                  <td style='width:60%'>$desc</td>
                </tr>
                <tr>
                  <th class='w3-indigo'>Activity</th>
                  <td style='width:60%'>$activity</td>
                </tr>
                <tr>
                  <th class='w3-indigo'>Created At</th>
                  <td style='width:60%'>$created</td>
                </tr>
                <tr>
                  <th class='w3-indigo'>Updated At</th>
                  <td style='width:60%'>$updated</td>
                </tr>
                    </tbody>
                </table>
                <a href='editpersonas.php?id=" . $pid . "' onclick=\"document.getElementById('newsdetails1').style.display='block';return false;\">
                    <input class='w3-button w3-margin-top w3-indigo w3-round w3-center' type='submit' name='submit'
                        value='Edit Persona' />";
                        ?>
                        <div style="display:flex; justify-content: center;">
                            <form method="post">
                                <input class='w3-button w3-margin-top w3-indigo w3-round w3-center' type='submit'
                                    name='delete' value='Delete' />
                            </form>
                        </div>
            </div>
            <br>
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