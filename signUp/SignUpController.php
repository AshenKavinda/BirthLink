<?php
session_start();
require_once '../models/Mother.php';
require_once '../utils/Mailer.class.php';
$mother = new Mother();
$mailer = new Mailer();

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
        global $user;
        $result = $user->validateUser($email,$password);
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
            "bday" => $_POST['bday'],
            "latitude" => $_POST['latitude'],
            "longitude" => $_POST['longitude'],
            "password" => "",
            "otp" => "",
            "otp-time" => ""
        );


        if (isset($_SESSION['personalData'])) {
            unset($_SESSION['personalData']);
        }
        $_SESSION['personalData'] = $dataArr;

        if (isset($_SESSION['personalData'])) {
            http_response_code(200);
        }
        else {
            throw new Exception();
        }
    } catch (\Throwable $th) {
        http_response_code(400);
    }
}

function setPassword() {
    try {
        if (isset($_SESSION['personalData'])) {
            $_SESSION['personalData']['password'] = $_POST['password'];
            http_response_code(200);
        }
        else {
            throw new Exception();
        }
    } catch (Exception $th) {
        http_response_code(400);
    }
    
}

function getUsername() {
    try {
        if (isset($_SESSION['personalData'])) {
            if (isset($_SESSION['personalData']['email'])) {
                http_response_code(200);
                echo $_SESSION['personalData']['email'];
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
        if (isset($_SESSION['personalData'])) {
            $email = $_SESSION['personalData']['email'];
            $subject = "BirthLink OTP";
            $otp = mt_rand(10000,99999);
            $massege = "Your BirthLink OTP is ".$otp." .";
            
            
            // $_SESSION['personalData']['otp'] = $otp; 
            // echo $_SESSION['personalData']['otp'];
            global $mailer;
            if ($mailer->send($email,$subject,$massege)) {
                $_SESSION['personalData']['otp'] = $otp;
                $_SESSION['personalData']['otp-time'] = time();
                http_response_code(200);
            }
            else {
                throw new Exception();
            }
        }else {
            throw new Exception();
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
    
}

function verifyOTP() {
    try {
        
        if (isset($_SESSION['personalData'])) {
            $otp = $_POST['otp'];
            //error line
            $ootp = $_SESSION['personalData']['otp'];
            $otpTime = $_SESSION['personalData']['otp-time'];
            $currentTime = time();
            // Check if OTP has expired (2 minutes = 120 seconds)
            
            if (($currentTime - $otpTime) > 120) {
                // OTP expired
                unset($_SESSION['personalData']['otp']);
                unset($_SESSION['personalData']['otp-time']);
                throw new Exception("OTP expired!");
            }

            
            if ((string)$ootp===(string)$otp) {
                $fName = $_SESSION['personalData']['fName'];
                $lName = $_SESSION['personalData']['lName'];
                $nic = $_SESSION['personalData']['nic'];
                $email = $_SESSION['personalData']['email'];
                $phone = $_SESSION['personalData']['phone'];
                $address = $_SESSION['personalData']['address'].", ".$_SESSION['personalData']['address2'].", ".$_SESSION['personalData']['city'];
                $password = $_SESSION['personalData']['password'];
                $bDay = $_SESSION['personalData']['bday'];
                $latitude = $_SESSION['personalData']['latitude'];
                $longitude = $_SESSION['personalData']['longitude'];
                global $mother;
                $result = $mother->addUser($fName,$lName,$nic,$phone,$email,$address,$password,$bDay,$latitude,$longitude);
                if ($result!= null) {
                    unset($_SESSION['personalData']);
                    http_response_code(200);
                    exit();
                }
                else{
                    http_response_code(200);
                    echo "EmailExist";
                    exit();
                }
                
            }else {
                throw new Exception("Wrong OTP");
            }
        }
        else {
            throw new Exception("System error!");
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
    
}


?>