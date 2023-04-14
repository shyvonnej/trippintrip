<?php

include_once("dbconnect.php");

if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    $sqlloadtrips = "SELECT * FROM tbl_trips WHERE user_id = '$user_id' ORDER BY trip_id DESC";
    
    $result = $conn->query($sqlloadtrips);
    
    if ($result->num_rows > 0) {
        $trips["trips"] = array();
        
        while ($row = $result->fetch_assoc()) {
            $trip = array();
            $trip['trip_id'] = $row['trip_id'];
            $trip['trip_name'] = $row['trip_name'];
            $trip['trip_desc'] = $row['trip_desc'];
            $trip['trip_location'] = $row['trip_location'];
            $trip['start_date'] = $row['start_date'];
            $trip['end_date'] = $row['end_date'];
            array_push($trips["trips"], $trip);
        }
        
        $response = array('status' => 'success', 'data' => $trips);
        sendJsonResponse($response);
    } else {
        $response = array('status' => 'failed', 'data' => null);
        sendJsonResponse($response);
        echo "No matching data";
    }
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
