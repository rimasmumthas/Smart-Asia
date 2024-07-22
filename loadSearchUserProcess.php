<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $searchText = $_GET["text"];

    $userDetails_rs = Database::search("SELECT * FROM user
                                    INNER JOIN user_profile ON user.email = user_profile.user_email                      
                                    INNER JOIN user_status ON user.user_status_id = user_status.id
                                    WHERE user.fname LIKE '%" . $searchText . "%' 
                                    OR user.lname LIKE '" . $searchText . "%'
                                    OR user.email LIKE '" . $searchText . "%'");

    $userDetails_num = $userDetails_rs->num_rows;

    for ($u = 1; $u <= $userDetails_num; $u++) {
        $userDetails_data = $userDetails_rs->fetch_assoc();

        $userAddress_rs = database::search("SELECT * FROM user_has_city 
                                        INNER JOIN city ON user_has_city.city_id = city.id
                                        INNER JOIN district ON city.district_id = district.id
                                        INNER JOIN provinces ON district.provinces_id = provinces.id WHERE user_email = '" . $userDetails_data["email"] . "'");
        $userAddress_data = $userAddress_rs->fetch_assoc();
?>

        <tr>
            <td class="border-bottom"><?php echo $u ?></td>
            <td class="border-bottom">
                <div class="d-flex gap-2">
                    <div>
                        <img src="<?php echo $userDetails_data["path"] ?>" height="65px" width="65px" alt="">
                    </div>
                    <div class="d-flex flex-column">
                        <span><?php echo $userDetails_data["fname"]; ?>&nbsp;<?php echo $userDetails_data["lname"]; ?></span>
                        <span class="fw-semibold"><?php echo $userDetails_data["email"]; ?></span>
                    </div>
                </div>
            </td>
            <td class="border-bottom">
                <div class="d-flex flex-column">
                    <span><?php echo $userDetails_data["registered_date"]; ?></span>
                </div>
            </td>
            <td class="border-bottom">
                <div class="d-flex flex-column">
                    <span><?php echo $userAddress_data["province_name"]; ?></span>
                    <span><?php echo $userAddress_data["district_name"]; ?></span>
                </div>
            </td>
            <td class="border-bottom">
                <div class="d-flex flex-column">
                    <span><?php echo $userAddress_data["line1"]; ?></span>
                    <span><?php echo $userAddress_data["line2"]; ?></span>
                    <span><?php echo $userAddress_data["city_name"]; ?></span>
                </div>
            </td>
            <td class="border-bottom">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" <?php if ($userDetails_data["status"] == "Active") { ?> checked <?php } ?> onclick="changeUserStatus('<?php echo $userDetails_data['email']; ?>');">
                </div>
            </td>
        </tr>
<?php
    }
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
