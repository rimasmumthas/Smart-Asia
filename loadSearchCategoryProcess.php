<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $searchText = $_GET["text"];

    $cat_rs = database::search("SELECT * FROM category WHERE cat_name LIKE '%" . $searchText . "%'");

    for ($a = 0; $a < $cat_rs->num_rows; $a++) {
        $cat_data = $cat_rs->fetch_assoc();
?>

        <tr>
            <td class="border-bottom"><?php echo $cat_data["id"] ?></td>
            <td class="border-bottom">
                <img src="<?php echo $cat_data["cat_path"] ?>" height="65px" width="65px" alt="">
            </td>
            <td class="border-bottom"><?php echo $cat_data["cat_name"] ?></td>
            <td class="border-bottom">
                <label class="text-primary fw-semibold">Update</label>
            </td>
        </tr>

<?php
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
