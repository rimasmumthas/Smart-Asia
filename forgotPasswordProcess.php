<?php

require "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_GET["e"])) {

    $email = $_GET["e"];

    $rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");
    $n = $rs->num_rows;

    if ($n == 1) {

        $code = rand(100000, 999999);

        Database::iud("UPDATE `user` SET `verification_code`='" . $code . "' WHERE `email`='" . $email . "'");

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rimasmumthasofficial@gmail.com';
        $mail->Password = 'mhbjklfbabctpnnt';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('rimasmumthasofficial@gmail.com', 'Reset Password');
        $mail->addReplyTo('rimasmumthasofficial@gmail.com', 'Reset Password');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Smart Asia forgot password verification code';
        $bodyContent = '<h3>Your verification code is <br/>  ' . $code . '</h3>';
        $mail->Body    = $bodyContent;

        if (!$mail->send()) {
            echo 'verification code sending failed';
        } else {
            echo 'success';
        }
    } else {
        echo ("Invalid Email Address");
    }
}
