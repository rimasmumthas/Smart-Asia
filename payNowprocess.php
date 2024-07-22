<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $umail = $_SESSION["user"]["email"];
    $total = $_POST["total"];

    $array;
    $order_id = time();
    $amount = $total;
    $merchant_id = "1221155";
    $currency = "LKR";
    $merchant_secret = "NjY0NzI4Njg1NDA2MTkwMDg2MjEyODM3TYAxMTQyNTk0Nzk5NjI3";
    $fname = $_SESSION["user"]["fname"];
    $lname = $_SESSION["user"]["lname"];
    $hash = strtoupper(
        md5(
            $merchant_id .
                $order_id .
                number_format($amount, 2, '.', '') .
                $currency .
                strtoupper(md5($merchant_secret))
        )
    );

    $array["order_id"] = $order_id;
    $array["amount"] = $amount;
    $array["fname"] = $fname;
    $array["lname"] = $lname;
    $array["mail"] = $umail;
    $array["merchant_id"] = $merchant_id;
    $array["currency"] = $currency;
    $array["hash"] = $hash;

    echo json_encode($array);
} else {
    header("Location:http://localhost/smart_asia/signin.php");
}
