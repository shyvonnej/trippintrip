<?php
// Check if the user is logged in as an admin
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: adminlogin.php');
    exit;
}

// Retrieve the admin's information from the database
require_once('dbconnect.php');
$email = $_SESSION['email'];
$query = "SELECT * FROM tbl_admin INNER JOIN tbl_states ON tbl_admin.state_id = tbl_states.state_id 
WHERE admin_email = '$email'";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$admin_id = $result['admin_id'];
$admin_name = $result['admin_name'];
$admin_phone = $result['admin_phone'];
$admin_email = $result['admin_email'];
$admin_state = $result['state_name'];
$state_id = $result['state_id'];

// Check if the form has been submitted for updating the admin's information
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the new admin information from the form
    $admin_name = $_POST['admin_name'];
    $admin_phone = $_POST['admin_phone'];
    $admin_email = $_POST['admin_email'];
    $state_id = $_POST['state_id'];

    // Update the admin's information in the database
    $query = "UPDATE tbl_admin SET admin_name = :admin_name, admin_phone = :admin_phone, admin_email = :admin_email, state_id = :state_id WHERE admin_id = :admin_id";
    $statement = $conn->prepare($query);
    $statement->bindValue(':admin_id', $admin_id);
    $statement->bindValue(':admin_name', $admin_name);
    $statement->bindValue(':admin_phone', $admin_phone);
    $statement->bindValue(':admin_email', $admin_email);
    $statement->bindValue(':state_id', $state_id);
    $statement->execute();

    try {
        if (file_exists($_FILES["fileToUpload"]["tmp_name"]) && is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
            $last_id = $admin_id;
            uploadImage($last_id);
        }
        echo "<script>alert('Success')</script>";
        echo "<script>window.location.replace('adminprofile.php')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Failed')</script>";
        echo "<script>window.location.replace('admineditprofile.php')</script>";
    }
}

function uploadImage($filename)
{
    $target_dir = "../assets/admin/";
    $target_file = $target_dir . $filename . ".png";

    // Check if file already exists
    if (file_exists($target_file)) {
        unlink($target_file); // Remove the existing image file
    }

    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
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

        .form-field {
            width: 80%;
            height: 30px;
            padding: 5px;
            /* Set the width to 80% of its parent element */
        }

        .form-label {
            display: inline-block;
            width: 100px;
            padding-right: 10px;
            padding-left: 10px;
        }
    </style>
    <script>
        function previewFile() {
            const preview = document.querySelector('.w3-image');
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();
            reader.addEventListener("load", function () {
                // convert image file to base64 string
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>

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
            src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=821&q=80"
            alt="Homepage" style="width:1800px; height:300px; object-fit: cover; filter: brightness(50%);">
        <div class="w3-display-middle w3-margin-top w3-center">
            <h1>
                <span class="w3-hide-small w3-text-light-grey"><b>Edit Profile</b></span>
            </h1>
        </div>
    </header>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main w3-content w3-padding w3-center" style="max-width:1500px;margin-top:20px">
        <div style="display:flex; justify-content: center">
            <div class="w3-container w3-card w3-padding w3-margin" style="width:600px;margin:auto;text-align:left;">
                <h3 class="w3-center">Edit Admin Profile</h3>
                <form action="admineditprofile.php" method="post">
                    <div class="w3-container w3-center">
                        <img class="w3-image w3-margin" src="../assets/admin/<?php echo $admin_id; ?>.png"
                            style="height:200px;width:200px; object-fit: cover;"><br>
                        <input type="file" name="fileToUpload" onchange="previewFile()">
                    </div>
                    <p>
                        <label for="admin_name" class="form-label">Name:</label>
                        <input type="text" name="admin_name" value="<?php echo $admin_name; ?>" class="form-field"><br>
                    </p>
                    <p>
                        <label for="admin_email" class="form-label">Email:</label>
                        <input type="email" name="admin_email" value="<?php echo $admin_email; ?>"
                            class="form-field"><br>
                    </p>
                    <p>
                        <label for="admin_phone" class="form-label">Phone:</label>
                        <input type="tel" name="admin_phone" value="<?php echo $admin_phone; ?>" class="form-field"><br>
                    </p>
                    <p>
                        <label for="state_id" class="form-label">State:</label>
                        <span class="padding-right"></span>
                        <select id="state_id" name="state_id" class="form-field">
                            <option value="1" <?php if ($state_id == 1)
                                echo "selected"; ?>>Johor</option>
                            <option value="2" <?php if ($state_id == 2)
                                echo "selected"; ?>>Kedah</option>
                            <option value="3" <?php if ($state_id == 3)
                                echo "selected"; ?>>Kelantan</option>
                            <option value="4" <?php if ($state_id == 4)
                                echo "selected"; ?>>Melaka</option>
                            <option value="5" <?php if ($state_id == 5)
                                echo "selected"; ?>>Negeri Sembilan</option>
                            <option value="6" <?php if ($state_id == 6)
                                echo "selected"; ?>>Pahang</option>
                            <option value="7" <?php if ($state_id == 7)
                                echo "selected"; ?>>Perak</option>
                            <option value="8" <?php if ($state_id == 8)
                                echo "selected"; ?>>Perlis</option>
                            <option value="9" <?php if ($state_id == 9)
                                echo "selected"; ?>>Penang</option>
                            <option value="10" <?php if ($state_id == 10)
                                echo "selected"; ?>>Sabah</option>
                            <option value="11" <?php if ($state_id == 11)
                                echo "selected"; ?>>Sarawak</option>
                            <option value="12" <?php if ($state_id == 12)
                                echo "selected"; ?>>Selangor</option>
                            <option value="13" <?php if ($state_id == 13)
                                echo "selected"; ?>>Terengganu</option>
                        </select>
                    </p>
                    <br>
                    <div style="text-align: center;">
                        <input class='w3-button w3-margin-top w3-indigo w3-round w3-center' type="submit" value="Save Changes">
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