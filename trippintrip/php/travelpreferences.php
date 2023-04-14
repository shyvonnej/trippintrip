<?php

// Get data from the Flutter app
$user_id = $_POST['user_id'];
$interests = $_POST['interests'];
$accommodation = $_POST['accommodation'];
$budget = $_POST['budget'];
$travel_style = $_POST['travel_style'];
$destination_preferences = $_POST['destination_preferences'];

// Update the data in the database
$query = "UPDATE user_persona_preferences SET interests = '$interests', accommodation= '$accommodation', budget = '$budget', travel_style = '$travel_style', destination_preferences = '$destination_preferences' WHERE user_id = '$user_id'";
databaseUpdate($query);
function databaseUpdate($sql){
    include_once("dbconnect.php"); 
    if ($conn->query($sql) === TRUE) {
        $response = array('status' => 'success', 'data' => null);
        sendJsonResponse($response);
    } else {
        $response = array('status' => 'failed', 'data' => null);
        sendJsonResponse($response);
    }
}
function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}
?>
