<?php
require "connection.php";

$query = "SELECT * FROM offer 
                    INNER JOIN product ON offer.product_product_id = product.product_id                                                  
                    INNER JOIN brand_has_model ON product.brand_has_model_id = brand_has_model.id
                    INNER JOIN brand ON brand_has_model.brand_id = brand.id
                    INNER JOIN model ON brand_has_model.model_id = model.id                              
                    INNER JOIN `condition` ON product.condition_id = `condition`.id ORDER BY offer.percentage DESC";

if ("0" != ($_POST["page"])) {
    $pageno = $_POST["page"];
} else {
    $pageno = 1;
}

$product_rs = Database::search($query);
$product_num = $product_rs->num_rows;

$results_per_page = 12;
$number_of_pages = ceil($product_num / $results_per_page);

$page_results = ($pageno - 1) * $results_per_page;
$offerProduct_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");
$offerProduct_num = $offerProduct_rs->num_rows;

$offerProduct_num = $offerProduct_rs->num_rows;

if ($offerProduct_num !== 0) {
?>

    <div class="col-12 d-flex flex-column align-items-center mb-3">
        <div class="col-11">
            <div class="col-12 p-2 mb-5 bg-light">
                <i class="fa-regular fa-fire fs-5 px-1"></i>
                <span class="fw-semibold">Best Offers</span>
                <span class="badge rounded-pill text-bg-danger">Hot</span>
            </div>
            <div class="col-12 p-2 my-3 d-flex">
                <div class="row justify-content-center gap-3">
                    <?php

                    for ($e = 0; $e < $offerProduct_num; $e++) {
                        $offerProduct_data = $offerProduct_rs->fetch_assoc();

                        $img_rs = Database::search("SELECT * FROM product_image WHERE product_product_id = '" . $offerProduct_data["product_product_id"] . "'");
                        $img_data = [];
                        $row = $img_rs->fetch_assoc();
                        $img_data[] = $row;
                    ?>
                        <div class="card p-3 itemCard" style="width: 200px;">
                            <img src="<?php echo $img_data[0]['path'] ?>" height="170px" class="card-img-top" alt="...">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="cartButton" onclick="addToWatchlist(<?php echo $offerProduct_data['product_id']; ?>);">
                                    <i class="fa-regular fa-heart-circle-plus fs-5"></i>
                                </button>
                                <button class="cartButton" onclick="singleProductView(<?php echo $offerProduct_data['product_id']; ?>);">
                                    <i class="fa-regular fa-cart-circle-plus fs-5"></i>
                                </button>
                            </div>
                            <div class="card-body p-0 mt-2" onclick="singleProductView(<?php echo $offerProduct_data['product_id']; ?>);">
                                <span class="card-title">
                                    <?php
                                    $productTitle;
                                    if (strlen($offerProduct_data["title"]) > 20) {
                                        // Subtract 5 from the total length
                                        $newLength =  20;
                                        // Use substr to get the substring of the new length
                                        $productTitle = substr($offerProduct_data["title"], 0, $newLength);
                                    } else {
                                        // If the string is 5 characters or less, return an empty string or the original string
                                        $productTitle = $offerProduct_data["title"];
                                    }
                                    echo $productTitle;
                                    ?>

                                </span>
                                <div class="card-text">
                                    <?php
                                    $price = $offerProduct_data["price"];
                                    $percentage = $offerProduct_data["percentage"];
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

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" <?php if ($pageno <= 1) {
                                            echo ("#");
                                        } else {
                                        ?> onclick="loadBestOfferproducts(<?php echo ($pageno - 1) ?>);" <?php
                                                                                                        } ?> aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php

            for ($x = 1; $x <= $number_of_pages; $x++) {
                if ($x == $pageno) {
            ?>
                    <li class="page-item active">
                        <a class="page-link" onclick="loadBestOfferproducts(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="page-item">
                        <a class="page-link" onclick="loadBestOfferproducts(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                    </li>
            <?php
                }
            }

            ?>

            <li class="page-item">
                <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                            echo ("#");
                                        } else {
                                        ?> onclick="loadBestOfferproducts(<?php echo ($pageno + 1) ?>);" <?php
                                                                                                        } ?> aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

<?php
}
?>