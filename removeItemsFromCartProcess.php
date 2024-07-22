<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    if (isset($_GET["id"])) {

        $email = $_SESSION["user"]["email"];
        $pid = $_GET["id"];

        $cart_rs = database::search("SELECT * FROM `cart` WHERE `product_product_id`='" . $pid . "' AND `user_email`='" . $email . "'");
        $cart_data = $cart_rs->fetch_assoc();
        database::iud("DELETE FROM `cart` WHERE `cart_id`='" . $cart_data["cart_id"] . "'");
        echo ("success");
    } else {
        echo ("Something went wrong");
    }
} else {
    header("Location:http://localhost/smart_asia/signin.php");
}
