<?php

require "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

$email = $_GET["e"];

if (!$email) {
    echo 'Please type your email address';
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Please type a valid email address';
} else if (strlen($email) > 100) {
    echo 'Email length must be less than 100 characters';
} else {

    $user_result = Database::search("SELECT * FROM `admin` WHERE `email`='" . $email . "'");
    $user_number = $user_result->num_rows;

    if ($user_number !== 0) {

        $code = rand(100000, 999999);

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rimasmumthasofficial@gmail.com';
        $mail->Password = 'mhbjklfbabctpnnt';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('rimasmumthasofficial@gmail.com', 'Email Verification');
        $mail->addReplyTo('rimasmumthasofficial@gmail.com', 'Email Verification');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Smart Asia admin verification process';
        $bodyContent = '<h3>Your verification code is <br/> ' . $code . '</h3>';
        $mail->Body    = $bodyContent;

        if (!$mail->send()) {
            echo 'sending failed';
        } else {

            Database::iud("UPDATE `admin` SET verification_code='" . $code . "' WHERE email='" . $email . "'");
            echo 'success';
        }
    } else {
        echo 'There is no account for this email';
    }
}
