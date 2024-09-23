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
        if (isset($_POST['date']) && isset($_POST['district'])) {
            global $report;
            $result = $report->getPregnanciesByDistrictAndMonth($_POST['date'],$_POST['district']);
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
                            <th scope="col">Pregnancy Date</th>
                            <th scope="col">Name</th>
                            <th scope="col">NIC</th>
                            <th scope="col">Address</th>
                            <th scope="col">Email</th>
                            <th scope="col">Center</th>
                            <th scope="col">District</th>
                            </tr>
                        </thead>';
        $slNo = 1;

        while ($row = $result->fetch_assoc()){

    
                $table.=' <tr>
                <td>'.$slNo.'</td>
                <td>'.$row['preg_date'].'</td>
                <td>'.$row['fName'].' '.$row['lName'].'</td>
                <td>'.$row['nic'].'</td>
                <td>'.$row['address'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['center_name'].'</td>
                <td>'.$row['district_name'].'</td>
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