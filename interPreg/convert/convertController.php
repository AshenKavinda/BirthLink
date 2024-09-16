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

function addToSession() {
    try {
        if (isset($_POST['bDay']) && isset($_POST['gender']) && isset($_POST['pID'])) {
            $data = array(
                "pID" => $_POST['pID'],
                "bDay" => $_POST['bDay'],
                "birthNo" => $_POST['birthNo'],
                "gender" => $_POST['gender']
            );

            if (!isset($_SESSION['baby'])) {
                $_SESSION['baby'] = array();
            } else {
                $_SESSION['baby'][] = $data;
                http_response_code(200);
                exit();
            }
        } else {
            throw new Exception("System error!");
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
}

?>

