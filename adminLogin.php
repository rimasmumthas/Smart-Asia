<?php

session_start();

if (!isset($_SESSION["admin"])) {


?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Admin login | Smart Asia</title>


        <link rel="stylesheet" href="resources/bootstrap/bootstrap.css">
        <link rel="stylesheet" href="resources/css/style.css" />
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>

    <body>

        <div class="container-fluid d-flex justify-content-center align-items-center vh-100 custom-pattern">

            <div class="d-flex align-items-center justify-content-center col-12 col-md-11 col-lg-8">
                <div class="col-md-5 col-lg-6 d-none d-md-block left-side-para" data-aos="fade-right" data-aos-duration="2000">
                    <img src="resources/images/admin_img.png" class="w-100" alt="">
                </div>

                <!-- Sign In -->
                <div class="col-12 col-md-7 col-lg-6 d-flex flex-column justify-content-center align-items-center p-2 p-md-5" id="signInBox" data-aos="zoom-in-down" data-aos-duration="2000">

                    <div class="w-100 my-4 text-center">
                        <div class="col-12">
                            <img src="resources/images/smart_asia_logo.jpg" height="110px" alt="">
                        </div>
                        <span class="fw-bold fs-4">ADMIN LOGIN</span>
                    </div>

                    <div class="alert alert-danger w-100 d-none" id="adminLoginError" role="alert"></div>

                    <div class="input-1 input-group mb-4 rounded-3 px-2 py-1">
                        <span class="input-group-text border-0 bg-transparent" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" class="form-control border-0 shadow-none bg-transparent" placeholder="Email Address" id="adminEmail" required>
                    </div>

                    <button class="btn btn-primary w-100 auth-button" onclick="adminEmailVerification();">LOGIN</button>

                </div>

            </div>
        </div>

        <!-- admin verification Modal -->
        <div class="modal fade" id="adminVerificationModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-circle-exclamation me-2 fs-5" style="color: #071952;"></i>Account Verification</h1>
                    </div>
                    <div class="modal-body d-flex flex-column justify-content-center align-items-center ">
                        <div class="w-75 my-2">
                            <span class="fw-semibold">Enter verification code</span>
                        </div>
                        <input type="text" class="verification-input w-75 mb-2" id="adminCode">
                        <div class="alert alert-danger w-75 d-none" id="adminVerificationCodeError" role="alert"></div>
                        <div class="w-75 mt-4">
                            <p class="text-secondary">Verification code has been sent to your email. Please check your inbox.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary border-0" style="background-color: #088395;" onclick="confirmAdminEmailVerificationCode(document.getElementById('adminEmail').value);">Verify</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- js file -->
        <script src="resources/js/script.js"></script>
        <!-- font awesome icon link -->
        <script src="https://kit.fontawesome.com/0dab43209e.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
        <!-- moving animation link -->
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>

    </body>

    </html>

<?php

} else {
    header("Location:http://localhost/smart_asia/adminDashboard.php");
}

?>