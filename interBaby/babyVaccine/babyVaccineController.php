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

function updateVaccineRecord()
{
    try {
        if(isset($_POST['babyID']) && isset($_POST['vaccineID']) && isset($_POST['selectedDate'])){
            global $vaccine;
            $vaccine->updateVaccineRecord($_POST['babyID'], $_POST['vaccineID'], $_POST['selectedDate']);
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

function removeRecord()
{
    try {
        if(isset($_POST['babyID']) && isset($_POST['vaccineID']) ){
            global $vaccine;
            $result = $vaccine->removeVaccineRecord($_POST['babyID'],$_POST['vaccineID']);
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

function getVaccines() {

    try {
        global $vaccine;
        $result = $vaccine->getAll();
        
        $options = '';
        while ($row = mysqli_fetch_assoc($result)) {
            $options .= '<option value="' . $row['vID'] . '">' . $row['vaccineName'] . '</option>';
        }

        http_response_code(200);
        echo $options;
        exit();
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
}

function createVaccinationTable()
{
    try {
        if(isset($_POST['babyID'])){
            global $vaccine;
            $result = $vaccine->getVaccinationDetails($_POST['babyID']);

            $table = '<table class="table">
                            <thead>
                                <tr>
                                <th scope="col">No</th>
                                <th scope="col">Vaccine</th>
                                <th scope="col">Dosing date</th>
                                <th scope="col">Given date</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>';
            $slNo = 1;

            while($row = mysqli_fetch_assoc($result)){

                    $vaccineID = $row['vID'];
                    $babyID = $row['bID'];
                    $vaccine = $row['vaccineName'];
                    $doseDate = $row['doseDate'];
                    $givenDate = $row['givenDate'];
        
                    $table.=' <tr>
                    <td>'.$slNo.'</td>
                    <td>'.$vaccine.'</td>
                    <td>'.$doseDate.'</td>
                    <td>'.$givenDate.'</td>
                    <td>
                        <button class="btn btn-danger" onclick="updateVaccineRecord('.$babyID.','.$vaccineID.')">Remove</button>
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