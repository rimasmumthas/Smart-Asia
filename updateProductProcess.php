<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $adminEmail = $_SESSION["admin"]["email"];

    $pid = $_POST["pid"];
    $qty = $_POST["qty"];
    $deliveryFee = $_POST["deliveryFee"];
    $title = $_POST["title"];
    $description = $_POST["description"];

    if (empty($qty)) {
        echo ("Please enter quantity");
    } else if (!is_numeric($qty)) {
        echo ("Invalid input for quantity");
    } else if ($qty == 0 | $qty < 0) {
        echo ("Please enter quantity");
    } else if (empty($deliveryFee)) {
        echo ("Please enter delivery fee");
    } else if (!is_numeric($deliveryFee)) {
        echo ("Invalid input for delivery fee");
    } else if ($deliveryFee == 0 | $deliveryFee < 0) {
        echo ("Invalid input for delivery fee");
    } else if (empty($title)) {
        echo ("please enter a title");
    } else if (strlen($title <= 100)) {
        echo ("Title should have lower than 100 characters");
    } else if (empty($description)) {
        echo ("Please enter description");
    } else {

        $length = sizeof($_FILES);

        if ($length <= 3 && $length > 0) {

            $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
            $imageStatus = true;

            for ($x = 0; $x < $length; $x++) {
                if (isset($_FILES["image" . $x])) {
                    $img_file = $_FILES["image" . $x];
                    $file_extention = $img_file["type"];
                    if (!in_array($file_extention, $allowed_image_extentions)) {
                        $imageStatus = false;
                    }
                }
            }

            if ($imageStatus) {

                database::iud("UPDATE product 
                SET qty='" . $qty . "',title='" . $title . "',description='" . $description . "',delivery_fee='" . $deliveryFee . "' WHERE product_id='" . $pid . "'");

                $image_rs = database::search("SELECT * FROM `product_image` WHERE `product_product_id`='" . $pid . "' ");
                $image_num = $image_rs->num_rows;

                for ($c = 0; $c < $image_num; $c++) {
                    $image_data = $image_rs->fetch_assoc();
                    if (file_exists($image_data["path"])) {
                        if (unlink($image_data["path"])) {
                            Database::iud("DELETE FROM `product_image` WHERE `path`='" . $image_data["path"] . "'");
                        }
                    }
                }

                for ($y = 0; $y < $length; $y++) {

                    $img_file = $_FILES["image" . $y];
                    $file_extention = $img_file["type"];

                    $new_image_extention;
                    if ($file_extention == "image/jpg") {
                        $new_image_extention = ".jpg";
                    } else if ($file_extention == "image/jpeg") {
                        $new_image_extention = ".jpeg";
                    } else if ($file_extention == "image/png") {
                        $new_image_extention = ".png";
                    } else if ($file_extention == "image/svg+xml") {
                        $new_image_extention = ".svg";
                    }

                    $file_name = "resources//product_images//" . $title . "_" . $y . "_" . uniqid() . $new_image_extention;
                    move_uploaded_file($img_file["tmp_name"], $file_name);
                    Database::iud("INSERT INTO product_image (`path`,`product_product_id`) VALUES ('" . $file_name . "','" . $pid . "')");
                }
                echo "success";
            } else {
                echo ("Invalid image type");
            }
        } else {
            echo ("Please select 1-3 images");
        }
    }
}
