<?php
require "connection.php";

$email = $_POST['email'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$createPassword = $_POST['createPassword'];
$confirmPassword = $_POST['confrimPassword'];

$passwordPattern = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

if (!$email) {
    echo ("Please enter your email address");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Please enter a valid email address");
} else if (strlen($email) > 100) {
    echo ("Email address cannot be longer than 100 characters");
} else if (!$fname) {
    echo ("Please enter your first name");
} else if (strlen($fname) > 45) {
    echo ("First name must be less than 45 characters");
} else if (!$lname) {
    echo ("Please enter your last name");
} else if (strlen($lname) > 45) {
    echo ("Last name must be less than 45 characters");
} else if (!$createPassword) {
    echo ("Please create a password");
} else if (!preg_match($passwordPattern, $createPassword)) {
    echo ("Password must contain upper cases, lower cases, at least a digit, at least a speacial character, and minimum eight in length");
} else if (!$confirmPassword) {
    echo ("Please re-type password");
} else if ($createPassword !== $confirmPassword) {
    echo ("Both passwords should be same");
} else {

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    Database::search("UPDATE `user` SET `fname`='" . $fname . "',`lname`='" . $lname . "',`password`='" . $confirmPassword . "',`registered_date`='" . $date . "',`user_status_id`='1' 
    WHERE `email`='" . $email . "'");
    echo 'success';
}
