<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $email = $_SESSION["user"]["email"];
    $pid = $_GET["id"];

    $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `product_product_id`='" . $pid . "' AND `user_email`='" . $email . "'");
    $watchlist_num = $watchlist_rs->num_rows;

    if ($watchlist_num == 1) {
        echo ("This product already in your watchlist.");
    } else {
        Database::iud("INSERT INTO `watchlist`(`product_product_id`,`user_email`) VALUES ('" . $pid . "','" . $email . "')");
        echo ("success");
    }
} else {
    echo "please login";
}
