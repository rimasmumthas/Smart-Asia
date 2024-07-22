<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $adminEmail = $_SESSION["admin"]["email"];

    $category = $_POST["category"];
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $condition = $_POST["condition"];
    $color = $_POST["color"];
    $quantity = $_POST["quantity"];
    $cost = $_POST["cost"];
    $deliveryFee = $_POST["deliveryFee"];
    $title = $_POST["title"];
    $description = $_POST["description"];

    if ($category == "0") {
        echo ("please select category");
    } else if ($brand == "0") {
        echo ("please select brand");
    } else if ($model == "0") {
        echo ("please select model");
    } else if ($condition == "0") {
        echo ("please select condition");
    } else if ($color == "0") {
        echo ("Please select color");
    } else if (empty($quantity)) {
        echo ("Please enter quantity");
    } else if (!is_numeric($quantity)) {
        echo ("Invalid input for quantity");
    } else if ($quantity == 0 | $quantity < 0) {
        echo ("Please enter valid quantity");
    } else if (empty($cost)) {
        echo ("Please enter price");
    } else if (!is_numeric($cost)) {
        echo ("Invalid input for price");
    } else if ($cost == 0 | $cost < 0) {
        echo ("Invalid input for price");
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
                $bhm_rs = database::search("SELECT * FROM `brand_has_model` where `brand_id`='" . $brand . "' AND `model_id`='" . $model . "'");
                $bhm_data = $bhm_rs->fetch_assoc();

                $d = new DateTime();
                $tz = new DateTimeZone("Asia/Colombo");
                $d->setTimezone($tz);
                $date = $d->format("Y-m-d H:i:s");

                database::iud("INSERT INTO `product`
                (`category_id`,`brand_has_model_id`,`color_id`,`condition_id`,`product_status_id`,`price`,`qty`,`title`,`description`,
                `delivery_fee`,`datetime_added`) VALUE ('" . $category . "','" . $bhm_data["id"] . "',
                '" . $color . "','" . $condition . "','1','" . $cost . "','" . $quantity . "','" . $title . "','" . $description . "',
                '" . $deliveryFee . "','" . $date . "')");

                $product_id = database::$connection->insert_id;

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
                    database::iud("INSERT INTO `product_image`(`path`,`product_product_id`) VALUES ('" . $file_name . "','" . $product_id . "')");
                }
                echo "success";
            } else {
                echo ("Invalid image type");
            }
        } else {
            echo ("Please select 1-3 images");
        }
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
