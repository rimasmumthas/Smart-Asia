<?php
require "connection.php";

if (isset($_GET["id"])) {
    $pid = $_GET["id"];

    $product_rs = database::search("SELECT * FROM product
                                    INNER JOIN category ON product.category_id=category.id
                                    INNER JOIN brand_has_model ON product.brand_has_model_id = brand_has_model.id
                                    INNER JOIN brand ON brand_has_model.brand_id = brand.id
                                    INNER JOIN model ON brand_has_model.model_id = model.id
                                    INNER JOIN color ON product.color_id = color.id
                                    INNER JOIN `condition` ON product.condition_id = `condition`.id
                                    INNER JOIN product_status ON product.product_status_id = product_status.id 
                                    WHERE product.product_id = '" . $pid . "'");

    $product_num = $product_rs->num_rows;

    if ($product_num == 1) {
        $product_data = $product_rs->fetch_assoc();

        $offer_rs = Database::search("SELECT * FROM offer WHERE product_product_id = '" . $product_data["product_id"] . "'");
        $offer_data = $offer_rs->fetch_assoc();
?>

        <div class="col-12 d-flex justify-content-center mt-5">
            <div class="col-10 d-flex justify-content-evenly">

                <div class="col-6 d-flex gap-1">
                    <div class="col-3 d-flex flex-column gap-1">
                        <?php

                        $image_rs = database::search("SELECT * FROM `product_image` WHERE `product_product_id`='" . $pid . "'");
                        $image_num = $image_rs->num_rows;
                        $img = array();

                        if ($image_num != 0) {

                            for ($x = 0; $x < $image_num; $x++) {
                                $image_data = $image_rs->fetch_assoc();
                                $img[$x] = $image_data["path"];
                        ?>

                                <div class="border p-3">
                                    <img src="<?php echo $img["$x"]; ?>" height="100px" width="100%" id="productImg<?php echo $x; ?>" onclick="loadMainImg(<?php echo $x; ?>);">
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="col-9 d-flex flex-column gap-3">
                        <div class="col-12 d-flex justify-content-end p-5 border">
                            <img src="resources/product_images/addproductimg.svg" height="400px" width="100%" id="mainImage">
                        </div>
                    </div>
                </div>

                <div class="col-5 d-flex flex-column">
                    <div class="col-12">
                        <h3 class="fw-bold"><?php echo $product_data["title"] ?></h3>
                    </div>
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

                            $price = $product_data["price"];
                            $percentage = $offer_data["percentage"];
                            $x = ($percentage / 100) - 1;
                            $oldPrice = $price / $x;

                        ?>
                            <span><?php echo $percentage ?> % Off</span>
                            <span class="text-decoration-line-through text-danger fs-5 ps-3"><?php echo number_format($oldPrice) ?></span>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-12 pb-3">
                        <h4 class="fw-semibold">Rs. <?php echo number_format($product_data["price"], 2); ?></h4>
                    </div>
                    <div class="col-12">
                        <p>
                            <?php echo $product_data["description"] ?>
                        </p>
                    </div>
                    <div class="alert alert-danger w-100 d-none" id="addToCartError" role="alert"></div>
                    <div class="col-12 d-flex gap-2">
                        <div>
                            <input type="number" class="form-control shadow-none" id="addToCartQty" min="0" value="1">
                        </div>
                        <div>
                            <button class="defaultButton2" onclick="addToCart(<?php echo $product_data['product_id'] ?>,document.getElementById('addToCartQty').value);"><i class="fa-solid fa-cart-shopping"></i></button>
                            <i class="fa-solid fa-heart fs-5 ps-2"></i>
                        </div>
                    </div>
                    <hr class=" mt-5">
                    <div class="mt-5 d-flex flex-column gap-2">
                        <div class="d-flex gap-5">
                            <span class="fw-semibold w-25">Availability</span>
                            <span><?php echo $product_data["qty"] ?> items left</span>
                        </div>
                        <div class="d-flex gap-5">
                            <span class="fw-semibold w-25">Brand</span>
                            <span><?php echo $product_data["brand_name"] ?></span>
                        </div>
                        <div class="d-flex gap-5">
                            <span class="fw-semibold w-25">Model</span>
                            <span><?php echo $product_data["model_name"] ?></span>
                        </div>
                        <div class="d-flex gap-5">
                            <span class="fw-semibold w-25">Condition</span>
                            <span><?php echo $product_data["condition_name"] ?></span>
                        </div>
                        <div class="d-flex gap-5">
                            <span class="fw-semibold w-25">Color</span>
                            <span><i class="fa-solid fa-circle pe-2" style="color: <?php echo $product_data['color_name'] ?>;"></i><?php echo $product_data["color_name"] ?></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

<?php
    }
}
?>