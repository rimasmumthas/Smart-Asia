<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $searchText = $_GET["text"];

    $invoiceNumber = 0;
    $invoice_rs = database::search("SELECT * FROM invoice                                                   
                                        INNER JOIN order_status ON invoice.order_status_os_id = order_status.os_id 
                                        WHERE invoice.invoice_id LIKE '%" . $searchText . "%'
                                        ORDER BY `datetime` DESC ");
    $invoice_num = $invoice_rs->num_rows;

    for ($j = 1; $j <= $invoice_num; $j++) {
        $invoice_data = $invoice_rs->fetch_assoc();
?>
        <tr class="purchasingHistoryRow" tabindex="0" onclick="viewOrderedItems(<?php echo $invoice_data['invoice_id'] ?>)">
            <td class="border-bottom"><?php echo $j ?></td>
            <td class="border-bottom"><?php echo $invoice_data["invoice_id"] ?></td>
            <td class="border-bottom"><?php echo $invoice_data["datetime"] ?></td>
            <td class="border-bottom"><?php echo $invoice_data["user_email"] ?></td>
            <td class="border-bottom">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" <?php if ($invoice_data["order_status_name"] == "delivered") { ?> checked <?php } ?>>
                </div>
            </td>
        </tr>
<?php
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
