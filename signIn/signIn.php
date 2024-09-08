<?php
require_once '../utils/DB.php';
require_once '../models/UserModel.php';
session_start();
$db = new DB(); 
$signIn = new UserModel($db) ;
if (isset($_POST['username']) && isset($_POST['password'])) {
  echo $_POST['username'];
  echo $_POST['password'];
  $result = $signIn->validateUser($_POST['username'],$_POST['password']);
  if ($result == "200") {
    $uID = $signIn->getuIDByEmail($_POST['username']);
    if ($uID != 2) {
      $_SESSION['uID'] = $uID;
    }
    header('Location: ../test.php');
  }
  else {
    header('Location: FormSignIn.php?invalied');
  }

}

?>