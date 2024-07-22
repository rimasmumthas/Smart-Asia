<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $pid = $_GET["pid"];
    Database::search("DELETE FROM offer WHERE product_product_id='".$pid."'");
    echo "success";
    
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
