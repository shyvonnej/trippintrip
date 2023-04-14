<?php

include_once("dbconnect.php");
$sqlpersona = "SELECT * FROM tbl_personas";
$result = $conn->query($sqlpersona);
if ($result->num_rows > 0) {
     $persona["persona"] = array();
while ($row = $result->fetch_assoc()) {
        $personalist = array();
        $personalist['personaid'] = $row['persona_id'];
        $personalist['personaname'] = $row['name'];
        $personalist['personatype'] = $row['persona_type'];
        $personalist['personadesc'] = $row['description'];
        $personalist['personaimage'] = $row['image_url'];
        $personalist['personaactivity'] = $row['prefered_activity'];
        array_push($persona["persona"],$personalist);
    }
     $response = array('status' => 'success', 'data' => $persona);
    sendJsonResponse($response);
}else{
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
}

function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}

?>