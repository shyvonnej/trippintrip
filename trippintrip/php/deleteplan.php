<?php
// Include database connection
include_once("dbconnect.php");

// Check if trip_id is provided
if (!isset($_POST['trip_id'])) {
    echo 'Missing trip_id parameter';
    exit;
}

// Sanitize and validate input
$trip_id = filter_var($_POST['trip_id'], FILTER_SANITIZE_NUMBER_INT);
if (!$trip_id) {
    echo 'Invalid trip_id parameter';
    exit;
}

// Prepare SQL statement
$sql = "DELETE FROM tbl_trips WHERE trip_id = $trip_id";

// Execute SQL statement and check if successful
if ($conn->query($sql) === TRUE) {
    echo 'success';
} else {
    echo 'Failed to delete plan: ' . $conn->error;
}

// Close database connection
$conn->close();
?>
