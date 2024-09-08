<?php
session_start();
require_once '../utils/DB.php';
require_once '../models/UserModel.php';
require_once '../utils/Mailer.class.php';
$db = new DB();
$model = new UserModel($db);

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

function verifyEmail() {
    try {
        if (isset($_POST['email'])) {
            global $model;
            
            if ($model->verifyEmail($_POST['email'])===true) {
                http_response_code(200);
            }
            else {
                http_response_code(404);
            }
        }
    } catch (Exception $th) {
        http_response_code(400);
    }
}

function createFogotSession() {
    try {
        if (isset($_POST['email'])) {
            $data = array(
                "email" => $_POST['email'],
                "token" => "",
                "otp" => ""
            );

            if (isset($_SESSION['fogot'])) {
                unset($_SESSION['fogot']);
            }
    
            $_SESSION['fogot'] = $data;
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        
    } catch (Exception $th) {
        http_response_code(400);
    }
}

function getUsername() {
    if (isset($_SESSION['fogot']['email'])) {
        echo $_SESSION['fogot']['email'];
    }
}

function sendOTP() {
    try {
        if (isset($_SESSION['fogot']['email'])) {
            $email = $_SESSION['fogot']['email'];
            $subject = "BirthLink OTP";
            $otp = mt_rand(10000,99999);
            $massege = "Your BirthLink fogot password OTP is ".$otp." .";
            $mailer = new Mailer();
            
            // $_SESSION['personalData']['otp'] = $otp; 
            // echo $_SESSION['personalData']['otp'];
            
            if ($mailer->send($email,$subject,$massege)) {
                $_SESSION['fogot']['otp'] = $otp; 
                http_response_code(200);
                echo $_SESSION['fogot']['otp'];
            }
            else {
                http_response_code(400);
            }
        }else {
            http_response_code(400);
        }
    } catch (Exception $th) {
        http_response_code(400);
    }
    
}

function verifyOTP() {
    if (isset($_SESSION['fogot']['email'])) {
        $otp = $_POST['otp'];
        $ootp = $_SESSION['fogot']['otp'];
        if ((string)$ootp===(string)$otp) {
            global $model;
            $result = $model->setToken($_SESSION['fogot']['email']);
            if ($result != false) {
                $_SESSION['fogot']['token'] = $result;
            }
            if ($_SESSION['fogot']['token'] != "") {
                http_response_code(200);
            }
            else{
                http_response_code(400);
            }
            
        }else {
            echo "wrong-OTP";
        }
    }
    else {
        http_response_code(400);
    }
}


?>