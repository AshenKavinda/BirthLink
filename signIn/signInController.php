<?php
require_once '../utils/DB.php';
require_once '../models/UserModel.php';
session_start();
$db = new DB(); 
$model = new UserModel($db) ;


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

function signIn() {
  try {
    if (isset($_POST['username']) && isset($_POST['password'])) {
      global $model;
      $result = $model->validateUser($_POST['username'],$_POST['password']);
      if ($result) {
        $row = $model->getUserByEmail($_POST['username']);
        if ($row != false) {
          $_SESSION['uID'] = $row['uID'];
          $type = $row['type'];
          http_response_code(200);
          echo $type;
        }
        else {
          throw new Exception();
        }
      }
      else {
        throw new Exception();
      } 
    }
    else {
      throw new Exception();
    }
  } catch (Exception $th) {
    http_response_code(400);
  }
}

?>