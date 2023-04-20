<?php
// Create a PDO connection
include_once("dbconnect.php");

// Execute a SQL query to get the personas and their user count
$query = "SELECT tbl_personas.*, COUNT(user_persona_preferences.user_id) AS user_count
          FROM tbl_personas LEFT JOIN user_persona_preferences ON tbl_personas.persona_id = user_persona_preferences.persona_id
          GROUP BY tbl_personas.persona_id";

$result = $conn->query($query);

// Create an array to hold the header row of the CSV file
$headers = array(
    "Persona ID",
    "Persona Name",
    "Persona Type",
    "Persona Description",
    "Persona Prefered Activity",
    "Image URL",
    "Count",
);

// Create an empty array to hold the data rows of the CSV file
$rows = array();

// Loop through each row in the result set and add the user details to the data rows array
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $user = array(
        $row["persona_id"],
        $row["name"],
        $row["persona_type"],
        $row["description"],
        $row["prefered_activity"],
        $row["image_url"],
        $row["user_count"]
    );

    // Add the user details to the data rows array
    array_push($rows, $user);
}

// Close the connection
$conn = null;

// Set the content type and headers to force a download of the CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="persona_report.csv"');
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
