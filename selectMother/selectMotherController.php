<?php
session_start();
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

    try {
        //code...
        $uID = 11;
    
        if (isset($_SESSION['uID'])) {
            $uID = $_SESSION['uID'];
        }
        global $mother;
        $result = $mother->getMothersByMID($uID);
    
        $table = '<table class="table">
                    <thead>
                        <tr>
                            <th scope="col">UID</th>
                            <th scope="col">Name</th>
                            <th scope="col">NIC</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>';
    
        while ($row = mysqli_fetch_assoc($result)) {
    
            $id = $row['uID'];
            $fname = $row['fName'];
            $lname = $row['lName'];
            $nic = $row['nic'];
            $contact = $row['contactNo'];
    
            $table .= '<tr>
                        <td>'.$id.'</td>
                        <td>'.$fname.' '.$lname.'</td>
                        <td>'.$nic.'</td>
                        <td>'.$contact.'</td>
                        <td><button class="btn btn-dark" onclick="openMother('.$id.')">Select</button></td>
                      </tr>';
        }
    
        $table .= '</tbody></table>';
        http_response_code(200);
        echo $table;
        exit();
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }

}

function searchMotherTable() {

    try {
        //code...
        global $mother;
    
        if (isset($_POST['mid']) && !empty($_POST['mid'])) {
    
            $uID = $_POST['mid'];
            $result = $mother->getMotherById($uID);
    
            $table = '<table class="table">
                        <thead>
                            <tr>
                                <th scope="col">UID</th>
                                <th scope="col">Name</th>
                                <th scope="col">NIC</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>';
    
            if (mysqli_num_rows($result) > 0) {
    
                while ($row = mysqli_fetch_assoc($result)) {
    
                    $id = $row['uID'];
                    $fname = $row['fName'];
                    $lname = $row['lName'];
                    $nic = $row['nic'];
                    $contact = $row['contactNo'];
    
                    $table .= '<tr>
                                <td>'.$id.'</td>
                                <td>'.$fname.' '.$lname.'</td>
                                <td>'.$nic.'</td>
                                <td>'.$contact.'</td>
                                <td><button class="btn btn-dark" onclick="">Select</button></td>
                              </tr>';
                }
            } else {
                $table .= '<tr><td colspan="5">No data found</td></tr>';
            }
    
            $table .= '</tbody></table>';
            http_response_code(200);
            echo $table;
            exit();
    
        } else {
            http_response_code(400); 
            echo 'Please provide a valid ID.';
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }

}
?>