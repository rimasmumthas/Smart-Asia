<?php

require "connection.php";
$email = $_POST['email'];
$code = $_POST['code'];

$resultset = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' AND `verification_code`='" . $code . "'");
$result_num = $resultset->num_rows;

if ($result_num == 1) {
    echo ("success");
} else {
    echo ("invalid code");
}
