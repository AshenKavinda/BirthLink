<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="signup.css">
  </head>
  <body style="background-color:#E2E2E2;">
    <div class="d-flex flex-column align-items-center justify-content-center w-100 h-100">
      <div class="p-4 m-3 rounded-4 w-50 shadow" style="background-color: rgb(255, 255, 255);color: rgb(122, 122, 122);font-weight: 700;">

        <form class="row g-2" action="createpersonalDataSesstion.php" id="formPersonalData" name="formPersonalData" method="post">
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
            <button type="submit" name="submit" class="btn btn-primary px-5 border-0" style="font-weight: 700;background-color: blueviolet;" >NEXT</button>
          </div>

        </form>
      </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
      //form validation
      document.getElementById('formPersonalData').addEventListener('submit',function(event){
        event.preventDefault();
        var firstName = document.getElementById('firstName');
        var lastName = document.getElementById('lastName');
        var NIC = document.getElementById('NIC');
        var email = document.getElementById('email');
        var phone = document.getElementById('phone');
        var inputAddress = document.getElementById('inputAddress');
        var inputAddress2 = document.getElementById('inputAddress2');
        var inputCity = document.getElementById('inputCity');
        var inputZip = document.getElementById('inputZip');
        var Checkbox = document.getElementById('checkbox');

        if (firstName.value.trim() === "") {
          alert("First name can not be empty.");
          firstName.focus();
          return false;
        }
        if (lastName.value.trim() === "") {
          alert("Last name can not be empty.");
          lastName.focus();
          return false;
        }
        if (NIC.value.trim() === "") {
          alert("NIC can not be empty.");
          NIC.focus();
          return false;
        }
        if (phone.value.trim() === "") {
          alert("Phone number can not be empty.");
          phone.focus();
          return false;
        }
        if (isNaN(phone.value.trim())) {
          alert("Phone number shuld be numaric");
          phone.focus();
          return false;
        }
        if (inputAddress.value.trim() === "" ) {
          alert("Address can not be empty.");
          inputAddress.focus();
          return false;
        }
        if (inputAddress2.value.trim() === "" ) {
          alert("Address 2 can not be empty.");
          inputAddress2.focus();
          return false;
        }
        if (inputCity.value.trim() === "" ) {
          alert("City can not be empty.");
          inputCity.focus();
          return false;
        }
        if (inputZip.value.trim() === "" ) {
          alert("ZIP can not be empty.");
          inputZip.focus();
          return false;
        }
        if (!Checkbox.checked) {
          alert("Please check");
          Check.focus();
          return false;
        }

        this.removeEventListener('submit',arguments.callee);
        this.submit();
        

      });
    </script>
  </body>
</html>