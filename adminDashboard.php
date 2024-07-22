<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {
    $admin = $_SESSION["admin"];
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Admin Dashboard | Smart Asia</title>

        <link rel="stylesheet" href="resources/css/style.css" />
        <link rel="stylesheet" href="resources/bootstrap/bootstrap.css">
        <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/all.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <link rel="icon" href="resources/images/smart_asia_logo.jpg">

    </head>

    <body class="bg-light" onload="getSalesDetails();">

        <div class="col-12 vh-100 overflow-hidden d-flex">

            <!-- side panel -->
            <div class="side-panel-div p-3">
                <div class="h-100 p-3 d-flex flex-column justify-content-between side-panel">

                    <div>
                        <div class="d-flex justify-content-center gap-2 py-3 border-bottom border-secondary">
                            <h5>SMART ASIA</h5>
                            <span>&trade;</span>
                        </div>
                        <div class="d-flex align-items-start my-2">
                            <div class="nav flex-column nav-pills w-100" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link active" id="dashboard" data-bs-toggle="pill" data-bs-target="#v-pills-dashboard" value="Dashboard" onclick="headerChange(document.getElementById('dashboard').value);"><i class="fa-regular fa-grid-horizontal fs-3 pe-2"></i>Dashboard</button>
                                <button class="nav-link" id="productManagement" data-bs-toggle="pill" data-bs-target="#v-pills-products" value="Product Management" onclick="headerChange(document.getElementById('productManagement').value);"><i class="fa-light fa-box-open-full fs-5 pe-2"></i>Product management</button>
                                <button class="nav-link" id="userManagement" data-bs-toggle="pill" data-bs-target="#v-pills-users" value="User Management" onclick="headerChange(document.getElementById('userManagement').value);"><i class="fa-light fa-users fs-5 pe-2"></i>User Management</button>
                                <button class="nav-link" id="orderManagement" data-bs-toggle="pill" data-bs-target="#v-pills-orders" value="Order Management" onclick="headerChange(document.getElementById('orderManagement').value);"><i class="fa-light fa-users fs-5 pe-2"></i>Order Management</button>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-light fw-semibold d-flex justify-content-center align-items-center" onclick="adminLogOut();"><i class="fa-solid fa-left-from-bracket fs-5 pe-2"></i>Log Out</button>

                </div>
            </div>

            <!-- content loading area -->
            <div class="content-loading-area p-3 vh-100" id="content-load-area">

                <div class="col-12 mt-1 d-flex justify-content-between pb-2" id="area-header">
                    <span class="fs-4 fw-bold" id="headerTitle">Dashboard</span>
                    <div class="d-flex justify-content-end gap-4">
                        <span>Welcome! <b>Mohamed</b></span>
                        <i class="fa-solid fa-gear fs-5" data-bs-toggle="offcanvas" data-bs-target="#settingsOffcanvas" aria-controls="settingsOffcanvas"></i>
                        <i class="fa-solid fa-bell fs-5"></i>
                    </div>
                </div>

                <!-- content changing area -->
                <div class="tab-content overflow-scroll pe-3" id="v-pills-tabContent">

                    <!-- dashboard -->
                    <div class="tab-pane fade show active" id="v-pills-dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">

                        <div class="col-12 d-flex justify-content-between gap-3 mt-5">
                            <?php
                            $d = new DateTime();
                            $tz = new DateTimeZone("Asia/Colombo");
                            $d->setTimezone($tz);
                            ?>
                            <div class="countingBoxes p-3 ">
                                <div class="d-flex justify-content-between">
                                    <div class="bg-success text-white p-4 rounded-3 position-relative topIcon">
                                        <i class="fa-solid fa-sack-dollar fs-4"></i>
                                    </div>
                                    <div>
                                        <span class="fw-light">Today's sale</span>
                                        <h4 class="fw-semibold" id="todaySales"></h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-success fw-semibold text-end"><?php echo $d->format("D") . " " . $d->format("d") ?></div>
                            </div>
                            <div class="countingBoxes p-3 ">
                                <div class="d-flex justify-content-between">
                                    <div class="bg-warning text-white p-4 rounded-3 position-relative topIcon">
                                        <i class="fa-solid fa-box-open-full fs-4"></i>
                                    </div>
                                    <div>
                                        <span class="fw-light">This Month's sale</span>
                                        <h4 class="fw-semibold" id="thisMonthSale"></h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-warning fw-semibold text-end"><?php echo $d->format("M") ?></div>
                            </div>
                            <div class="countingBoxes p-3 ">
                                <div class="d-flex justify-content-between">
                                    <div class="bg-danger text-white p-4 rounded-3 position-relative topIcon">
                                        <i class="fa-solid fa-users fs-4"></i>
                                    </div>
                                    <div>
                                        <span class="fw-light">This Year's sale</span>
                                        <h4 class="fw-semibold" id="thisYearSale"></h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-danger fw-semibold text-end"><?php echo $d->format("Y") ?></div>
                            </div>
                            <div class="countingBoxes p-3 ">
                                <div class="d-flex justify-content-between">
                                    <div class="bg-info text-white p-4 rounded-3 position-relative topIcon">
                                        <i class="fa-solid fa-sack-dollar fs-4"></i>
                                    </div>
                                    <div>
                                        <span class="fw-light">Total sale</span>
                                        <h4 class="fw-semibold" id="totalSales"></h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-info fw-semibold text-end">2012 - <?php echo $d->format("Y") ?></div>
                            </div>
                        </div>
                        <div class="col-12 mt-3 rounded-4 d-flex justify-content-between gap-3">
                            <div class="chart1 p-5 bg-white rounded-4 d-flex flex-column align-items-center justify-content-center ">
                                <h6 class="fw-semibold">User's Interaction with Products</h6>
                                <canvas id="pieChart"></canvas>
                            </div>
                            <div class="chart2 p-5 bg-white rounded-4 d-flex flex-column align-items-center justify-content-center ">
                                <h6 class="fw-semibold">User registration </h6>
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>

                    </div>

                    <!-- products -->
                    <div class="tab-pane fade" id="v-pills-products" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">

                        <div class="col-12 d-flex justify-content-between align-items-center p-3 rounded-4" style="background-color:var(--secondary-color);">
                            <div class="form-floating productSearchBox">
                                <input type="text" class="form-control bg-transparent text-white rounded-4 shadow-none" autocomplete="off" id="searchProduct" placeholder="Smart Phones" onkeyup="searchProduct();">
                                <label for="floatingInput" class="text-white"><i class="fa-light fa-magnifying-glass pe-2"></i>Search products</label>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-light border-0 fw-semibold" data-bs-toggle="modal" data-bs-target="#addNewProductModal">
                                    Add new product
                                </button>
                                <button type="button" class="btn btn-light border-0 fw-semibold" data-bs-toggle="modal" data-bs-target="#productOfferModal">
                                    Product offers
                                </button>
                            </div>
                        </div>

                        <!-- table -->
                        <div class="col-12 mt-3 rounded-4 bg-white">
                            <table class="table rounded-table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border-bottom">Product Id</th>
                                        <th scope="col" class="border-bottom">Title & Price & Condition</th>
                                        <th scope="col" class="border-bottom">Brand & Model</th>
                                        <th scope="col" class="border-bottom">Category</th>
                                        <th scope="col" class="border-bottom">Color & Quantity</th>
                                        <th scope="col" class="border-bottom">Status</th>
                                        <th scope="col" class="border-bottom">Option</th>
                                    </tr>
                                </thead>
                                <tbody id="productLoadingArea">
                                    <?php
                                    $selected_rs = database::search("SELECT * FROM product
                                    INNER JOIN category ON product.category_id=category.id
                                    INNER JOIN brand_has_model ON product.brand_has_model_id = brand_has_model.id
                                    INNER JOIN brand ON brand_has_model.brand_id = brand.id
                                    INNER JOIN model ON brand_has_model.model_id = model.id
                                    INNER JOIN color ON product.color_id = color.id
                                    INNER JOIN `condition` ON product.condition_id = `condition`.id
                                    INNER JOIN product_status ON product.product_status_id = product_status.id");

                                    for ($a = 0; $a < $selected_rs->num_rows; $a++) {
                                        $selected_data = $selected_rs->fetch_assoc();
                                    ?>
                                        <tr>
                                            <td class="border-bottom"><?php echo $selected_data["product_id"]; ?></td>
                                            <td class="border-bottom">
                                                <div class="d-flex gap-2">
                                                    <?php
                                                    $productImge_rs = Database::search("SELECT * FROM product_image WHERE product_product_id = '" . $selected_data["product_id"] . "'");
                                                    $productImg_data = $productImge_rs->fetch_assoc();
                                                    ?>
                                                    <div>
                                                        <img src="<?php echo $productImg_data["path"] ?>" height="65px" width="65px" alt="">
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <span><?php echo $selected_data["title"]; ?></span>
                                                        <span class="fw-semibold">Rs. <?php echo $selected_data["price"]; ?></span>
                                                        <span><?php echo $selected_data["condition_name"]; ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-bottom">
                                                <div class="d-flex flex-column">
                                                    <span><?php echo $selected_data["brand_name"]; ?></span>
                                                    <span><?php echo $selected_data["model_name"]; ?></span>
                                                </div>
                                            </td>
                                            <td class="border-bottom"><?php echo $selected_data["cat_name"]; ?></td>
                                            <td class="border-bottom">
                                                <div class="d-flex flex-column">
                                                    <span><?php echo $selected_data["color_name"]; ?></span>
                                                    <span><?php echo $selected_data["qty"]; ?></span>
                                                </div>
                                            </td>
                                            <td class="border-bottom">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" <?php if ($selected_data["status_name"] == "Available") { ?> checked <?php } ?> onclick="changeProductStatus(<?php echo $selected_data['product_id']; ?>);">
                                                </div>
                                            </td>
                                            <td class="border-bottom">
                                                <label class="text-primary fw-semibold" onclick="viewUpdateProductModal(<?php echo $selected_data['product_id'] ?>)">Update</label>
                                            </td>
                                        </tr>

                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>

                    </div>

                    <!-- Manage Users-->
                    <div class="tab-pane fade" id="v-pills-users" role="tabpanel" aria-labelledby="v-pills-disabled-tab" tabindex="0">

                        <div class="col-12 d-flex justify-content-between align-items-center p-3 rounded-4" style="background-color:var(--secondary-color);">
                            <div class="form-floating productSearchBox">
                                <input type="text" class="form-control bg-transparent text-white rounded-4 shadow-none" autocomplete="off" id="searchUser" placeholder="User name" onkeyup="searchUser();">
                                <label for="floatingInput" class="text-white"><i class="fa-light fa-magnifying-glass pe-2"></i>Search users</label>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-light border-0 fw-semibold" onclick="loadBlockedUsers();">
                                    View Blocked Users
                                </button>
                            </div>
                        </div>

                        <!-- table -->
                        <div class="col-12 mt-1 rounded-4 bg-white mt-3">
                            <table class="table rounded-table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border-bottom">#</th>
                                        <th scope="col" class="border-bottom">Profile & Name & Email</th>
                                        <th scope="col" class="border-bottom">Registered Date</th>
                                        <th scope="col" class="border-bottom">Province & District</th>
                                        <th scope="col" class="border-bottom">Address & City</th>
                                        <th scope="col" class="border-bottom">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="usersLoadingArea">
                                    <?php
                                    $userDetails_rs = database::search("SELECT * FROM user
                                    INNER JOIN user_profile ON user.email = user_profile.user_email                      
                                    INNER JOIN user_status ON user.user_status_id = user_status.id");
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
                                    ?>

                                </tbody>
                            </table>

                        </div>

                    </div>

                    <!-- Orders -->
                    <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab" tabindex="0">

                        <div class="col-12 d-flex align-items-center p-3 rounded-4" style="background-color:var(--secondary-color);">
                            <div class="form-floating productSearchBox">
                                <input type="text" class="form-control bg-transparent text-white rounded-4 shadow-none" autocomplete="off" id="searchOrders" placeholder="Search Order" onkeyup="searchOrderedItems();">
                                <label for="floatingInput" class="text-white"><i class="fa-light fa-magnifying-glass pe-2"></i>Search invoice</label>
                            </div>
                        </div>

                        <div class="col-12 p-3 rounded-4 mt-3 bg-white d-flex align-items-end gap-3" style="box-shadow: 1px 1px 10px 1px rgba(0, 0, 0, 0.07);">
                            <div class="d-flex flex-column gap-1">
                                <span class="fw-semibold">From</span>
                                <input type="date" class="form-control shadow-none" id="orderFrom">
                            </div>
                            <div class="d-flex flex-column gap-1">
                                <span class="fw-semibold">To</span>
                                <input type="date" class="form-control shadow-none" id="orderTo">
                            </div>
                            <div class="d-flex flex-column gap-1">
                                <span class="fw-semibold">Order By</span>
                                <select class="form-select shadow-none" id="orderStatusBy">
                                    <option value="0">Select Model</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Delivered</option>
                                </select>
                            </div>
                            <div>
                                <button class="defaultButton2" onclick="loadOrdersByFilter();">Search</button>
                            </div>
                        </div>

                        <div class="col-12 d-flex gap-3">
                            <div class="w-75 mt-1 rounded-4 mt-3 p-2">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="border-bottom">#</th>
                                            <th scope="col" class="border-bottom">Invoice No</th>
                                            <th scope="col" class="border-bottom">Invoice Date</th>
                                            <th scope="col" class="border-bottom">User Email</th>
                                            <th scope="col" class="border-bottom">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ordersLoadingArea">
                                        <?php
                                        $invoiceNumber = 0;
                                        $invoice_rs = database::search("SELECT * FROM invoice                                                   
                                        INNER JOIN order_status ON invoice.order_status_os_id = order_status.os_id ORDER BY `datetime` DESC ");
                                        $invoice_num = $invoice_rs->num_rows;

                                        for ($j = 1; $j <= $invoice_num; $j++) {
                                            $invoice_data = $invoice_rs->fetch_assoc();
                                        ?>
                                            <tr class="purchasingHistoryRow" tabindex="0" onclick="viewOrderedItems(<?php echo $invoice_data['invoice_id'] ?>)">
                                                <td class="border-bottom"><?php echo $j ?></td>
                                                <td class="border-bottom"><?php echo $invoice_data["invoice_id"] ?></td>
                                                <td class="border-bottom"><?php echo $invoice_data["datetime"] ?></td>
                                                <td class="border-bottom"><?php echo $invoice_data["user_email"] ?></td>
                                                <td class="border-bottom">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" <?php if ($invoice_data["order_status_name"] == "delivered") { ?> checked <?php } ?>>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="w-50 mt-1 rounded-4 mt-3 p-2" id="showInvoiceItemsArea"></div>
                        </div>

                    </div>

                </div>

            </div>

            <!-- add product modal -->
            <div class="modal fade" id="addNewProductModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="staticBackdropLabel">Add New Product</h1>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">

                                <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                                    <div class="alert alert-danger w-100 d-none" id="addProductError" role="alert"></div>
                                    <span class="fw-semibold">Add product images</span>
                                    <div class="col-12 d-flex justify-content-center mt-2 gap-2">
                                        <div class="border border-secondary rounded-3 p-3">
                                            <img src="resources/product_images/add_image.svg" class="img-fluid" height="150px" width="150px" id="i0" />
                                        </div>
                                        <div class="border border-secondary rounded-3 p-3">
                                            <img src="resources/product_images/add_image.svg" class="img-fluid" height="150px" width="150px" id="i1" />
                                        </div>
                                        <div class="border border-secondary rounded-3 p-3">
                                            <img src="resources/product_images/add_image.svg" class="img-fluid" height="150px" width="150px" id="i2" />
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center my-3">
                                        <input type="file" class="d-none" id="imageuploader" multiple />
                                        <label for="imageuploader" class="defaultButton2" onclick="changeProductImage();">Upload Images</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="col-12 d-flex justify-content-between gap-2">
                                        <div class="addProductDivs p-1 p-md-3 d-flex flex-column gap-1 gap-md-2">
                                            <span class="fw-semibold">Select Category</span>
                                            <select class="form-select shadow-none" id="category" onchange="load_brand(document.getElementById('category'),document.getElementById('brand'));">
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
                                        <div class="addProductDivs p-1 p-md-3 d-flex flex-column gap-1 gap-md-2">
                                            <span class="fw-semibold">Select Brand</span>
                                            <select class="form-select shadow-none" id="brand" onchange="load_model(document.getElementById('brand'),document.getElementById('model'));">
                                                <option value="0">Select Brand</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="col-12 d-flex justify-content-between gap-2">
                                        <div class="addProductDivs p-1 p-md-3 d-flex flex-column gap-1 gap-md-2">
                                            <span class="fw-semibold">Select Model</span>
                                            <select class="form-select shadow-none" id="model">
                                                <option value="0">Select Model</option>
                                            </select>
                                        </div>
                                        <div class="addProductDivs p-1 p-md-3 d-flex flex-column gap-1 gap-md-2">
                                            <span class="fw-semibold">Select Condition</span>
                                            <select class="form-select shadow-none" id="condition">
                                                <option value="0">Select Condition</option>
                                                <?php
                                                $condition_rs = database::search("SELECT * FROM `condition`");
                                                $condition_num = $condition_rs->num_rows;
                                                for ($x = 0; $x < $condition_num; $x++) {
                                                    $condition_data = $condition_rs->fetch_assoc();
                                                ?>
                                                    <option value="<?php echo $condition_data["id"]; ?>"><?php echo $condition_data["condition_name"]; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="col-12 d-flex justify-content-between gap-2">
                                        <div class="addProductDivs p-1 p-md-3 d-flex flex-column gap-1 gap-md-2">
                                            <span class="fw-semibold">Select Color</span>
                                            <select class="form-select shadow-none" id="color">
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
                                        <div class="addProductDivs p-1 p-md-3 d-flex flex-column gap-1 gap-md-2">
                                            <span class="fw-semibold">Enter Quantity</span>
                                            <input type="text" class="form-control shadow-none" id="quantity">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="col-12 d-flex justify-content-between gap-2">
                                        <div class="addProductDivs p-1 p-md-3 d-flex flex-column gap-1 gap-md-2">
                                            <span class="fw-semibold">Cost Per Item</span>
                                            <input type="text" class="form-control shadow-none" id="cost">
                                        </div>
                                        <div class="addProductDivs p-1 p-md-3 d-flex flex-column gap-1 gap-md-2">
                                            <span class="fw-semibold">Delivery Cost per item</span>
                                            <input type="text" class="form-control shadow-none" id="deliveryFee">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-1 p-md-3 d-flex flex-column gap-1 gap-md-2">
                                        <span class="fw-semibold">Product Title</span>
                                        <input type="text" class="form-control shadow-none" id="title">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-1 p-md-3 d-flex flex-column gap-1 gap-md-2">
                                        <span class="fw-semibold">Product Description</span>
                                        <textarea class="form-control shadow-none" id="description" rows="5"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="defaultButton2" onclick="addProduct();">Save Product</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- update product modal -->
            <div class="modal fade" id="updateProductModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="staticBackdropLabel">Update Product</h1>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="updateProductModalBody">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="defaultButton2" onclick="updateProduct();">Update Product</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="offcanvas offcanvas-end p-3" tabindex="-1" id="settingsOffcanvas" aria-labelledby="settingsOffcanvas">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title fw-semibold" id="offcanvasRightLabel">Options</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="col-12 d-flex flex-column">
                        <div class="options" data-bs-toggle="modal" data-bs-target="#manageCategoryModal" onclick="bootstrap.Offcanvas.getInstance(document.getElementById('settingsOffcanvas')).hide()">
                            <i class="fa-solid fa-circle-right pe-2"></i>
                            <label id="manageCategories">Manage Categories</label>
                        </div>
                        <div class="options" data-bs-toggle="modal" data-bs-target="#manageBrandModal" onclick="bootstrap.Offcanvas.getInstance(document.getElementById('settingsOffcanvas')).hide()">
                            <i class="fa-solid fa-circle-right pe-2"></i>
                            <label>Manage Brands & Models</label>
                        </div>
                        <div class="options" data-bs-toggle="modal" data-bs-target="#colorModal" onclick="bootstrap.Offcanvas.getInstance(document.getElementById('settingsOffcanvas')).hide()">
                            <i class="fa-solid fa-circle-right pe-2"></i>
                            <label>Manage Colors</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manage category modal -->
            <div class="modal fade" id="manageCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="staticBackdropLabel">Manage Categories</h1>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">

                                <div class="col-12 d-flex justify-content-between align-items-center p-3 rounded-4" style="background-color:var(--secondary-color);">
                                    <div class="form-floating productSearchBox">
                                        <input type="text" class="form-control bg-transparent text-white rounded-4 shadow-none" autocomplete="off" id="searchcategory" placeholder="Smart Phones" onkeyup="searchCategory();">
                                        <label for="floatingInput" class="text-white"><i class="fa-light fa-magnifying-glass pe-2"></i>Search category</label>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-light border-0 fw-semibold" onclick="document.getElementById('newCategoryForm').className='col-12 my-3 border p-3'">
                                            Add new category
                                        </button>
                                    </div>
                                </div>

                                <!-- add new category -->
                                <div class="col-12 my-3 border p-3 d-none" id="newCategoryForm">
                                    <div class="col-12 d-flex align-items-center gap-1 mb-1">
                                        <i class="fa-solid fa-square-plus"></i>
                                        <span class="fw-semibold">Add New Category</span>
                                    </div>
                                    <div class="alert alert-danger w-100 d-none" id="addCategoryError" role="alert"></div>
                                    <div class="col-12 d-flex justify-content-center gap-3 my-2">
                                        <div>
                                            <div class="col-12 d-flex justify-content-center mt-2 gap-2">
                                                <div class="border border-secondary rounded-3 p-3">
                                                    <img src="resources/product_images/add_image.svg" class="img-fluid" height="150px" width="150px" id="imageView" />
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-center mt-3">
                                                <input type="file" class="d-none" id="imageuploader3" />
                                                <label for="imageuploader3" class="defaultButton2" onclick="changeCategoryImage();">Upload Image</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            <div>
                                                <span class="fw-semibold">Category Name</span>
                                                <input type="text" class="form-control shadow-none mt-1" id="cname">
                                            </div>
                                            <div>
                                                <button class="btn btn-success w-100" onclick="saveCategory()">Save Category</button>
                                            </div>
                                            <div>
                                                <button class="btn btn-dark w-100" onclick="document.getElementById('newCategoryForm').className='d-none'">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- update category -->
                                <div class="col-12 my-3 border p-3 d-none" id="updateCategoryform">

                                </div>

                                <!-- table -->
                                <div class="col-12 mt-3 rounded-4 bg-white">
                                    <table class="table rounded-table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="border-bottom">Category Id</th>
                                                <th scope="col" class="border-bottom">Category Image</th>
                                                <th scope="col" class="border-bottom">Category Name</th>
                                                <th scope="col" class="border-bottom">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody id="categoryLoadingArea">
                                            <?php
                                            $cat_rs = database::search("SELECT * FROM category");
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
                                                        <label class="text-primary fw-semibold" style="cursor: pointer;" onclick="viewUpdateCategoryForm(<?php echo $cat_data['id'] ?>);">Update</label>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- product offers modal -->
            <div class="modal fade" id="productOfferModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="staticBackdropLabel">Product Offers</h1>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">
                                <div class="alert alert-danger w-100 d-none" id="offerError" role="alert"></div>
                                <div class="col-12 d-flex justify-content-between align-items-center p-3 rounded-4" style="background-color:var(--secondary-color);">
                                    <div class="form-floating productSearchBox">
                                        <input type="text" class="form-control bg-transparent text-white rounded-4 shadow-none" autocomplete="off" id="searchOfferproduct" placeholder="Smart Phones" onkeyup="searchOfferProduct();">
                                        <label for="searchOfferproduct" class="text-white"><i class="fa-light fa-magnifying-glass pe-2"></i>Search products</label>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-light border-0 fw-semibold" onclick="document.getElementById('newOfferForm').className='col-12 my-3 border p-3'">
                                            Add Offer
                                        </button>
                                    </div>
                                </div>

                                <!-- add new offer -->
                                <div class="col-12 my-3 border p-3 d-none" id="newOfferForm">
                                    <div class="col-12 d-flex align-items-center gap-1 mb-1">
                                        <i class="fa-solid fa-square-plus"></i>
                                        <span class="fw-semibold">Add Offer</span>
                                    </div>
                                    <div class="alert alert-danger w-100 d-none" id="newOfferError" role="alert"></div>
                                    <div class="col-12 my-2">
                                        <div class="d-flex align-items-end gap-2">
                                            <div>
                                                <span>Product Id</span>
                                                <input type="text" class="form-control shadow-none mt-1" id="product-id">
                                            </div>
                                            <div>
                                                <span>Percentage</span>
                                                <input type="text" class="form-control shadow-none mt-1" id="percentage">
                                            </div>
                                            <div>
                                                <button class="btn btn-success w-100" onclick="saveOffer();">Save Offer</button>
                                            </div>
                                            <div>
                                                <button class="btn btn-dark w-100" onclick="document.getElementById('newOfferForm').className='d-none'">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- table -->
                                <div class="col-12 mt-3 rounded-4 bg-white">
                                    <table class="table rounded-table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="border-bottom">Product Id</th>
                                                <th scope="col" class="border-bottom">Title & Price & Condition</th>
                                                <th scope="col" class="border-bottom">Brand & Model</th>
                                                <th scope="col" class="border-bottom">Offer Percentage</th>
                                                <th scope="col" class="border-bottom">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productOfferLoadingArea">
                                            <?php
                                            $offer_rs = database::search("SELECT * FROM offer");
                                            for ($e = 0; $e < $offer_rs->num_rows; $e++) {
                                                $offer_data = $offer_rs->fetch_assoc();

                                                $offerProduct_rs = Database::search("SELECT * FROM product                                
                                                INNER JOIN brand_has_model ON product.brand_has_model_id = brand_has_model.id
                                                INNER JOIN brand ON brand_has_model.brand_id = brand.id
                                                INNER JOIN model ON brand_has_model.model_id = model.id                              
                                                INNER JOIN `condition` ON product.condition_id = `condition`.id 
                                                WHERE product.product_id='" . $offer_data["product_product_id"] . "'");
                                                $offerProduct_data = $offerProduct_rs->fetch_assoc();
                                            ?>
                                                <tr>
                                                    <td class="border-bottom"><?php echo $offer_data["product_product_id"] ?></td>
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
                                                    <td class="border-bottom"><?php echo $offer_data["percentage"] ?></td>
                                                    <td class="border-bottom">
                                                        <label class="text-danger fw-semibold" style="cursor: pointer;" onclick="deleteOffer(<?php echo $offer_data['product_product_id'] ?>);">Delete</label>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manage Brand modal -->
            <div class="modal fade" id="manageBrandModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="staticBackdropLabel">Manage Brand & Model</h1>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">

                                <!-- brand register -->
                                <div class="col-12">
                                    <div class="col-12 p-3 bg-light fw-bold fs-5">
                                        Register Brand
                                    </div>
                                    <div class="alert alert-danger w-100 d-none" id="brandRegisterError" role="alert"></div>
                                    <div class="col-12 d-flex gap-3 p-3">
                                        <div class="w-50 d-flex flex-column gap-1">
                                            <span class="fw-semibold">Select Category</span>
                                            <select class="form-select shadow-none" id="categoryregister">
                                                <option value="0">Select Category</option>
                                                <?php
                                                $category_rs2 = database::search("SELECT * FROM category");
                                                for ($n = 0; $n < $category_rs2->num_rows; $n++) {
                                                    $category_data2 = $category_rs2->fetch_assoc();
                                                ?>
                                                    <option value="<?php echo $category_data2["id"] ?>"><?php echo $category_data2["cat_name"] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="w-50 d-flex flex-column gap-1">
                                            <span class="fw-semibold">Enter Brand</span>
                                            <input type="text" class="form-control shadow-none" id="brandCategoryRegister">
                                        </div>
                                        <div class="w-25 d-flex align-items-end">
                                            <button class="defaultButton2 w-100" onclick="brandRegistration();">Save Brand</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- model register -->
                                <div class="col-12">
                                    <div class="col-12 p-3 bg-light fw-bold fs-5">
                                        Register Model
                                    </div>
                                    <div class="alert alert-danger w-100 d-none" id="modelRegisterError" role="alert"></div>
                                    <div class="col-12 d-flex gap-3 p-3">
                                        <div class="w-100 d-flex flex-column gap-1">
                                            <span class="fw-semibold">Enter Model</span>
                                            <input type="text" class="form-control shadow-none" id="modelRegister">
                                        </div>
                                        <div class="w-25 d-flex align-items-end">
                                            <button class="defaultButton2 w-100" onclick="modelRegistration();">Save Model</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- brand model register -->
                                <div class="col-12">
                                    <div class="col-12 p-3 bg-light fw-bold fs-5">
                                        Register Brand & Model
                                    </div>
                                    <div class="alert alert-danger w-100 d-none" id="brandWithModelError" role="alert"></div>
                                    <div class="col-12 d-flex gap-3 p-3">
                                        <div class="w-50 d-flex flex-column gap-1">
                                            <span class="fw-semibold">Select Brand</span>
                                            <select class="form-select shadow-none" id="brandWithCategory">
                                                <option value="0">Select Brand</option>
                                                <?php
                                                $brand_rs2 = database::search("SELECT brand_name, cat_name, brand.id AS brand_id FROM brand 
                                                INNER JOIN category ON brand.category_id = category.id");
                                                for ($n = 0; $n < $brand_rs2->num_rows; $n++) {
                                                    $brand_data2 = $brand_rs2->fetch_assoc();
                                                ?>
                                                    <option value="<?php echo $brand_data2["brand_id"] ?>"><?php echo $brand_data2["brand_name"] . " " . $brand_data2["cat_name"] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="w-50 d-flex flex-column gap-1">
                                            <span class="fw-semibold">Select Model</span>
                                            <select class="form-select shadow-none" id="modelWithBrandId">
                                                <option value="0">Select Model</option>
                                                <?php
                                                $model_rs2 = database::search("SELECT * FROM model");
                                                for ($n = 0; $n < $model_rs2->num_rows; $n++) {
                                                    $model_data2 = $model_rs2->fetch_assoc();
                                                ?>
                                                    <option value="<?php echo $model_data2["id"] ?>"><?php echo $model_data2["model_name"] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="w-25 d-flex align-items-end">
                                            <button class="defaultButton2 w-100" onclick="brandWithModelRegistration();">Save</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- color modal -->
            <div class="modal fade" id="colorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="staticBackdropLabel">Add New Color</h1>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 d-flex gap-3">
                                <div class="w-75 d-flex flex-column gap-1">
                                    <span class="fw-semibold">Enter Color</span>
                                    <input type="text" class="form-control shadow-none" id="saveColor">
                                </div>
                                <div class="w-25 d-flex align-items-end">
                                    <button class="defaultButton2 w-100" onclick="saveColor(document.getElementById('saveColor').value);">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script src="resources/js/script.js"></script>
        <script src="resources/bootstrap/bootstrap.bundle.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const pie = document.getElementById('pieChart');

            <?php
            $userCount_rs = Database::search("SELECT COUNT(*) AS user_count FROM user");
            $userCount_data = $userCount_rs->fetch_assoc();
            $usersCount = $userCount_data["user_count"];

            $cartCount_results = Database::search("SELECT COUNT(*) AS cart_item_count FROM cart");
            $cartCount_results_data = $cartCount_results->fetch_assoc();
            $cartCount = $cartCount_results_data["cart_item_count"];

            $watchlist_rs = Database::search("SELECT COUNT(*) AS watchlist_count FROM watchlist");
            $watchlist_data = $watchlist_rs->fetch_assoc();
            $watchlistCount = $watchlist_data["watchlist_count"];

            ?>

            new Chart(pie, {
                type: 'doughnut',
                data: {
                    labels: ['Users', 'Cart', 'Watchlist'],
                    datasets: [{
                        label: 'Total items',
                        data: [<?php echo $usersCount ?>, <?php echo $cartCount ?>, <?php echo $watchlistCount ?>],
                        backgroundColor: [
                            'rgb(75, 192, 192)',
                            'rgb(255, 205, 86)',
                            'rgb(54, 162, 235)'
                        ]
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const line = document.getElementById('lineChart');

            //calculate user registrations
            <?php

            $jan = 0;
            $feb = 0;
            $march = 0;
            $april = 0;
            $may = 0;
            $jun = 0;
            $jul = 0;
            $aug = 0;
            $sep = 0;
            $oct = 0;
            $nov = 0;
            $dec = 0;

            $d0 = new DateTime();
            $tz0 = new DateTimeZone("Asia/Colombo");
            $d0->setTimezone($tz0);

            $userReg_rs = Database::search("SELECT * FROM user WHERE registered_date LIKE '" . $d0->format("Y") . "%'");
            while ($userReg_data = $userReg_rs->fetch_assoc()) {
                $registerDate = $userReg_data["registered_date"];
                $d1 = new DateTime($registerDate);
                $tz1 = new DateTimeZone("Asia/Colombo");
                $d1->setTimezone($tz1);
                $month = $d1->format("n");

                if ($month == 1) {
                    $jan++;
                } else if ($month == 2) {
                    $feb++;
                } else if ($month == 3) {
                    $march++;
                } else if ($month == 4) {
                    $april++;
                } else if ($month == 5) {
                    $may++;
                } else if ($month == 6) {
                    $jun++;
                } else if ($month == 7) {
                    $jul++;
                } else if ($month == 8) {
                    $aug++;
                } else if ($month == 9) {
                    $sep++;
                } else if ($month == 10) {
                    $oct++;
                } else if ($month == 11) {
                    $nov++;
                } else if ($month == 12) {
                    $dec++;
                }
            }

            ?>

            new Chart(line, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Donations for 2024',
                        data: [
                            <?php echo $jan ?>,
                            <?php echo $feb ?>,
                            <?php echo $march ?>,
                            <?php echo $april ?>,
                            <?php echo $may ?>,
                            <?php echo $jun ?>,
                            <?php echo $jul ?>,
                            <?php echo $aug ?>,
                            <?php echo $sep ?>,
                            <?php echo $oct ?>,
                            <?php echo $nov ?>,
                            <?php echo $dec ?>,

                        ],
                        borderWidth: 2,
                        fill: false,
                        borderColor: '#088395',

                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: false,
                        }
                    }
                }
            });

            //set box height accurately
            var div1 = document.getElementById("content-load-area").offsetHeight;
            var div2 = document.getElementById("area-header").offsetHeight;
            var boxHeight = div1 - div2;
            document.getElementById("v-pills-tabContent").style.height = boxHeight + "px";
        </script>

    </body>

    </html>

<?php
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
?>