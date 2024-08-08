<?php
session_start();

if (!isset($_SESSION['personalData'])) {
  header("location: personalData.php");
}
if (isset($_SESSION['personalData'])) {
  echo $_SESSION['personalData']['otp'];
}





?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            background-color:#E2E2E2;
        }

        a.disabled {
          pointer-events: none;
          color: gray;
        }

        a.enabled {
          pointer-events: visible;
          color: blue;
        }
    </style>
  </head>
  <body>
    <div class="d-flex flex-column align-items-center justify-content-center w-100 h-100">
      <div class="w-50 p-5 rounded-4 shadow" style="background-color: #fff;">
        <form action="signUp.php" id="formSign-up" method="post">
          <div class="row mb-3 g-4">
            <label for="inputEmail3" class="col-md-3 col-form-label">Username</label>
            <div class="col-md-9">
              <input type="email" class="form-control" id="inputEmail3" name="username" value=<?=$_SESSION['personalData']['email']?> readonly>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputPassword3" class="col-md-3 col-form-label">Password</label>
            <div class="col-md-9">
              <input type="text" id="password" class="form-control" value=<?php echo $_SESSION['personalData']['password'];?> >
            </div>
          </div>
          <div class="row mb-3">
              <label for="inputPassword3" class="col-md-3 col-form-label">Re-Password</label>
              <div class="col-md-9">
                <input type="text" id="Re-Password" name="password" class="form-control" value=<?php echo $_SESSION['personalData']['password'];?> >
              </div>
          </div>
          <div class="row mb-3">
              <label for="inputPassword3" class="col-md-3 col-form-label">OTP</label>
              <div class="col-md-4">
                <input type="text" class="form-control" id="otp" name="otp">
              </div>
              <div class="col-md-5 d-flex flex-column align-items-center justify-content-center">
                  <span class="" id="alart">Check phone number</span>
                  <?php if(isset($_GET['otp'])) : ?>
                    <script>
                      document.getElementById('alart').innerText = "OTP is Incorrect";
                      document.getElementById('alart').style.color = "red";
                    </script>
                  <?php endif; ?>
              </div>
          </div>
          <div class="row mb-3">
              <div class="col-md-3"></div>
              <div class="col-md-5">
                <div class="row">
                  <div class="col-md-6">
                    <a href="sendotp.php" id="sendotp">send-otp</a>
                    <?php if (isset($_GET['reSend'])) : //implement resend text?>
                      <script>
                        document.getElementById('sendotp').innerText = "resend-otp" ;
                      </script>                             
                    <?php endif ; ?>
                  </div>
                  <div class="col-md-4">
                    <span id="time" style="color: rgb(228, 17, 17);">60s</span>
                    <?php if (isset($_GET['reSend'])) : //implement count down function?>
                      <script>
                        var limit = 60 ;
                        document.getElementById('sendotp').setAttribute("class","disabled");
                        
                        var timer = setInterval(function(){
                          limit--;
                          document.getElementById('time').innerText = limit+"s";
                          if (limit === 0) {
                            document.getElementById('time').innerText = "60s";
                            document.getElementById('sendotp').setAttribute("class","enabled");
                            clearInterval(timer);
                          }
                        },1000);
                      </script>
                    <?php endif; ?>
                  </div>
                      
                </div>
              </div>
          </div>
          <div class="d-flex justify-content-end">
              <button type="submit" name="submitSignUp" class="btn px-4 btn-primary border-0" style="font-weight: 700;background-color: blueviolet;color: aliceblue;">Sign-Up</button>
          </div>
        </form>
      </div>
    </div>
    <script>
      document.getElementById('formSign-up').addEventListener('submit',function(event){
        event.preventDefault();
        var password = document.getElementById('password');
        var rePassword = document.getElementById('Re-Password');
        var otp = document.getElementById('otp');

        if (password.value.trim() === "") {
          alert("please enter password");
          password.focus();
          return false;
        }
        if (rePassword.value.trim() === "") {
          alert("please enter again password");
          rePassword.focus();
          return false;
        }

        if (password.value.trim() !== rePassword.value.trim()) {
          alert("Password ia not match");
          return false;
        }
        if (otp.value.trim() === "") {
          alert("please enter OTP");
          otp.focus();
          return false;
        }

        this.removeEventListener('submit',arguments.callee);
        this.submit();

      });

      function setTime() {
        var limit = 60 ;
        setTimeout(function(){
          document.getElementById('time').innerText = limit;
          limit--;
          if (limit === 0) {
            clearTimeout(this);
          }
        },1000);
      }
        

      
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>