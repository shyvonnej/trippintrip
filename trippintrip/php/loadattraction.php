<?php

include_once("dbconnect.php");

if(isset($_GET['search'])) {
    $search = $_GET['search'];
    
    if($search == "all") {
		$sqlloadattraction = "SELECT * FROM tbl_attraction ORDER BY att_id DESC";
	} else {
		$sqlloadattraction = "SELECT a.*, s.state_name 
                     FROM tbl_attraction a 
                     INNER JOIN tbl_states s ON a.state_id = s.state_id 
                     WHERE a.att_name LIKE '%$search%' 
                     OR s.state_name LIKE '%$search%' 
                     OR a.att_category LIKE '%$search%' 
                     ORDER BY a.att_id DESC";
                     
	}	
    
    $result = $conn->query($sqlloadattraction);
    
    if ($result->num_rows > 0) {
        $attractions["attractions"] = array();
        
        while ($row = $result->fetch_assoc()) {
            $attlist = array();
            $attlist['att_id'] = $row['att_id'];
            $attlist['att_name'] = $row['att_name'];
            $attlist['att_category'] = $row['att_category'];
            $attlist['att_location'] = $row['att_location'];
            $attlist['att_opening'] = $row['att_opening'];
            $attlist['att_closing'] = $row['att_closing'];
            $attlist['att_price'] = $row['att_price'];
            $attlist['att_desc'] = $row['att_desc'];
			$attlist['state_id'] = $row['state_id'];
            array_push($attractions["attractions"],$attlist);
        }
        
        $response = array('status' => 'success', 'data' => $attractions);
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
