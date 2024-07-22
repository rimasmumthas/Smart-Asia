<?php
session_start();
require "connection.php";

if (isset($_GET["c"])) {

    $category_id = $_GET["c"];

    $brand_rs = database::search("SELECT * FROM `brand` WHERE `category_id` = '" . $category_id . "' ");
    $brand_num = $brand_rs->num_rows;

    if ($brand_num > 0) {
?>
        <option value="0">Select Brand</option>
        <?php
        for ($x = 0; $x < $brand_num; $x++) {

            $brand_data = $brand_rs->fetch_assoc();
        ?>
            <option value="<?php echo $brand_data["id"]; ?>"> <?php echo $brand_data["brand_name"]; ?> </option>
        <?php
        }
    } else {
        ?>
        <option value="0">Select Brand</option>
<?php
    }
}
?>