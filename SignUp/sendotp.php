<?php
session_start();
require_once("../classes/Mailer.class.php");

if (isset($_SESSION['personalData'])) {
    $email = $_SESSION['personalData']['email'];
    $subject = "BirthLink OTP";
    $otp = mt_rand(10000,99999);
    $massege = "Your BirthLink OTP is ".$otp." .";

    $mailer = new Mailer();
    //$_SESSION['personalData']['otp'] = $otp;
    //header("location: FormVerify.php?reSend");
    
    if ($mailer->send($email,$subject,$massege)) {
        $_SESSION['personalData']['otp'] = $otp;
        header("location: FormVerify.php?reSend");
    }
    else {
        echo "Something Went Worng";
    }
}
?>