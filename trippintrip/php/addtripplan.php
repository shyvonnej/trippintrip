<?php
include_once("dbconnect.php");

  // Get the trip information from the form
  $user_id = $_POST["user_id"];
  $trip_name = $_POST["trip_name"];
  $trip_description = $_POST["trip_desc"];
  $trip_location = $_POST["trip_location"];
  $start_date = $_POST["start_date"];
  $end_date = $_POST["end_date"];
  $na = "na";

  // Prepare and bind SQL statement
  $sqlinsert = "INSERT INTO tbl_trips (user_id, trip_name, trip_desc, trip_location, start_date, end_date, total_cost) VALUES ('$user_id', '$trip_name', '$trip_description', '$trip_location', '$start_date', '$end_date', '$na')";

  if ($conn->query($sqlinsert) === TRUE) {
        $response = array('status' => 'success', 'data' => null);
        sendEmail($email);
        sendJsonResponse($response);
    } else {
        $response = array('status' => 'failed', 'data' => null);
        sendJsonResponse($response);
    }

    function sendJsonResponse($sentArray)
    {
        header('Content-Type: application/json');
        echo json_encode($sentArray);
    }
?>