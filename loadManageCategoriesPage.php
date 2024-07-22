<?php

session_start();
require "connection.php";
if (isset($_SESSION["admin"])) {
?>

    <div class="col-12">
        <h4>Hello wrold</h4>
    </div>

<?php
} else {
    header("Location:http://localhost/smart_asia/index.php");
}
?>