<?php
session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    if (isset($_FILES["image"])) {

        $image = $_FILES["image"];

        $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
        $file_ex = $image["type"];

        if (!in_array($file_ex, $allowed_image_extentions)) {
            echo "Please select a valid image";
        } else {

            $catName = $_POST["category"];
            $catId = $_POST["catId"];

            if (!$catName) {
                echo 'Please enter category name';
            } else {
                $new_file_extention;

                if ($file_ex == "image/jpg") {
                    $new_file_extention = ".jpg";
                } else if ($file_ex == "image/jpeg") {
                    $new_file_extention = ".jpeg";
                } else if ($file_ex == "image/png") {
                    $new_file_extention = ".png";
                } else if ($file_ex == "image/svg+xml") {
                    $new_file_extention = ".svg";
                }

                $file_name = "resources/category_images/" . $catName . "_" . uniqid() . $new_file_extention;
                move_uploaded_file($image["tmp_name"], $file_name);

                $cat_rs = database::search("SELECT * FROM `category` WHERE `id`='" . $catId . "'");
                $cat_data = $cat_rs->fetch_assoc();

                if (file_exists($cat_data["cat_path"])) {
                    if (unlink($cat_data["cat_path"])) {
                        database::iud("UPDATE `category` SET `cat_path`='" . $file_name . "',`cat_name`='" . $catName . "' WHERE 
                        `id`='" . $catId . "' ");
                    }
                }
                echo "success";
            }
        }
    } else {
        echo "Please select another image";
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
