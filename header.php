<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="resources/css/style.css" />
    <link rel="stylesheet" href="resources/bootstrap/bootstrap.css">
</head>

<body>

    <?php require "connection.php" ?>
    <div class="col-12 sticky-top bg-white p-0">
        <div class="col-12 d-flex justify-content-between headerTopLine">
            <div class="d-flex align-items-center">
                <label>About Us</label>
                <label data-bs-toggle="modal" data-bs-target="#userRatingModal">Rate us</label>
            </div>
            <div class="d-flex">
                <?php

                if (isset($_SESSION["user"])) {
                    $data = $_SESSION["user"];
                ?>

                    <label class="text-white">Welcome <?php echo $data["fname"]; ?> </label>
                    <label class="text-white" onclick="userSignout();">Sign Out</label>

                <?php

                } else {

                ?>

                    <label onclick="window.location='signin.php'">Login Here</label>

                <?php
                }

                ?>
            </div>
        </div>

        <div class="col-12 d-flex">
            <div class="col-12 col-md-4 d-flex justify-content-between align-items-center px-md-3">
                <img src="resources/images/smart_asia_logo.jpg" height="80px" alt="Smart Asia Logo">
                <div class="dropdown d-none d-md-block">
                    <button class="btn btn-light border-secondary dropdown-toggle headerDrpdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        All Categories
                    </button>
                    <ul class="dropdown-menu">
                        <?php

                        $category_rs = database::search("SELECT * FROM `category`");
                        $category_num = $category_rs->num_rows;

                        for ($x = 0; $x < $category_num; $x++) {
                            $category_data = $category_rs->fetch_assoc();
                        ?>

                            <li onclick="loadSelectedCategory(<?php echo $category_data['id']; ?> ,'<?php echo $category_data['cat_name']; ?>');"><a class="dropdown-item" href="#" value="<?php echo $category_data["id"]; ?>"><?php echo $category_data["cat_name"] ?></a></li>

                        <?php
                        }

                        ?>

                    </ul>
                </div>

                <div class="d-flex justify-content-end align-items-center gap-3 d-md-none px-3">
                    <div class="dropdown">
                        <button class="btn btn-light border-secondary dropdown-toggle headerDrpdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            All Categories
                        </button>
                        <ul class="dropdown-menu">
                            <?php
                            $category_rs = database::search("SELECT * FROM `category`");
                            $category_num = $category_rs->num_rows;
                            for ($x = 0; $x < $category_num; $x++) {
                                $category_data = $category_rs->fetch_assoc();
                            ?>
                                <li onclick="loadSelectedCategory(<?php echo $category_data['id']; ?> ,'<?php echo $category_data['cat_name']; ?>');"><a class="dropdown-item" href="#" value="<?php echo $category_data["id"]; ?>"><?php echo $category_data["cat_name"] ?></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <button class="px-3 offcanvasButton" type="button" data-bs-toggle="offcanvas" data-bs-target="#headerOffcanvas" aria-controls="headerOffcanvas"><i class="fa-solid fa-bars fs-3"></i></button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center">
                <div class="input-group headerSearch">
                    <input type="text" class="form-control shadow-none" placeholder="Search entire store..." id="basicSearchInput1">
                    <button onclick="basicSearch(0);"><i class="fa-solid fa-magnifying-glass"></i>&nbsp; Search</button>
                </div>
            </div>
            <div class="col-4 d-none d-lg-flex justify-content-end gap-4 gap-md-3 align-items-center pe-3">
                <button class="btn btn-light d-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffCanvas" aria-controls="filterOffCanvas">
                    <i class="fa-regular fa-filter fs-5"></i>&nbsp;<label>Filter</label>
                </button>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        My Account
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="userProfile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="cart.php">Cart</a></li>
                        <li><a class="dropdown-item" href="watchlist.php">Watchlist</a></li>
                        <li><a class="dropdown-item" href="purchasingHistory.php">Purchasing History</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 d-block d-md-none d-flex align-items-center my-1">
            <div class="input-group headerSearch">
                <input type="text" class="form-control shadow-none" placeholder="Search entire store..." id="basicSearchInput2">
                <button onclick="basicSearch(0);"><i class="fa-solid fa-magnifying-glass"></i>&nbsp; Search</button>
            </div>
        </div>
        <div class="col-12 d-none d-lg-none d-md-flex justify-content-end gap-4 mb-3 pe-3 align-items-center">
            <button class="btn btn-light d-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffCanvas" aria-controls="filterOffCanvas">
                <i class="fa-regular fa-filter fs-5"></i>&nbsp;<label>Filter</label>
            </button>
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    My Account
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="userProfile.php">Profile</a></li>
                    <li><a class="dropdown-item" href="cart.php">Cart</a></li>
                    <li><a class="dropdown-item" href="watchlist.php">Watchlist</a></li>
                    <li><a class="dropdown-item" href="purchasingHistory.php">Purchasing History</a></li>
                </ul>
            </div>
        </div>
        <div class="col-12 d-none d-md-flex border headerItemsLine">
            <label onclick="location='index.php';">Home</label>
            <label onclick="loadBestOfferproducts(0);">Best Offers</label>
            <label onclick="loadNewProducts();">New Additions</label>
        </div>
        <div class="offcanvas offcanvas-start m-0 p-0" data-bs-scroll="true" tabindex="-1" id="headerOffcanvas" aria-labelledby="headerOffcanvas">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Navigation</h5>
                <button type="button" class="text-white bg-transparent border-0 shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-xmark fs-5"></i></button>
            </div>
            <div class="offcanvas-body d-flex flex-column m-0 p-0">
                <div class="col-12 d-flex align-items-center px-2 mb-2 text-white" style="background-color: var(--secondary-color); height: 45px;"><i class="fa-brands fa-slack fs-5"></i>&nbsp;Features</div>
                <div class="d-flex flex-column gap-2 px-2 mb-4 offcanvasFeatures">
                    <div>Filter</label></div>
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            My Account
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="userProfile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="cart.php">Cart</a></li>
                            <li><a class="dropdown-item" href="watchlist.php">Watchlist</a></li>
                            <li><a class="dropdown-item" href="purchasingHistory.php">Purchasing History</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 d-flex align-items-center px-2 text-white mb-2" style="background-color: var(--secondary-color); height: 45px;"><i class="fa-brands fa-gripfire fs-5"></i>&nbsp;Options</div>
                <div class="d-flex flex-column gap-2 px-2 offcanvasFeatures">
                    <label onclick="location='index.php';">Home</label>
                    <label onclick="loadBestOfferproducts();">Best Offers</label>
                    <label onclick="loadNewProducts();">New Additions</label>
                </div>
            </div>
        </div>
    </div>

    <!-- filter -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffCanvas" aria-labelledby="filterOffCanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title d-flex align-items-center" id="offcanvasRightLabel"><i class="fa-regular fa-filter pe-2"></i>Filter</h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="col-12 d-flex flex-column gap-3">
                <div class="col-12">
                    <div class="d-flex gap-2">
                        <input class="form-control shadow-none" type="text" placeholder="Min Price" id="minPrice">
                        <input class="form-control shadow-none" type="text" placeholder="Max Price" id="maxPrice">
                    </div>
                </div>
                <div class="col-12">
                    <select class="form-select shadow-none" id="selectedCategory" onchange="load_brand(document.getElementById('selectedCategory'),document.getElementById('selectedBrand'));">
                        <option value="0">Select Category</option>
                        <?php

                        $category_rs = database::search("SELECT * FROM `category`");
                        $category_num = $category_rs->num_rows;

                        for ($x = 0; $x < $category_num; $x++) {
                            $category_data = $category_rs->fetch_assoc();
                        ?>
                            <option value="<?php echo $category_data["id"]; ?>"><?php echo $category_data["cat_name"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12">
                    <select class="form-select shadow-none" id="selectedBrand" onchange="load_model(document.getElementById('selectedBrand'),document.getElementById('selectedModel'));">
                        <option value="0">Select Brand</option>
                    </select>
                </div>
                <div class="col-12">
                    <select class="form-select shadow-none" id="selectedModel">
                        <option value="0">Select Model</option>
                    </select>
                </div>
                <div class="col-12">
                    <select class="form-select shadow-none" id="selectedColor">
                        <option value="0">Select Color</option>
                        <?php
                        $color_rs = database::search("SELECT * FROM `color`");
                        $color_num = $color_rs->num_rows;
                        for ($x = 0; $x < $color_num; $x++) {
                            $color_data = $color_rs->fetch_assoc();
                        ?>
                            <option value="<?php echo $color_data["id"]; ?>"><?php echo $color_data["color_name"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12 d-flex flex-column">
                    <span>Condition</span>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input shadow-none" style="cursor: pointer;" type="radio" name="inlineRadioOptions" id="new" value="option1">
                            <label class="form-check-label" for="inlineRadio1">New</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input shadow-none" style="cursor: pointer;" type="radio" name="inlineRadioOptions" id="used" value="option2">
                            <label class="form-check-label" for="inlineRadio2">Used</label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <select class="form-select shadow-none" id="selectedOrder">
                        <option value="0">Price low to high</option>
                        <option value="1">Price high to low</option>
                        <option value="2">Quantity low to high</option>
                        <option value="3">Quantity high to low</option>
                    </select>
                </div>
                <div class="col-12">
                    <button class="defaultButton2 w-100" onclick="advanceSearch();">Search</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="userRatingModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Rate Us</h1>
                </div>
                <div class="modal-body">
                    <div class="rating-container col-12">
                        <div class="star-widget">
                            <input type="radio" name="rate" id="rate-5" value="5">
                            <label for="rate-5" class="fa-solid fa-star"></label>
                            <input type="radio" name="rate" id="rate-4" value="4">
                            <label for="rate-4" class="fa-solid fa-star"></label>
                            <input type="radio" name="rate" id="rate-3" value="3">
                            <label for="rate-3" class="fa-solid fa-star"></label>
                            <input type="radio" name="rate" id="rate-2" value="2">
                            <label for="rate-2" class="fa-solid fa-star"></label>
                            <input type="radio" name="rate" id="rate-1" value="1">
                            <label for="rate-1" class="fa-solid fa-star"></label>
                            <form>
                                <header></header>
                                <div class="textarea">
                                    <textarea class="form-control" rows="5" placeholder="Describe your experience.." id="userFeedBackSaying"></textarea>
                                </div>
                                <div class="btn-rate">
                                    <button type="button" onclick="saveCustomerRating();">Post</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>