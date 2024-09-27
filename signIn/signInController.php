<?php
require_once '../utils/DB.php';
require_once '../models/User.php';
session_start();
$db = new DB(); 
$user = new User($db) ;


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
      global $user;
      $result = $user->validateUser($_POST['username'],$_POST['password']);
      if ($result) {
        $row = $user->getUserByEmail($_POST['username']);
        if ($row != false) {

          switch ($row['type']) {
            case 'mother':
              if(isset($_SESSION['mother'])){
                unset($_SESSION['mother']);
              }
              $_SESSION['mother'] = $row['uID'];
              break;
            case 'midwife':
              if(isset($_SESSION['midwife'])){
                unset($_SESSION['midwife']);
              }
              $_SESSION['midwife'] = $row['uID'];
              break;
            case 'admin':
              if(isset($_SESSION['admin'])){
                unset($_SESSION['admin']);
              }
              $_SESSION['admin'] = $row['uID'];
              break;
            case 'officer':
              if(isset($_SESSION['officer'])){
                unset($_SESSION['officer']);
              }
              $_SESSION['officer'] = $row['uID'];
              break;
            default:
              # code...
              break;
          }

          $type = $row['type'];
          http_response_code(200);
          echo $type;
          exit();
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
    //echo json_encode(array('error' => $th->getMessage()));
    exit();
  }
}


?>