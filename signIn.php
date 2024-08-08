<?php
require_once('classes/DB.class.php');
require_once('classes/User.class.php');
session_start();
$signIn = new User() ;
if (isset($_POST['username']) && isset($_POST['password'])) {
  $result = $signIn->validateUser($_POST['username'],$_POST['password']);
  if ($result == true) {
    $uID = $signIn->getuIDByEmail($_POST['username']);
    if ($uID != 2) {
      $_SESSION['uID'] = $uID;
    }
    header('Location: test.php');
  }
  else {
    header('Location: index1.php?invalied');
  }

}

?>