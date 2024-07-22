<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    if (isset($_GET["id"])) {

        $email = $_SESSION["user"]["email"];
        $pid = $_GET["id"];

        $watchlist_rs = database::search("SELECT * FROM `watchlist` WHERE `product_product_id`='" . $pid . "' AND `user_email`='" . $email . "'");
        $watchlist_data = $watchlist_rs->fetch_assoc();
        database::iud("DELETE FROM `watchlist` WHERE `watchlist_id`='" . $watchlist_data["watchlist_id"] . "'");
        echo ("success");
    } else {
        echo ("Something went wrong");
    }
} else {
    header("Location:http://localhost/smart_asia/signin.php");
}
