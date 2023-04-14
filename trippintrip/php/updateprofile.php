<?php
include_once("dbconnect.php");

if (!isset($_POST)) {
    sendJsonResponse(array('status' => 'failed', 'data' => null));
    die();
}

$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$userid = $_POST['userid'];
$image = $_POST['image'];

// Update the user profile information
$sqlupdate = "UPDATE tbl_users SET user_phone ='$phone', user_name = '$name', user_address = '$address' WHERE user_id = '$userid'";

try {
    databaseUpdate($sqlupdate, $userid, $image);

    // Check if the profile is complete and update the database accordingly
    $sqlcheck = "SELECT * FROM tbl_users WHERE user_id = '$userid' AND user_name IS NOT NULL AND user_phone IS NOT NULL AND user_address IS NOT NULL";
    $result = $conn->query($sqlcheck);

    if ($result->num_rows > 0) {
        $sqlcomplete = "UPDATE tbl_users SET isProfileComplete = true WHERE user_id = '$userid'";
        $conn->query($sqlcomplete);
    }

    sendJsonResponse(array('status' => 'success'));

} catch(Exception $e) {
    sendJsonResponse(array('status' => 'failed'));
}

function databaseUpdate($sql, $userid, $image) {
    global $conn;
    if ($conn->query($sql) === TRUE) {
        $decoded_string = base64_decode($image);
        $filename = $userid;
        $path = '../assets/user/'.$filename.'.png';
        file_put_contents($path, $decoded_string);
    } else {
        throw new Exception("Database update error.");
    }
}

function sendJsonResponse($sentArray) {
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}

$conn->close();

?>
