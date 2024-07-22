<?php
require "connection.php";

$catId = $_GET["catId"];
$catName = $_GET["catName"];

$product_rs = Database::search("SELECT * FROM product
INNER JOIN category ON product.category_id=category.id
WHERE category.id='" . $catId . "'");
$product_num = $product_rs->num_rows;

if ($product_num == 0) {
?>
    <div class="col-12 p-3 d-flex flex-column justify-content-center align-items-center">
        <img src="resources/images/noItemsFound.png" height="150" width="150">
        <h5>Oops... No products found!</h5>
    </div>

<?php
} else {
?>
    <div class="col-12 d-flex flex-column align-items-center justify-content-center">
        <div class="col-11 bg-light p-3 d-flex align-items-center">
            <i class="fa-solid fa-angles-right pe-2"></i>
            <span class="fw-semibold"><?php echo $catName; ?></span>
        </div>
        <div class="col-11 p-3">
            <div class="col-12 d-flex">
                <div class="row justify-content-center gap-3">
                    <?php
                    for ($a = 0; $a < $product_rs->num_rows; $a++) {
                        $product_data = $product_rs->fetch_assoc();

                        $image_rs = Database::search("SELECT * FROM product_image WHERE product_product_id='" . $product_data['product_id'] . "'");
                        $image_data = $image_rs->fetch_assoc();
                    ?>
                        <div class="card p-0 itemCard" style="width: 200px;">
                            <div class="p-3">
                                <img src="<?php echo $image_data["path"] ?>" height="170px" class="card-img-top" alt="...">
                            </div>
                            <div class="d-flex justify-content-end gap-2 px-2">
                                <button class="cartButton" onclick="addToWatchlist(<?php echo $product_data['product_id']; ?>);">
                                    <i class="fa-regular fa-heart-circle-plus fs-5"></i>
                                </button>
                                <button class="cartButton" onclick="singleProductView(<?php echo $product_data['product_id']; ?>);">
                                    <i class="fa-regular fa-cart-circle-plus fs-5"></i>
                                </button>
                            </div>
                            <div class="card-body" onclick="singleProductView(<?php echo $product_data['product_id']; ?>);">
                                <span class="card-title">
                                    <?php
                                    $productTitle;
                                    if (strlen($product_data["title"]) > 19) {
                                        // Subtract 5 from the total length
                                        $newLength =  18;
                                        // Use substr to get the substring of the new length
                                        $productTitle = substr($product_data["title"], 0, $newLength);
                                    } else {
                                        // If the string is 5 characters or less, return an empty string or the original string
                                        $productTitle = $product_data["title"];
                                    }
                                    echo $productTitle;
                                    ?>

                                </span>
                                <h6 class="card-text fw-bold text-end">Rs. <?php echo $product_data["price"]; ?></h6>
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