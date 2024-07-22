<?php

session_start();

if (isset($_SESSION["user"])) {
    $email = $_SESSION["user"]["email"];
?>

    <!DOCTYPE html>
    <html>

    <head>

        <title>User Profile | Smart Asia</title>

        <link rel="stylesheet" href="resources/bootstrap/bootstrap.css">
        <link rel="stylesheet" href="resources/css/style.css" />

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css" integrity="sha512-X/RSQYxFb/tvuz6aNRTfKXDnQzmnzoawgEQ4X8nZNftzs8KFFH23p/BA6D2k0QCM4R0sY1DEy9MIY9b3fwi+bg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css" integrity="sha512-f28cvdA4Bq3dC9X9wNmSx21rjWI+5piIW/uoc2LuQ67asKxfQjUow2MkcCNcfJiaLrHcGbed1wzYe3dlY4w9gA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="icon" href="resources/images/smart_asia_logo.jpg">

    </head>

    <body>
        <div class="container-fluid">
            <div class="row">

                <?php
                include "header.php"
                ?>
                <div id="main-content-load-area-home">

                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-center align-items-center align-items-lg-start p-0 my-4 gap-4">
                        <div class="col-10 col-lg-4 border p-3">
                            <div class="col-12 border-bottom">
                                <h5 class="fw-bold"><i class="fa-duotone fa-user-tie fs-4 pe-2"></i>Profile Details</h5>
                            </div>
                            <?php

                            $user_rs = Database::search("SELECT *FROM `user` WHERE `email`='" . $email . "'");
                            $user_data = $user_rs->fetch_assoc();

                            ?>
                            <div class="col-12 my-4 d-flex flex-column align-items-center justify-content-center">
                                <?php

                                $user_profile_rs = Database::search("SELECT *FROM `user_profile` WHERE `user_email`='" . $email . "'");
                                $user_profile_num = $user_profile_rs->num_rows;

                                if ($user_profile_num != 0) {
                                    $user_profile_data = $user_profile_rs->fetch_assoc();
                                ?>
                                    <img src="<?php echo $user_profile_data["path"] ?>" height="150px" width="150px" class="rounded-circle" alt="" id="viewImage">
                                <?php
                                } else {
                                ?>
                                    <img src="resources/user_profile/images.png" height="150px" width="150px" class="rounded-circle" alt="" id="viewImage">
                                <?php
                                }

                                ?>

                                <input type="file" class="d-none" id="profileimg" accept="image/*" />
                                <label for="profileimg" class="defaultButton my-3">Update Image</label>
                                <span style="font-size: 12px;">Email : <?php echo $user_data["email"] ?></span>
                            </div>
                            <div class="alert alert-danger w-100 d-none" id="updateProfileDetailsError" role="alert"></div>
                            <div class="col-12 d-flex flex-column align-items-center">
                                <div class="col-8 my-2">
                                    <div class="w-100">
                                        <span class="fw-semibold">First Name</span>
                                    </div>
                                    <input type="text" class="verification-input w-100 mb-2" id="fname" value="<?php echo $user_data["fname"] ?>">
                                </div>
                                <div class="col-8 my-2">
                                    <div class="w-100">
                                        <span class="fw-semibold">Last Name</span>
                                    </div>
                                    <input type="text" class="verification-input w-100 mb-2" id="lname" value="<?php echo $user_data["lname"] ?>">
                                </div>
                                <div class="col-8 my-2">
                                    <div class="w-100">
                                        <span class="fw-semibold">Password</span>
                                    </div>
                                    <input type="password" class="verification-input w-100 mb-2" id="userPasswsord" value="<?php echo $user_data["password"] ?>">
                                </div>
                                <div class="col-8 d-flex justify-content-end">
                                    <button class="defaultButton" onclick="updateUserProfileDetails();">Update Profile</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-10 col-lg-4 border p-3">
                            <div class="col-12 border-bottom mb-2">
                                <h5 class="fw-bold"><i class="fa-regular fa-location-dot fs-4 pe-2"></i>Address Details</h5>
                            </div>
                            <?php
                            // Fetch user's city details from the database
                            $userCity_rs = database::search("SELECT * FROM user_has_city
                        INNER JOIN city ON user_has_city.city_id = city.id
                        INNER JOIN district ON city.district_id = district.id
                        INNER JOIN provinces ON district.provinces_id = provinces.id
                        WHERE user_has_city.user_email = '" . $_SESSION["user"]["email"] . "'");

                            // Check if user has a city record
                            $userCity_num = $userCity_rs->num_rows;
                            $line1 = "";
                            $line2 = "";
                            $usersCity = "0";
                            $userCityName = "select city";
                            $postCode = "none";
                            $district = "none";
                            $province = "none";
                            if ($userCity_num !== 0) {
                                $userCity_data = $userCity_rs->fetch_assoc();
                                $line1 = $userCity_data["line1"];
                                $line2 = $userCity_data["line2"];
                                $usersCity = $userCity_data["city_id"];
                                $userCityName = $userCity_data["city_name"];
                                $postCode = $userCity_data["postalcode"];
                                $district = $userCity_data["district_name"];
                                $province = $userCity_data["province_name"];
                            }
                            ?>

                            <div class="alert alert-danger w-100 d-none" id="updateAddressDetailsError" role="alert"></div>
                            <div class="col-12">
                                <div class="w-100">
                                    <span class="fw-semibold">Address Line 1</span>
                                </div>
                                <input type="text" class="verification-input w-100 mb-2" id="line1" value="<?php echo $line1 ?>">
                            </div>
                            <div class="col-12">
                                <div class="w-100">
                                    <span class="fw-semibold">Address Line 2</span>
                                </div>
                                <input type="text" class="verification-input w-100 mb-2" id="line2" value="<?php echo $line2 ?>">
                            </div>
                            <div class="col-12">
                                <div class="w-100">
                                    <span class="fw-semibold">City</span>
                                </div>
                                <div class="w-100 my-2">
                                   <select id="citySelection" name="city" style="width: 100%;">
                                        <option value="<?php echo $usersCity; ?>"><?php echo $userCityName; ?></option>
                                        <?php
                                        // Fetch all cities for dropdown
                                        $city_rs = Database::search("SELECT * FROM city");
                                        $city_num = $city_rs->num_rows;

                                        // Display each city in the dropdown
                                        for ($x = 0; $x < $city_num; $x++) {
                                             $city_data = $city_rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo $city_data["id"]; ?>"><?php echo $city_data["city_name"]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-evenly">
                                <span id="postCode">Post Code: <?php echo $postCode; ?></span>
                                <span id="district">District: <?php echo $district; ?></span>
                                <span id="province">Province: <?php echo $province; ?></span>
                            </div>
                            <div class="col-12 mt-3 d-flex justify-content-end">
                                <button class="defaultButton" onclick="updateUserAddress();">Update Address</button>
                            </div>
                            <div class="alert alert-warning mt-5" role="alert">
                                Note: Your orders will be delivered to this address by default, so please make sure to update your exact location.
                            </div>


                        </div>

                    </div>

                </div>

                <?php include "footer.php" ?>

            </div>
        </div>

        <script src="resources/js/script.js"></script>

        <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/all.css">

        <script src="resources/bootstrap/bootstrap.bundle.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#citySelection').select2();
            });
        </script>

    </body>

    </html>

<?php
} else {
    header("Location:http://localhost/smart_asia/signin.php");
}
?>