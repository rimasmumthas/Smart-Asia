<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $pid = $_GET["pid"];

    $product_rs = Database::search("SELECT * FROM product
                                    INNER JOIN category ON product.category_id=category.id
                                    INNER JOIN brand_has_model ON product.brand_has_model_id = brand_has_model.id
                                    INNER JOIN brand ON brand_has_model.brand_id = brand.id
                                    INNER JOIN model ON brand_has_model.model_id = model.id
                                    INNER JOIN color ON product.color_id = color.id
                                    INNER JOIN `condition` ON product.condition_id = `condition`.id
                                    INNER JOIN product_status ON product.product_status_id = product_status.id 
                                    WHERE product.product_id='" . $pid . "'");

    if ($product_rs->num_rows > 0) {
        $product_data = $product_rs->fetch_assoc();

        $img = array();
        $img[0] = "resources/product_images/add_image.svg";
        $img[1] = "resources/product_images/add_image.svg";
        $img[2] = "resources/product_images/add_image.svg";

        $itemImage_rs = Database::search("SELECT * FROM product_image WHERE product_product_id='" . $pid . "'");
        for ($d = 0; $d < $itemImage_rs->num_rows; $d++) {
            $itemImage_data = $itemImage_rs->fetch_assoc();
            $img[$d] = $itemImage_data["path"];
        }
?>
        <div class="col-12">
            <div class="col-12">
                <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                    <div class="alert alert-danger w-100 d-none" id="updateProductError" role="alert"></div>
                    <span class="fw-semibold">Update product images</span>
                    <div class="col-12 d-flex justify-content-center mt-2 gap-2">
                        <div class="border border-secondary rounded-3 p-3">
                            <img src="<?php echo $img[0]; ?>" class="img-fluid" height="150px" width="150px" id="z0" />
                        </div>
                        <div class="border border-secondary rounded-3 p-3">
                            <img src="<?php echo $img[1]; ?>" class="img-fluid" height="150px" width="150px" id="z1" />
                        </div>
                        <div class="border border-secondary rounded-3 p-3">
                            <img src="<?php echo $img[2]; ?>" class="img-fluid" height="150px" width="150px" id="z2" />
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center my-3">
                        <input type="file" class="d-none" id="imageuploader2" multiple />
                        <label for="imageuploader2" class="defaultButton2" onclick="changeUpdateProductImage();">Upload Images</label>
                    </div>
                </div>
                <div class="col-12 d-flex flex-column bg-light p-3">
                    <div class="col-12 d-flex justify-content-between mt-3">
                        <div class="col-3 d-flex flex-column">
                            <label class="fw-semibold">Product Id</label>
                            <span id="productId"><?php echo $product_data["product_id"] ?></span>
                        </div>
                        <div class="col-3 d-flex flex-column">
                            <label class="fw-semibold">Category</label>
                            <span><?php echo $product_data["cat_name"] ?></span>
                        </div>
                        <div class="col-3 d-flex flex-column">
                            <label class="fw-semibold">Brand</label>
                            <span><?php echo $product_data["brand_name"] ?></span>
                        </div>
                        <div class="col-3 d-flex flex-column">
                            <label class="fw-semibold">Model</label>
                            <span><?php echo $product_data["model_name"] ?></span>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between mt-3">
                        <div class="col-3 d-flex flex-column">
                            <label class="fw-semibold">Color</label>
                            <span><?php echo $product_data["color_name"] ?></span>
                        </div>
                        <div class="col-3 d-flex flex-column">
                            <label class="fw-semibold">Condition</label>
                            <span><?php echo $product_data["condition_name"] ?></span>
                        </div>
                        <div class="col-3 d-flex flex-column">
                            <label class="fw-semibold">Price</label>
                            <span><?php echo $product_data["price"] ?></span>
                        </div>
                        <div class="col-3 d-flex flex-column">
                            <label class="fw-semibold">Added Time</label>
                            <span><?php echo $product_data["datetime_added"] ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-between gap-2">
                    <div class="addProductDivs p-1 p-md-3 d-flex flex-column gap-1 gap-md-2">
                        <span class="fw-semibold">Quantity</span>
                        <input type="text" class="form-control shadow-none" value="<?php echo $product_data["qty"] ?>" id="updateQty">
                    </div>
                    <div class="addProductDivs p-1 p-md-3 d-flex flex-column gap-1 gap-md-2">
                        <span class="fw-semibold">Delivery Fee</span>
                        <input type="text" class="form-control shadow-none" value="<?php echo $product_data["delivery_fee"] ?>" id="updateDeliveryFee">
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-1 p-md-3 d-flex flex-column gap-1 gap-md-2">
                        <span class="fw-semibold">Product Title</span>
                        <input type="text" class="form-control shadow-none" value="<?php echo $product_data["title"] ?>" id="updateTitle">
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-1 p-md-3 d-flex flex-column gap-1 gap-md-2">
                        <span class="fw-semibold">Product Description</span>
                        <textarea class="form-control shadow-none" id="updateDescription" rows="5"><?php echo $product_data["description"] ?></textarea>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
