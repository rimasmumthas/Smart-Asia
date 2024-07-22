<?php

session_start();
require "connection.php";

if (isset($_SESSION["admin"])) {

    $catId = $_GET["catId"];

    $cat_rs = Database::search("SELECT * FROM category WHERE id='" . $catId . "'");
    $cat_data = $cat_rs->fetch_assoc();
?>

    <div class="col-12 d-flex align-items-center gap-1 mb-1">
        <i class="fa-solid fa-square-plus"></i>
        <span class="fw-semibold">Update Category</span>
    </div>
    <div class="alert alert-danger w-100 d-none" id="updateCategoryError" role="alert"></div>
    <div class="col-12 d-flex justify-content-center gap-3 my-2">
        <div>
            <div class="col-12 d-flex justify-content-center mt-2 gap-2">
                <div class="border border-secondary rounded-3 p-3">
                    <img src="<?php echo $cat_data['cat_path'] ?>" class="img-fluid" height="150px" width="150px" id="catImageView" />
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center mt-3">
                <input type="file" class="d-none" id="catImageUploader" />
                <label for="catImageUploader" class="defaultButton2" onclick="changeUpdateCategoryImage();">Upload Image</label>
            </div>
        </div>
        <div class="d-flex flex-column gap-2">
            <div>
                <span class="fw-semibold">Category Name</span>
                <input type="text" class="form-control shadow-none mt-1" value="<?php echo $cat_data['cat_name'] ?>" id="updateCatName">
            </div>
            <div>
                <button class="btn btn-success w-100" onclick="updateCategory(<?php echo $catId ?>);">Update Category</button>
            </div>
            <div>
                <button class="btn btn-dark w-100" onclick="document.getElementById('updateCategoryform').className='d-none'">Cancel</button>
            </div>
        </div>
    </div>

<?php

} else {
    header("Location:http://localhost/smart_asia/index.php");
}
