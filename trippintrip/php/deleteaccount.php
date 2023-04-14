<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    echo "failed";
    die();
}

include_once("dbconnect.php");

$email =$_REQUEST['user_email'];
// sql to delete a record
$sql = "DELETE FROM tbl_users WHERE user_email = $email";

if ($conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>