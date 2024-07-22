<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $pid = $_POST["pid"];
    $percentage = $_POST["percentage"];

    if (!$pid) {
        echo "Please enter product id";
    } else if (!is_numeric($pid)) {
        echo "Invalid input for product id";
    } else if (!$percentage) {
        echo "Please enter offer percentage";
    } else if (!is_numeric($percentage)) {
        echo "Invalid input for offer percentage";
    } else if ($percentage <= 0) {
        echo "Offer percentage should be greater than zero";
    } else {

        $product_rs = Database::search("SELECT * FROM product WHERE product_id = '" . $pid . "'");
        if ($product_rs->num_rows == 1) {

            $offerItem_rs = Database::search("SELECT * FROM offer 
            INNER JOIN product ON offer.product_product_id = product.product_id 
            WHERE product_id = '" . $pid . "'");

            if ($offerItem_rs->num_rows == 1) {
                Database::iud("UPDATE `offer` SET `percentage`='" . $percentage . "' WHERE `product_product_id`='" . $pid . "'");
                echo "success";
            } else {
                Database::iud("INSERT INTO `offer` VALUES ('" . $pid . "','" . $percentage . "')");
                echo "success";
            }
        } else {
            echo "Products not matched for this product id";
        }
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
