<?php
session_start();
include_once("dbconnect.php");

if (!isset($_SESSION['sessionid'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script>window.location.replace('adminlogin.php')</script>";
    exit();
} else {
    $email = $_SESSION['email'];
}

if (isset($_POST['submit'])) {
    $name = $_POST['att_name'];
    $category = $_POST['att_category'];
    $location = $_POST['att_location'];
    $longtitude = $_POST['att_longtitude'];
    $latitude = $_POST['att_latitude'];
    $opening = $_POST['att_opening'];
    $closing = $_POST['att_closing'];
    $stateid = $_POST['state_id'];
    $price = $_POST['att_price'];
    $desc = $_POST['att_desc'];

    // Get the maximum value of the id column from the tbl_attraction table
    $sql = "SELECT MAX(att_id) as max_id FROM tbl_attraction";
    $result = $conn->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $max_id = $row['max_id'];

    // Set the auto_increment value of the id column to be the maximum value + 1
    $sql = "ALTER TABLE tbl_attraction AUTO_INCREMENT = " . ($max_id + 1);
    $conn->exec($sql);

    $stmt = $conn->prepare("INSERT INTO tbl_attraction (att_name, att_category, att_location, att_longtitude, att_latitude, att_opening, att_closing, state_id, att_price, att_desc) VALUES (:att_name, :att_category, :att_location, :att_longtitude, :att_latitude, :att_opening, :att_closing, :state_id, :att_price, :att_desc)");

    $stmt->bindValue(':att_name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':att_category', $category, PDO::PARAM_STR);
    $stmt->bindValue(':att_location', $location, PDO::PARAM_STR);
    $stmt->bindValue(':att_longtitude', $longtitude, PDO::PARAM_STR);
    $stmt->bindValue(':att_latitude', $latitude, PDO::PARAM_STR);
    $stmt->bindValue(':att_opening', $opening, PDO::PARAM_STR);
    $stmt->bindValue(':att_closing', $closing, PDO::PARAM_STR);
    $stmt->bindValue(':state_id', $stateid, PDO::PARAM_STR);
    $stmt->bindValue(':att_price', $price, PDO::PARAM_STR);
    $stmt->bindValue(':att_desc', $desc, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Loop through uploaded files and handle each file separately
        $target_dir = "../assets/attraction/";
        $target_file_prefix = ($max_id+1) . '_';
        $uploadOk = 1;
        for ($i = 0; $i < count($_FILES["fileToUpload"]["name"]); $i++) {
            $target_file = $target_dir . $target_file_prefix . ($i + 1) . ".png";
            $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"][$i], PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$i]);
            if ($check !== false) {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
                    echo "<script>The file " . htmlspecialchars(
                        basename(
                            $target_file
                        )
                    ) . " has been uploaded.<br> </script>";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                    $uploadOk = 0;
                }
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        if ($uploadOk) {
            echo "<script>alert('Attraction added successfully');</script>";
            echo "<script>window.location.replace('attractiondetails.php?id=" . ($max_id+1) . "')</script>";
            exit();
        } else {
            $sql = "DELETE FROM tbl_attraction WHERE att_name = :att_name";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':att_name', $name, PDO::PARAM_STR);
            $stmt->execute();
            echo "<script>alert('Failed to add attraction. Please try again later.');</script>";
            echo "<script>window.location.replace('addattraction.php')</script>";
            exit();
        }
    } else {
        echo "<script>alert('Failed to add attraction. Please try again later.');</script>";
        echo "<script>window.location.replace('addattraction.php')</script>";
        exit();
    }
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
    <script>
        function previewFiles() {
            var preview = document.querySelector('#imagePreview');
            var files = document.querySelector('input[type=file]').files;

            function readAndPreview(file) {
                // Make sure `file.name` matches our extensions criteria
                if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
                    var reader = new FileReader();

                    reader.addEventListener("load", function () {
                        var image = new Image();
                        image.height = 200;
                        image.width = 200;
                        image.title = file.name;
                        image.src = this.result;
                        image.style.marginRight = "10px";
                        image.style.marginTop = "10px";
                        image.style.marginBottom = "10px";
                        image.style.marginLeft = "10px";
                        preview.appendChild(image);
                    }, false);

                    reader.readAsDataURL(file);
                }
            }

            if (files) {
                [].forEach.call(files, readAndPreview);
            }
        }
    </script>
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
                <span class="w3-hide-small w3-text-light-grey"><b>Add Attraction Dashboard</b></span>
            </h1>
        </div>
    </header>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main w3-content w3-padding w3-center" style="max-width:1500px;margin-top:20px">
        <div style="display:flex; justify-content: center">
            <div class="w3-container w3-card w3-padding w3-margin" style="width:600px;margin:auto;text-align:left;">
                <h3 class="w3-center">Add New Attraction</h3>
                <form action="addattraction.php" method="POST" enctype="multipart/form-data">
                    <div class="w3-container w3-center">
                        <div id="imagePreview" style="margin-top: 10px; margin-bottom: 20px"></div>
                        <label for="fileToUpload">Choose file:</label>
                        <input type="file" name="fileToUpload[]" id="fileToUpload" multiple onchange="previewFiles()">
                    </div>
                    <p style="display: flex; align-items: center;">
                        <label for="att_name" class="form-label" style="margin-top: 30px">Name:</label>
                        <input type="text" name="att_name" class="form-field" style="margin-top: 30px"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_category" class="form-label">Category:</label>
                        <input type="text" name="att_category" class="form-field"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_location" class="form-label">Location:</label>
                        <textarea name="att_location" class="form-field"
                            style="height: 80px; resize: none; overflow: auto;"></textarea>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_longtitute" class="form-label">Longtitute:</label>
                        <input type="text" name="att_longtitude" class="form-field"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_latitude" class="form-label">Latitude:</label>
                        <input type="text" name="att_latitude" class="form-field"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_opening" class="form-label">Opening Time:</label>
                        <input type="text" name="att_opening" class="form-field"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_closing" class="form-label">Closing Time:</label>
                        <input type="text" name="att_closing" class="form-field"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="state_id" class="form-label">State:</label>
                        <span class="padding-right"></span>
                        <select id="state_id" name="state_id" class="form-field" style="height: 40px;">
                            <option value="1">Johor</option>
                            <option value="2">Kedah</option>
                            <option value="3">Kelantan</option>
                            <option value="4">Melaka</option>
                            <option value="5">Negeri Sembilan</option>
                            <option value="6">Pahang</option>
                            <option value="7">Perak</option>
                            <option value="8">Perlis</option>
                            <option value="9">Penang</option>
                            <option value="10">Sabah</option>
                            <option value="11">Sarawak</option>
                            <option value="12">Selangor</option>
                            <option value="13">Terengganu</option>
                        </select>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_price" class="form-label">Price:</label>
                        <input type="text" name="att_price" class="form-field"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_desc" class="form-label">Description:</label>
                        <textarea name="att_desc" class="form-field"
                            style="height: 150px; resize: none; overflow: auto;"></textarea>
                    </p>
                    <div style="text-align: center;">
                        <input class='w3-button w3-margin-top w3-indigo w3-round w3-center' type="submit" name="submit"
                            value="Add Attraction">
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

</html>
