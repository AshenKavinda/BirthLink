<?php
session_start();

if (!isset($_SESSION['personalData'])) {
  header("location: FormPersonalData.php");
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
      <div class="w-50 p-5 rounded-4 shadow" style="background-color: #fff;color: rgb(122, 122, 122);font-weight: 700;">
        <form action="signUp.php" id="formSign-up" method="post">
            <div class="row mb-3">
                <label for="inputPassword3" class="col-md-3 col-form-label">OTP</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="otp" name="otp">
                </div>
                <div class="col-md-5 d-flex flex-column align-items-center justify-content-center">
                    <span class="" id="alart">Check phone number</span>
                    <?php if(isset($_GET['invaliedotp'])) : ?>
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
                        <a href="sendotp.php" id="sendotp">Resend-otp</a>
                    </div>
                    <div class="col-md-4">
                        <span id="time" style="color: rgb(228, 17, 17);"></span>
                        <?php if (isset($_GET['otpSended'])) : //implement count down function?>
                        <script>
                            var limit = 5 ;
                            document.getElementById('sendotp').setAttribute("class","disabled");
                            
                            var timer = setInterval(function(){
                            limit--;
                            document.getElementById('time').innerText = limit+"s";
                            if (limit === 0) {
                                document.getElementById('time').innerText = limit+"s";
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
                <button type="submit" name="submitSignUp" class="btn px-4 btn-primary border-0" style="font-weight: 700;background-color: blueviolet;color: aliceblue;">Sign-In</button>
            </div>
        </form>
      </div>
    </div>
    <script>
      //form validation
      document.getElementById('formSign-up').addEventListener('submit',function(event){
        event.preventDefault();

        var otp = document.getElementById('otp');

        if (otp.value.trim() === "") {
          alert("please enter OTP");
          otp.focus();
          return false;
        }

        this.removeEventListener('submit',arguments.callee);
        this.submit();

      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>