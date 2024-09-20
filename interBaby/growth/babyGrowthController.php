<?php

require_once '../../models/growth.php';

$growth = new growth();

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

function removeGrowthRecord()
{
    try {
        if(isset($_POST['babyID']) && isset($_POST['growthID']) ){
            global $growth;
            $result = $growth->removeGrowthRecord($_POST['babyID'],$_POST['growthID']);
            http_response_code(200);

        }else{
            throw new Exception("System Error!");
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
        
    }

}

function addGrowthRecord()
{
    try {
        if(isset($_POST['babyID']) && isset($_POST['growthID']) && isset($_POST['selectedDate'])){
            global $growth;
            $growth->addGrowthRecord($_POST['babyID'], $_POST['growthID'], $_POST['selectedDate']);
            http_response_code(200);
        }else
        {
            throw new Exception("System Error!");
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
}

function createGrowthDetailsTable()
{
    try {
        if(isset($_POST['babyID'])){
            global $growth;
            $result = $growth->getGrowthDetails($_POST['babyID']);

            $table = '<table class="table">
                            <thead>
                                <tr>
                                <th scope="col">No</th>
                                <th scope="col">Growth stage</th>
                                <th scope="col">Recorded date</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>';
            $slNo = 1;

            while($row = mysqli_fetch_assoc($result)){

                    $growthID = $row['gid'];
                    $babyID = $row['bID'];
                    $stage = $row['development'];
                    $recordedDate = $row['happenedDate'];
    
        
                    $table.=' <tr>
                    <td>'.$slNo.'</td>
                    <td>'.$stage.'</td>
                    <td>'.$recordedDate.'</td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteGrowthRecord('.$babyID.','.$growthID.')">Remove</button>
                    </td>
                    </tr>';
                    $slNo++;   
            }

            $table.='</table>';
            http_response_code(200);
            echo $table;
            exit();

        }else{
            throw new Exception("System Error!");
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }

}

?>