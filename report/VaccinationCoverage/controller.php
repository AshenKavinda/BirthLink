<?php

require_once '../../models/Report.php';
$report = new Report();

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

function displaySearch() {
    try {
        if (isset($_POST['district'])) {
            global $report;
            $result = $report->getVaccinationCoverageByDistrict($_POST['district']);
            displayTable($result); 
        } else {
            throw new Exception('No date found!');
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
}

function displayTable($result)
{
    try {
        $table = '<table class="table">
                        <thead>
                            <tr>
                            <th scope="col">No</th>
                            <th scope="col">Vaccine</th>
                            <th scope="col">Vaccinated Babies</th>
                            <th scope="col">Total Babies</th>
                            <th scope="col">Coverage</th>
                            <th scope="col">District</th>
                            </tr>
                        </thead>';
        $slNo = 1;

        while ($row = $result->fetch_assoc()){

    
                $table.=' <tr>
                <td>'.$slNo.'</td>
                <td>'.$row['Vaccine'].'</td>
                <td>'.$row['VaccinatedBabies'].'</td>
                <td>'.$row['TotalBabies'].'</td>
                <td>'.$row['VaccinationCoverage'].'</td>
                <td>'.$row['District'].'</td>
                </tr>';
                $slNo++;   
        }

        $table.='</table>';
        http_response_code(200);
        echo $table;
        exit();
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }

}

?>