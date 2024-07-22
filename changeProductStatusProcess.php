<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $product = $_GET["p"];

    $product_rs = database::search("SELECT * FROM `product` WHERE `product_id`='" . $product . "' ");
    $product_num = $product_rs->num_rows;

    if ($product_num == 1) {

        $product_data = $product_rs->fetch_assoc();
        $status = $product_data["product_status_id"];
        if ($status == 1) {
            database::iud("UPDATE `product` SET `product_status_id`='2' WHERE `product_id`='" . $product . "' ");
            echo ("Deactivated");
        } else if ($status == 2) {
            database::iud("UPDATE `product` SET `product_status_id`='1' WHERE `product_id`='" . $product . "' ");
            echo ("Activated");
        }
    } else {
        echo ("Something went wrong.Please try again later.");
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
