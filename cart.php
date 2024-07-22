<?php

session_start();

if (isset($_SESSION["user"])) {
    $email = $_SESSION["user"]["email"];
?>

    <!DOCTYPE html>
    <html>

    <head>

        <title>Cart | Smart Asia</title>

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
                        <div class="col-10 offset-1">
                            <i class="fa-solid fa-angles-right px-2"></i>
                            <span class="fw-bold">Shopping Cart</span>
                        </div>
                    </div>

                    <?php
                    $subTotal = 0;
                    $cart_rs = database::search("SELECT * FROM cart WHERE user_email='" . $email . "' ORDER BY cart_id DESC");

                    if ($cart_rs->num_rows > 0) {
                    ?>

                        <div class="col-12 d-flex gap-3">
                            <div class="col-7 offset-1 mt-3 rounded-4 bg-white">
                                <table class="table rounded-table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="border-bottom fw-bold">#</th>
                                            <th scope="col" class="border-bottom fw-bold w-50">Products</th>
                                            <th scope="col" class="border-bottom fw-bold">Price</th>
                                            <th scope="col" class="border-bottom fw-bold">Quantity</th>
                                            <th scope="col" class="border-bottom fw-bold">Total</th>
                                            <th scope="col" class="border-bottom fw-bold"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        for ($e = 1; $e <= $cart_rs->num_rows; $e++) {
                                            $cart_data = $cart_rs->fetch_assoc();

                                            $cartProduct_rs = Database::search("SELECT * FROM product WHERE product.product_id='" . $cart_data["product_product_id"] . "'");
                                            $cartProduct_data = $cartProduct_rs->fetch_assoc();

                                            $image_rs = database::search("SELECT * FROM `product_image` WHERE `product_product_id`='" . $cart_data["product_product_id"] . "'");
                                            $image_data = $image_rs->fetch_assoc();
                                        ?>
                                            <tr id="cartItemsRow">
                                                <td class="border-bottom"><?php echo $e; ?></td>
                                                <td class="border-bottom">
                                                    <img src="<?php echo $image_data["path"] ?>" height="75px" width="75px" alt="">
                                                    <span class="ps-3"><?php echo $cartProduct_data["title"] ?></span>
                                                </td>
                                                <td class="border-bottom">Rs. <?php echo number_format($cartProduct_data["price"]) ?></td>
                                                <td class="border-bottom">
                                                    <input type="number" style="width: 75px; height: 35px;" id="cartItemCount<?php echo  $cart_data["product_product_id"]; ?>" value="<?php echo $cart_data["quantity"] ?>" onchange="updateCartProducts(<?php echo $cartProduct_data['product_id']; ?>)" class="form-control shadow-none" min="0">
                                                </td>
                                                <td class="border-bottom">Rs. <?php echo number_format($cart_data["quantity"] * $cartProduct_data["price"]) ?></td>
                                                <td class="border-bottom"><i class="fa-light fa-xmark" onclick="removeItemFromCart(<?php echo $cartProduct_data['product_id']; ?>);"></i></td>
                                            </tr>
                                        <?php
                                            $subTotal += $cart_data["quantity"] * $cartProduct_data["price"];
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-3 mt-0 px-3">
                                <div class="col-12 bg-light p-5">
                                    <div class="col-12 fw-bold">Cart Total</div>
                                    <div class="col-12 mt-5 d-flex justify-content-between">
                                        <span class="fw-semibold">Sub Total</span>
                                        <span class="fw-semibold">Rs. <?php echo number_format($subTotal); ?></span>
                                    </div>
                                    <div class="col-12 mt-2 d-flex justify-content-between">
                                        <span class="fw-semibold">Delivery Fee</span>
                                        <span class="fw-semibold">Rs. <?php
                                                                        if ($subTotal == 0) {
                                                                            echo 0;
                                                                        } else {
                                                                            echo number_format(450);
                                                                        }
                                                                        ?></span>
                                    </div>
                                    <hr>
                                    <div class="col-12 mt-2 d-flex justify-content-between">
                                        <span class="fw-bold">Total</span>
                                        <span class="text-danger fw-bold">Rs. <?php
                                                                                if ($subTotal == 0) {
                                                                                    echo 0;
                                                                                } else {
                                                                                    echo number_format($subTotal + 450);
                                                                                }
                                                                                ?></span>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <?php
                                        $parameter = 0;
                                        if ($subTotal != 0) {
                                            $parameter = $subTotal + 450;
                                        }
                                        ?>
                                        <button class="defaultButton2 w-100 fw-semibold" type="submit" id="payhere-payment" onclick="verifyAddressDetails(<?php echo $parameter ?>);">PROCEED TO CHECKOUT</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                    } else {
                    ?>
                        <div class="col-12 p-3 d-flex flex-column justify-content-center align-items-center">
                            <img src="resources/images/noItemsFound.png" height="150" width="150">
                            <h5>Oops... No products found in your cart!</h5>
                            <button class="border-0 px-3 py-2 text-white fw-semibold" style="background-color: var(--primary-color);" onclick="window.location='index.php'">Add Products</button>
                        </div>
                    <?php
                    }
                    ?>

                </div>

                <?php include "footer.php" ?>

            </div>
        </div>

        <script src="resources/js/script.js"></script>
        <script src="resources/bootstrap/bootstrap.bundle.js"></script>
        <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

    </body>

    </html>

<?php
} else {
    header("Location:http://localhost/smart_asia/signin.php");
}
?>