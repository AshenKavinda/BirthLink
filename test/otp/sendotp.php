<?php

if (isset($_POST['name']) && isset($_POST['tel'])) {
    # code...
    // Authorisation details.
    $username = "kavindahemarathna456@gmail.com";
    $hash = "533bbf8a5522dec9aad68c8d3e2b06561767cde24748909ce9a521ddbefd20d3";
    
    // Config variables. Consult http://api.txtlocal.com/docs for more info.
    $test = "0";
    $otp = mt_rand(10000,99999);
    setcookie("otp",$otp);
    
    // Data for text message. This is the text message data.
    $sender = "API Test"; // This is who the message appears to be from.
    $numbers = $_POST['tel'];
    $name =  $_POST['name'];
    $message = "Hay ".$name. " your otp is ".$otp;
    echo $numbers . "<br>";
    echo $message . "<br>";
    // 612 chars or less
    // A single number or a comma-seperated list of numbers
    $message = urlencode($message);
    $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
    $ch = curl_init('https://api.txtlocal.com/send/?');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch); // This is the result from the API
    if ($result) {
        echo "OTP is successfuly sent";
    }
    else {
        echo "Something went wrong please try again";
    }
    curl_close($ch);
}
?>
