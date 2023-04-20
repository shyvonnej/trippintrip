<?php
session_start();

include_once("dbconnect.php");

if (!isset($_SESSION['sessionid'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('adminlogin.php')</script>";
} else {
    $email = $_SESSION['email'];
}

// Query the database to get the number of users for each persona
$sql = "SELECT p.persona_id, p.name, p.persona_type, COUNT(up.persona_id) as total_users
    FROM tbl_personas p
    LEFT JOIN user_persona_preferences up ON up.persona_id = p.persona_id
    GROUP BY p.persona_id
    ";
$result = $conn->query($sql);


//retrive the numbers
$sqladmins = "SELECT COUNT(*) as totaladmin FROM tbl_admin";
$sqlusers = "SELECT COUNT(*) as totalusers FROM tbl_users";
$sqlattraction = "SELECT COUNT(*) as totalattraction FROM tbl_attraction";
$sqlpersonas = "SELECT COUNT(*) as totalpersonas FROM tbl_personas";

$resultuser = $conn->query($sqlusers);
if ($resultuser->rowCount() > 0) {
    $row = $resultuser->fetch(PDO::FETCH_ASSOC);
    $total_users = $row["totalusers"];
} else {
    echo "No users found.";
}

$resultadmin = $conn->query($sqladmins);
if ($resultadmin->rowCount() > 0) {
    $row = $resultadmin->fetch(PDO::FETCH_ASSOC);
    $total_admin = $row["totaladmin"];
} else {
    echo "No admin found.";
}

$resultattraction = $conn->query($sqlattraction);
if ($resultattraction->rowCount() > 0) {
    $row = $resultattraction->fetch(PDO::FETCH_ASSOC);
    $total_attraction = $row["totalattraction"];
} else {
    echo "No attraction found.";
}

$resultpersonas = $conn->query($sqlpersonas);
if ($resultpersonas->rowCount() > 0) {
    $row = $resultpersonas->fetch(PDO::FETCH_ASSOC);
    $total_personas = $row["totalpersonas"];
} else {
    echo "No personas found.";
}

$conn = null;
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
    <script>
        function userreports() {
            fetch('userreports.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'text/csv'
                },
                body: JSON.stringify({ /* put any data to send to the server here */ })
            })
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(new Blob([blob]));
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'users_report.csv';
                    a.click();
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error(error); // handle any error here
                });
        }
    </script>
    <script>
        function attractionreports() {
            fetch('attractionreport.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'text/csv'
                },
                body: JSON.stringify({ /* put any data to send to the server here */ })
            })
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(new Blob([blob]));
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'attraction_report.csv';
                    a.click();
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error(error); // handle any error here
                });
        }
    </script>
    <script>
        function personareports() {
            fetch('personareports.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'text/csv'
                },
                body: JSON.stringify({ /* put any data to send to the server here */ })
            })
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(new Blob([blob]));
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'persona_report.csv';
                    a.click();
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error(error); // handle any error here
                });
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
            width: 80%;
        }

        button {
            font-size: 16px;
            padding: 12px 24px;
            background-color: #728FCE;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2B3856;
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
                <span class="w3-hide-small w3-text-light-grey"><b>Insights Dashboard</b></span>
            </h1>
        </div>
    </header>

    <div class="w3-row-padding w3-margin-bottom" style="margin-top: 30px; margin-left: 35px; margin-right: 35px;">
        <a href="attraction.php">
            <div class="w3-quarter">
                <div class="w3-container w3-red w3-padding-16" style="margin-right: 5px">
                    <div class="w3-left"><i class="fa fa-location-arrow w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3>
                            <?php echo $total_attraction; ?>
                        </h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Attractions</h4>
                </div>
            </div>
        </a>
        <a href="personas.php">
            <div class="w3-quarter">
                <div class="w3-container w3-blue w3-padding-16" style="margin-right: 5px">
                    <div class="w3-left"><i class="fa fa-child w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3>
                            <?php echo $total_personas; ?>
                        </h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Personas</h4>
                </div>
            </div>
        </a>
        <a href="admin.php">
            <div class="w3-quarter">
                <div class="w3-container w3-teal w3-padding-16" style="margin-right: 5px">
                    <div class="w3-left"><i class="fa fa-cog w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3>
                            <?php echo $total_admin; ?>
                        </h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Admins</h4>
                </div>
            </div>
        </a>
        <a href="users.php">
            <div class="w3-quarter">
                <div class="w3-container w3-orange w3-text-white w3-padding-16">
                    <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3>
                            <?php echo $total_users; ?>
                        </h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Users</h4>
                </div>
            </div>
        </a>
    </div>
    <hr>
    <h1 style="text-align:center"><b>Persona User Count Report</b></h1>
    <?php
    // Output the results as an HTML table
    echo "<table style='margin: 0 auto;'>";
    echo "<tr><th>ID</th><th>Persona Name</th><th>Total Users</th></tr>";
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>" . $row["persona_id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["persona_type"] . "</td><td>" . $row["total_users"] . "</td></tr>";
    }
    echo "</table>";
    ?>
    <h2 style="text-align:center"><b>Download Report in Excel</b></h2>
    <div style="text-align: center;">
        <h4>Users Report</h4>
        <button onclick="userreports()">Download</button>
    </div>
    <div style="text-align: center;">
        <h4>Attractions Report</h4>
        <button onclick="attractionreports()">Download</button>
    </div>
    <div style="text-align: center;">
        <h4>Persona Report</h4>
        <button onclick="personareports()">Download</button>
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
