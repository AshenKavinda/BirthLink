function lordImage() {

  resetmidPanel();
  document.getElementById("rightPanel").className = "rightPanels1b"; 
  document.getElementById('btn2').classList.add("gray-0");
  setTimeout(function (){

      document.getElementById("rightPanel").className = "rightPanel";
                
    }, 1);
  setTimeout(function (){
        document.getElementById('rightPanelContent').style.opacity = '1' ;
      document.getElementById("rightPanelContent").innerHTML = `
            <div id="rightPanelContent" class="d-flex flex-column justify-content-between h-100">
            <div class="mx-5 mt-2">
              <p>
                <span style="font-size: 5vw;font-weight: 600;">BirthLink</span><br>
                <span style="font-size: 1.5vw;">Little Miracles, Big Smiles</span>
              </p>
            </div>
            <div class="h-100 w-100 d-flex flex-column align-items-center justify-content-center imgContainer">
              <img src="img/coverImg.png" alt="Mother Image">
            </div>`;

      document.getElementById("rightPanel").className = "rightPanels2";
      
                
    }, 1000);
  
}

function SignUp() {

    var eliment =  document.getElementById('midPanel');
    //eliment.classList.toggle("midPanelsignUp");

    
    if (eliment.classList.contains("midPanelsignUp")) {
        eliment.classList.remove("midPanelsignUp") ;
        lordImage();
    }
    else
    {
        document.getElementById('rightPanelContent').style.opacity = '0' ;
        document.getElementById('midPanel').className = "midPanelsignUp";
        document.getElementById('rightPanel').className = "rightPanelWhite";
        document.getElementById('btn1').classList.remove("gray-100");
        document.getElementById('btn2').classList.remove("gray-0");
        document.getElementById('btn2').classList.add("gray-100");
        document.getElementById('midPanel').innerHTML = `<h1>Sign-up</h1>`;

    }

    
}

function resetmidPanel() {
    document.getElementById('midPanel').className = "midPanel";
    document.getElementById('midPanel').innerHTML = `
        <div class="w-100 h-100 position-relative overflow-hidden">

            <div class="p-5 d-flex flex-column justify-content-center w-100 h-100 fontSizeSignIn">
              
              <form class="" action="index1.php" method="post">
                
                <div class="d-flex flex-column align-content-center justify-content-center gap-2">

                  <div class="hedder text-center w-100">Welcome!</div>

                  <div class="row">
                    <label for="inputEmail3" class="col-form-label">Email</label>
                    <div class="">
                      <input name="username" type="text" class="form-control form-control-lg" id="inputEmail3"
                        placeholder="Email" required>
                    </div>
                  </div>
                  
                  <div class="row">
                    <label for="inputPassword3" class="col-form-label">Password</label>
                    <div class="">
                      <input name="password" type="password" class="form-control form-control-lg" id="inputPassword3"
                        placeholder="Password" required>
                      <a href="http://" class="float-start text-decoration-none fontSizeSignIn" style="color: #e13030;">
                        <?= $invalid ;?>
                      </a>
                    </div>
                  </div>

                  <div>
                    <a href="http://" class="text-decoration-none fontSizeSignInFogot"
                    style="color: #7E30E1; font-size: 16px; cursor: pointer;">forgot password?</a>
                  </div>

                  <button name="SigninSubmit" type="submit" class="btn w-100 py-2 fontSizeSignIn"
                  style="background-color: #7E30E1;font-weight: 700;color: #fff;">Sign in</button>
                </div>
                
                
                <div class="mt-3 signup-midpanel">
                  <span>Don't have an account? <a href="http://"
                      style="font-weight: 600;font-size: 16px; color: #7E30E1;text-decoration: none;">Sign-Up</a></span>
                </div>
              </form>

            </div>

          </div> `;
    document.getElementById('btn1').classList.remove("gray-0");
    document.getElementById('btn1').classList.add("gray-100");
}

