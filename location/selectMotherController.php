<?php
require_once '../models/Mother.php';

$mother = new Mother();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['action'])) {
        $action = $_POST['action'];

        if (function_exists($action)) {
            $action();
        } else {
            http_response_code(400);
            echo "Function not found!";
        }
    } else {
        http_response_code(400);
        echo "No action specified!";
    }
}

function setMotherTable() {

    global $mother;
    $result = $mother->getMothers();

    $table = '<table class="table">
                <thead>
                    <tr>
                        <th scope="col">slNo</th>
                        <th scope="col">Name</th>
                        <th scope="col">NIC</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>';
    $index = 1;
    while ($row = mysqli_fetch_assoc($result)) {

        $latitude = $row['latitude'];
        $longitude = $row['longitude'];
        $fname = $row['fName'];
        $lname = $row['lName'];
        $nic = $row['nic'];
        $contact = $row['contactNo'];

        $table .= '<tr>
                    <td>'.$index.'</td>
                    <td>'.$fname.' '.$lname.'</td>
                    <td>'.$nic.'</td>
                    <td>'.$contact.'</td>
                    <td><button class="btn btn-dark" onclick="openGoogleMaps('.$latitude.', '.$longitude.')">Get Directions</button></td>
                    
                  </tr>';
        $index++;
    }

    $table .= '</tbody></table>';
    http_response_code(200);
    echo $table;
    exit();
}

function searchMotherTable() {

    try {
        global $mother;

        if (isset($_POST['nic']) && !empty($_POST['nic'])) {

            $nic = $_POST['nic'];
            $result = $mother->getMotherByNIC($nic);

            $table = '<table class="table">
                        <thead>
                            <tr>
                                <th scope="col">slNo</th>
                                <th scope="col">Name</th>
                                <th scope="col">NIC</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>';
            $index= 1;
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {

                    $latitude = $row['latitude'];
                    $longitude = $row['longitude'];
                    $fname = $row['fName'];
                    $lname = $row['lName'];
                    $nic = $row['nic'];
                    $contact = $row['contactNo'];

                    $table .= '<tr>
                                <td>'.$index.'</td>
                                <td>'.$fname.' '.$lname.'</td>
                                <td>'.$nic.'</td>
                                <td>'.$contact.'</td>
                                <td><button class="btn btn-dark" onclick="openGoogleMaps('.$latitude.', '.$longitude.')">Get Directions</button></td>
                            </tr>';
                    $index++;
                }
            } else {
                $table .= '<tr><td colspan="5">No data found</td></tr>';
            }

            $table .= '</tbody></table>';
            http_response_code(200);
            echo $table;
            exit();

        } else {
            setMotherTable();
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }

    
}
?>