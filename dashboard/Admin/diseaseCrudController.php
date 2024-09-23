<?php

require_once '../../models/disease.php';

$disease = new disease();

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

function addNewCondition()
{
    try {

        if(isset($_POST['name']) && isset($_POST['discription']) ){
            global $disease;
            $result = $disease->addNewDisease($_POST['name'],$_POST['discription']);
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

function updatePathology()
{
    try {

        if(isset($_POST['dID']) && isset($_POST['name']) && isset($_POST['discription']) ){
            global $disease;
            $result = $disease->updateDisease($_POST['dID'],$_POST['name'],$_POST['discription']);
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

function getPathology()
{

    try {
        if(isset($_POST['dID'])){
            global $disease;
            $result = $disease->getDisease($_POST['dID']);
            $response = array();

            if ($row = mysqli_fetch_assoc($result)) {

                $response = $row;

            } else {

                throw new Exception("No data found while fetching.");
            }

            echo json_encode($response);

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

function deletePathology()
{

    try {
        if(isset($_POST['dID'])){
            global $disease;
            $result = $disease->deleteDisease($_POST['dID']);
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


function displayDiseaseTable()
{
    try {
        if(isset($_POST['dataSend'])){
            global $disease;
            $result = $disease->getPathalogyDetails();

            $table = '<table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Pathology ID</th>
                                <th scope="col">Pathology Name</th>
                                <th scope="col">Discription</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>';

            while($row = mysqli_fetch_assoc($result)){

                    $pathologyID = $row['dID'];
                    $name = $row['name'];
                    $discription = $row['discription'];
        
                    $table.=' <tr>
                    <td>'.$pathologyID.'</td>
                    <td>'.$name.'</td>
                    <td>'.$discription.'</td>
                    <td>
                        <button class="btn btn-dark" onclick="getPathology('.$pathologyID.')">Update</button>
                        <button class="btn btn-danger" onclick="removePathology('.$pathologyID.')">Delete</button>
                    </td>
                    </tr>';
               
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