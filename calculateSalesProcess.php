<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $f = $_GET["format"];

    $query = "SELECT invoice_id FROM invoice";

    if ($f != "none") {
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format($f);

        $query .= " WHERE invoice.datetime LIKE '" . $date . "%'";
    }

    $sales = 0;

    $invoice_rs = database::search($query);
    $invoice_num = $invoice_rs->num_rows;

    for ($j = 0; $j < $invoice_num; $j++) {
        $invoice_data = $invoice_rs->fetch_assoc();

        $invoice_item_rs = Database::search("SELECT invoice_item.item_qty, product.price
        FROM invoice_item INNER JOIN product ON invoice_item.product_product_id = product.product_id
        WHERE invoice_item.invoice_invoice_id='" . $invoice_data['invoice_id'] . "'");
        while ($row = $invoice_item_rs->fetch_assoc()) {
            $sales += $row["item_qty"] * $row["price"];
        }
    }
    echo number_format($sales, 2);
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
