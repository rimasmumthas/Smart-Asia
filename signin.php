<?php

session_start();

if (!isset($_SESSION["user"])) {

    $email = "";
    $password = "";

    if (isset($_COOKIE["email"])) {
        $email = $_COOKIE["email"];
    }
    if (isset($_COOKIE["password"])) {
        $password = $_COOKIE["password"];
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Smart Asia</title>


        <link rel="stylesheet" href="resources/bootstrap/bootstrap.css">
        <link rel="stylesheet" href="resources/css/style.css" />
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>

    <body>

        <div class="container-fluid d-flex justify-content-center align-items-center vh-100">

            <div class="d-flex align-items-center justify-content-center col-12 col-md-11 col-lg-8">
                <div class="col-md-5 col-lg-6 d-none d-md-block left-side-para" data-aos="fade-right" data-aos-duration="2000">
                    <h3>Welcome to</h3>
                    <h1>Smart Asia</h1>
                    <p class="auth-paragraph mt-4">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                    <span class="multi-text fs-4 fw-bold"></span>
                    <br><br>
                    <span class="mt-5">Follow us :</span>
                    <div class="mt-3 d-flex gap-4 social-media-icons">
                        <a href="#"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="#"><i class="fa-brands fa-square-instagram"></i></a>
                    </div>
                </div>

                <!-- Sign In -->
                <div class="col-12 col-md-7 col-lg-6 d-flex flex-column justify-content-center align-items-center p-2 p-md-5" id="signInBox" data-aos="zoom-in-down" data-aos-duration="2000">

                    <div class="w-100 my-4 text-center">
                        <div class="col-12">
                            <img src="resources/images/smart_asia_logo.jpg" height="110px" alt="">
                        </div>
                        <span class="fw-bold fs-4">LOGIN HERE</span>
                    </div>

                    <div class="alert alert-danger w-100 d-none" id="signInErrorBox" role="alert"></div>

                    <div class="input-1 input-group mb-4 rounded-3 px-2 py-1">
                        <span class="input-group-text border-0 bg-transparent" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
                        <input type="text" class="form-control border-0 shadow-none bg-transparent" placeholder="Email Address" id="loginEmail" required value="<?php echo ($email); ?>">
                    </div>

                    <div class="input-1 input-group mb-4 rounded-3 px-2 py-1">
                        <span class="input-group-text border-0 bg-transparent" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" class="form-control border-0 shadow-none bg-transparent" placeholder="Password" id="loginPassword" required value="<?php echo ($password); ?>">
                    </div>

                    <div class="col-12 d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input shadow-none" type="checkbox" checked id="rememberMe">
                            <label class="form-check-label" for="flexCheckDefault">
                                Remember Me
                            </label>
                        </div>
                        <a href="#" class="forgot-password" onclick="showForgotPasswordCode(document.getElementById('loginEmail').value);">Forgot Password?</a>
                    </div>

                    <button class="btn btn-primary my-3 w-100 auth-button" onclick="userLogin();">LOGIN</button>
                    <div>
                        <span class="signup-link" onclick="changeView();">Don't you have an account?</span>
                    </div>
                </div>

                <!-- Sign Up -->
                <div class="col-12 col-md-7 col-lg-6 d-flex flex-column justify-content-center align-items-center p-2 p-md-5 d-none" id="signUpBox" data-aos="zoom-in-up" data-aos-duration="2000">

                    <div class="w-100 my-4 text-center">
                        <div class="col-12">
                            <img src="resources/images/smart_asia_logo.jpg" height="110px" alt="">
                        </div>
                        <span class="fw-bold fs-4 d-none d-md-block">Create an account</span>
                    </div>

                    <div class="alert alert-danger w-100 d-none" id="signUpErrorBox" role="alert"></div>

                    <div class="input-1 input-group mb-4 rounded-3  px-2 py-1">
                        <span class="input-group-text border-0 bg-transparent" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" class="form-control border-0 shadow-none bg-transparent" placeholder="Email Address" id="signUpEmail">
                    </div>

                    <button class="btn btn-primary mb-3 w-100 auth-button" onclick="userVerification(document.getElementById('signUpEmail').value);">SIGN UP</button>
                    <div>
                        <span class="signup-link" onclick="changeView();">Already have an account?</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- user verification Modal -->
        <div class="modal fade" id="userVerificationModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-circle-exclamation me-2 fs-5" style="color: #071952;"></i>Account Verification</h1>
                    </div>
                    <div class="modal-body d-flex flex-column justify-content-center align-items-center ">
                        <div class="w-75 my-2">
                            <span class="fw-semibold">Enter verification code</span>
                        </div>
                        <input type="text" class="verification-input w-75 mb-2" id="code">
                        <div class="alert alert-danger w-75 d-none" id="verificationCodeError" role="alert"></div>
                        <div class="w-75 mt-4">
                            <p class="text-secondary">Verification code has been sent to your email. Please check your inbox.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary border-0" style="background-color: #088395;" onclick="confirmEmailVerificationCode(document.getElementById('signUpEmail').value);">Verify</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- other signup details Modal -->
        <div class="modal fade" id="otherSignUpDetailsModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-user me-2 fs-5" style="color: #071952;"></i>User Registration</h1>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 d-flex justify-content-evenly">
                            <div class="col-5 my-2 d-flex flex-column align-items-center">
                                <div class="w-100">
                                    <span class="fw-semibold">First Name</span>
                                </div>
                                <input type="text" class="verification-input w-100 mb-2" id="fname">
                            </div>
                            <div class="col-5 my-2 d-flex flex-column align-items-center">
                                <div class="w-100">
                                    <span class="fw-semibold">Last Name</span>
                                </div>
                                <input type="text" class="verification-input w-100 mb-2" id="lname">
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-evenly">
                            <div class="col-5 my-2 d-flex flex-column align-items-center">
                                <div class="w-100">
                                    <span class="fw-semibold">Create Password</span>
                                </div>
                                <input type="password" class="verification-input w-100 mb-2" id="createPassword">
                            </div>
                            <div class="col-5 my-2 d-flex flex-column align-items-center">
                                <div class="w-100">
                                    <span class="fw-semibold">Re-type Password</span>
                                </div>
                                <input type="password" class="verification-input w-100 mb-2" id="reTypePassword">
                            </div>
                        </div>
                        <div class="alert alert-danger my-3 d-none" id="registrationError" role="alert"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary border-0" style="background-color: #088395;" onclick="registerUser(document.getElementById('signUpEmail').value);">Register</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- forgot Password Verification Code Modal -->
        <div class="modal fade" id="forgotPasswordVerificationCodeModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-circle-exclamation me-2 fs-5" style="color: #071952;"></i>Email Verification</h1>
                    </div>
                    <div class="modal-body d-flex flex-column justify-content-center align-items-center ">
                        <div class="w-75 my-2">
                            <span class="fw-semibold">Enter verification code</span>
                        </div>
                        <input type="text" class="verification-input w-75 mb-2" id="forgotPasswordCode">
                        <div class="alert alert-danger w-75 d-none" id="forgotPasswordCodeError" role="alert"></div>
                        <div class="w-75 mt-4">
                            <p class="text-secondary">Verification code has been sent to your email. Please check your inbox.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary border-0" style="background-color: #088395;" onclick="codeValidation(document.getElementById('loginEmail').value);">Verify</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- create new password Modal -->
        <div class="modal fade" id="createnNewPasswordModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-circle-exclamation me-2 fs-5" style="color: #071952;"></i>Reset Password</h1>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 d-flex justify-content-evenly">
                            <div class="col-5 my-2 d-flex flex-column align-items-center">
                                <div class="w-100">
                                    <span class="fw-semibold">Create Password</span>
                                </div>
                                <input type="password" class="verification-input w-100 mb-2" id="resetNewPassword">
                            </div>
                            <div class="col-5 my-2 d-flex flex-column align-items-center">
                                <div class="w-100">
                                    <span class="fw-semibold">Re-type Password</span>
                                </div>
                                <input type="password" class="verification-input w-100 mb-2" id="reTypeResetNewPassword">
                            </div>
                        </div>
                        <div class="alert alert-danger my-3 d-none" id="resetPasswordError" role="alert"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary border-0" style="background-color: #088395;" onclick="createNewPassword(document.getElementById('loginEmail').value);">Reset</button>
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
        <!-- typing animation link -->
        <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
        <script>
            var typed = new Typed(".multi-text", {
                strings: ["SMART PHONES", "LAPTOPS", "ACCESSORIES"],
                typeSpeed: 50,
                backSpeed: 50,
                backDelay: 1000,
                startDelay: 3000,
                loop: true,
                showCursor: false,
            })
        </script>
        <!-- moving animation link -->
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>

    </body>

    </html>

<?php
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
?>