<?php

require "connection.php";

$email = $_POST["email"];
$createPassword = $_POST["createPassword"];
$confirmPassword = $_POST["confirmPassword"];

$passwordPattern = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

if (!$email) {
    echo ("Missing Email !!");
} else if (!$createPassword) {
    echo ("Please create a password");
} else if (!preg_match($passwordPattern, $createPassword)) {
    echo ("Password must contain upper cases, lower cases, at least a digit, at least a speacial character, and minimum eight in length");
} else if (!$confirmPassword) {
    echo ("Please re-type password");
} else if ($createPassword !== $confirmPassword) {
    echo ("Both passwords should be same");
} else {

    $rs = database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");
    $n = $rs->num_rows;

    if ($n == 1) {
        database::iud("UPDATE `user` SET `password`='" . $confirmPassword . "' WHERE `email`='" . $email . "' ");
        echo ("success");
    }
}
