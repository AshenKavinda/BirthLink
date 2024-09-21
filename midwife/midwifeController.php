<?php
    require_once '../models/Midwife.php';
    $midwife = new Midwife();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $action = $_POST['action'];

        if (function_exists($action)) {

            $action($_POST);
        } else {
            echo "Function not found!";
        }
    }

    function add() {
        try {
            if (isset($_POST['mfname']) && isset($_POST['mlname']) && isset($_POST['mnic']) && isset($_POST['memail']) && isset($_POST['mphon']) && isset($_POST['madd1']) && isset($_POST['madd2']) && isset($_POST['mcity']) && isset($_POST['mpass']) && isset($_POST['center'])) {
    
                global $midwife;

                $address = $_POST['madd1']. ' ' .$_POST['madd2']. ' '.$_POST['mcity'];
                 
                $result = $midwife->addMidwife(
                    $_POST['mfname'],
                    $_POST['mlname'],
                    $_POST['mnic'],
                    $_POST['memail'],
                    $_POST['mphon'],
                    $address,
                    $_POST['mpass'],
                    $_POST['center']
                );
            } else {
                throw new Exception("System Error!");
            }
        } catch (\Throwable $th) {
            http_response_code(400);
            echo json_encode(array('error' => $th->getMessage()));
            exit();
        }
    }

    function setMidwifeTable() {

        global $midwife;
        $result = $midwife->allMidwifes();
    
        $table = '<table class="table">
                    <thead>
                        <tr>
                            <th scope="col">UID</th>
                            <th scope="col">Name</th>
                            <th scope="col">NIC</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Email</th>
                            <th scope="col">Center</th>
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
            $email = $row['email'];
            $center = $row['name'];
    
            $table .= '<tr>
                        <td>'.$id.'</td>
                        <td>'.$fname.' '.$lname.'</td>
                        <td>'.$nic.'</td>
                        <td>'.$contact.'</td>
                        <td>'.$email.'</td>
                        <td>'.$center.'</td>
                        <td><div class="d-flex"><button class="btn btn-dark mx-1" onclick="getMidwifeDetails('.$id.')">Update</button>
                        <button class="btn btn-danger" onclick="deleteMidwife('.$id.')">Delete</button>
                        </div></td>
                      </tr>';
        }
    
        $table .= '</tbody></table>';
        http_response_code(200);
        echo $table;
        exit();
    }

    function searchMidwifeTable() {

        global $midwife;

        if(isset($_POST['mID'])){

            $mid = $_POST['mID'];
            $result = $midwife->searchMidwifes($mid);
        
            $table = '<table class="table">
                        <thead>
                            <tr>
                                <th scope="col">UID</th>
                                <th scope="col">Name</th>
                                <th scope="col">NIC</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Email</th>
                                <th scope="col">Center</th>
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
                $email = $row['email'];
                $center = $row['name'];
        
                $table .= '<tr>
                            <td>'.$id.'</td>
                            <td>'.$fname.' '.$lname.'</td>
                            <td>'.$nic.'</td>
                            <td>'.$contact.'</td>
                            <td>'.$email.'</td>
                            <td>'.$center.'</td>
                            <td><div class="d-flex"><button class="btn btn-dark mx-1" onclick="getMidwifeDetails('.$id.')">Update</button>
                            <button class="btn btn-danger" onclick="deleteMidwife('.$id.')">Delete</button>
                            </div></td>
                        </tr>';
            }
        
            $table .= '</tbody></table>';
            http_response_code(200);
            echo $table;
            exit();
        }    
    }

    function updateMidwife(){
        global $midwife;
        
        try {
            if (isset($_POST['uID']) && isset($_POST['mfname']) && isset($_POST['mlname']) && isset($_POST['mnic']) && isset($_POST['memail']) && isset($_POST['mphon']) && isset($_POST['madd1']) && isset($_POST['center'])) {

                $result = $midwife->updateMidwife(
                    $_POST['uID'],
                    $_POST['mfname'],
                    $_POST['mlname'],
                    $_POST['mnic'],
                    $_POST['memail'],
                    $_POST['mphon'],
                    $_POST['madd1'],
                    $_POST['center']
                );
    
                if ($result) {
                    setMidwifeTable();
                } else {
                    throw new Exception("Update failed!");
                }
            } else {
                throw new Exception("Invalid data!");
            }
        } catch (\Throwable $th) {
            http_response_code(400);
            echo json_encode(array('error' => $th->getMessage()));
            exit();
        }
    }

    function deleteMidwife(){
        global $midwife;

        try {
            if(isset($_POST['mid'])){

                $id = $_POST['mid'];
                $midwife->deleteMidwife($id);

             }
        } catch (\Throwable $th) {
            http_response_code(400);
            echo json_encode(array('error' => $th->getMessage()));
            exit();
        }

        
    }

    function getCenter() {

        try {
            global $midwife;
            $result = $midwife->getAll();
            
            $options = '<option value="0"> Select Center</option>';
            while ($row = mysqli_fetch_assoc($result)) {
                $options .= '<option value="' . $row['centerID'] . '">' . $row['name'] . '</option>';
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

    function getMidwifeDetails(){
        global $midwife;

        try {
            if (isset($_POST['uID'])) {
                $uID = $_POST['uID'];
                 $result = $midwife->searchMidwifes($uID);
        
                if ($row = mysqli_fetch_assoc($result)) {

                    http_response_code(200);
                    echo json_encode($row);
                    exit();
                } else {
                    throw new Exception("Record not found");
                }
            } else {

                throw new Exception("URL not valid");
            }
        } catch (\Throwable $th) {
            http_response_code(400);
            echo json_encode(array('error' => $th->getMessage()));
            exit();
        }
    }

?>    