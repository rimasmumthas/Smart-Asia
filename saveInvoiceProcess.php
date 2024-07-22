<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    if (isset($_GET["orderId"])) {

        $invoiceId = $_GET["orderId"];
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");
        $orderStatus = "1";
        $userEmail = $_SESSION["user"]["email"];

        $invoice_item_rs = Database::search("SELECT * FROM cart WHERE user_email='" . $userEmail . "'");
        $invoice_item_num = $invoice_item_rs->num_rows;

        if ($invoice_item_num > 0) {
            Database::iud("INSERT INTO invoice VALUES ('" . $invoiceId . "','" . $date . "','" . $orderStatus . "','" . $userEmail . "')");
            for ($x = 0; $x < $invoice_item_num; $x++) {
                $invoice_item_data = $invoice_item_rs->fetch_assoc();
                Database::iud("INSERT INTO invoice_item (`product_product_id`,`invoice_invoice_id`,`item_qty`) 
                VALUES ('" . $invoice_item_data["product_product_id"] . "','" . $invoiceId . "','" . $invoice_item_data["quantity"] . "')");
            }
            echo "success";
        }
    } else {
        echo "Something went wrong.";
    }
} else {
    header("Location:http://localhost/smart_asia/signin.php");
}
