<?php
require_once __DIR__ . '/../../models/pregnancy.php';
require_once __DIR__ . '/../../models/baby.php';
$pregnancy = new pregnancy();
$baby = new baby();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the action (function name) from the request
    $action = $_POST['action'];

    // Check if the function exists and then call it
    if (function_exists($action)) {
        // Call the function dynamically
        $action($_POST); // Pass the $_POST data to the function
    } else {
        echo "Function not found!";
    }

}


function createBabyCard()
{
    try {
        if(isset($_POST['userID'])){

            global $baby;
            global $pregnancy;
            $result = $baby->displayBaby($_POST['userID']);
            $result2 = $pregnancy->displayPregnancy($_POST['userID']);

            $card = '';

            // if($result == null && $result2 == null){
            //     $card .= '<h1>hiiii</h1>';
            // }

            while($row = mysqli_fetch_assoc($result))
            {
                $card .='<div class="col-md-3" onclick="viewBabyProfile(\'' . htmlspecialchars($row['pID']) . '\', \'' . htmlspecialchars($row['bID']) . '\')">

                            <div class="card my-2" id="carid" style="height: 250px; background-image: url(\'../../img/mother.png\');">
                                <div class="card-body">
                                    <h4 class="card-title">Baby ID: '.$row['bID'].'</h4>
                                    <h6>Pregnancy ID: '.$row['pID'].'</h6>
                                    <p class="card-text">Birthday: '.$row['bDay'].'</p>
                                    <p class="card-text">Birth No: '.$row['birthNumber'].'</p>
                                    <p class="card-text">Gender: '.$row['gender'].'</p>
                                </div>
                            </div>
                        </div>';
            }

            while($row = mysqli_fetch_assoc($result2))
            {
                $card .= '<div class="col-md-3" onclick="viewPregnancyProfile('.$row['pID'].')">
                            <div class="card my-2" id="carid" style="height: 250px;  background-image: url(\'../../img/pregWoman.jpg\');">
                                <div class="card-body">
                                    <h4 class="card-title">Pregnancy ID: '.$row['pID'].'</h4>
                                    <h6>Mother ID: '.$row['uID'].'</h6>
                                    <p class="card-text">'.$row['date'].'</p>
                                </div>
                            </div>
                        </div>';
            }

            http_response_code(200);
            echo $card;
            exit();

        }else{
            throw new Exception("System Error aneee!");
        }

    } catch (\Throwable $th) {

        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
}

?>