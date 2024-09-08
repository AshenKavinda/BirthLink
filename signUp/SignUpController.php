<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the action (function name) from the request
    $action = $_POST['action'];

    // Check if the function exists and then call it
    if (function_exists($action)) {
        // Call the function dynamically
        $action($_POST); // Pass the $_POST data to the function
    } else {
        echo "Function not found!";
    }
}


function verify() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        global $model;
        $result = $model->validateUser($email,$password);
        if ($result === true) {
            http_response_code(200);
            echo json_encode(['success' => true]);
        }else {
            http_response_code(400);
            echo ['error'=>$result];
        }
    }
}

function createUserSession() {
    try {
        //create data array and assign data from FormPersonalData
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
            unset($_SESSION['personalData']); //if the personalData session alredy exsist, unseting it
        }
        $_SESSION['personalData'] = $dataArr; //assaing data array to session named personalData

        if (isset($_SESSION['personalData'])) {
            http_response_code(200);
            echo $_SESSION['personalData']['email'];
        }
        else {
            http_response_code(400);
        }
    } catch (\Throwable $th) {
        http_response_code(400);
    }
}

function setPassword() {
    if (isset($_SESSION['personalData'])) {
        $_SESSION['personalData']['password'] = $_POST['password'];
        http_response_code(200);
        echo true;
    }
    else {
        http_response_code(400);
        echo false;
    }
}

function getUsername() {
    if (isset($_SESSION['personalData'])) {
        if (isset($_SESSION['personalData']['email'])) {
            http_response_code(200);
            echo $_SESSION['personalData']['email'];
        }
        else {
            http_response_code(400);
        }
    }
}


function sendOTP() {
    require_once '../utils/Mailer.class.php';
    if (isset($_SESSION['personalData'])) {
        $email = $_SESSION['personalData']['email'];
        $subject = "BirthLink OTP";
        $otp = mt_rand(10000,99999);
        $massege = "Your BirthLink OTP is ".$otp." .";
        $mailer = new Mailer();
        
        // $_SESSION['personalData']['otp'] = $otp; 
        // echo $_SESSION['personalData']['otp'];
        
        if ($mailer->send($email,$subject,$massege)) {
            $_SESSION['personalData']['otp'] = $otp; 
            echo $_SESSION['personalData']['otp'];
            http_response_code(200);
        }
        else {
            http_response_code(400);
        }
    }else {
        http_response_code(400);
    }
}

function verifyOTP() {
    if (isset($_SESSION['personalData'])) {
        $otp = $_POST['otp'];
        $ootp = $_SESSION['personalData']['otp'];
        if ((string)$ootp===(string)$otp) {
            require_once '../utils/DB.php';
            require_once '../models/UserModel.php';
            $db = new DB();
            $model = new UserModel($db);
            $fName = $_SESSION['personalData']['fName'];
            $lName = $_SESSION['personalData']['lName'];
            $nic = $_SESSION['personalData']['nic'];
            $email = $_SESSION['personalData']['email'];
            $phone = $_SESSION['personalData']['phone'];
            $address = $_SESSION['personalData']['address'].", ".$_SESSION['personalData']['address2'].", ".$_SESSION['personalData']['city'].", ".$_SESSION['personalData']['zip'];
            $password = $_SESSION['personalData']['password'];
            $result = $model->addUser($fName,$lName,$nic,$phone,$email,$address,$password);
            if ($result) {
                echo "success";
            }
            else{
                echo "unsuccess";
            }
            
        }else {
            echo "wrong-otp";
        }
    }
    else {
        echo "wrong-otp";
    }
}


?>