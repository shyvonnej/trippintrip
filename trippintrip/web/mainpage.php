<?php
session_start();
if (!isset($_SESSION['email'])) {
  header('Location: adminlogin.php');
  exit;
}

include_once("dbconnect.php");

$email = $_SESSION['email'];

$sql = "SELECT admin_name FROM tbl_admin WHERE admin_email = '$email'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$current_admin = $result['admin_name'];

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
      src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=821&q=80"
      alt="Homepage" style="width:1800px; height:300px; object-fit: cover; filter: brightness(50%);">
    <div class="w3-display-middle w3-margin-top w3-center">
      <h1>
        <span class="w3-hide-small w3-text-light-grey"><b>Welcome Back! <?php echo $current_admin; ?></b></span>
      </h1>
    </div>
  </header>

  <!-- First Row Grid-->
  <div class="w3-row-padding" style="margin-top: 50px; margin-left: 80px; margin-right: 80px;">
    <a href="attraction.php">
      <div class="w3-third w3-container w3-margin-bottom">
        <img
          src="https://images.unsplash.com/photo-1501256504904-1fbe305bb538?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
          alt="Attractions" style="width:100%; height: 300px; object-fit: cover;" class="w3-hover-opacity">
        <div class="w3-container w3-white">
          <p><b>Attractions</b></p>
          <p>Adding new attractions, updating existing ones, and removing outdated or incorrect information.</p>
        </div>
      </div>
    </a>
    <a href="personas.php">
      <div class="w3-third w3-container w3-margin-bottom">
        <img
          src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
          alt="Personas" style="width:100%; height: 300px; object-fit: cover;" class="w3-hover-opacity">
        <div class="w3-container w3-white">
          <p><b>Personas</b></p>
          <p>Adding new personas, updating existing ones, and removing outdated or incorrect information.</p>
        </div>
      </div>
    </a>
    <a href="users.php">
      <div class="w3-third w3-container">
        <img
          src="https://plus.unsplash.com/premium_photo-1661573291619-7542ad8cf915?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
          alt="Users" style="width:100%; height: 300px; object-fit: cover;" class="w3-hover-opacity">
        <div class="w3-container w3-white">
          <p><b>Users</b></p>
          <p>Manage the registered user, review their preferences and review the user's profile.</p>
        </div>
      </div>
    </a>
  </div>

  <!-- Second Row Grid-->
  <div class="w3-row-padding" style="margin-top: 5px; margin-left: 80px; margin-right: 80px;">
    <a href="admin.php">
      <div class="w3-third w3-container w3-margin-bottom">
        <img
          src="https://images.unsplash.com/photo-1579389083078-4e7018379f7e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
          alt="Admin" style="width:100%; height: 300px; object-fit: cover;" class="w3-hover-opacity">
        <div class="w3-container w3-white">
          <p><b>Admin</b></p>
          <p>Manage the registered admin and review the admin's profile.</p>
        </div>
      </div>
    </a>
    <a href="insights.php">
      <div class="w3-third w3-container w3-margin-bottom">
        <img
          src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=815&q=80"
          alt="Insights" style="width:100%; height: 300px; object-fit: cover;" class="w3-hover-opacity">
        <div class="w3-container w3-white">
          <p><b>Insights</b></p>
          <p>Insights generate reports on user preferences and selected personas.</p>
        </div>
      </div>
    </a>
    <a href="adminprofile.php">
      <div class="w3-third w3-container">
        <img
          src="https://images.unsplash.com/photo-1511367461989-f85a21fda167?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1031&q=80"
          alt="Profile" style="width:100%; height: 300px; object-fit: cover;" class="w3-hover-opacity">
        <div class="w3-container w3-white">
          <p><b>Profile</b></p>
          <p>Review the personal profile.</p>
        </div>
      </div>
    </a>
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
