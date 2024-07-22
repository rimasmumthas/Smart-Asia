<?php

session_start();

if (isset($_SESSION["user"])) {
    $email = $_SESSION["user"]["email"];
?>

    <!DOCTYPE html>
    <html>

    <head>

        <title>Purchasing History | Smart Asia</title>

        <link rel="stylesheet" href="resources/bootstrap/bootstrap.css">
        <link rel="stylesheet" href="resources/css/style.css" />
        <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/all.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="icon" href="resources/images/smart_asia_logo.jpg">

    </head>

    <body>
        <div class="container-fluid">
            <div class="row">

                <?php
                include "header.php"
                ?>

                <div id="main-content-load-area-home">

                    <div class="col-12 p-2 mb-3 bg-light">
                        <div class="col-10 offset-1 ">
                            <i class="fa-solid fa-angles-right px-2"></i>
                            <span class="fw-bold">Purchasing History</span>
                        </div>
                    </div>

                    <div class="col-12 d-flex gap-3">
                        <div class="col-4 offset-1">
                            <?php
                            $inv_rs = database::search("SELECT * FROM invoice WHERE user_email = '" . $email . "' ORDER BY datetime DESC");
                            $inv_num = $inv_rs->num_rows;
                            if ($inv_num > 0) {
                            ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="border-bottom fw-bold">#</th>
                                            <th scope="col" class="border-bottom fw-bold">Invoice No</th>
                                            <th scope="col" class="border-bottom fw-bold">Invoice Date</th>
                                            <th scope="col" class="border-bottom fw-bold">Order Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for ($s = 1; $s <= $inv_num; $s++) {
                                            $inv_data = $inv_rs->fetch_assoc();
                                        ?>
                                            <tr class="purchasingHistoryRow" tabindex="0" onclick="viewPurchasedItems(<?php echo $inv_data['invoice_id'] ?>)">
                                                <td class="border-bottom"><?php echo $s; ?></td>
                                                <td class="border-bottom"><?php echo $inv_data['invoice_id']; ?></td>
                                                <td class="border-bottom"><?php echo $inv_data['datetime']; ?></td>
                                                <td class="border-bottom">
                                                    <?php
                                                    if ($inv_data["order_status_os_id"] == 1) {
                                                        echo "Order Placed";
                                                    } else {
                                                        echo "Order Delivered";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-6 border p-3 d-none" id="showPurchasedItemsArea"></div>
                    </div>

                </div>

                <?php include "footer.php" ?>

            </div>
        </div>

        <script src="resources/js/script.js"></script>
        <script src="resources/bootstrap/bootstrap.bundle.js"></script>

    </body>

    </html>

<?php
} else {
    header("Location:http://localhost/smart_asia/signin.php");
}
?>