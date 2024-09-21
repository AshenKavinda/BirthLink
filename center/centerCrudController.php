<?php

require_once '../models/center.php';

$center = new center();

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

function addNewCenter(){

    try {
        if(isset($_POST['centerName']) && isset($_POST['provinceID']) && isset($_POST['districtID']) && isset($_POST['areaID'])){
            global $center;
            $center->addNewCenter($_POST['centerName'], $_POST['provinceID'], $_POST['districtID'], $_POST['areaID']);
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

function getCenter(){

    try {
        if(isset($_POST['centerID'])){
            global $center;
            $result=$center->getCenter($_POST['centerID'])->fetch_assoc();
            echo json_encode($result);
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

function updateCenter(){

    try {
        if(isset($_POST['centerID']) && isset($_POST['centerName']) && isset($_POST['provinceID']) && isset($_POST['districtID']) &&isset($_POST['areaID'])){
            global $center;
            $result=$center->updateCenter($_POST['centerID'],$_POST['centerName'],$_POST['provinceID'],$_POST['districtID'],$_POST['areaID']);
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

function getProvinces() {

    try {
        global $center;
        $result = $center->getAllProvinces();
        
        $options = '<option value = 0 selected>- Select Province -</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            $options .= '<option value="' . $row['provinceid'] . '">' . $row['name'] . '</option>';
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

function getDistrict() {

    try {
        global $center;
        $result = $center->getAllDistricts();
        
        $options = '<option value = 0 selected>- Select District -</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            $options .= '<option value="' . $row['districtID'] . '">' . $row['name'] . '</option>';
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

function getAreas() {

    try {
        global $center;
        $result = $center->getAllAreas();
        
        $options = '<option value = 0 selected>- Select Area -</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            $options .= '<option value="' . $row['areaID'] . '">' . $row['name'] . '</option>';
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

function deleteCenter(){

    try {
        if(isset($_POST['CenterID'])){
            global $center;
            $center->deleteCenter($_POST['CenterID']);
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

function displayCenterTable()
{
    try {
        if(isset($_POST['dataSend'])){
            global $center;
            $result = $center->getAllCenters();

            $table = '<table class="table">
                            <thead>
                                <tr>
                                <th scope="col">No</th>
                                <th scope="col">Center Name</th>
                                <th scope="col">Province</th>
                                <th scope="col">District</th>
                                <th scope="col">Area</th>
                                <th scope="col">Action</th>        
                                </tr>
                            </thead>';
            $slNo = 1;

            while($row = mysqli_fetch_assoc($result)){

               
                    $centerID = $row['centerID'];
                    $centerName = $row['centerName'];
                    $province = $row['provinceName'];
                    $district = $row['districtName'];
                    $area = $row['areaName'];
        
                    $table.=' <tr>
                    <td>'.$slNo.'</td>
                    <td>'.$centerName.'</td>
                    <td>'.$province.'</td>
                    <td>'.$district.'</td>
                    <td>'.$area.'</td>
                    <td>
                        <button class="btn btn-dark" onclick="getCenter('.$centerID.')">Update</button>
                        <button class="btn btn-danger" onclick="removeCenter('.$centerID.')">Remove</button>
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