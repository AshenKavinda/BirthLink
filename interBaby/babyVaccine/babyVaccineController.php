<?php

require_once '../../models/vaccine.php';
require_once '../../models/baby.php';
$vaccine = new vaccine();
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

function addVaccinationsByBID()
{
    try {
        if(isset($_POST['babyID']) && isset($_POST['vaccineID']) && isset($_POST['selectedDate'])){
            global $vaccine;
            $result = $vaccine->addVaccinationsByBID($_POST['babyID'], $_POST['vaccineID'], $_POST['selectedDate']);
            if ($result) {
                http_response_code(200);
            } else {
                throw new Exception("System Error!");
            }
            
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
        
        $options = '<option value="0" selected>- Select Vaccine -</option>';
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
            global $baby;

            $allVaccines = $vaccine->getAll();
            $allVaccination = $vaccine->getVaccinationsByBID($_POST['babyID']);
            $babyData = $baby->getBabyByBID($_POST['babyID'])->fetch_assoc();
            $bDay = $babyData['bDay'];

            $tableVaccines = [];
            
            $arrAllVaccinations = [];
            while ($row = $allVaccination->fetch_assoc()) {
                $arrAllVaccinations[] = [
                    'vID' => $row['vID'],
                    'givenDate' => $row['givenDate']
                ];
            }

            
            function findGivenDate($vaccinations, $vID) {
                foreach ($vaccinations as $vaccination) {
                    if ($vaccination['vID'] == $vID) {
                        return $vaccination['givenDate'];
                    }
                }
                return null;
            }

            
            while ($row = $allVaccines->fetch_assoc()) {
                $givenDate = findGivenDate($arrAllVaccinations, $row['vID']);

                $doseDate = new DateTime($bDay);
                $doseDate->modify("+{$row['age']} months");

                
                $tableVaccines[] = [
                    'vID' => $row['vID'],
                    'vaccineName' => $row['vaccineName'],
                    'doseDate' => $doseDate->format('Y-m-d'),
                    'givenDate' => $givenDate !== null ? $givenDate : "not yet"
                ];
            }


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

            foreach ($tableVaccines as $item) {
                    $vaccineID = $item['vID'];
                    $babyID = $_POST['babyID'];
                    $vaccine = $item['vaccineName'];
                    $doseDate = $item['doseDate'];
                    $givenDate = $item['givenDate'];
        
                    $table.=' <tr>
                    <td>'.$slNo.'</td>
                    <td>'.$vaccine.'</td>
                    <td>'.$doseDate.'</td>
                    <td>'.$givenDate.'</td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteVaccineRecord('.$babyID.','.$vaccineID.')">Remove</button>
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