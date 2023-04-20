<?php
// Create a PDO connection
include_once("dbconnect.php");

// Execute a SQL query to get the attractions sorted by state
$query = "SELECT *
          FROM tbl_attraction
          INNER JOIN tbl_states WHERE tbl_attraction.state_id = tbl_states.state_id
          ORDER BY tbl_attraction.state_id";

$result = $conn->query($query);

// Create an array to hold the header row of the CSV file
$headers = array(
    "Attraction ID",
    "Attraction Name",
    "Attraction Category",
    "Attraction Description",
    "Attraction Location",
    "Attraction Time",
    "Attraction Price",
    "State ID",
    "State Name",
);

// Create an empty array to hold the data rows of the CSV file
$rows = array();

// Loop through each row in the result set and add the user details to the data rows array
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $user = array(
        $row["att_id"],
        $row["att_name"],
        $row["att_category"],
        $row["att_desc"],
        $row["att_location"],
        $row["att_opening"] . "-" . $row["att_closing"],
        $row["att_price"],
        $row["state_id"],
        $row["state_name"]
    );

    // Add the user details to the data rows array
    array_push($rows, $user);
}

// Close the connection
$conn = null;

// Set the content type and headers to force a download of the CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="attraction_report.csv"');
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
