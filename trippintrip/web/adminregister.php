<?php
if (isset($_POST['submit'])) {
    include_once("dbconnect.php");
    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $state = $_POST['state'];
    $password = sha1($_POST['password']);

    // check if the state already has two registered admins
    $sql_check = "SELECT COUNT(*) AS num_admins FROM tbl_admin WHERE state_id = '$state'";
    $result = $conn->query($sql_check);
    $row = $result->fetch_assoc();
    $num_admins = $row['num_admins'];
    if ($num_admins >= 2) {
        echo "<script>alert('Registration failed. This state already has two registered admins.')</script>";
        echo "<script>window.location.replace('adminregister.php')</script>";
        exit();
    }

    $sqlregister = "INSERT INTO tbl_admin (admin_email, admin_name, admin_phone, admin_password, state_id) VALUES ('$email', '$name', '$phone', '$password', '$state')";
    try {
        $conn->query($sqlregister);

        if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
            $last_id = $conn->insert_id;
            uploadImage($last_id);
            echo "<script>alert('Success')</script>";
            echo "<script>window.location.replace('adminlogin.php')</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Failed')</script>";
        echo "<script>window.location.replace('adminregister.php')</script>";
    }
}

function uploadImage($filename)
{
    $target_dir = "../assets/admin/";
    $target_file = $target_dir . $filename . ".png";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
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

        .padding-right {
            margin-right: 20px;
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

    <!-- !PAGE CONTENT! -->
    <div class="w3-main w3-content w3-padding w3-center" style="max-width:1500px;margin-top:20px">
        <div style="display:flex; justify-content: center">
            <div class="w3-container w3-card w3-padding w3-margin" style="width:600px;margin:auto;text-align:left;">
                <form name="signupForm" action="adminregister.php" method="post" enctype="multipart/form-data">
                    <div class="w3-container w3-center">
                        <img class="w3-image w3-margin" src="../assets/admin/defaultprofile.png"
                            style="height:200px;width:200px"><br>
                        <input type="file" name="fileToUpload" onchange="previewFile()">
                    </div>
                    <p>
                        <label><b>Name</b></label>
                        <input class="w3-input w3-round w3-border" type="text" name="name" id="idname"
                            placeholder="Your name" required>
                    </p>
                    <p>
                        <label><b>Email</b></label>
                        <input class="w3-input w3-round w3-border" type="email" name="email" id="idemail"
                            placeholder="Your email" required>
                    </p>
                    <p>
                        <label><b>Phone Number</b></label>
                        <input class="w3-input w3-round w3-border" type="tel" name="phone" id="idphone"
                            placeholder="Your phone number" required>
                    </p>
                    <p>
                        <label><b>Password</b></label><br>
                        <input class="w3-input w3-round w3-border" type="password" name="password" id="idpass"
                            placeholder="Your password" required>
                    </p>
                    <label for="state"><b>State:</b></label>
                    <span class="padding-right"></span>
                    <select id="state" name="state" class="form-control">
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

                    <p style="font-size:16px;"> Already have an account? <a href="adminlogin.php">Login</a></p>
                    <div style="display:flex; justify-content: center">
                        <p style="text-align:center;">
                            <input class="w3-button w3-round w3-border w3-light-blue" type="submit" name="submit"
                                id="submit" value="Register" style="margin:0 auto;">
                        </p>
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