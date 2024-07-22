function changeView() {

    var signUpBox = document.getElementById("signUpBox");
    var signInBox = document.getElementById("signInBox");

    signUpBox.classList.toggle("d-none");
    signInBox.classList.toggle("d-none");

}

var userVerificationModal;

function userVerification(email) {

    var email = document.getElementById("signUpEmail").value;
    var signUpError = document.getElementById("signUpErrorBox");

    function showError(message, type) {
        if (type == "info") {
            signUpError.classList = "alert alert-info w-100 d-block";
            signUpError.innerHTML = message + ' ' + '<i class="fa-solid fa-spinner fa-spin fs-4"></i>';
        } else {
            signUpError.classList = "alert alert-danger w-100 d-block";
            signUpError.innerHTML = message;
        }

    }

    showError("Please wait untill we send a code to your email address...", "info");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            signUpError.classList = "alert alert-info w-100 d-none";
            if (response == "success") {
                var m = document.getElementById("userVerificationModal");
                userVerificationModal = new bootstrap.Modal(m);
                userVerificationModal.show();
            } else {
                showError(response);
            }

        }

    };

    request.open("GET", "sendUserVerificationCodeProcess.php?e=" + email, true);
    request.send();


}

var userRegistrationModal;

function confirmEmailVerificationCode(email) {

    var code = document.getElementById("code").value;
    var verificationCodeError = document.getElementById("verificationCodeError");

    function showError(message) {
        verificationCodeError.classList = "alert alert-danger w-75 d-block";
        verificationCodeError.innerHTML = message;
    }

    if (!code) {
        showError('Please enter verification code');
    } else {

        var form = new FormData();
        form.append("email", email);
        form.append("code", code);
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;
                if (response == "success") {
                    userVerificationModal.hide();
                    var m = document.getElementById("otherSignUpDetailsModal");
                    userRegistrationModal = new bootstrap.Modal(m);
                    userRegistrationModal.show();
                } else {
                    showError(response);
                }
            }

        };

        request.open("POST", "confirmEmailVerificationCodeProcess.php", true);
        request.send(form);
    }

}

function registerUser() {

    var email = document.getElementById("signUpEmail").value;
    var registrationError = document.getElementById("registrationError");
    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;
    var createPassword = document.getElementById("createPassword").value;
    var confrimPassword = document.getElementById("reTypePassword").value;

    function showError(message) {
        registrationError.classList = "alert alert-danger my-3 d-block";
        registrationError.innerHTML = message;
    }

    var form = new FormData();
    form.append("email", email);
    form.append("fname", fname);
    form.append("lname", lname);
    form.append("createPassword", createPassword);
    form.append("confrimPassword", confrimPassword);
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            if (response == "success") {
                userRegistrationModal.hide();
                Swal.fire({
                    title: 'Registration Success',
                    text: 'Now you can login to your account',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location.reload();
                    })
            } else {
                showError(response);
            }
        }

    };

    request.open("POST", "registerUserProcess.php", true);
    request.send(form);

}

function userLogin() {

    var email = document.getElementById("loginEmail").value;
    var password = document.getElementById("loginPassword").value;
    var rememberMe = document.getElementById("rememberMe");
    var signInError = document.getElementById("signInErrorBox");

    function showError(message) {
        signInError.classList = "alert alert-danger w-100 d-block";
        signInError.innerHTML = message;
    }

    var form = new FormData();
    form.append("email", email);
    form.append("password", password);
    form.append("rememberMe", rememberMe.checked);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            if (response == "success") {
                window.location = "index.php";
            } else if (response === "Inactive user") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    confirmButtonColor: "#071952",
                    text: 'You have been blocked! Please contact admin'
                });
            } else {
                showError(response);
            }
        }
    };

    request.open("POST", "userSignInProcess.php", true);
    request.send(form);

}

var forgotPasswordVerificationCodeModal;
function showForgotPasswordCode(email) {

    var signInError = document.getElementById("signInErrorBox");

    function showError(message) {
        signInError.classList = "alert alert-danger w-100 d-block";
        signInError.innerHTML = message;
    }

    if (!email) {
        showError('Please enter email and click forgot password');
    } else {
        Swal.showLoading();

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;
                if (response == "success") {
                    Swal.close();
                    var m = document.getElementById("forgotPasswordVerificationCodeModal");
                    forgotPasswordVerificationCodeModal = new bootstrap.Modal(m);
                    forgotPasswordVerificationCodeModal.show();
                } else {
                    Swal.close();
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            confirmButtonColor: "#071952",
                            text: response
                        });
                    }, 500);
                }
            }
        };

        request.open("GET", "forgotPasswordProcess.php?e=" + email, true);
        request.send();
    }

}

var createnNewPasswordModal;
function codeValidation(email) {

    var code = document.getElementById("forgotPasswordCode").value;
    var codeError = document.getElementById("forgotPasswordCodeError");

    function showError(message) {
        codeError.classList = "alert alert-danger w-75 d-block";
        codeError.innerHTML = message;
    }

    if (!code) {
        showError('Please enter code')
    } else {
        var form = new FormData();
        form.append("email", email);
        form.append("code", code);
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;
                if (response == "success") {
                    forgotPasswordVerificationCodeModal.hide();
                    var m = document.getElementById("createnNewPasswordModal");
                    createnNewPasswordModal = new bootstrap.Modal(m);
                    createnNewPasswordModal.show();
                } else {
                    showError(response);
                }
            }

        };

        request.open("POST", "confirmEmailVerificationCodeProcess.php", true);
        request.send(form);
    }
}

function createNewPassword(email) {

    var newPassword = document.getElementById("resetNewPassword").value;
    var reTypedPassword = document.getElementById("reTypeResetNewPassword").value;
    var resetPasswordError = document.getElementById("resetPasswordError");

    function showError(message) {
        resetPasswordError.classList = "alert alert-danger my-3 d-block";
        resetPasswordError.innerHTML = message;
    }

    if (!newPassword || !reTypedPassword) {
        showError('Please create password and re-type it to confirm');
    } else {

        var form = new FormData();
        form.append("email", email);
        form.append("createPassword", newPassword);
        form.append("confirmPassword", reTypedPassword);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;
                if (response == "success") {
                    Swal.fire({
                        title: 'Password Reset Successfully',
                        text: 'Now you can login to your account',
                        icon: 'success',
                        confirmButtonText: 'Okay',
                        confirmButtonColor: "#071952"
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    showError(response);
                }
            }
        };

        request.open("POST", "resetUserPasswordProcess.php", true);
        request.send(form);
    }

}

function userSignout() {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            if (response == "success") {
                window.location.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    confirmButtonColor: "#071952",
                    text: response
                });
            }
        }
    }

    request.open("GET", "userSignoutProcess.php", true);
    request.send();
}

document.getElementById("profileimg").onchange = function () {
    Swal.fire({
        title: "Are you sure?",
        text: "Your current profile image will be deleted and new image will be updated",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Change it!"
    }).then((result) => {
        if (result.isConfirmed) {
            var image = document.getElementById("profileimg");
            var form = new FormData();
            form.append("image", image.files[0]);
            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    var response = request.responseText;
                    if (response == "success") {
                        var view = document.getElementById("viewImage");
                        var file1 = image.files[0];
                        var url = window.URL.createObjectURL(file1);
                        view.src = url;
                        Swal.fire({
                            title: "Success!",
                            text: "You profile image changed successfully",
                            icon: "success"
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            icon: "error",
                            text: response,
                        });
                    }
                }
            }
            request.open("POST", "updateProfileImageProcess.php", true);
            request.send(form);
        } else {
            location.reload();
        }
    });
}

function updateUserProfileDetails() {

    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;
    var password = document.getElementById("userPasswsord").value;
    var error = document.getElementById("updateProfileDetailsError");

    function showError(message) {
        error.classList = "alert alert-danger w-100 d-block";
        error.innerHTML = message;
    }

    if (!fname) {
        showError('Please enter first name');
    } else if (!lname) {
        showError('Please enter last name');
    } else if (!password) {
        showError('Please enter password');
    } else {
        var form = new FormData();
        form.append("fname", fname);
        form.append("lname", lname);
        form.append("password", password);
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;
                if (response == "success") {
                    Swal.fire({
                        title: "Success!",
                        text: "You profile details updated successfully",
                        icon: "success"
                    })
                        .then(() => {
                            location.reload();
                        })
                } else {
                    showError(response);
                }
            }
        }
        request.open("POST", "updateProfileDetailsProcess.php", true);
        request.send(form);
    }

}

document.getElementById("citySelection").onchange = function () {
    var cityId = this.value;
    var postCode = document.getElementById("postCode");
    var district = document.getElementById("district");
    var province = document.getElementById("province");
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var jsonResponseText = request.responseText;
            var jsResponseObject = JSON.parse(jsonResponseText);
            if (jsResponseObject.status == "success") { // Check the status in the JSON response
                postCode.innerHTML = "Post Code : " + jsResponseObject.postCode;
                district.innerHTML = "District : " + jsResponseObject.district;
                province.innerHTML = "Province : " + jsResponseObject.province;
            } else {
                postCode.innerHTML = "Post Code : none";
                district.innerHTML = "District : none";
                province.innerHTML = "Province : none";
                Swal.fire({
                    title: "Error!",
                    icon: "error",
                    text: jsResponseObject.message, // Display the error message from the response
                });
            }
        }
    };
    request.open("GET", "getCityDetails.php?cid=" + cityId, true);
    request.send();
};

function updateUserAddress() {

    var line1 = document.getElementById("line1").value;
    var line2 = document.getElementById("line2").value;
    var cityid = document.getElementById("citySelection").value;
    var error = document.getElementById("updateAddressDetailsError");

    function showError(message) {
        error.classList = "alert alert-danger w-100 d-block";
        error.innerHTML = message;
    }

    if (!line1) {
        showError('Please enter address line 1');
    } else if (!line2) {
        showError('Please enter address line 2');
    } else if (cityid == 0) {
        showError('Please select city');
    } else {
        var form = new FormData();
        form.append("line1", line1);
        form.append("line2", line2);
        form.append("cityid", cityid);
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;
                if (response == "success") {
                    Swal.fire({
                        title: "Success!",
                        text: "You address details updated successfully",
                        icon: "success"
                    })
                        .then(() => {
                            location.reload();
                        })
                } else {
                    showError(response);
                }
            }
        }
        request.open("POST", "updateAddressDetailsProcess.php", true);
        request.send(form);
    }

}

var adminVerificationModal;
function adminEmailVerification() {

    var adminEmail = document.getElementById("adminEmail").value;
    var error = document.getElementById("adminLoginError");

    function showError(message, type) {
        if (type == "info") {
            error.classList = "alert alert-info w-100 d-block";
            error.innerHTML = message + ' ' + '<i class="fa-solid fa-spinner fa-spin fs-4"></i>';
        } else {
            error.classList = "alert alert-danger w-100 d-block";
            error.innerHTML = message;
        }

    }

    showError("Please wait untill we send a code to your email address...", "info");

    if (!adminEmail) {
        showError('Please enter email address');
    } else {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;
                if (response == "success") {
                    var m = document.getElementById("adminVerificationModal");
                    adminVerificationModal = new bootstrap.Modal(m);
                    adminVerificationModal.show();
                } else {
                    showError(response);
                }
            }
        }
        request.open("GET", "adminEmailVerificationprocess.php?e=" + adminEmail, true);
        request.send();
    }
}

function confirmAdminEmailVerificationCode(email) {

    var code = document.getElementById("adminCode").value;
    var verificationCodeError = document.getElementById("adminVerificationCodeError");

    function showError(message) {
        verificationCodeError.classList = "alert alert-danger w-75 d-block";
        verificationCodeError.innerHTML = message;
    }

    if (!code) {
        showError('Please enter verification code');
    } else {

        var form = new FormData();
        form.append("adminEmail", email);
        form.append("adminCode", code);
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;
                if (response == "success") {
                    location = "adminDashboard.php";
                } else {
                    showError(response);
                }
            }

        };

        request.open("POST", "confirmAdminEmailVerificationCodeProcess.php", true);
        request.send(form);
    }

}

function headerChange(title) {
    document.getElementById("headerTitle").innerHTML = title;;
}

function adminLogOut() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            if (response == "success") {
                window.location.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    confirmButtonColor: "#071952",
                    text: response
                });
            }
        }
    }

    request.open("GET", "adminSignoutProcess.php", true);
    request.send();
}

function changeProductImage() {
    var image = document.getElementById("imageuploader");

    image.onchange = function () {

        var file_count = image.files.length;

        if (file_count <= 3) {

            for (var x = 0; x < file_count; x++) {
                var file = this.files[x];
                var url = window.URL.createObjectURL(file);
                document.getElementById("i" + x).src = url;
            }

        } else {
            alert("Please select 3 or less than 3 images");
        }
    }
}

function load_brand(category, brand) {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            brand.innerHTML = t;
        }
    }
    r.open("GET", "loadBrand.php?c=" + category.value, true);
    r.send();

}

function load_model(brand, model) {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            model.innerHTML = t;
        }
    }
    r.open("GET", "loadModel.php?b=" + brand.value, true);
    r.send();

}

function addProduct() {

    var category = document.getElementById("category").value;
    var brand = document.getElementById("brand").value;
    var model = document.getElementById("model").value;
    var condition = document.getElementById("condition").value;
    var color = document.getElementById("color").value;
    var quantity = document.getElementById("quantity").value;
    var cost = document.getElementById("cost").value;
    var deliveryFee = document.getElementById("deliveryFee").value;
    var title = document.getElementById("title").value;
    var description = document.getElementById("description").value;
    var image = document.getElementById("imageuploader");
    var error = document.getElementById("addProductError");

    function showError(message) {
        error.classList = "alert alert-danger w-100 d-block";
        error.innerHTML = message;
    }

    var f = new FormData();
    f.append("category", category);
    f.append("brand", brand);
    f.append("model", model);
    f.append("condition", condition);
    f.append("color", color);
    f.append("quantity", quantity);
    f.append("cost", cost);
    f.append("deliveryFee", deliveryFee);
    f.append("title", title);
    f.append("description", description);

    var file_count = image.files.length;

    for (var x = 0; x < file_count; x++) {
        f.append("image" + x, image.files[x]);
    }

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Registration Success',
                    text: 'Product updated successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location.reload();
                    })
            } else {
                showError(t);
            }
        }
    }

    r.open("POST", "addProductProcess.php", true);
    r.send(f);

}

function searchProduct() {

    var searchText = document.getElementById("searchProduct").value;
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("productLoadingArea").innerHTML = t;
        }
    }
    r.open("GET", "loadSearchProductProcess.php?text=" + searchText, true);
    r.send();

}

var updateProductModal;
function viewUpdateProductModal(productId) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("updateProductModalBody").innerHTML = t;
            var m = document.getElementById("updateProductModal");
            updateProductModal = new bootstrap.Modal(m);
            updateProductModal.show();
        }
    }
    r.open("GET", "loadUpdateProductModalProcess.php?pid=" + productId, true);
    r.send();
}

function changeUpdateProductImage() {

    var defaultUrl = "resources/product_images/add_image.svg";
    document.getElementById("z0").src = defaultUrl;
    document.getElementById("z1").src = defaultUrl;
    document.getElementById("z2").src = defaultUrl;

    var image = document.getElementById("imageuploader2");

    image.onchange = function () {
        var file_count = image.files.length;
        if (file_count <= 3) {
            for (var x = 0; x < file_count; x++) {
                var file = this.files[x];
                var url = window.URL.createObjectURL(file);
                document.getElementById("z" + x).src = url;
            }

        } else {
            alert("Please select 3 or less than 3 images");
        }
    }
}

function updateProduct() {

    var pid = document.getElementById("productId").innerHTML;
    var updateQty = document.getElementById("updateQty").value;
    var updateDeliveryFee = document.getElementById("updateDeliveryFee").value;
    var updateTitle = document.getElementById("updateTitle").value;
    var description = document.getElementById("updateDescription").value;
    var image = document.getElementById("imageuploader2");
    var error = document.getElementById("updateProductError");

    function showError(message) {
        error.classList = "alert alert-danger w-100 d-block";
        error.innerHTML = message;
    }

    var f = new FormData();
    f.append("pid", pid);
    f.append("qty", updateQty);
    f.append("deliveryFee", updateDeliveryFee);
    f.append("title", updateTitle);
    f.append("description", description);

    var img_count = image.files.length;
    for (var x = 0; x < img_count; x++) {
        f.append("image" + x, image.files[x]);
    }

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Update Success',
                    text: 'Product updated successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location.reload();
                    })
            } else {
                showError(t);
            }
        }
    }

    r.open("POST", "updateProductProcess.php", true);
    r.send(f);
}

function changeProductStatus(productId) {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "Deactivated") {
                Swal.fire({
                    title: 'Success',
                    text: 'Product deactivated successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            } else if (t == "Activated") {
                Swal.fire({
                    title: 'Success',
                    text: 'Product activated successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            } else {
                Swal.fire({
                    title: 'OOps...',
                    text: t,
                    icon: 'error',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            }

        }
    }

    r.open("GET", "changeProductStatusProcess.php?p=" + productId, true);
    r.send();
}

function searchUser() {

    var searchText = document.getElementById("searchUser").value;
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("usersLoadingArea").innerHTML = t;
        }
    }
    r.open("GET", "loadSearchUserProcess.php?text=" + searchText, true);
    r.send();

}

function loadBlockedUsers() {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("usersLoadingArea").innerHTML = t;
        }
    }
    r.open("GET", "loadBlockedUsers.php", true);
    r.send();
}

function changeUserStatus(email) {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "Deactivated") {
                Swal.fire({
                    title: 'Success',
                    text: 'User blocked successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            } else if (t == "Activated") {
                Swal.fire({
                    title: 'Success',
                    text: 'User unblocked successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            } else {
                Swal.fire({
                    title: 'OOps...',
                    text: t,
                    icon: 'error',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            }

        }
    }

    r.open("GET", "changeUserStatusProcess.php?e=" + email, true);
    r.send();
}


function searchCategory() {

    var searchText = document.getElementById("searchcategory").value;
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("categoryLoadingArea").innerHTML = t;
        }
    }
    r.open("GET", "loadSearchCategoryProcess.php?text=" + searchText, true);
    r.send();

}


function changeCategoryImage() {
    var image = document.getElementById("imageuploader3");
    image.onchange = function () {
        var file_count = image.files.length;
        if (file_count == 1) {
            var file = this.files[0];
            var url = window.URL.createObjectURL(file);
            document.getElementById("imageView").src = url;
        } else {
            alert("Please select one image");
        }
    }
}

function saveCategory() {

    var category = document.getElementById("cname").value;
    var image = document.getElementById("imageuploader3");
    var error = document.getElementById("addCategoryError");

    function showError(message) {
        error.classList = "alert alert-danger w-100 d-block";
        error.innerHTML = message;
    }

    var f = new FormData();
    f.append("category", category);
    f.append("image", image.files[0]);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Success',
                    text: 'Category saved successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location.reload();
                    })
            } else {
                showError(t);
            }
        }
    }

    r.open("POST", "addCategoryProcess.php", true);
    r.send(f);

}

function viewUpdateCategoryForm(catId) {
    var updateCategoryForm = document.getElementById("updateCategoryform");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            updateCategoryForm.innerHTML = t;
            updateCategoryForm.classList = "col-12 my-3 border p-3";
        }
    }
    r.open("GET", "loadUpdateCategoryProcess.php?catId=" + catId, true);
    r.send();

}

function changeUpdateCategoryImage() {
    var image = document.getElementById("catImageUploader");
    image.onchange = function () {
        var file_count = image.files.length;
        if (file_count == 1) {
            var file = this.files[0];
            var url = window.URL.createObjectURL(file);
            document.getElementById("catImageView").src = url;
        } else {
            alert("Please select one image");
        }
    }
}

function updateCategory(categoryId) {

    var categoryImage = document.getElementById("catImageUploader");
    var category = document.getElementById("updateCatName").value;

    var error = document.getElementById("updateCategoryError");

    function showError(message) {
        error.classList = "alert alert-danger w-100 d-block";
        error.innerHTML = message;
    }

    var f = new FormData();
    f.append("catId", categoryId);
    f.append("category", category);
    f.append("image", categoryImage.files[0]);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Success',
                    text: 'Category updated successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location.reload();
                    })
            } else {
                showError(t);
            }
        }
    }

    r.open("POST", "updateCategoryProcess.php", true);
    r.send(f);

}

function loadSelectedCategory(catId, catName) {

    var mainArea = document.getElementById("main-content-load-area-home");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            mainArea.innerHTML = t;
        }
    }
    r.open("GET", "loadCategoryWiseProductsProcess.php?catId=" + catId + "&catName=" + catName, true);
    r.send();

}

function saveOffer() {

    var pid = document.getElementById("product-id").value;
    var percentage = document.getElementById("percentage").value;

    var error = document.getElementById("newOfferError");

    function showError(message) {
        error.classList = "alert alert-danger w-100 d-block";
        error.innerHTML = message;
    }

    var f = new FormData();
    f.append("pid", pid);
    f.append("percentage", percentage);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Success',
                    text: 'Offer saved successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location.reload();
                    })
            } else {
                showError(t);
            }
        }
    }

    r.open("POST", "saveOfferproductprocess.php", true);
    r.send(f);

}

function deleteOffer(pid) {

    var error = document.getElementById("offerError");
    function showError(message) {
        error.classList = "alert alert-danger w-100 d-block";
        error.innerHTML = message;
    }

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Success',
                    text: 'Offer deleted successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location.reload();
                    })
            } else {
                showError(t);
            }
        }
    }
    r.open("GET", "deleteOfferProcess.php?pid=" + pid, true);
    r.send();

}

function searchOfferProduct() {

    var searchText = document.getElementById("searchOfferproduct").value;
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("productOfferLoadingArea").innerHTML = t;
        }
    }
    r.open("GET", "loadSearchOfferProductProcess.php?text=" + searchText, true);
    r.send();

}

function loadBestOffers() {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("main-content-load-area-home").innerHTML = t;
        }
    }
    r.open("GET", "loadBestOffersProcess.php", true);
    r.send();

}

function advanceSearch() {

    var minPrice = document.getElementById("minPrice").value;
    var maxPrice = document.getElementById("maxPrice").value;
    var selectedCategory = document.getElementById("selectedCategory").value;
    var selectedBrand = document.getElementById("selectedBrand").value;
    var selectedModel = document.getElementById("selectedModel").value;
    var selectedColor = document.getElementById("selectedColor").value;
    var condition = "0";
    if (document.getElementById("new").checked) {
        condition = "1";
    } else if (document.getElementById("used").checked) {
        condition = "2";
    }
    var selectedOrder = document.getElementById("selectedOrder").value;
    var mainArea = document.getElementById("main-content-load-area-home");

    var f = new FormData();
    f.append("minPrice", minPrice);
    f.append("maxPrice", maxPrice);
    f.append("selectedCategory", selectedCategory);
    f.append("selectedBrand", selectedBrand);
    f.append("selectedModel", selectedModel);
    f.append("selectedColor", selectedColor);
    f.append("condition", condition);
    f.append("selectedOrder", selectedOrder);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            mainArea.innerHTML = t;
            bootstrap.Offcanvas.getInstance(document.getElementById("filterOffCanvas")).hide();
        }
    }

    r.open("POST", "advanceSearchprocess.php", true);
    r.send(f);

}

function singleProductView(pid) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("main-content-load-area-home").innerHTML = t;
            loadMainImg(0);
        }
    }
    r.open("GET", "singleProductView.php?id=" + pid, true);
    r.send();
}

function loadMainImg(id) {

    var img = document.getElementById("productImg" + id).src;
    var main = document.getElementById("mainImage");
    main.src = img;
}

function addToCart(id, qty) {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Success',
                    text: 'Product added to cart successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location.reload();
                    })
            } else if (t == "please login") {
                Swal.fire({
                    title: 'Oops...',
                    text: 'Please login to continue!',
                    icon: 'error',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location = "signin.php";
                    })
            } else {
                Swal.fire({
                    title: 'Oops...',
                    text: t,
                    icon: 'error',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            }
        }
    }

    r.open("GET", "addToCartProcess.php?id=" + id + "&qty=" + qty, true);
    r.send();
}

function updateCartProducts(pid) {

    var qty = document.getElementById("cartItemCount" + pid).value;
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Success',
                    text: 'Cart item quantity updated successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location.reload();
                    })
            } else {
                Swal.fire({
                    title: 'Oops...',
                    text: t,
                    icon: 'error',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            }
        }
    }

    r.open("GET", "updateCartItemProcess.php?id=" + pid + "&qty=" + qty, true);
    r.send();

}

function removeItemFromCart(pid) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Success',
                    text: 'Item removed from cart successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location.reload();
                    })
            } else {
                Swal.fire({
                    title: 'Oops...',
                    text: t,
                    icon: 'error',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            }
        }
    }
    r.open("GET", "removeItemsFromCartProcess.php?id=" + pid, true);
    r.send();

}

function verifyAddressDetails(total) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                payNow(total);
            } else {
                Swal.fire({
                    title: 'Oops...',
                    text: t,
                    icon: 'warning',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location = "userProfile.php";
                    })
            }
        }
    }
    r.open("GET", "verifyUserAddressDetails.php", true);
    r.send();
}

function payNow(total) {

    if (total > 0) {

        var f = new FormData();
        f.append("total", total)

        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;

                var obj = JSON.parse(t);
                var mail = obj["mail"];

                payhere.onCompleted = function onCompleted(orderId) {
                    saveInvoice(orderId, mail);
                };

                // Put the payment variables here
                var payment = {
                    "sandbox": true,
                    "merchant_id": obj["merchant_id"], // Replace your Merchant ID
                    "return_url": "http://localhost/smart_asia/cart.php", // Important
                    "cancel_url": "http://localhost/smart_asia/cart.php", // Important
                    "notify_url": "http://sample.com/notify",
                    "order_id": obj["order_id"],
                    "items": "Check Out",
                    "amount": obj["amount"],
                    "currency": obj["currency"],
                    "hash": obj["hash"], // *Replace with generated hash retrieved from backend
                    "first_name": obj["fname"],
                    "last_name": obj["lname"],
                    "email": mail,
                    "phone": obj["mobile"],
                    "address": "",
                    "city": "",
                    "country": "Sri Lanka",
                    "delivery_address": "",
                    "delivery_city": "",
                    "delivery_country": "",
                };

                // Show the payhere.js popup, when "PayHere Pay" is clicked
                payhere.startPayment(payment);
                //   document.getElementById("payhere-payment").onclick = function (e) {

                //   };
            }
        };
        r.open("POST", "payNowProcess.php", true);
        r.send(f);
    } else {
        Swal.fire({
            title: 'Oops...',
            text: "Please add products to your cart",
            icon: 'warning',
            confirmButtonText: 'Okay',
            confirmButtonColor: "#071952"
        })
            .then(() => {
                window.location = "index.php";
            })
    }
}

function clearCart(email, orderId) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                window.location = "invoice.php?inId=" + orderId;
            } else {
                Swal.fire({
                    title: 'Oops...',
                    text: t,
                    icon: 'error',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            }

        }
    }
    r.open("GET", "clearCartprocess.php?e=" + email, true);
    r.send();
}

function saveInvoice(orderId, email) {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Thank You!',
                    text: 'Transaction successfull!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        clearCart(email, orderId);
                    })
            } else {
                Swal.fire({
                    title: 'Oops...',
                    text: t,
                    icon: 'error',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            }
        }
    };

    r.open("GET", "saveInvoiceProcess.php?orderId=" + orderId, true);
    r.send();
}

function printInvoice() {
    var body = document.body.innerHTML;
    var page = document.getElementById("invoicePage").innerHTML;
    document.body.innerHTML = page;
    window.print();
    document.body.innerHTML = body;
}

function removeItemFromWatchlist(pid) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Success',
                    text: 'Item removed from watchlist successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location.reload();
                    })
            } else {
                Swal.fire({
                    title: 'Oops...',
                    text: t,
                    icon: 'error',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            }
        }
    }
    r.open("GET", "removeItemsFromWatchlistProcess.php?id=" + pid, true);
    r.send();

}

function addToWatchlist(id) {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Success',
                    text: 'Product added to watchlist successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location.reload();
                    })
            } else if (t == "please login") {
                Swal.fire({
                    title: 'Oops...',
                    text: 'Please login to continue!',
                    icon: 'error',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location = "signin.php";
                    })
            } else {
                Swal.fire({
                    title: 'Oops...',
                    text: t,
                    icon: 'error',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            }
        }
    }

    r.open("GET", "addToWatchlistProcess.php?id=" + id, true);
    r.send();
}

function viewPurchasedItems(invId) {

    var loadingArea = document.getElementById("showPurchasedItemsArea");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            loadingArea.classList = "col-6 border p-3";
            loadingArea.innerHTML = t;
        }
    }

    r.open("GET", "loadPurchasedItemsProcess.php?invId=" + invId, true);
    r.send();
}

function loadNewProducts() {
    var loadingArea = document.getElementById("main-content-load-area-home");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            loadingArea.innerHTML = t;
        }
    }

    r.open("GET", "loadNewProductsProcess.php", true);
    r.send();
}

function basicSearch(page) {

    var searchtext1 = document.getElementById('basicSearchInput1').value;
    var searchtext2 = document.getElementById('basicSearchInput2').value;

    var text;
    if (!searchtext1 && !searchtext2) {
        text = "";
    } else if (!searchtext1 && searchtext2) {
        text = searchtext2;
    } else if (searchtext1 && !searchtext2) {
        text = searchtext1;
    }

    var f = new FormData();
    f.append("text", text);
    f.append("page", page);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("main-content-load-area-home").innerHTML = t;
        }
    }
    r.open("POST", "basicSearchProcess.php", true);
    r.send(f);

}

function brandRegistration() {

    var category = document.getElementById("categoryregister");
    var brand = document.getElementById("brandCategoryRegister");
    var error = document.getElementById("brandRegisterError");

    function showError(message) {
        error.classList = "alert alert-danger w-100 d-block";
        error.innerHTML = message;
    }

    var f = new FormData();
    f.append("category", category.value);
    f.append("brand", brand.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Success',
                    text: 'Brand saved successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        error.className = "d-none";
                        category.value = 0;
                        brand.value = "";
                    })
            } else {
                showError(t);
            }
        }
    }
    r.open("POST", "brandRegistrationProcess.php", true);
    r.send(f);
}

function modelRegistration() {

    var model = document.getElementById("modelRegister");
    var error = document.getElementById("modelRegisterError");

    function showError(message) {
        error.classList = "alert alert-danger w-100 d-block";
        error.innerHTML = message;
    }

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Success',
                    text: 'Model saved successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        error.className = "d-none";
                        model.value = "";
                    })
            } else {
                showError(t);
            }
        }
    }
    r.open("GET", "modelRegistrationProcess.php?model=" + model.value, true);
    r.send();
}

function brandWithModelRegistration() {

    var brand = document.getElementById("brandWithCategory");
    var model = document.getElementById("modelWithBrandId");
    var error = document.getElementById("brandWithModelError");

    function showError(message) {
        error.classList = "alert alert-danger w-100 d-block";
        error.innerHTML = message;
    }

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Success',
                    text: 'Brand with Model saved successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        error.className = "d-none";
                        brand.value = 0;
                        model.value = 0;
                    })
            } else {
                showError(t);
            }
        }
    }
    r.open("GET", "brandWithModelRegistrationProcess.php?brand=" + brand.value + "&model=" + model.value, true);
    r.send();

}

function saveColor(color) {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                Swal.fire({
                    title: 'Success',
                    text: 'Color saved successfully!',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
                    .then(() => {
                        window.location.reload();
                    })
            } else {
                Swal.fire({
                    title: 'Oops...',
                    text: t,
                    icon: 'error',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            }
        }
    }
    r.open("GET", "saveColorProcess.php?color=" + color, true);
    r.send();

}

function viewOrderedItems(invId) {

    var loadingArea = document.getElementById("showInvoiceItemsArea");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            loadingArea.innerHTML = t;
        }
    }

    r.open("GET", "loadOrderedItemsProcess.php?invId=" + invId, true);
    r.send();
}

function searchOrderedItems() {

    var searchText = document.getElementById("searchOrders").value;
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("ordersLoadingArea").innerHTML = t;
        }
    }
    r.open("GET", "loadSearchOrdersProcess.php?text=" + searchText, true);
    r.send();

}

function loadOrdersByFilter() {

    document.getElementById("searchOrders").value = "";
    var from = document.getElementById("orderFrom").value;
    var to = document.getElementById("orderTo").value;
    var orderby = document.getElementById("orderStatusBy").value;

    var f = new FormData();
    f.append("from", from);
    f.append("to", to);
    f.append("orderby", orderby);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "empty from") {
                Swal.fire({
                    title: 'Oops...',
                    text: "Please select starting date",
                    icon: 'error',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            } else if (t == "empty to") {
                Swal.fire({
                    title: 'Oops...',
                    text: "Please select ending date",
                    icon: 'error',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: "#071952"
                })
            } else {
                document.getElementById("ordersLoadingArea").innerHTML = t;
            }

        }
    }
    r.open("GET", "loadOrdersByFilterProcess.php?to=" + to, "&orderby=" + orderby, true);
    r.send();

}

function getTodaySales() {
    var format = "Y-m-d";
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("todaySales").innerHTML = "Rs. " + t;
        }
    }
    r.open("GET", "calculateSalesProcess.php?format=" + format, true);
    r.send();
}

function getThisMonthSales() {
    var format = "Y-m";
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("thisMonthSale").innerHTML = "Rs. " + t;
        }
    }
    r.open("GET", "calculateSalesProcess.php?format=" + format, true);
    r.send();
}

function getThisYearSales() {
    var format = "Y";
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("thisYearSale").innerHTML = "Rs. " + t;
        }
    }
    r.open("GET", "calculateSalesProcess.php?format=" + format, true);
    r.send();
}

function getTotalSales() {
    var format = "none";
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("totalSales").innerHTML = "Rs. " + t;
        }
    }
    r.open("GET", "calculateSalesProcess.php?format=" + format, true);
    r.send();
}

function getSalesDetails() {
    getTodaySales();
    getThisMonthSales();
    getThisYearSales();
    getTotalSales();
}

function loadBestOfferproducts(page) {
    var f = new FormData();
    f.append("page", page);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("main-content-load-area-home").innerHTML = t;
        }
    }
    r.open("POST", "loadBestOffersProcess.php", true);
    r.send(f);
}

function saveCustomerRating() {
    var stars = document.getElementsByName('rate');
    var text = document.getElementById("userFeedBackSaying").value;
    var selectedRating = null;

    for (var star of stars) {
        if (star.checked) {
            selectedRating = star.value;
            break;
        }
    }

    if (selectedRating > 1) {

        var f = new FormData();
        f.append("starCount", selectedRating);
        f.append("text", text);

        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;
                if (t == "success") {
                    Swal.fire({
                        title: 'Thank You!',
                        text: "Your feedback has been saved",
                        icon: 'success',
                        confirmButtonText: 'Okay',
                        confirmButtonColor: "#071952"
                    })
                        .then(() => {
                            window.location.reload();
                        })
                } else {
                    Swal.fire({
                        title: 'Oops...',
                        text: t,
                        icon: 'error',
                        confirmButtonText: 'Okay',
                        confirmButtonColor: "#071952"
                    })
                }
            }
        }
        r.open("POST", "saveCustomerRatingProcess.php", true);
        r.send(f);

    } else {
        alert('Please select a rating.');
    }

}