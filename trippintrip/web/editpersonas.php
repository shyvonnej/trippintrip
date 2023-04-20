<?php
// Check if the user is logged in as an admin
session_start();
include_once("dbconnect.php");

if (!isset($_SESSION['sessionid'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('adminlogin.php')</script>";
} else {
    $email = $_SESSION['email'];
}

if (isset($_GET['id'])) {
    // Retrieve the attraction's information from the database
    $pid = $_GET['id'];
    $query = "SELECT * FROM tbl_personas WHERE persona_id = $pid";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $id = $result['persona_id'];
    $name = $result['name'];
    $type = $result['persona_type'];
    $desc = $result['description'];
    $activity = $result['prefered_activity'];
    $image = $result['image_url'];

    // Check if the form has been submitted for updating the attraction's information
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the new attraction information from the form
        $name = $_POST['name'];
        $type = $_POST['persona_type'];
        $desc = $_POST['description'];
        $activity = $_POST['prefered_activity'];
        $image = $_POST['image_url'];

        // Update the attraction's information in the database
        $query = "UPDATE tbl_personas SET name = :name, persona_type = :persona_type, description = :description, prefered_activity = :prefered_activity, image_url = :image_url, updated_at = NOW() WHERE persona_id = :persona_id";
        $statement = $conn->prepare($query);
        $statement->bindValue(':persona_id', $id);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':persona_type', $type);
        $statement->bindValue(':description', $desc);
        $statement->bindValue(':prefered_activity', $activity);
        $statement->bindValue(':image_url', $image);
        $statement->execute();

        echo "<script>alert('Persona Updated Successfully')</script>";
        echo "<script>window.location.replace('personas.php')</script>";
    }
}

?>

<!DOCTYPE html>
<html>

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
            width: 40%;
        }

        .form-label {
            display: inline-block;
            width: 110px;
            /* adjust as needed */
            text-align: right;
            margin-right: 30px;
            margin-bottom: 5px;
            /* add some spacing between the label and the input field */
        }

        .form-field {
            display: inline-block;
            width: 70%;
            /* adjust as needed */
            vertical-align: top;
            /* align the top of the input field with the label */
            margin-bottom: 5px;
            padding-left: 10px;
            padding-right: 10px;
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
                <span class="w3-hide-small w3-text-light-grey"><b>Attraction Dashboard</b></span>
            </h1>
        </div>
    </header>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main w3-content w3-padding w3-center" style="max-width:1500px;margin-top:20px">
        <div style="display:flex; justify-content: center">
            <div class="w3-container w3-card w3-padding w3-margin" style="width:600px;margin:auto;text-align:left;">
                <h3 class="w3-center">Edit Persona</h3>
                <form action="editpersonas.php?id=<?php echo $pid; ?>" method="POST">
                    <p style="display: flex; align-items: center;">
                        <label for="name" class="form-label" style="margin-top: 30px">Name:</label>
                        <input type="text" name="name" value="<?php echo $name; ?>" class="form-field"
                            style="margin-top: 30px"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="persona_type" class="form-label">Type:</label>
                        <input type="text" name="persona_type" value="<?php echo $type; ?>" class="form-field"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="description" class="form-label">Description:</label>
                        <textarea name="description" class="form-field"
                            style="height: 80px; resize: none; overflow: auto;"><?php echo $desc; ?></textarea>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="prefered_activity" class="form-label">Preferred Activity:</label>
                        <textarea name="prefered_activity" class="form-field"
                            style="height: 160px; resize: none; overflow: auto; white-space: pre-line;"><?php echo $activity; ?></textarea>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="image_url" class="form-label">Image URL:</label>
                        <input type="text" name="image_url" value="<?php echo $image; ?>" class="form-field"><br>
                    </p>
                    <div style="text-align: center;">
                        <input class='w3-button w3-margin-top w3-indigo w3-round w3-center' type="submit"
                            value="Save Changes">
                    </div>
                    <br>
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
