<?php

require_once '../../models/vaccine.php';

$vaccine = new vaccine();

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

function addNewVaccine()
{
    try {

        if(isset($_POST['name']) && isset($_POST['age']) ){
            global $vaccine;
            $result = $vaccine->addNewVaccine($_POST['name'],$_POST['age']);
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

function getVaccine()
{
    try {

        if(isset($_POST['vID'])){
            global $vaccine;
            $result = $vaccine->getVaccine($_POST['vID']);
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

function deleteVaccine()
{
    try {

        if(isset($_POST['vID'])){
            global $vaccine;
            $result = $vaccine->deleteVaccine($_POST['vID']);
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

function updateVaccine()
{
    try {

        if(isset($_POST['vID']) && isset($_POST['name']) && isset($_POST['age']) ){
            global $vaccine;
            $result = $vaccine->updateVaccine($_POST['vID'],$_POST['name'],$_POST['age']);
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

function displayVaccineTable()
{
    try {
        if(isset($_POST['dataSend'])){
            global $vaccine;
            $result = $vaccine->getAll();

            $table = '<table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Vaccine ID</th>
                                <th scope="col">Advised Age</th>
                                <th scope="col">Vaccine Name</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>';

            while($row = mysqli_fetch_assoc($result)){

                    $vaccineID = $row['vID'];
                    $age = $row['age'];
                    $vaccineName = $row['vaccineName'];
        
                    $table.=' <tr>
                    <td>'.$vaccineID.'</td>
                    <td>'.$age.'</td>
                    <td>'.$vaccineName.'</td>
                    <td>
                        <button class="btn btn-dark" onclick="getVaccine('.$vaccineID.')">Update</button>
                        <button class="btn btn-danger" onclick="removeVaccine('.$vaccineID.')">Delete</button>
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