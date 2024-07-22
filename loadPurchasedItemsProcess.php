<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $invoiceId = $_GET["invId"];

?>

    <div class="col-12 text-center bg-light p-3">
        <h5 class="fw-semibold">Invoice Details</h5>
        <span><?php echo $invoiceId; ?></span>
    </div>
    <div class="col-12 mt-3">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="border-bottom fw-bold">Product</th>
                    <th scope="col" class="border-bottom fw-bold">Price</th>
                    <th scope="col" class="border-bottom fw-bold">Quantity</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $invItem_rs = Database::search("SELECT * FROM invoice_item
                INNER JOIN product ON invoice_item.product_product_id = product.product_id
                WHERE invoice_item.invoice_invoice_id = '" . $invoiceId . "'");
                $invItem_num = $invItem_rs->num_rows;
                for ($l = 0; $l < $invItem_num; $l++) {
                    $invItem_data = $invItem_rs->fetch_assoc();

                    $img_rs = Database::search("SELECT * FROM product_image WHERE product_product_id = '" . $invItem_data["product_product_id"] . "'");
                    $img_data = [];
                    $row = $img_rs->fetch_assoc();
                    $img_data[] = $row;
                ?>
                    <tr id="purchasedItems">
                        <td class="border-bottom">
                            <img src="<?php echo $img_data[0]["path"] ?>" height="75px" width="75px" alt="">
                            <span><?php echo $invItem_data["title"]; ?></span>
                        </td>
                        <td class="border-bottom">Rs. <?php echo number_format($invItem_data["price"], 2); ?></td>
                        <td class="border-bottom"><?php echo $invItem_data["item_qty"]; ?></td>
                    </tr>
                <?php
                }

                ?>
            </tbody>
        </table>
    </div>  

<?php

} else {
    header("Location:http://localhost/smart_asia/index.php");
}
