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
                <span style="font-size: 5vw; letter-spacing: 0.5rem; font-weight: 600;">BirthLink</span><br>
                <span style="font-size: 1.5vw;">Little Miracles, Big Smiles</span>
              </p>
            </div>
            <div class="h-100 imgContainer">
              <img src="img/mother.png" alt="Mother Image">
            </div>
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
        <div class="p-5 d-flex flex-column justify-content-center w-100 h-100" style="font-size: 1.2vw;">
            <label for="" class="hedder mb-4 text-center w-100" style="color: #7E30E1;font-size: 4vw; font-weight: 700;">Welcome !</label>
            <form class="" action="index1.php" method="post">
              <div class="row mb-3">
                <label for="inputEmail3" class="col-form-label">Email</label>
                <div class="">
                <input name="username" type="text" class="form-control form-control-lg" id="inputEmail3" placeholder="Email">
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputPassword3" class="col-form-label">Password</label>
                <div class="">
                  <input name="password" type="password" class="form-control form-control-lg" id="inputPassword3" placeholder="Password" >
                  <a href="http://" class="float-end text-decoration-none" style="color: #7E30E1; font-size: 0.9vw;">fogot password?</a>
                  <a href="http://" class="float-start text-decoration-none" style="color: #e13030; font-size: 0.9vw;"><?= $invalid ;?></a>
                </div>
              </div>
              <button name="SigninSubmit" type="submit" class="btn w-100 py-2" style="background-color: #7E30E1; font-size: 1.2vw; font-weight: 700;color: #fff;">Sign in</button>
            </form>
    
          </div>
        `;
    document.getElementById('btn1').classList.remove("gray-0");
    document.getElementById('btn1').classList.add("gray-100");
}

