<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $invoiceId = $_GET["invId"];

?>

    <div class="col-12 text-center bg-white p-3 rounded-4">
        <span class="fw-bold">Ordered Products</span>
        <span>( <?php echo $invoiceId; ?> )</span>
    </div>
    <div class="col-12">
        <div class="w-100 mt-1 rounded-4 bg-white mt-3 p-2">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="border-bottom">#</th>
                        <th scope="col" class="border-bottom">Product Id</th>
                        <th scope="col" class="border-bottom">Product</th>
                        <th scope="col" class="border-bottom">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $order_rs = Database::search("SELECT * FROM invoice_item
                    INNER JOIN product ON invoice_item.product_product_id = product.product_id
                    WHERE invoice_item.invoice_invoice_id = '" . $invoiceId . "'");
                    $order_num = $order_rs->num_rows;
                    for ($l = 1; $l <= $order_num; $l++) {
                        $order_data = $order_rs->fetch_assoc();
                    ?>
                        <tr>
                            <td class="border-bottom"><?php echo $l; ?></td>
                            <td class="border-bottom"><?php echo $order_data["product_product_id"]; ?></td>
                            <td class="border-bottom"><?php echo $order_data["title"]; ?></td>
                            <td class="border-bottom"><?php echo $order_data["item_qty"]; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
?>