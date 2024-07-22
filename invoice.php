<?php

session_start();

if (isset($_SESSION["user"])) {

    require "connection.php";

    $user = $_SESSION["user"];
    $invoiceId = $_GET["inId"];
?>

    <!DOCTYPE html>

    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Invoice | Smart Asia</title>

        <link rel="stylesheet" href="resources/bootstrap/bootstrap.css">
        <link rel="stylesheet" href="resources/css/style.css" />
        <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/all.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="icon" href="resources/images/smart_asia_logo.jpg">

    </head>

    <body>

        <div class="container-fluid">
            <div class="row">

                <div class="col-12 d-flex flex-column align-items-center justify-content-center my-5 gap-3 p-3">
                    <div class="col-8 d-flex justify-content-between">
                        <button class="btn btn-light fw-bold" onclick="window.location='index.php'"><i class="fa-solid fa-circle-chevron-left pe-2"></i>Back to home</button>
                        <button class="defaultButton" onclick="printInvoice();"><i class="fa-regular fa-download pe-2"></i>Save Invoice</button>
                    </div>
                    <div class="col-8 d-flex flex-column border p-5" id="invoicePage">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <img src="resources/images/smart_asia_logo.jpg" height="120px">
                            <div class="w-50 text-white text-center p-3" style="background-color: var(--secondary-color); border-top-left-radius: 25px; border-bottom-right-radius: 25px;">
                                <span class="fs-2 fw-semibold">INVOICE</span>
                            </div>
                        </div>
                        <div class="col-12 mt-5 d-flex justify-content-between">
                            <div class="d-flex flex-column gap-1">
                                <span class="fw-semibold">Bill To </span>
                                <span><?php echo $user["fname"]; ?>&nbsp;<?php echo $user["lname"] ?></span>
                                <?php
                                $address_rs = Database::search("SELECT * FROM user_has_city 
                                INNER JOIN city ON user_has_city.city_id = city.id  WHERE user_email='" . $user["email"] . "'");
                                $address_data = $address_rs->fetch_assoc();
                                ?>
                                <span><?php echo $address_data["line1"]; ?> <?php echo $address_data["line2"]; ?></span>
                                <span><?php echo $address_data["city_name"]; ?> <?php echo $address_data["postalcode"]; ?></span>
                                <span><?php echo $user["email"]; ?></span>
                            </div>
                            <div class="d-flex flex-column gap-1">
                                <?php
                                $in_rs = Database::search("SELECT * FROM invoice WHERE invoice_id='" . $invoiceId . "'");
                                $in_data = $in_rs->fetch_assoc();
                                ?>
                                <span class="fw-semibold">Invoice</span>
                                <span><?php echo $in_data["invoice_id"]; ?></span>
                                <span><?php echo $in_data["datetime"]; ?></span>
                            </div>
                        </div>
                        <div class="col-12 mt-5">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border-bottom fw-bold">#</th>
                                        <th scope="col" class="border-bottom fw-bold w-50">Product</th>
                                        <th scope="col" class="border-bottom fw-bold">Price</th>
                                        <th scope="col" class="border-bottom fw-bold">Quantity</th>
                                        <th scope="col" class="border-bottom fw-bold">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0;
                                    $subTotal = 0;
                                    $in_item_rs = database::search("SELECT * FROM invoice_item WHERE invoice_invoice_id='" . $invoiceId . "'");
                                    for ($e = 1; $e <= $in_item_rs->num_rows; $e++) {
                                        $in_item_data = $in_item_rs->fetch_assoc();

                                        $pr_rs = Database::search("SELECT * FROM product WHERE product.product_id='" . $in_item_data["product_product_id"] . "'");
                                        $pr_data = $pr_rs->fetch_assoc();

                                    ?>
                                        <tr>
                                            <td class="border-bottom"><?php echo $e; ?></td>
                                            <td class="border-bottom">
                                                <span><?php echo $pr_data["title"] ?></span>
                                            </td>
                                            <td class="border-bottom">Rs. <?php echo number_format($pr_data["price"]) ?></td>
                                            <td class="border-bottom"><?php echo $in_item_data["item_qty"] ?></td>
                                            <td class="border-bottom">Rs. <?php echo number_format($in_item_data["item_qty"] * $pr_data["price"]) ?></td>
                                        </tr>
                                    <?php
                                        $subTotal +=  $in_item_data["item_qty"] * $pr_data["price"];
                                    }
                                    $delivery_fee = 450;
                                    $total = $subTotal + $delivery_fee;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 d-flex flex-column align-items-end mt-5">
                            <div class="col-4 d-flex justify-content-between gap-5">
                                <span>Sub Total</span>
                                <span>Rs. <?php echo number_format($subTotal) ?></span>
                            </div>
                            <div class="col-4 d-flex justify-content-between gap-5">
                                <span>Delivery Charges</span>
                                <span>Rs. <?php echo number_format($delivery_fee) ?></span>
                            </div>
                            <div class="col-4 border-bottom my-3"></div>
                            <div class="col-4 d-flex justify-content-between gap-5 fw-semibold">
                                <span class="fw-semibold">Total</span>
                                <span>Rs. <?php echo number_format($total) ?></span>
                            </div>
                        </div>
                        <div class="col-12 alert alert-info mt-5" role="alert">
                            Note : Invoice was created on a computer and is valid withoud the Signature and Seal.
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <script src="resources/js/script.js"></script>
        <script src="resources/bootstrap/bootstrap.bundle.js"></script>

    </body>

    </html>

<?php
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
?>