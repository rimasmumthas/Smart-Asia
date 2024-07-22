<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $searchText = $_GET["text"];

    $offerProduct_rs = Database::search("SELECT * FROM offer 
        INNER JOIN product ON offer.product_product_id = product.product_id                               
        INNER JOIN brand_has_model ON product.brand_has_model_id = brand_has_model.id
        INNER JOIN brand ON brand_has_model.brand_id = brand.id
        INNER JOIN model ON brand_has_model.model_id = model.id                              
        INNER JOIN `condition` ON product.condition_id = `condition`.id 
        WHERE product.product_id LIKE '%" . $searchText . "%' 
        OR brand_name LIKE '%" . $searchText . "%' 
        OR model_name LIKE '%" . $searchText . "%' 
        OR title LIKE '%" . $searchText . "%'");

    for ($e = 0; $e < $offerProduct_rs->num_rows; $e++) {
        $offerProduct_data = $offerProduct_rs->fetch_assoc();
?>

        <tr>
            <td class="border-bottom"><?php echo $offerProduct_data["product_id"] ?></td>
            <td class="border-bottom">
                <div class="d-flex flex-column">
                    <span><?php echo $offerProduct_data["title"]; ?></span>
                    <span class="fw-semibold">Rs. <?php echo $offerProduct_data["price"]; ?></span>
                    <span><?php echo $offerProduct_data["condition_name"]; ?></span>
                </div>
            </td>
            <td class="border-bottom">
                <div class="d-flex flex-column">
                    <span><?php echo $offerProduct_data["brand_name"]; ?></span>
                    <span><?php echo $offerProduct_data["model_name"]; ?></span>
                </div>
            </td>
            <td class="border-bottom"><?php echo $offerProduct_data["percentage"] ?></td>
            <td class="border-bottom">
                <label class="text-danger fw-semibold" style="cursor: pointer;" onclick="deleteOffer(<?php echo $offerProduct_data['product_product_id'] ?>);">Delete</label>
            </td>
        </tr>

<?php
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
