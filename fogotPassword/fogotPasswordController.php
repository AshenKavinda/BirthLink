<?php
session_start();
require_once '../utils/DB.php';
require_once '../models/User.php';
require_once '../utils/MailerMailGun.php';
$db = new DB();
$user = new User($db);

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
            global $user;
            
            if ($user->verifyEmail($_POST['email'])===true) {
                http_response_code(200);
            }
            else {
                throw new Exception();
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
            throw new Exception();
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

function confirm() {
    
    try {
        if (isset($_POST['password']) && isset($_SESSION['fogot']['token'])) {
            global $user;
            $token = $_SESSION['fogot']['token'];
            $email = $_SESSION['fogot']['email'];
            $password = $_POST['password'];
            if ($user->matchToken($email,$token)) {
                $result = $user->updatePasswordByEmail($email,$password);
                if ($result) {
                    if ($user->setToken($_SESSION['fogot']['email'])>1) {
                        unset($_SESSION['fogot']);
                        http_response_code(200);
                    } else {
                        throw new Exception();
                    }
                }else {
                    throw new Exception();
                } 
            }
            else {
                throw new Exception();
            }
        }
    } catch (Exception $th) {
        http_response_code(400);
    }
}

function sendOTP() {
    try {
        if (isset($_SESSION['fogot']['email'])) {
            $email = $_SESSION['fogot']['email'];
            $subject = "BirthLink OTP";
            $otp = mt_rand(10000,99999);
            $massege = "Your BirthLink fogot password OTP is ".$otp." .";
            $mailer = new MailerMailGun();
            
            // $_SESSION['personalData']['otp'] = $otp; 
            // echo $_SESSION['personalData']['otp'];
            
            if ($mailer->send($email,$subject,$massege)) {
                $_SESSION['fogot']['otp'] = $otp; 
                http_response_code(200);
            }
            else {
                throw new Exception();
            }
        }else {
            throw new Exception();
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
            global $user;
            $result = $user->setToken($_SESSION['fogot']['email']);
            if ($result != false) {
                $_SESSION['fogot']['token'] = $result;
            }
            if ($_SESSION['fogot']['token'] != "") {
                http_response_code(200);
            }
            else{
                throw new Exception();
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