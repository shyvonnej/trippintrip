<?php
    if (!isset($_POST)) {
        $response = array('status' => 'failed', 'data' => null);
        echo "failed";
        die();
    }

    include_once("dbconnect.php");

    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    $sqllogin = "SELECT * FROM tbl_users WHERE user_email = '$email' AND user_password = '$password'";

    $result = $conn->query($sqllogin);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userlist = array();
            $userlist['id'] = $row['user_id'];
            $userlist['email'] = $row['user_email'];
            $userlist['name'] = $row['user_name'];
            $userlist['phone'] = $row['user_phone'];
            $userlist['address'] = $row['user_address'];
            $userlist['otp'] = $row['otp'];
            $userlist['isProfileComplete'] = $row['isProfileComplete'] === "1" ? true : false;
            echo json_encode($userlist);
            $conn->close();
            return;
        }
    } else {
        echo "failed";
    }

    mysqli_close($conn);
?>