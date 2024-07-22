<?php
require "connection.php";

$minPrice = $_POST["minPrice"];
$maxPrice = $_POST["maxPrice"];
$selectedCategory = $_POST["selectedCategory"];
$selectedBrand = $_POST["selectedBrand"];
$selectedModel = $_POST["selectedModel"];
$selectedColor = $_POST["selectedColor"];
$condition = $_POST["condition"];
$selectedOrder = $_POST["selectedOrder"];

$query = "SELECT * FROM product INNER JOIN brand_has_model ON product.brand_has_model_id = brand_has_model.id";
$status = 0;

if (!empty($minPrice) && empty($maxPrice)) {
    if ($status == 0) {
        $query .= " WHERE `price` >= '" . $minPrice . "' ";
        $status = 1;
    } else if ($status != 0) {
        $query .= " AND `price` >= '" . $pfrom . "' ";
    }
} else if (empty($minPrice) && !empty($maxPrice)) {
    if ($status == 0) {
        $query .= " WHERE `price` <= '" . $maxPrice . "' ";
        $status = 1;
    } else if ($status != 0) {
        $query .= " AND `price` <= '" . $maxPrice . "' ";
    }
} else if (!empty($minPrice) && !empty($maxPrice)) {
    if ($status == 0) {
        $query .= " WHERE `price` BETWEEN '" . $minPrice . "' AND '" . $maxPrice . "' ";
        $status = 1;
    } else if ($status != 0) {
        $query .= " AND `price` BETWEEN '" . $minPrice . "' AND '" . $maxPrice . "' ";
    }
}

if ($status == 0 && $selectedCategory != 0) {
    $query .= " WHERE `category_id`='" . $selectedCategory . "'";
    $status = 1;
} else if ($status != 0 && $selectedCategory != 0) {
    $query .= " AND `category_id`='" . $selectedCategory . "'";
}

if ($selectedBrand != 0 && $selectedModel == 0) {
    if ($status == 0) {
        $query .= " WHERE `brand_id`='" . $selectedBrand . "'";
        $status = 1;
    } else if ($status != 0) {
        $query .= " AND `brand_id`='" . $selectedBrand . "'";
    }
}

if ($selectedBrand == 0 && $selectedModel != 0) {
    if ($status == 0) {
        $query .= " WHERE `model_id`='" . $selectedModel . "'";
        $status = 1;
    } else if ($status != 0) {
        $query .= " AND `model_id`='" . $selectedModel . "'";
    }
}

if ($selectedBrand != 0 && $selectedModel != 0) {
    if ($status == 0) {
        $query .= " WHERE `brand_id`='" . $selectedBrand . "' AND `model_id`='" . $selectedModel . "'";
        $status = 1;
    } else if ($status != 0) {
        $query .= " AND `brand_id`='" . $selectedBrand . "' AND `model_id`='" . $selectedModel . "'";
    }
}

if ($status == 0 && $selectedColor != 0) {
    $query .= " WHERE `color_id`='" . $selectedColor . "'";
    $status = 1;
} else if ($status != 0 && $selectedColor != 0) {
    $query .= " AND `color_id`='" . $selectedColor . "'";
}

if ($status == 0 && $condition != 0) {
    $query .= " WHERE `condition_id`='" . $condition . "'";
    $status = 1;
} else if ($status != 0 && $condition != 0) {
    $query .= " AND `condition_id`='" . $condition . "'";
}


if ($selectedOrder == 0) {
    $query .= " ORDER BY `price` ASC";
} else if ($selectedOrder == 1) {
    $query .= " ORDER BY `price` DESC";
} else if ($selectedOrder == 2) {
    $query .= " ORDER BY `qty` ASC";
} else if ($selectedOrder == 3) {
    $query .= " ORDER BY `qty` DESC";
}

$product_rs = Database::search($query);
$product_num = $product_rs->num_rows;

if ($product_num == 0) {
?>
    <div class="col-12 p-3 d-flex flex-column justify-content-center align-items-center">
        <img src="resources/images/noItemsFound.png" height="150" width="150">
        <h5>Oops... No products matched!</h5>
    </div>

<?php
} else {
?>
    <div class="col-12 d-flex flex-column align-items-center justify-content-center">
        <div class="col-11 bg-light p-3 d-flex align-items-center">
            <i class="fa-solid fa-angles-right pe-2"></i>
            <span class="fw-semibold">Search Results</span>
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
                                <button class="cartButton">
                                    <i class="fa-regular fa-heart-circle-plus fs-5"></i>
                                </button>
                                <button class="cartButton">
                                    <i class="fa-regular fa-cart-circle-plus fs-5"></i>
                                </button>
                            </div>
                            <div class="card-body">
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