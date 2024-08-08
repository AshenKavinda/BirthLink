<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
      body{
        width: 100vw;
        height: 100vh;
        background-color:#E2E2E2;
      }
    </style>
  </head>
  <body>
    <div class="container-fluid h-100">
      <div class="d-flex flex-column w-100 h-100 align-items-center justify-content-center">
        <div class="rounded-4 shadow p-5" style="background-color:#fff;width:30vw;">
          <form class="" action="signIn.php" method="post">
            
            <div class="d-flex flex-column align-content-center justify-content-center gap-2">
  
              <div class="text-center w-100" style="font-size: 3vw;color: #7E30E1;font-weight: 700;">Welcome!</div>
  
              <div class="row">
                <label for="inputEmail3" class="col-form-label">Email</label>
                <div class="">
                  <input name="username" type="text" class="form-control form-control-md" id="inputEmail3"
                    placeholder="Email" required>
                </div>
              </div>
              
              <div class="">
                <label for="inputPassword3" class="col-form-label">Password</label>
                <div class="">
                  <input name="password" type="password" class="form-control form-control-md" id="inputPassword3" placeholder="Password" required>
                </div>
              </div>
  
              <div>
                <?php if(isset($_GET['invalied'])) : ?>
                  <span class="float-start text-decoration-none fontSizeSignIn" style="color: #e13030;">Invalied userName or password</span><br>
                <?php endif; ?>
                <a href="http://" class="text-decoration-none fontSizeSignInFogot"
                style="color: #7E30E1; font-size: 16px; cursor: pointer;">forgot password?</a>
              </div>
  
              <button name="SigninSubmit" type="submit" class="btn w-100 py-2" style="background-color: #7E30E1;font-weight: 700;color: #fff;">Sign in</button>
            </div>
            
            <div class="mt-3">
              <span>Don't have an account? <a href="SignUp/personalData.php" style="font-weight: 600;font-size: 16px; color: #7E30E1;text-decoration: none;">Sign-Up</a></span>
            </div>
          </form>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/scriptIndex.js"></script>
  </body>
</html>