<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $model = $_GET["model"];

    if (!$model) {
        echo "Please enter model name";
    } else {

        $model_rs = Database::search("SELECT * FROM model WHERE model_name = '" . $model . "'");
        if ($model_rs->num_rows == 1) {
            echo "Same model already exists";
        } else {
            Database::iud("INSERT INTO model (`model_name`) VALUES ('" . $model . "')");
            echo "success";
        }
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
