<?php
session_start();

include_once("dbconnect.php");

if (!isset($_SESSION['sessionid'])) {
  echo "<script>alert('Session not available. Please login');</script>";
  echo "<script> window.location.replace('adminlogin.php')</script>";
} else {
  $email = $_SESSION['email'];
}

//Retrieve attraction
$sqlattraction = "SELECT a.*, s.state_name 
FROM tbl_attraction a 
INNER JOIN tbl_states s ON a.state_id = s.state_id ";

//Pagination
$results_per_page = 10;

if (isset($_GET['page_no'])) {
  $page_no = (int) $_GET['page_no'];
  $page_first_result = ($page_no - 1) * $results_per_page;
} else {
  $page_no = 1;
  $page_first_result = 0;
}

$stmt_attraction = $conn->prepare($sqlattraction);
$stmt_attraction->execute();

$number_of_result = $stmt_attraction->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page); // round off

$sqlattraction = $sqlattraction . " LIMIT $page_first_result, $results_per_page";

$stmt = $conn->prepare($sqlattraction);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

$conn = null; // close connection

function truncate($string, $length, $dots = "...")
{
  return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>TrippinTrip Portal</title>
  <link rel="shortcut icon" href="your-favicon-file.ico">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    integrity="sha512-SjCz7B1xJxuV7OQq3qzwV7meHrmiJchBwZtivBJm+C2Q43cxIuTt06jy8Sl+b9sPpVbvcg0nRwLZjKfRKhsNDA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
      width: 90%;
    }

    .col-1 {
      width: 5%;
    }

    .col-2 {
      width: 10%;
    }

    .col-3 {
      width: 15%;
    }

    .col-4 {
      width: 25%;
    }

    .fa-sort {
      margin-left: 5px;
    }

    .fa-sort-up {
      margin-left: 5px;
      color: green;
    }

    .fa-sort-down {
      margin-left: 5px;
      color: red;
    }
  </style>
  <script>
    $(document).ready(function () {
      $('th').click(function () {
        var table = $(this).parents('table').eq(0);
        var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
        this.asc = !this.asc;
        if (!this.asc) {
          rows = rows.reverse();
        }
        for (var i = 0; i < rows.length; i++) {
          table.append(rows[i]);
        }
        $('th').removeClass('sorted');
        if (this.asc) {
          $(this).addClass('sorted').find('i').removeClass('fa-sort').removeClass('fa-sort-down').addClass('fa-sort-up');
        } else {
          $(this).addClass('sorted').find('i').removeClass('fa-sort').removeClass('fa-sort-up').addClass('fa-sort-down');
        }
      });
    });

    function comparer(index) {
      return function (a, b) {
        var valA = getCellValue(a, index);
        var valB = getCellValue(b, index);
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
      };
    }

    function getCellValue(row, index) {
      return $(row).children('td').eq(index).text();
    }
  </script>
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
      src="https://images.unsplash.com/photo-1501256504904-1fbe305bb538?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
      alt="Homepage" style="width:1800px; height:300px; object-fit: cover; filter: brightness(50%);">
    <div class="w3-display-middle w3-margin-top w3-center">
      <h1>
        <span class="w3-hide-small w3-text-light-grey"><b>Attraction Dashboard
          </b></span>
      </h1>
    </div>
  </header>

  <body>
    <section>
      <div class="w3-container w3-padding-15 w3-center" id="content">
        <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16">Attraction List</h3>
        <div style="overflow-x:auto;">
        <input class="w3-button w3-round w3-border w3-indigo" type="submit" name="submit" value="Add New Attraction" onclick="location.href='addattraction.php'">
          <br>
          <table id="attractions" class="sortable, w3-hoverable" style="border:1px solid black;margin-left:auto;margin-right:auto;margin-top:20px;">
            <thead>
              <tr>
                <th class="col-1">ID<i class="fa fa-sort"></th>
                <th class="col-3">Name<i class="fa fa-sort"></th>
                <th class="col-2">Category<i class="fa fa-sort"></th>
                <th class="col-4">Location<i class="fa fa-sort"></th>
                <th class="col-2">Longtitude<i class="fa fa-sort"></th>
                <th class="col-2">Latitude<i class="fa fa-sort"></th>
                <th class="col-2">Time<i class="fa fa-sort"></th>
                <th class="col-1">State<i class="fa fa-sort"></th>
                <th class="col-3">Price<i class="fa fa-sort"></th>
                <th class="col-1"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 0;

              echo

                "
               
               ";
              // LOOP TILL END OF DATA
              foreach ($rows as $result) {
                $i++;
                $id = $result['att_id'];
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

                echo
                  "
                <tr>
                  <td>
                  $id
                  </td>
                  <td>
                  $name
                 </td>
                  <td>
                   $category 
                  </td>
                  <td>
                  $location
                 </td>
                  <td>
                   $longtitude
                  </td>
                  <td>
                   $latitude
                  </td>
                  <td>
                   $opening - $closing
                  </td>
                  <td>
                   $statename
                  </td>
                  <td>
                   $price
                  </td>
                  <td>
                  <a href='attractiondetails.php?id=" . $id . "' onclick=\"document.getElementById('newsdetails1').style.display='block';return false;\">
                  <button style='margin-bottom:5px' class='fa fa-newspaper-o'></button>
                </a>
</td>
                  </tr>
              
                </div>";
              }
              ?>
            </tbody>
          </table>
          <?php
          $num = 1;
          if ($page_no == 1) {
            $num = 1;
          } else if ($page_no == 2) {
            $num = ($num) + 10;
          } else {
            $num = $page_no * 10 - 9;
          }

          echo "<div class='w3-container w3-row'>";
          echo "<center>Page:";
          for ($page = 1; $page <= $number_of_page; $page++) {
            if ($page == $page_no) {
              echo '<a href = "?page_no=' . $page . '" style= "text-decoration: none; color: #DA920C"><b>&nbsp&nbsp' . $page . ' </b></a>';
            } else {
              echo '<a href = "?page_no=' . $page . '" style= "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
            }
          }
          echo "</center></div>";
          ?>
          <br>
        </div>
    </section>
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

</body>

</html>