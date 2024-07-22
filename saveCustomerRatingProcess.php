<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $email = $_SESSION["user"]["email"];

    $stars = $_POST["starCount"];
    $text = $_POST["text"];

    if ($stars == 0) {
        echo "Please select stars";
    } else if (!$text) {
        echo "Please type your opinion";
    } else {

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        $rate_rs = Database::search("SELECT * FROM feedback WHERE user_email = '" . $email . "'");
        if ($rate_rs->num_rows == 1) {
            Database::iud("UPDATE feedback SET feed='" . $text . "', feed_datetime='" . $date . "', stars_count='" . $stars . "' WHERE user_email='" . $email . "'");
            echo "success";
        } else {
            Database::iud("INSERT INTO feedback (`feed`,`feed_datetime`,`stars_count`,`user_email`) VALUES ('" . $text . "','" . $date . "','" . $stars . "','" . $email . "')");
            echo "success";
        }
    }
} else {
    echo "login to continue";
}
