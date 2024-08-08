<?php 

if (isset($_POST['otp'])) {
    $uotp = $_POST['otp'];
    $otp = $_COOKIE["otp"];

    if ($uotp == $otp) {
        echo "OTP is correct";
    }
    else {
        echo "OTP is not correct";
    }
}

?>