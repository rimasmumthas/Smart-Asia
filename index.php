<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Smart Asia</title>

    <link rel="stylesheet" href="resources/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="resources/css/style.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css" integrity="sha512-X/RSQYxFb/tvuz6aNRTfKXDnQzmnzoawgEQ4X8nZNftzs8KFFH23p/BA6D2k0QCM4R0sY1DEy9MIY9b3fwi+bg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css" integrity="sha512-f28cvdA4Bq3dC9X9wNmSx21rjWI+5piIW/uoc2LuQ67asKxfQjUow2MkcCNcfJiaLrHcGbed1wzYe3dlY4w9gA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="resources/images/smart_asia_logo.jpg">

</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php
            session_start();
            include "header.php";
            ?>

            <div id="main-content-load-area-home">
                <!--carousel-->
                <div class="col-12 m-0 p-0">
                    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active" data-bs-interval="3000">
                                <img src="resources/images/carousel_img_1.jpg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item" data-bs-interval="3000">
                                <img src="resources/images/carousel_img_2.jpg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item" data-bs-interval="3000">
                                <img src="resources/images/carousel_img_3.jpg" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <!--our specality-->
                <div class="col-12 d-flex justify-content-center align-items-center my-5 custom-pattern">
                    <div class="col-11 d-flex flex-column flex-lg-row justify-content-evenly align-items-start align-items-lg-center p-3">
                        <div class="d-flex justify-content-center align-items-center p-3 gap-3">
                            <i class="fa-thin fa-truck-bolt fa-bounce fs-1" style="color: var(--secondary-color);"></i>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold">Island-wide Next Day</span>
                                <span class="text-start text-lg-center">Delivery</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center p-3 gap-3">
                            <i class="fa-thin fa-message-smile fa-bounce fs-1" style="color: var(--secondary-color);"></i>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold">99% Customer</span>
                                <span class="text-start text-lg-center">Feedbacks</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center p-3 gap-3">
                            <i class="fa-thin fa-shield-check fa-bounce fs-1" style="color: var(--secondary-color);"></i>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold">Warranty Add-ons</span>
                                <span class="text-start text-lg-center">Available</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center p-3 gap-3">
                            <i class="fa-thin fa-credit-card-front fa-bounce fs-1" style="color: var(--secondary-color);"></i>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold">Leading Credit Cards</span>
                                <span class="text-start text-lg-center">& Cash on delivery</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center p-3 gap-3">
                            <i class="fa-thin fa-tag fa-bounce fs-1" style="color: var(--secondary-color);"></i>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold">Genuine Devices</span>
                                <span class="text-start text-lg-center">with Warranty</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex flex-column align-items-center mt-2 mb-5">
                    <div class="col-12 d-flex justify-content-center mb-5">
                        <div class="col-11 d-flex align-items-center p-2">
                            <i class="fa-regular fa-layer-group px-1"></i>
                            <span class="fw-semibold">Top Categories</span>
                        </div>
                    </div>
                    <div id="owl-demo" class="owl-carousel owl-theme col-11">
                        <?php
                        $category_rs = database::search("SELECT * FROM `category`");
                        $category_num = $category_rs->num_rows;
                        for ($x = 0; $x < $category_num; $x++) {
                            $category_data = $category_rs->fetch_assoc();
                        ?>
                            <div class="item d-flex flex-column align-items-center">
                                <div class="img-div" onclick="loadSelectedCategory(<?php echo $category_data['id']; ?> ,'<?php echo $category_data['cat_name']; ?>');"><img src="<?php echo $category_data["cat_path"] ?>" alt="Owl Image" /></div>
                                <div><?php echo $category_data["cat_name"] ?></div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                </div>

                <?php

                $query = "SELECT * FROM offer 
                    INNER JOIN product ON offer.product_product_id = product.product_id                                               
                    INNER JOIN brand_has_model ON product.brand_has_model_id = brand_has_model.id
                    INNER JOIN brand ON brand_has_model.brand_id = brand.id
                    INNER JOIN model ON brand_has_model.model_id = model.id                              
                    INNER JOIN `condition` ON product.condition_id = `condition`.id ORDER BY offer.percentage DESC";

                $pageno;

                if (isset($_GET["page"])) {
                    $pageno = $_GET["page"];
                } else {
                    $pageno = 1;
                }

                $offer_rs = Database::search($query);
                $offer_num = $offer_rs->num_rows;

                $results_per_page = 12;
                $number_of_pages = ceil($offer_num / $results_per_page);

                $page_results = ($pageno - 1) * $results_per_page;
                $offerProduct_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

                $offerProduct_num = $offerProduct_rs->num_rows;

                if ($offerProduct_num !== 0) {
                ?>

                    <div class="col-12 d-flex flex-column align-items-center mb-3">
                        <div class="col-11">
                            <div class="col-12 p-2 mb-5">
                                <i class="fa-regular fa-fire fs-5 px-1"></i>
                                <span class="fw-semibold">Best Offers</span>
                                <span class="badge rounded-pill text-bg-danger">Hot</span>
                            </div>
                            <div class="col-12 p-2 my-3 d-flex">
                                <div class="row justify-content-center gap-3">
                                    <?php

                                    for ($e = 0; $e < $offerProduct_num; $e++) {
                                        $offerProduct_data = $offerProduct_rs->fetch_assoc();
                                        $img_rs = Database::search("SELECT * FROM product_image WHERE product_product_id = '" . $offerProduct_data["product_id"] . "'");
                                        $img_data = [];
                                        $row = $img_rs->fetch_assoc();
                                        $img_data[] = $row;

                                    ?>
                                        <div class="card p-3 itemCard" style="width: 200px;">
                                            <img src="<?php echo $img_data[0]["path"] ?>" height="170px" class="card-img-top">
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

                        <!--pagination-->
                        <nav class="col-12 d-flex justify-content-center">
                            <ul class="pagination">
                                <?php
                                if ($pageno <= 1) {
                                ?>
                                    <li class="page-item disabled">
                                        <a class="page-link shadow-none shadow-none">&laquo;</a>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="page-item">
                                        <a class="page-link shadow-none" href="?page=<?php echo $pageno - 1; ?>">&laquo;</a>
                                    </li>
                                <?php
                                }

                                for ($page = 1; $page <= $number_of_pages; $page++) {
                                ?>
                                    <li class="page-item <?php if ($page == $pageno) echo 'active'; ?>">
                                        <a class="page-link shadow-none" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                                    </li>
                                <?php
                                }

                                if ($pageno >= $number_of_pages) {
                                ?>
                                    <li class="page-item disabled">
                                        <a class="page-link shadow-none">&raquo;</a>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="page-item">
                                        <a class="page-link shadow-none" href="?page=<?php echo $pageno + 1; ?>">&raquo;</a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </nav>

                    </div>

                <?php
                }
                ?>

                <div class="col-12 my-5 d-flex flex-column flex-lg-row justify-content-center align-items-center gap-5 ourAchievement">
                    <div class="col-11 col-lg-5">
                        <img src="resources/images/web-150_01.jpg" class="w-100">
                    </div>
                    <div class="col-11 col-lg-5 text-white d-flex flex-column justify-content-center gap-5">
                        <h1> 150 Million Sales Club – Samsung</h1>
                        <p>Smart Asia is the prestigious dealer in smartphones to hold the category of 150 Million sales Club for Samsung smartphones and tablet sales in Sri Lanka! Your No.1 Retailer in Smartphones!
                            We hold the major awards from all famous smartphone brands in Sri Lanka. The most awarded mobile partner in Sri Lanka. We specialize in major brands of mobiles and mobile accessories and bring you only the best in quality.
                            We thank all our customers for the love and support which helped us to achieve our milestones.</p>
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-center align-items-center my-5">
                    <div class="col-11">

                        <div class="col-12 text-center fs-1 fw-bold my-2">CUSTOMERS SAY ABOUT US?</div>

                        <div class="col-12 pt-5">
                            <div id="owl-demo" class="owl-carousel2 owl-theme">

                                <?php
                                $feedback_rs = Database::search("SELECT * FROM feedback 
                                INNER JOIN user ON feedback.user_email = user.email");

                                if ($feedback_rs->num_rows == 0) {
                                ?>

                                    <div class="quoteItem mb-4 me-4">
                                        <i class="fa-solid fa-quote-left fs-2 ps-4"></i>
                                        <div class="p-4 d-flex flex-column subItemDiv">
                                            <p class="text-start text-secondary">Far far away, behind the word <br> mountains,
                                                far from the
                                                countries
                                                <br> Vokalia and Consonantia, there live <br> the blind texts.
                                            </p>
                                            <div class="d-flex">
                                                <img src="resources/images/person_1.jpg" alt="Owl Image" />
                                                <div class="d-flex flex-column justify-content-center align-items-start ps-3">
                                                    <label class="owlCarouselNameLable">Roger Scott</label>
                                                    <label class="mt-1 text-secondary">Marketing Manager</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="quoteItem mb-4 me-4">
                                        <i class="fa-solid fa-quote-left fs-2 ps-4"></i>
                                        <div class="p-4 d-flex flex-column subItemDiv">
                                            <p class="text-start text-secondary">Far far away, behind the word <br> mountains,
                                                far from the
                                                countries
                                                <br> Vokalia and Consonantia, there live <br> the blind texts.
                                            </p>
                                            <div class="d-flex">
                                                <img src="resources/images/person_1.jpg" alt="Owl Image" />
                                                <div class="d-flex flex-column justify-content-center align-items-start ps-3">
                                                    <label class="owlCarouselNameLable">Roger Scott</label>
                                                    <label class="mt-1 text-secondary">Marketing Manager</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="quoteItem mb-4 me-4">
                                        <i class="fa-solid fa-quote-left fs-2 ps-4"></i>
                                        <div class="p-4 d-flex flex-column subItemDiv">
                                            <p class="text-start text-secondary">Far far away, behind the word <br> mountains,
                                                far from the
                                                countries
                                                <br> Vokalia and Consonantia, there live <br> the blind texts.
                                            </p>
                                            <div class="d-flex">
                                                <img src="resources/images/person_1.jpg" alt="Owl Image" />
                                                <div class="d-flex flex-column justify-content-center align-items-start ps-3">
                                                    <label class="owlCarouselNameLable">Roger Scott</label>
                                                    <label class="mt-1 text-secondary">Marketing Manager</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="quoteItem mb-4 me-4">
                                        <i class="fa-solid fa-quote-left fs-2 ps-4"></i>
                                        <div class="p-4 d-flex flex-column subItemDiv">
                                            <p class="text-start text-secondary">Far far away, behind the word <br> mountains,
                                                far from the
                                                countries
                                                <br> Vokalia and Consonantia, there live <br> the blind texts.
                                            </p>
                                            <div class="d-flex">
                                                <img src="resources/images/person_1.jpg" alt="Owl Image" />
                                                <div class="d-flex flex-column justify-content-center align-items-start ps-3">
                                                    <label class="owlCarouselNameLable">Roger Scott</label>
                                                    <label class="mt-1 text-secondary">Marketing Manager</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="quoteItem mb-4 me-4">
                                        <i class="fa-solid fa-quote-left fs-2 ps-4"></i>
                                        <div class="p-4 d-flex flex-column subItemDiv">
                                            <p class="text-start text-secondary">Far far away, behind the word <br> mountains,
                                                far from the
                                                countries
                                                <br> Vokalia and Consonantia, there live <br> the blind texts.
                                            </p>
                                            <div class="d-flex">
                                                <img src="resources/images/person_1.jpg" alt="Owl Image" />
                                                <div class="d-flex flex-column justify-content-center align-items-start ps-3">
                                                    <label class="owlCarouselNameLable">Roger Scott</label>
                                                    <label class="mt-1 text-secondary">Marketing Manager</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                } else {

                                    while ($feedback_data = $feedback_rs->fetch_assoc()) {

                                        $feedUserimg_rs = Database::search("SELECT * FROM user_profile WHERE user_email = '" . $feedback_data["email"] . "'");
                                        $feedUserimg_data = $feedUserimg_rs->fetch_assoc();
                                    ?>

                                        <div class="quoteItem mb-4 me-4">
                                            <i class="fa-solid fa-quote-left fs-2 ps-4"></i>
                                            <div class="p-4 d-flex flex-column justify-content-between subItemDiv">
                                                <p class="text-start text-secondary">
                                                    <?php
                                                    $feed;
                                                    if (strlen($feedback_data["feed"]) > 20) {
                                                        // Subtract 5 from the total length
                                                        $newLength =  200;
                                                        // Use substr to get the substring of the new length
                                                        $feed = substr($feedback_data["feed"], 0, $newLength);
                                                    } else {
                                                        // If the string is 5 characters or less, return an empty string or the original string
                                                        $feed = $feedback_data["feed"];
                                                    }
                                                    echo $feed;
                                                    ?>

                                                </p>
                                                <div class="d-flex">
                                                    <?php
                                                    if ($feedUserimg_data == null) {
                                                    ?>
                                                        <img src="resources/user_profile/images.png" alt="Owl Image" />
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <img src="<?php echo $feedUserimg_data["path"] ?>" alt="Owl Image" />
                                                    <?php
                                                    }

                                                    ?>

                                                    <div class="d-flex flex-column justify-content-center align-items-start ps-3">
                                                        <label class="owlCarouselNameLable"><?php echo $feedback_data["fname"] . " " . $feedback_data["lname"] ?></label>
                                                        <label class="mt-1 text-secondary">
                                                            <?php
                                                            for ($f = 0; $f < $feedback_data["stars_count"]; $f++) {
                                                            ?>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                            <?php
                                                            }
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }

                                ?>
                            </div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js" integrity="sha512-9CWGXFSJ+/X0LWzSRCZFsOPhSfm6jbnL+Mpqo0o8Ke2SYr8rCTqb4/wGm+9n13HtDE1NQpAEOrMecDZw4FXQGg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                slideSpeed: 200,
                paginationSpeed: 600,
                autoPlay: true,
                autoplay: true,
                pagination: true,
                items: 7,
                itemsDesktop: [1199, 6],
                itemsDesktopSmall: [980, 3],
                itemsTablet: [768, 2],
                itemsMobile: [479, 2]
            });
        });
        $(document).ready(function() {
            $(".owl-carousel2").owlCarousel({
                slideSpeed: 200,
                paginationSpeed: 600,
                autoPlay: true,
                autoplay: true,
                pagination: true,
                items: 4,
                itemsDesktop: [1199, 4],
                itemsDesktopSmall: [980, 3],
                itemsTablet: [768, 2],
                itemsMobile: [479, 1]
            });
        });
    </script>


</body>

</html>