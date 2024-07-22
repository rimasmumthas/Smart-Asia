<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $addressLine1 = $_POST["line1"];
    $addressLine2 = $_POST["line2"];
    $userCityId = $_POST["cityid"];

    if (!$addressLine1) {
        echo ("Please enter address line 1");
    } else if (!$addressLine2) {
        echo ("Please enter address line 2");
    } else if ($userCityId == 0) {
        echo ("Please select city");
    } else {

        $user_has_city_rs = Database::search("SELECT * FROM user_has_city WHERE user_email='" . $_SESSION["user"]["email"] . "'");
        if ($user_has_city_rs->num_rows == 0) {
            Database::iud("INSERT INTO user_has_city VALUES 
            ('" . $_SESSION["user"]["email"] . "','" . $userCityId . "','" . $addressLine1 . "','" . $addressLine2 . "')");
        } else {
            Database::iud("UPDATE user_has_city SET city_id='" . $userCityId . "', line1='" . $addressLine1 . "', line2='" . $addressLine2 . "' 
            WHERE user_email='" . $_SESSION["user"]["email"] . "'");
        }
        echo "success";
    }
} else {
    header("Location:http://localhost/smart_asia/signin.php");
}
