<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $category = $_POST["category"];
    $brand = $_POST["brand"];

    if ($category == 0) {
        echo "Please select category";
    } else if (!$brand) {
        echo "Please enter brand name";
    } else {

        $cat_rs = Database::search("SELECT * FROM brand WHERE brand_name = '" . $brand . "' AND category_id = '" . $category . "'");
        if ($cat_rs->num_rows == 1) {
            echo "Same brand already exists with same category";
        } else {
            Database::iud("INSERT INTO brand (`brand_name`,`category_id`) VALUES ('" . $brand . "','" . $category . "')");
            echo "success";
        }
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
