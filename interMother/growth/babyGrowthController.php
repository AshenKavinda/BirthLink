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

function findGivenDate($babyGrowth, $gID) {
    foreach ($babyGrowth as $growth) {
        if ($growth['gID'] == $gID) {
            return $growth['happenedDate'];
        }
    }
    return null;
}

function createGrowthDetailsTable()
{
    try {
        if(isset($_POST['babyID'])){
            global $growth;
            $babyGrowth = $growth->getGrowthDetails($_POST['babyID']);
            $growthDetails = $growth->getAllGrowth();
            $arrTableData = [];
            $arrBabyGrowth = [];
            while ($row = $babyGrowth->fetch_assoc()) {
                $arrBabyGrowth[] = [
                    "gID" => $row['gid'],
                    "happenedDate" => $row['happenedDate']
                ];
            }

            while ($row = $growthDetails->fetch_assoc()) {
                $result = findGivenDate($arrBabyGrowth,$row['gid']);
                $arrTableData[] = [
                    "gID" => $row['gid'],
                    "development" => $row['development'],
                    "happenedDate" => $result != null ? $result : "Not yet"
                ];
            }

            

            $table = '<table class="table">
                            <thead>
                                <tr>
                                <th scope="col">No</th>
                                <th scope="col">Growth stage</th>
                                <th scope="col">Recorded date</th>
                                </tr>
                            </thead>';
            $slNo = 1;

            foreach ($arrTableData as $item){
                    $stage = $item['development'];
                    $recordedDate = $item['happenedDate'];
    
        
                    $table.=' <tr>
                    <td>'.$slNo.'</td>
                    <td>'.$stage.'</td>
                    <td>'.$recordedDate.'</td>
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