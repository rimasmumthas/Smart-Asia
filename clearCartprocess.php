<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $email = $_SESSION["user"]["email"];
    Database::iud("DELETE FROM cart WHERE user_email='" . $email . "'");
    echo "success";
} else {
    header("Location:http://localhost/smart_asia/signin.php");
}
