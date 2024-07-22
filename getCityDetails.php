<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    if (isset($_GET["cid"])) {
        $cityId = $_GET["cid"];

        $city_rs = database::search("SELECT * FROM `city` 
                                     INNER JOIN `district` ON `city`.`district_id`=`district`.`id`
                                     INNER JOIN `provinces` ON `district`.`provinces_id`=`provinces`.`id`
                                     WHERE `city`.`id`='" . $cityId . "'");

        if ($city_rs->num_rows > 0) {
            $city_data = $city_rs->fetch_assoc();

            $response = array(
                "postCode" => $city_data["postalcode"],
                "district" => $city_data["district_name"],
                "province" => $city_data["province_name"],
                "status" => "success"
            );
        } else {
            $response = array(
                "status" => "error",
                "message" => "City not found"
            );
        }
    } else {
        $response = array(
            "status" => "error",
            "message" => "Invalid city ID"
        );
    }
    echo json_encode($response);
} else {
    header("Location:http://localhost/smart_asia/signin.php");
}
