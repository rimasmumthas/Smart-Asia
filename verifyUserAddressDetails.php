<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    $results = Database::search("SELECT * FROM `user_has_city` WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");
    $num = $results->num_rows;
    if ($num > 0) {
        echo "success";
    } else {
        echo "Please fill address details in profile";
    }
} else {
    header("Location:http://localhost/smart_asia/signin.php");
}
