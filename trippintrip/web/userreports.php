<?php
// Create a PDO connection
include_once("dbconnect.php");

// Execute a SQL query to get the users and their details
$query = "SELECT tbl_users.*, tbl_personas.*, user_persona_preferences.*, IFNULL(trip_count, 0) AS trip_count
FROM tbl_users
INNER JOIN user_persona_preferences ON tbl_users.user_id = user_persona_preferences.user_id
INNER JOIN tbl_personas ON tbl_personas.persona_id = user_persona_preferences.persona_id
LEFT JOIN (
  SELECT user_id, COUNT(trip_id) AS trip_count
  FROM tbl_trips
  GROUP BY user_id
) AS trip_counts ON tbl_users.user_id = trip_counts.user_id";

$result = $conn->query($query);

// Create an array to hold the header row of the CSV file
$headers = array(
    "User ID",
    "User Name",
    "User Email",
    "User Gender",
    "User Bio",
    "User Phone",
    "User Address",
    "Persona ID",
    "Persona Name",
    "Persona Type",
    "Persona Description",
    "Preferred Activity",
    "Interests",
    "Accommodation",
    "Budget",
    "Travel Style",
    "Destination Preferences",
    "Trip Count"
);

// Create an empty array to hold the data rows of the CSV file
$rows = array();

// Loop through each row in the result set and add the user details to the data rows array
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $user = array(
        $row["user_id"],
        $row["user_name"],
        $row["user_email"],
        $row["user_gender"],
        $row["user_bio"],
        $row["user_phone"],
        $row["user_address"],
        $row["persona_id"],
        $row["name"],
        $row["persona_type"],
        $row["description"],
        $row["prefered_activity"],
        $row["interests"],
        $row["accommodation"],
        $row["budget"],
        $row["travel_style"],
        $row["destination_preferences"],
        $row["trip_count"]
    );

    // Add the user details to the data rows array
    array_push($rows, $user);
}

// Close the connection
$conn = null;

// Set the content type and headers to force a download of the CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="users_report.csv"');
header('Pragma: no-cache');
header('Expires: 0');

// Open a new output stream using php://output
$fp = fopen('php://output', 'w');

// Write the header row to the output stream
fputcsv($fp, $headers);

// Write each data row to the output stream
foreach ($rows as $row) {
    fputcsv($fp, $row);
}

// Close the output stream
fclose($fp);
?>
