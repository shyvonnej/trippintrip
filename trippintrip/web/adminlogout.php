<?php

    session_start();

    unset($_SESSION["sessionid"]);
    unset($_SESSION["email"]);
    header("Location: adminlogin.php"); // might need to edit redirect loc later

?>