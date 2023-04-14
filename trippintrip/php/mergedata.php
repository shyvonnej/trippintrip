<?php
include_once("dbconnect.php");

// create an empty array to store the data
$data = array();

// join three tables
$sql = "SELECT tbl_users.*, tbl_personas.*, user_persona_preferences.*
        FROM tbl_users
        INNER JOIN user_persona_preferences ON tbl_users.user_id = user_persona_preferences.user_id
        INNER JOIN tbl_personas ON tbl_personas.persona_id = user_persona_preferences.persona_id";

// execute query
$result = mysqli_query($conn, $sql);

// check if any results were returned
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        // access the columns by their respective table names
        $user_id = $row['user_id'];
        $name = $row['user_name'];
        $email = $row['user_email'];
        $address = $row['user_address'];
        $phone_number = $row['user_phone'];
        $persona_id = $row['persona_id'];
        $name_persona = $row['name'];
        $persona_type = $row['persona_type'];
        $persona_activity = $row['prefered_activity'];
        $interest = $row['interests'];
        $accommodation_style = $row['accommodation'];
        $travel_style = $row['travel_style'];
        $budget = $row['budget'];
        $destination_preference = $row['destination_preferences'];
        
        // add the retrieved data to the array
        $data[] = array(
            "user_id" => $user_id,
            "name" => $name,
            "email" => $email,
            "address" => $address,
            "phone_number" => $phone_number,
            "persona_id" => $persona_id,
            "name_persona" => $name_persona,
            "persona_type" => $persona_type,
            "persona_activity" => $persona_activity,
            "interest" => $interest,
            "accommodation_style" => $accommodation_style,
            "travel_style" => $travel_style,
            "budget" => $budget,
            "destination_preference" => $destination_preference
        );
    }
} else {
    echo "0 results";
}

// close the database connection
mysqli_close($conn);

// send JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
