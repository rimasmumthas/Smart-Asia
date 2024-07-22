<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $searchText = $_GET["text"];

    $product_rs = Database::search("SELECT * FROM product
                                    INNER JOIN category ON product.category_id=category.id
                                    INNER JOIN brand_has_model ON product.brand_has_model_id = brand_has_model.id
                                    INNER JOIN brand ON brand_has_model.brand_id = brand.id
                                    INNER JOIN model ON brand_has_model.model_id = model.id
                                    INNER JOIN color ON product.color_id = color.id
                                    INNER JOIN `condition` ON product.condition_id = `condition`.id
                                    INNER JOIN product_status ON product.product_status_id = product_status.id 
                                    WHERE product.title LIKE '%" . $searchText . "%' 
                                    OR category.cat_name LIKE '" . $searchText . "%'
                                    OR brand.brand_name LIKE '" . $searchText . "%'
                                    OR model.model_name LIKE '" . $searchText . "%'");

    for ($a = 0; $a < $product_rs->num_rows; $a++) {
        $product_data = $product_rs->fetch_assoc();
?>

        <tr>
            <td class="border-bottom"><?php echo $product_data["product_id"]; ?></td>
            <td class="border-bottom">
                <div class="d-flex gap-2">
                    <?php
                    $productImge_rs = Database::search("SELECT * FROM product_image WHERE product_product_id = '" . $product_data["product_id"] . "'");
                    $productImg_data = $productImge_rs->fetch_assoc();
                    ?>
                    <div>
                        <img src="<?php echo $productImg_data["path"] ?>" height="65px" width="65px" alt="">
                    </div>
                    <div class="d-flex flex-column">
                        <span><?php echo $product_data["title"]; ?></span>
                        <span class="fw-semibold">Rs. <?php echo $product_data["price"]; ?></span>
                        <span><?php echo $product_data["condition_name"]; ?></span>
                    </div>
                </div>
            </td>
            <td class="border-bottom">
                <div class="d-flex flex-column">
                    <span><?php echo $product_data["brand_name"]; ?></span>
                    <span><?php echo $product_data["model_name"]; ?></span>
                </div>
            </td>
            <td class="border-bottom"><?php echo $product_data["cat_name"]; ?></td>
            <td class="border-bottom">
                <div class="d-flex flex-column">
                    <span><?php echo $product_data["color_name"]; ?></span>
                    <span><?php echo $product_data["qty"]; ?></span>
                </div>
            </td>
            <td class="border-bottom">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" <?php if ($product_data["status_name"] == "Available") { ?> checked <?php } ?> onclick="changeProductStatus(<?php echo $product_data['product_id']; ?>);">
                </div>
            </td>
            <td class="border-bottom">
                <label class="text-primary fw-semibold" onclick="viewUpdateProductModal(<?php echo $product_data['product_id'] ?>)">Update</label>
            </td>
        </tr>
<?php
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
