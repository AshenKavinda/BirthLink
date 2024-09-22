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

function display() {
    try {
        global $report;
        $result = $report->getAllMalnutrition();
        displayTable($result);
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
}

function displaySearch() {
    try {
        if (isset($_POST['date'])) {
            if ($_POST['date']!= null) {
                global $report;
                $result = $report->getAllMalnutritionByMonth($_POST['date']);
                displayTable($result);
                # code...
            } else {
                display();
            }
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
                            <th scope="col">Baby ID</th>
                            <th scope="col">Baby day</th>
                            <th scope="col">Email</th>
                            <th scope="col">Weight</th>
                            <th scope="col">weight limit</th>
                            <th scope="col">Center</th>
                            </tr>
                        </thead>';
        $slNo = 1;

        while ($row = $result->fetch_assoc()){

    
                $table.=' <tr>
                <td>'.$slNo.'</td>
                <td>'.$row['bID'].'</td>
                <td>'.$row['bDay'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['weight'].'</td>
                <td>'.$row['min_weight_kg'].'</td>
                <td>'.$row['center_name'].'</td>
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