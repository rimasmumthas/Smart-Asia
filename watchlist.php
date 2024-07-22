<?php

session_start();

if (isset($_SESSION["user"])) {
    $email = $_SESSION["user"]["email"];
?>

    <!DOCTYPE html>
    <html>

    <head>

        <title>Watchlist | Smart Asia</title>

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
                            <span class="fw-bold">Watchlist</span>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-center">
                        <div class="col-7 mt-3">
                            <?php
                            $watch_rs = database::search("SELECT * FROM watchlist                           
                            INNER JOIN product ON watchlist.product_product_id = product.product_id
                            INNER JOIN brand_has_model ON product.brand_has_model_id = brand_has_model.id
                            INNER JOIN brand ON brand_has_model.brand_id = brand.id
                            INNER JOIN model ON brand_has_model.model_id = model.id
                            INNER JOIN color ON product.color_id = color.id
                            INNER JOIN `condition` ON product.condition_id = `condition`.id
                            INNER JOIN product_status ON product.product_status_id = product_status.id
                            WHERE watchlist.user_email ='" . $email . "' ORDER BY watchlist_id DESC");
                            $watch_num = $watch_rs->num_rows;

                            if ($watch_num > 0) {

                                for ($e = 0; $e < $watch_num; $e++) {
                                    $watch_data = $watch_rs->fetch_assoc();

                                    $offer_rs = Database::search("SELECT * FROM offer WHERE product_product_id = '" . $watch_data["product_product_id"] . "'");
                                    $offer_data = $offer_rs->fetch_assoc();

                                    $img_rs = Database::search("SELECT * FROM product_image WHERE product_product_id = '" . $watch_data["product_product_id"] . "'");
                                    $img_data = [];
                                    $row = $img_rs->fetch_assoc();
                                    $img_data[] = $row;

                            ?>

                                    <div class="col-12 d-flex justify-content-between mb-5">
                                        <div class="d-flex gap-5">
                                            <img src="<?php echo $img_data[0]["path"] ?>" height="200px" width="200px" alt="">
                                            <div>
                                                <h4 class="fw-semibold"><?php echo $watch_data["title"] ?></h4>
                                                <div class="col-12 d-flex align-items-center">
                                                    <div class="text-warning">
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-regular fa-star"></i>
                                                    </div>
                                                    <div class="ps-2">
                                                        <span>( 18 reviews )</span>
                                                    </div>
                                                </div>
                                                <div class="col-12 pt-3">
                                                    <?php
                                                    if (!empty($offer_data["percentage"])) {
                                                        $price = $watch_data["price"];
                                                        $percentage = $offer_data["percentage"];
                                                        $x = ($percentage / 100) - 1;
                                                        $oldPrice = $price / $x;

                                                    ?>
                                                        <span><?php echo $percentage ?> % Off</span>
                                                        <span class="text-decoration-line-through text-danger fs-5 ps-3"><?php echo number_format($oldPrice, 2) ?></span>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-12 pb-3">
                                                    <h4 class="fw-semibold">Rs. <?php echo number_format($watch_data["price"], 2) ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column justify-content-between">
                                            <div class="d-flex flex-column gap-1">
                                                <div class="d-flex gap-5">
                                                    <span class="fw-semibold w-25">Availability</span>
                                                    <span><?php echo $watch_data["qty"] ?> item(s) left</span>
                                                </div>
                                                <div class="d-flex gap-5">
                                                    <span class="fw-semibold w-25">Brand</span>
                                                    <span><?php echo $watch_data["brand_name"] ?></span>
                                                </div>
                                                <div class="d-flex gap-5">
                                                    <span class="fw-semibold w-25">Model</span>
                                                    <span><?php echo $watch_data["model_name"] ?></span>
                                                </div>
                                                <div class="d-flex gap-5">
                                                    <span class="fw-semibold w-25">Condition</span>
                                                    <span><?php echo $watch_data["condition_name"] ?></span>
                                                </div>
                                                <div class="d-flex gap-5">
                                                    <span class="fw-semibold w-25">Color</span>
                                                    <span><i class="fa-solid fa-circle pe-2" style="color: <?php echo $watch_data["color_name"] ?>;"></i><?php echo $watch_data["color_name"] ?></span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end gap-3">
                                                <button class="border-0 px-3 py-2 text-white fw-semibold" style="background-color: var(--secondary-color);" onclick="addToCart(<?php echo $watch_data['product_product_id'] ?>,1);">ADD TO CART <i class="fa-solid fa-cart-shopping ps-2"></i></button>
                                                <button class="border-0 px-3 py-2 text-white fw-semibold" style="background-color: var(--primary-color);" onclick="removeItemFromWatchlist(<?php echo $watch_data['product_product_id']; ?>);">REMOVE <i class="fa-solid fa-xmark ps-2"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                }
                            } else {
                                ?>
                                <div class="col-12 p-3 d-flex flex-column justify-content-center align-items-center">
                                    <img src="resources/images/noItemsFound.png" height="150" width="150">
                                    <h5>Oops... No products found in your watchlist!</h5>
                                    <button class="border-0 px-3 py-2 text-white fw-semibold" style="background-color: var(--primary-color);" onclick="window.location='index.php'">Add Products</button>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
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