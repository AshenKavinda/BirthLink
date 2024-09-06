<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <style>
    body {
            width: 100vw;
            height: 100vh;
    }
  </style>
  <body style="background-color:#E2E2E2;">
    <div class="d-flex flex-column align-items-center justify-content-center w-100 h-100">
      
      <div class="p-4 m-3 rounded-4 w-50 shadow" style="background-color: rgb(255, 255, 255);color: rgb(122, 122, 122);font-weight: 700;">
          <!--hedder-->
          <div class="text-center mb-4">
            <samp class="" style="font-family:Arial, Helvetica, sans-serif;font-weight: 700;font-size: 2rem;">Personal Details</samp>
          </div>

          <!--form body-->
          <div class="col-12">

            <div class="row g-2">
              <div class="col-md-6 input-group-sm">
                <label for="first-name" class="form-label">First Name</label>
                <input type="text" class="form-control" name="firstName" id="firstName">
              </div>
              <div class="col-md-6 input-group-sm">
                <label for="first-name" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lastName" id="lastName">
              </div>
            </div>
          </div>

          <div class="col-md-12 input-group-sm">
              <label for="first-name" class="form-label">NIC</label>
              <input type="text" class="form-control" name="NIC" id="NIC">
          </div>

          <div class="col-md-6 input-group-sm">
            <label for="inputEmail4" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email">
          </div>

          <div class="col-md-6 input-group-sm">
            <label for="inputEmail4" class="form-label">Phone No</label>
            <input type="number" class="form-control" name="phone" id="phone">
          </div>
          
          <div class="col-12 input-group-sm">
            <label for="inputAddress" class="form-label">Address</label>
            <input type="text" class="form-control" name="inputAddress" id="inputAddress" placeholder="1234 Main St">
          </div>

          <div class="col-12 input-group-sm">
            <label for="inputAddress2" class="form-label">Address 2</label>
            <input type="text" class="form-control" name="inputAddress2" id="inputAddress2" placeholder="Apartment, studio, or floor">
          </div>

          <div class="col-md-6 input-group-sm">
            <label for="inputCity" class="form-label">City</label>
            <input type="text" class="form-control" name="inputCity" id="inputCity">
          </div>

          <div class="col-md-2 input-group-sm">
            <label for="inputZip" class="form-label">Zip</label>
            <input type="text" class="form-control" name="inputZip" id="inputZip">
          </div>

          <div class="col-12 input-group-sm">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="checkbox">
              <label class="form-check-label" for="gridCheck">
                Check me out
              </label>
            </div>
          </div>

          <div class="col-12 d-flex justify-content-end">
            <button id="btnNext" class="btn btn-primary px-5 border-0" style="font-weight: 700;background-color: blueviolet;" onclick="createPerson()">NEXT</button>
          </div>
      </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>

      function createPerson() {
        if (validateInputFeild()) {
          $.ajax({
            url: '../controllers/SignUpController.php',
            method: 'post',
            data: {
              action: 'createUserSession',
              firstName: $('#firstName').val().trim(),
              lastName: $('#lastName').val().trim(),
              NIC: $('#NIC').val().trim(),
              email: $('#email').val().trim(),
              phone: $('#phone').val().trim(),
              inputAddress: $('#inputAddress').val().trim(),
              inputAddress2: $('#inputAddress2').val().trim(),
              inputCity: $('#inputCity').val().trim(),
              inputZip: $('#inputZip').val().trim()
            },
            success: function(response) {
              $('body').fadeOut(1000, function() { // 1000ms = 1 second
                window.location.href = 'FormSetPassword.php?email='+response; // Redirect after fade out
              });
            }
          });
        }
      }

      function validateInputFeild() {
      
        var firstName = $('#firstName').val().trim();
        var lastName = $('#lastName').val().trim();
        var NIC = $('#NIC').val().trim();
        var email = $('#email').val().trim();
        var phone = $('#phone').val().trim();
        var inputAddress = $('#inputAddress').val().trim();
        var inputAddress2 = $('#inputAddress2').val().trim();
        var inputCity = $('#inputCity').val().trim();
        var inputZip = $('#inputZip').val().trim();
        var Checkbox = $('#checkbox').is(':checked');

        if (firstName === "") {
          alert("First name cannot be empty.");
          $('#firstName').focus();
          return false;
        }
        if (lastName === "") {
          alert("Last name cannot be empty.");
          $('#lastName').focus();
          return false;
        }
        if (NIC === "") {
          alert("NIC cannot be empty.");
          $('#NIC').focus();
          return false;
        }
        if (phone === "") {
          alert("Phone number cannot be empty.");
          $('#phone').focus();
          return false;
        }
        if (isNaN(phone)) {
          alert("Phone number should be numeric.");
          $('#phone').focus();
          return false;
        }
        if (inputAddress === "") {
          alert("Address cannot be empty.");
          $('#inputAddress').focus();
          return false;
        }
        if (inputAddress2 === "") {
          alert("Address 2 cannot be empty.");
          $('#inputAddress2').focus();
          return false;
        }
        if (inputCity === "") {
          alert("City cannot be empty.");
          $('#inputCity').focus();
          return false;
        }
        if (inputZip === "") {
          alert("ZIP cannot be empty.");
          $('#inputZip').focus();
          return false;
        }
        if (!Checkbox) {
          alert("Please check the checkbox.");
          $('#checkbox').focus();
          return false;
        }

        return true;
      }

    </script>
  </body>
</html>