<?php
require_once '../models/pregnancy.php';
$pregnancy = new pregnancy();

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

function add()
{
    try {

        if(isset($_POST['userID']) && isset($_POST['pregDate'])){
            global $pregnancy;
            $result = $pregnancy->add($_POST['userID'],$_POST['pregDate']);

            if($result)
            {
                http_response_code(200);
                exit();
            }else{
                throw new Exception("System error!");
            }

        }else
        {
            throw new Exception("System error!");
        }
        
    } catch (\Throwable $th) {

        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
        
    }
}

function createPregCard()
{
    try {
        if(isset($_POST['userID'])){
            global $pregnancy;
            $result = $pregnancy->displayPregnancy($_POST['userID']);

            $card = '';
           
            while($row = mysqli_fetch_assoc($result))
            {
                $card .= '<div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">'.$row['pID'].'</h4>
                                    <h6>Mother ID: '.$row['uID'].'</h6>
                                    <p class="card-text">'.$row['date'].'</p>
                                </div>
                            </div>
                        </div>';
            }

            // $card .= '</div>';

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