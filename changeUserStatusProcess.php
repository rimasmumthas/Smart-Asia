<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $email = $_GET["e"];

    $user_rs = database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' ");
    $user_num = $user_rs->num_rows;

    if ($user_num == 1) {

        $user_data = $user_rs->fetch_assoc();
        $status = $user_data["user_status_id"];
        if ($status == 1) {
            database::iud("UPDATE `user` SET `user_status_id`='2' WHERE `email`='" . $email . "' ");
            echo ("Deactivated");
        } else if ($status == 2) {
            database::iud("UPDATE `user` SET `user_status_id`='1' WHERE `email`='" . $email . "' ");
            echo ("Activated");
        }
    } else {
        echo ("Something went wrong.Please try again later.");
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
