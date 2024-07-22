<?php

require "connection.php";

session_start();

$email = $_POST["email"];
$password = $_POST["password"];
$rememberMe = $_POST["rememberMe"];

if (empty($email)) {
    echo ("Please enter your Email");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Please enter valid Email");
} else if (empty($password)) {
    echo ("Please enter your Password");
} else {

    $resultset = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' AND `password`='" . $password . "'");
    $rowCount = $resultset->num_rows;

    if ($rowCount == 1) {
        $user = $resultset->fetch_assoc();

        if ($user["user_status_id"] == "1") {

            $_SESSION['user'] = $user;

            if ($rememberMe == "true") {
                setcookie("email", $email, time() + (1 * 60 * 24 * 365));
                setcookie("password", $password, time() + (1 * 60 * 24 * 365));
            } else {
                setcookie("email", "", -1);
                setcookie("password", "", -1);
            }

            echo ("success");
        } else if ($user["user_status_id"] == "2") {
            echo ("Inactive user");
        }
    } else {
        echo ("Invalid User");
    }
}
