<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $email = $_SESSION["user"]["email"];
    $pid = $_GET["id"];
    $qty = $_GET["qty"];

    if (!is_numeric($qty)) {
        echo ("Please enter quantity");
    } else if ($qty == 0 | $qty < 0) {
        echo ("Invalid input for quantity");
    } else {

        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_product_id`='" . $pid . "' AND `user_email`='" . $email . "'");
        $cart_num = $cart_rs->num_rows;

        $product_rs = Database::search("SELECT * FROM `product` WHERE `product_id`='" . $pid . "'");
        $product_data = $product_rs->fetch_assoc();
        $product_qty = $product_data["qty"];

        if ($cart_num == 1) {
            $cart_data = $cart_rs->fetch_assoc();

            if ($product_qty >= $qty) {
                Database::iud("UPDATE `cart` SET `quantity`='" . $qty . "' WHERE `cart_id`='" . $cart_data["cart_id"] . "'");
                echo ("success");
            } else {
                echo ("Not enough stock");
            }
        }
    }
} else {
    header("Location:http://localhost/smart_asia/signin.php");
}
