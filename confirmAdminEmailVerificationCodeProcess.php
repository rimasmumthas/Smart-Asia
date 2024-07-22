<?php
session_start();
require "connection.php";
$email = $_POST['adminEmail'];
$code = $_POST['adminCode'];

$resultset = Database::search("SELECT * FROM `admin` WHERE `email`='" . $email . "' AND `verification_code`='" . $code . "'");
$result_num = $resultset->num_rows;

if ($result_num == 1) {
    $admin = $resultset->fetch_assoc();
    $_SESSION['admin'] = $admin;
    echo ("success");
} else {
    echo ("invalid code");
}
