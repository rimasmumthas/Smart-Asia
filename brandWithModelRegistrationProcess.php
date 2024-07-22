<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $brand = $_GET["brand"];
    $model = $_GET["model"];

    if ($brand == 0) {
        echo "Please select brand";
    } else if ($model == 0) {
        echo "Please select model";
    } else {

        $bm_rs = Database::search("SELECT * FROM brand_has_model WHERE brand_id = '" . $brand . "' AND model_id='" . $model . "'");
        if ($bm_rs->num_rows == 1) {
            echo "Same brand with model already exists";
        } else {
            Database::iud("INSERT INTO brand_has_model (`brand_id`,`model_id`) VALUES ('" . $brand . "','" . $model . "')");
            echo "success";
        }
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
