<?php
session_start();

if (isset($_POST['submit'])) {
    $dataArr = array(
        "fName" => $_POST['firstName'],
        "lName" => $_POST['lastName'],
        "nic" => $_POST['NIC'],
        "email" => $_POST['email'],
        "phone" => $_POST['phone'],
        "address" => $_POST['inputAddress'],
        "address2" => $_POST['inputAddress2'],
        "city" => $_POST['inputCity'],
        "zip" => $_POST['inputZip'],
        "password" => "",
        "otp" => ""
    );

    if (isset($_SESSION['personalData'])) {
        unset($_SESSION['personalData']);
    }
    $_SESSION['personalData'] = $dataArr;
    

    
    header('location: FormVerify.php');  
}

?>