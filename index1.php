<?php
require_once('classes/DB.class.php');
require_once('classes/SignIn.class.php');
session_start();
$db = new DB;
$signIn = new SignIn ;
$invalid = " " ;
if (array_key_exists('SigninSubmit',$_POST)) {
  $result = $signIn->validate($_POST['username'],$_POST['password']);
  if ($result == 1) {
    $uID = $signIn->getuIDByEmail($_POST['username']);
    if ($uID != 2) {
      $_SESSION['uID'] = $uID;
    }
    header('Location: test.php');
  }
  else {
    $invalid = "Invalied userName or password" ;
  }
  try {
  } catch (\Throwable $th) {
    //throw $th;
  }

}

?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styleIndex.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="container-fluid">
      <div class="design">
        
        <div class="leftPanel leftPanel_anime" id="leftPanel">

          <div class="leftPanelcontent py-4 gap-2 h-100 d-flex flex-column justify-content-around">

            <div class="menubar h-auto gray-100" id="btn1" onclick="SignUp()">
              <div class="d-flex flex-row">
                  <div style="background-color: green; width: 0.5vw; "></div>
                  <div class="text-center d-flex flex-column justify-content-center align-items-center">
                    <img src="img/sign-up.png" class="mx-4 mt-3" alt="" srcset="" style="width: 4vw; margin-left: 1vw;">
                    <label for="" style="font-size: 1.2vw; font-weight: 600;">Sign-Up</label>
                  </div>
              </div>
            </div>
            

            <div class="menubar gray-0" onclick="lordImage()" id="btn2">
              <div class="d-flex flex-row">
                  <div style="background-color: green; width: 0.5vw; "></div>
                  <div class="text-center d-flex flex-column justify-content-center align-items-center">
                    <img src="img/sign-in.png" class="mx-4 mt-3" alt="" srcset="" style="width: 4vw; margin-left: 1vw;">
                    <label for="" style="font-size: 1.2vw; font-weight: 600;">Sign-In</label>
                  </div>
              </div>
            </div>


            <a href="About.html" class="text-decoration-none">
              <div class="menubar gray-100" id="btn3">
                <div class="d-flex flex-row">
                    <div style="background-color: green; width: 0.5vw; "></div>
                    <div class="text-center d-flex flex-column justify-content-center align-items-center">
                      <img src="img/staff.png" class="mx-4 mt-3" alt="" srcset="" style="width: 4vw; margin-left: 1vw;">
                      <label for="" style="font-size: 1.2vw; font-weight: 600;">About</label>
                    </div>
                </div>
              </div>
            </a>
              
          </div>

        </div>

        <div class="rightPanel rightPanel_anime" id="rightPanel">
          <div id="rightPanelContent" class="d-flex flex-column justify-content-between h-100">
            <div class="mx-5 mt-2">
              <p>
                <span style="font-size: 5vw; font-weight: 600;">BirthLink</span><br>
                <span style="font-size: 1.5vw;">Little Miracles, Big Smiles</span>
              </p>
            </div>
            <div class="h-100 w-100 d-flex flex-column align-items-center justify-content-center position-relative overflow-hidden imgContainer">
              <img src="img/coverImg.png" alt="Mother Image">
            </div>
          </div>
        </div>

        

         <div class="midPanel" id="midPanel">
          <div class="p-5 d-flex flex-column justify-content-center w-100 h-100 fontSizeSignIn">
            <label for="" class="hedder mb-4 text-center w-100" style="color: #7E30E1;font-size: 4vw; font-weight: 700;">Welcome !</label>
            <form class="" action="index1.php" method="post">
              <div class="row mb-3">
                <label for="inputEmail3" class="col-form-label">Email</label>
                <div class="">
                <input name="username" type="text" class="form-control form-control-lg" id="inputEmail3" placeholder="Email" required>
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputPassword3" class="col-form-label">Password</label>
                <div class="">
                  <input name="password" type="password" class="form-control form-control-lg" id="inputPassword3" placeholder="Password" required>
                  <a href="http://" class="float-end text-decoration-none fontSizeSignInFogot" style="color: #7E30E1;">fogot password?</a>
                  <a href="http://" class="float-start text-decoration-none fontSizeSignIn" style="color: #e13030;"><?= $invalid ;?></a>
                </div>
              </div>
              <button name="SigninSubmit" type="submit" class="btn w-100 py-2 fontSizeSignIn" style="background-color: #7E30E1;font-weight: 700;color: #fff;">Sign in</button>
              <div class="mt-3 signup-midpanel">
                <span>Don't have an account? <a href="http://" style="font-weight: 600; color: #7E30E1;text-decoration: none;">Sign-Up</a></span>
              </div>
            </form>
    
          </div>
         </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/scriptIndex.js"></script>
  </body>
</html>