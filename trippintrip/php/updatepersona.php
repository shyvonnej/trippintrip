<?php
include_once("dbconnect.php");

// get the user_id and persona_id from the POST request
$user_id = $_POST['user_id'];
$persona_id = $_POST['persona_id'];

// check if the record already exists
$query = "SELECT * FROM user_persona_preferences WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$num_rows = mysqli_num_rows($result);

// if the record exists, update the persona_id, else insert a new record
if ($num_rows > 0) {
  $query = "UPDATE user_persona_preferences SET persona_id = $persona_id, updated_at = NOW() WHERE user_id = $user_id";
  if (mysqli_query($conn, $query)) {
    echo "Persona preference updated successfully";
  } else {
    echo "Error updating persona preference: " . mysqli_error($conn);
  }
} else {
  $query = "INSERT INTO user_persona_preferences (user_id, persona_id) VALUES ($user_id, $persona_id)";
  if (mysqli_query($conn, $query)) {
    echo "Persona preference added successfully";
  } else {
    echo "Error adding persona preference: " . mysqli_error($conn);
  }
}

// close the database connection
mysqli_close($conn);
?>
