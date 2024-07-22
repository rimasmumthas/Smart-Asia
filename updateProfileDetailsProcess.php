<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $password = $_POST["password"];
    $passwordPattern = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

    if (!$fname) {
        echo ("Please enter your first name");
    } else if (strlen($fname) > 45) {
        echo ("First name must be less than 45 characters");
    } else if (!$lname) {
        echo ("Please enter your last name");
    } else if (strlen($lname) > 45) {
        echo ("Last name must be less than 45 characters");
    } else if (!$password) {
        echo ("Please enter a password");
    } else if (!preg_match($passwordPattern, $password)) {
        echo ("Password must contain upper cases, lower cases, at least a digit, at least a speacial character, and minimum eight in length");
    } else {
        Database::search("UPDATE `user` SET `fname`='" . $fname . "',`lname`='" . $lname . "',`password`='" . $password . "' 
        WHERE `email`='" . $_SESSION["user"]["email"] . "'");
        echo 'success';
    }
} else {
    header("Location:http://localhost/smart_asia/signin.php");
}
