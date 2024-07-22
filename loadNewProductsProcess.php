<?php
require "connection.php";

$nwe_rs = Database::search("SELECT * FROM product                                                 
                    INNER JOIN brand_has_model ON product.brand_has_model_id = brand_has_model.id
                    INNER JOIN brand ON brand_has_model.brand_id = brand.id
                    INNER JOIN model ON brand_has_model.model_id = model.id                              
                    INNER JOIN `condition` ON product.condition_id = `condition`.id ORDER BY product.datetime_added DESC");

$nwe_num = $nwe_rs->num_rows;

if ($nwe_num !== 0) {
?>

    <div class="col-12 d-flex flex-column align-items-center mb-3">
        <div class="col-11">
            <div class="col-12 p-2 mb-5 bg-light">
                <i class="fa-solid fa-sparkles fs-5 px-1"></i>
                <span class="fw-semibold">New Additions</span>
                <span class="badge rounded-pill text-bg-info">New</span>
            </div>
            <div class="col-12 p-2 my-3 d-flex">
                <div class="row justify-content-center gap-3">
                    <?php

                    for ($e = 0; $e < $nwe_num; $e++) {
                        $nwe_data = $nwe_rs->fetch_assoc();

                        $img_rs = Database::search("SELECT * FROM product_image WHERE product_product_id = '" . $nwe_data["product_id"] . "'");
                        $img_data = [];
                        $row = $img_rs->fetch_assoc();
                        $img_data[] = $row;
                    ?>
                        <div class="card p-3 itemCard" style="width: 200px;">
                            <img src="<?php echo $img_data[0]["path"] ?>" height="170px" class="card-img-top" alt="...">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="cartButton" onclick="addToWatchlist(<?php echo $nwe_data['product_id']; ?>);">
                                    <i class="fa-regular fa-heart-circle-plus fs-5"></i>
                                </button>
                                <button class="cartButton" onclick="singleProductView(<?php echo $nwe_data['product_id']; ?>);">
                                    <i class="fa-regular fa-cart-circle-plus fs-5"></i>
                                </button>
                            </div>
                            <div class="card-body p-0 mt-2" onclick="singleProductView(<?php echo $nwe_data['product_id']; ?>);">
                                <span class="card-title">
                                    <?php
                                    $productTitle;
                                    if (strlen($nwe_data["title"]) > 20) {
                                        // Subtract 5 from the total length
                                        $newLength =  20;
                                        // Use substr to get the substring of the new length
                                        $productTitle = substr($nwe_data["title"], 0, $newLength);
                                    } else {
                                        // If the string is 5 characters or less, return an empty string or the original string
                                        $productTitle = $nwe_data["title"];
                                    }
                                    echo $productTitle;
                                    ?>

                                </span>
                                <div class="card-text">
                                    <?php

                                    $offer_rs = Database::search("SELECT * FROM offer WHERE product_product_id = '" . $nwe_data["product_id"] . "'");
                                    $offer_num = $offer_rs->num_rows;

                                    if ($offer_num > 0) {
                                        $offer_data = $offer_rs->fetch_assoc();
                                        $price = $nwe_data["price"];
                                        $percentage = $offer_data["percentage"];
                                        $x = ($percentage / 100) - 1;
                                        $oldPrice = $price / $x;
                                    ?>
                                        <div>
                                            <span class="text-primary"><?php echo $percentage ?>% Off</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-decoration-line-through text-danger fw-normal">Rs.<?php echo  round($oldPrice); ?></span>
                                            <span class="fw-bold">Rs.<?php echo $price ?></span>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="d-flex justify-content-end align-items-center">
                                            <span class="fw-bold">Rs.<?php echo $nwe_data["price"] ?></span>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php
}
?>