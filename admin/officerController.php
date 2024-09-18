<?php
    require_once '../models/Officer.php';
    $officer = new Officer();
    
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
            if (isset($_POST['ofname']) && isset($_POST['olname']) && isset($_POST['onic']) && isset($_POST['oemail']) && isset($_POST['ophon']) && isset($_POST['oadd1']) && isset($_POST['oadd2']) && isset($_POST['ocity']) && isset($_POST['opass'])) {
    
                global $officer;

                $address = $_POST['oadd1']. ' ' .$_POST['oadd2']. ' '.$_POST['ocity'];
                 
                $result = $officer->addOfficer(
                    $_POST['ofname'],
                    $_POST['olname'],
                    $_POST['onic'],
                    $_POST['oemail'],
                    $_POST['ophon'],
                    $address,
                    $_POST['opass']
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
    
    function setOfficerTable() {

        global $officer;
        $result = $officer->allOfficers();
    
        $table = '<table class="table">
                    <thead>
                        <tr>
                            <th scope="col">UID</th>
                            <th scope="col">Name</th>
                            <th scope="col">NIC</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Email</th>
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
    
            $table .= '<tr>
                        <td>'.$id.'</td>
                        <td>'.$fname.' '.$lname.'</td>
                        <td>'.$nic.'</td>
                        <td>'.$contact.'</td>
                        <td>'.$email.'</td>
                        <td><div class="d-flex"><button class="btn btn-dark mx-1" onclick="">Update</button><button class="btn btn-danger" onclick="">Delete</button></div></td>
                      </tr>';
        }
    
        $table .= '</tbody></table>';
        http_response_code(200);
        echo $table;
        exit();
    }

    function searchOfficerTable($oID) {

        global $officer;
    
        if (isset($_POST['oID']) && !empty($_POST['oID'])) {
    
            $oID = $_POST['oID'];
            $result = $officer->getOfficerById($oID);
    
            $table = '<table class="table">
                        <thead>
                            <tr>
                                <th scope="col">UID</th>
                                <th scope="col">Name</th>
                                <th scope="col">NIC</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Email</th>
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
                    $email = $row['email'];
    
                    $table .= '<tr>
                                <td>'.$id.'</td>
                                <td>'.$fname.' '.$lname.'</td>
                                <td>'.$nic.'</td>
                                <td>'.$contact.'</td>
                                <td>'.$email.'</td>
                                <td><div class="d-flex"><button class="btn btn-dark mx-1" onclick="">Update</button><button class="btn btn-danger" onclick="">Delete</button></div></td>
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
    }

?>