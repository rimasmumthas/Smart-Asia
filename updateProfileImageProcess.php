<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    if (isset($_FILES["image"])) {

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

            $file_name = "resources/user_profile/" . $_SESSION["user"]["fname"] . "_" . uniqid() . $new_file_extention;

            move_uploaded_file($image["tmp_name"], $file_name);

            $image_rs = database::search("SELECT * FROM `user_profile` WHERE
            `user_email`='" . $_SESSION["user"]["email"] . "' ");
            $image_num = $image_rs->num_rows;

            if ($image_num == 0) {
                database::iud("INSERT INTO `user_profile` (`path`,`user_email`) VALUES 
                ('" . $file_name . "','" . $_SESSION["user"]["email"] . "') ");
            } else {
                $image_data = $image_rs->fetch_assoc();
                if (file_exists($image_data["path"])) {
                    if (unlink($image_data["path"])) {
                        database::iud("UPDATE `user_profile` SET `path`='" . $file_name . "' WHERE 
                        `user_email`='" . $_SESSION["user"]["email"] . "' ");
                    }
                }
            }
            echo "success";
        }
    } else {
        echo "no images found!";
    }
} else {
    header("Location:http://localhost/smart_asia/signin.php");
}
