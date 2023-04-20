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
    $attid = $_GET['id'];
    $query = "SELECT * FROM tbl_attraction INNER JOIN tbl_states ON tbl_attraction.state_id = tbl_states.state_id WHERE att_id = $attid";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $attid = $result['att_id'];
    $name = $result['att_name'];
    $category = $result['att_category'];
    $location = $result['att_location'];
    $longtitude = $result['att_longtitude'];
    $latitude = $result['att_latitude'];
    $opening = $result['att_opening'];
    $closing = $result['att_closing'];
    $stateid = $result['state_id'];
    $statename = $result['state_name'];
    $price = $result['att_price'];
    $desc = $result['att_desc'];

    // Check if the form has been submitted for updating the attraction's information
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the new attraction information from the form
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

        // Update the attraction's information in the database
        $query = "UPDATE tbl_attraction SET att_name = :att_name, att_category = :att_category, att_location = :att_location, att_longtitude = :att_longtitude, att_latitude = :att_latitude, att_opening = :att_opening, att_closing = :att_closing, state_id = :state_id, att_price = :att_price, att_desc = :att_desc WHERE att_id = :att_id";
        $statement = $conn->prepare($query);
        $statement->bindValue(':att_id', $attid);
        $statement->bindValue(':att_name', $name);
        $statement->bindValue(':att_category', $category);
        $statement->bindValue(':att_location', $location);
        $statement->bindValue(':att_longtitude', $longtitude);
        $statement->bindValue(':att_latitude', $latitude);
        $statement->bindValue(':att_opening', $opening);
        $statement->bindValue(':att_closing', $closing);
        $statement->bindValue(':state_id', $stateid); // Changed to $stateid from $state_id
        $statement->bindValue(':att_price', $price);
        $statement->bindValue(':att_desc', $desc);
        $statement->execute();

        // Delete the old images
        for ($i = 1; $i <= 5; $i++) {
            $image_path = "../assets/attraction/" . basename( $attid . "$i.png");
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        // Upload the new images
        for ($i = 1; $i <= 5; $i++) {
            if (isset($_FILES["att_name$i"]["name"]) && $_FILES["att_name$i"]["name"] != '') {
                $target_dir = "../assets/attraction/";
                $target_file = $target_dir . basename($_FILES["att_name$i"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["att_name$i"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["att_name$i"]["size"] > 5000000) {
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "<script>alert('Sorry, your file was not uploaded.');</script>";
                    // If everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["att_name$i"]["tmp_name"], $target_file)) {
                        $query = "INSERT INTO tbl_images (att_id, image_path) VALUES (:att_id, :image_path)";
                        $statement = $conn->prepare($query);
                        $statement->bindValue(':att_id', $attid);
                        $statement->bindValue(':image_path', $target_file);
                        $statement->execute();
                    } else {
                        echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
                    }
                }
            }
        }
        echo "<script>alert('Attraction information updated successfully.');</script>";
        echo "<script> window.location.replace('attraction.php')</script>";
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
                <h3 class="w3-center">Edit Attraction</h3>
                <form action="editattraction.php?id=<?php echo $attid; ?>" method="POST">
                    <div class="w3-container w3-center">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <?php $filename = $attid . '_' . $i . '.png'; ?>
                            <img class="w3-image w3-margin" src="../assets/attraction/<?php echo $filename; ?>"
                                style="height:200px;width:200px; object-fit: cover;"><br>
                            <input type="file" name="fileToUpload[]" onchange="previewFile(<?php echo $i; ?>)">
                        <?php } ?>
                    </div>
                    <p style="display: flex; align-items: center;">
                        <label for="att_name" class="form-label" style="margin-top: 30px">Name:</label>
                        <input type="text" name="att_name" value="<?php echo $name; ?>" class="form-field"
                            style="margin-top: 30px"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_category" class="form-label">Category:</label>
                        <input type="text" name="att_category" value="<?php echo $category; ?>" class="form-field"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_location" class="form-label">Location:</label>
                        <textarea name="att_location" class="form-field"
                            style="height: 80px; resize: none; overflow: auto;"><?php echo $location; ?></textarea>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_longtitute" class="form-label">Longtitute:</label>
                        <input type="text" name="att_longtitude" value="<?php echo $longtitude; ?>"
                            class="form-field"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_latitude" class="form-label">Latitude:</label>
                        <input type="text" name="att_latitude" value="<?php echo $latitude; ?>" class="form-field"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_opening" class="form-label">Opening Time:</label>
                        <input type="text" name="att_opening" value="<?php echo $opening; ?>" class="form-field"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_closing" class="form-label">Closing Time:</label>
                        <input type="text" name="att_closing" value="<?php echo $closing; ?>" class="form-field"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="state_id" class="form-label">State:</label>
                        <span class="padding-right"></span>
                        <select id="state_id" name="state_id" class="form-field" style="height: 40px;">
                            <option value="1" <?php if ($stateid == 1)
                                echo "selected"; ?>>Johor</option>
                            <option value="2" <?php if ($stateid == 2)
                                echo "selected"; ?>>Kedah</option>
                            <option value="3" <?php if ($stateid == 3)
                                echo "selected"; ?>>Kelantan</option>
                            <option value="4" <?php if ($stateid == 4)
                                echo "selected"; ?>>Melaka</option>
                            <option value="5" <?php if ($stateid == 5)
                                echo "selected"; ?>>Negeri Sembilan</option>
                            <option value="6" <?php if ($stateid == 6)
                                echo "selected"; ?>>Pahang</option>
                            <option value="7" <?php if ($stateid == 7)
                                echo "selected"; ?>>Perak</option>
                            <option value="8" <?php if ($stateid == 8)
                                echo "selected"; ?>>Perlis</option>
                            <option value="9" <?php if ($stateid == 9)
                                echo "selected"; ?>>Penang</option>
                            <option value="10" <?php if ($stateid == 10)
                                echo "selected"; ?>>Sabah</option>
                            <option value="11" <?php if ($stateid == 11)
                                echo "selected"; ?>>Sarawak</option>
                            <option value="12" <?php if ($stateid == 12)
                                echo "selected"; ?>>Selangor</option>
                            <option value="13" <?php if ($stateid == 13)
                                echo "selected"; ?>>Terengganu</option>
                        </select>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_price" class="form-label">Price:</label>
                        <input type="text" name="att_price" value="<?php echo $price; ?>" class="form-field"><br>
                    </p>
                    <p style="display: flex; align-items: center;">
                        <label for="att_desc" class="form-label">Description:</label>
                        <textarea name="att_desc" class="form-field"
                            style="height: 150px; resize: none; overflow: auto;"><?php echo $desc; ?></textarea>
                    </p>
                    <br>
                    <div style="text-align: center;">
                        <input class='w3-button w3-margin-top w3-indigo w3-round w3-center' type="submit"
                            value="Save Changes">
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
