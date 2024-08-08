<?php
session_start();
require_once("../classes/User.class.php");
$user = new User();

    $_SESSION['personalData']['password'] = $_POST['password'];
    if ($_SESSION['personalData']['otp']==$_POST['otp']) {
        if (isset($_SESSION['personalData'])) {
            $fName = $_SESSION['personalData']['fName'];
            $lName = $_SESSION['personalData']['lName'];
            $nic = $_SESSION['personalData']['nic'];
            $email = $_SESSION['personalData']['email'];
            $phone = $_SESSION['personalData']['phone'];
            $address = $_SESSION['personalData']['address'].", ".$_SESSION['personalData']['address2'].", ".$_SESSION['personalData']['city'].", ".$_SESSION['personalData']['zip'];
            $password = password_hash($_SESSION['personalData']['password'],PASSWORD_DEFAULT);
            $result = $user->addUser($fName,$lName,$nic,$phone,$email,$address,$password);
            if ($result) {
                unset($_SESSION['personalData']);
                header("location: ../index1.php?successful");
            }
            else {
                echo "Something Went Wrong!<br>";
                echo "<a href='personalData.php'>Please try again</a>";
            }
        }
        
    }
    else {
        header("location: FormVerify.php?reSend&otp");
    }

?>