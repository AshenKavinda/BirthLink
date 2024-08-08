<?php
require_once("classes/Mailer.class.php");
require_once("classes/User.class.php");
session_start();

echo $_SESSION['uID'];
/*
$mail = new Mailer();
$result = $mail->send("kavindahemarathna321@gmail.com","testEmail2","test email this");
echo $result;*/

$user = new User();
$password = password_hash("1234",PASSWORD_DEFAULT);
//$result = $user->addUser("ashen","kavinda","1212121212","078544452","as@as.as","galle",$password);
//echo $result;
/*
$result = $user->validateUser("as@as.as","1234");
echo $result;*/
/*
$result = $user->getuIDByEmail("kavindahemarathna321@gmail.com");
echo $result;*/
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styleindex.css">
  </head>
  <body>
    <div class="midPanelsignUp">
        <div>
          <span>ddddd</span>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>