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
        }
    </style>
  </head>
  <body>
    <div class="d-flex flex-column align-items-center justify-content-center w-100 h-100">
        <div class="w-25">
            <form action="sendotp.php" method="post">
                <div class="row g-4">
                    <div class="col-sm-12">
                        <div class="row">
                            <label for="" class="form-label col-sm-3">Name </label>
                            <input type="text" class="col-sm-9" name="name" id="">  
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <label for="" class="form-label col-sm-3">Phone </label>
                            <input type="tel" class="col-sm-9" name="tel" id="">  
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">SEND</button>
                    </div>
                    <form action="veryfyotp.php" method="post">
                        <div class="col-sm-12">
                            <div class="row">
                                <label for="" class="form-label col-sm-3">OTP </label>
                                <input type="text" class="col-sm-9" name="otp" id="">  
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">verify</button>
                        </div>
                    </form>
    
                </div>
               
            </form>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>