<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $color = $_GET["color"];

    if (!$color) {
        echo "Please enter color name";
    } else {

        $color_rs = Database::search("SELECT * FROM color WHERE color_name = '" . $color . "'");
        if ($color_rs->num_rows == 1) {
            echo "Same color name already exists";
        } else {
            Database::iud("INSERT INTO color (`color_name`) VALUES ('" . $color . "')");
            echo "success";
        }
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
