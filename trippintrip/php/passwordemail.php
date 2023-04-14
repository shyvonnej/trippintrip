<?php

session_start();

$user_email = $_POST['user_email'];

// Get the old, new, and confirm passwords from the form
if(isset($_POST['old_password'])) {
    $old_password = $_POST['old_password'];
}
if(isset($_POST['new_password'])) {
    $new_password = $_POST['new_password'];
}
if(isset($_POST['confirm_password'])) {
    $confirm_password = $_POST['confirm_password'];
}

// Define the database connection
include_once("dbconnect.php");

// Check if the old password is correct
$query = "SELECT * FROM tbl_users WHERE user_email = '$user_email'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) == 1) {
  $row = mysqli_fetch_assoc($result);
  $hashed_password = $row['user_password'];
  if (sha1($old_password) == $hashed_password) {

    // Check if the new and confirm passwords match
    if ($new_password == $confirm_password) {

      // Hash the new password
      $hashed_new_password = sha1($new_password);

      // Update the user's password in the database
      $query = "UPDATE tbl_users SET user_password = '$hashed_new_password' WHERE user_email = '$user_email'";
      $result = mysqli_query($conn, $query);

      // Check if the query was successful
      if ($result) {
        echo "Password changed successfully!";
      } else {
        echo "Error: " . mysqli_error($conn);
      }

    } else {
      echo "New password and confirm password do not match!";
    }

  } else {
    echo "Incorrect old password!";
  }
} else {
  echo "User not found!";
}

mysqli_close($conn);

?>
