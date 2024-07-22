<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $adminEmail = $_SESSION["admin"]["email"];

    $length = sizeof($_FILES);

    if ($length !== 0) {

        $category = $_POST["category"];

        if (!$category) {
            echo "Please enter category name";
        } else {

            $category_rs = database::search("SELECT * FROM `category` WHERE `cat_name`='" . $category . "' ");

            if ($category_rs->num_rows > 0) {
                echo "Category already exists";
            } else {

                $image = $_FILES["image"];

                $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
                $file_ex = $image["type"];

                if (!in_array($file_ex, $allowed_image_extentions)) {
                    echo "Please select a valid image";
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

                    $file_name = "resources/category_images/" . $category . "_" . uniqid() . $new_file_extention;
                    move_uploaded_file($image["tmp_name"], $file_name);

                    database::iud("INSERT INTO `category` (`cat_path`,`cat_name`) VALUES 
                        ('" . $file_name . "','" . $category . "') ");

                    echo "success";
                }
            }
        }
    } else {
        echo "Please select an image for category";
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
