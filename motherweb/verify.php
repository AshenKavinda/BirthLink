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

function verifyAuthentication(){
    try {
      if(isset($_SESSION['mother'])){
        http_response_code(200);
        echo $_SESSION['mother'];
        exit();
      }else{
        throw new Exception();
      }
      
    } catch (\Throwable $th) {
      http_response_code(400);
      echo json_encode(array('error' => $th->getMessage()));
      exit();
    }
}

?>