<?php

// Get the current user's ID
$user_id = $_SESSION['user_id'];

// Get the old, new, and confirm passwords from the form
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Check if the old password is correct
$query = "SELECT * FROM tbl_users WHERE id = '$user_id' AND password = '$old_password'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) == 1) {

  // Check if the new and confirm passwords match
  if ($new_password == $confirm_password) {

    // Update the user's password in the database
    $query = "UPDATE tbl_users SET password = '$new_password' WHERE id = '$user_id'";
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

?>
