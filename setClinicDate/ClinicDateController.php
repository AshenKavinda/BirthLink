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

function setClinicDate(){        

    try{
        if (isset($_POST['firstDate']) && isset($_POST['secondDate']) && isset($_POST['mid'])) {

            
            global $midwife;
            $result = $midwife->set($_POST['firstDate'],$_POST['secondDate'],$_POST['mid']);
            if($result){
                http_response_code(200);
                exit();
            }else {
                throw new Exception("System Error!");
            }
        }else {
            throw new Exception("System Error!");
        }
    }catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));

        exit();
    }
}

function getClinicDate(){
    try{
        global $midwife;
        if(isset($_POST['mid'])){

            $result = $midwife->displaydates($_POST['mid']);

            if($result){
                http_response_code(200);
                echo json_encode($result); 
                exit();
            }else {
                throw new Exception("System Error!");
            }
        }    

    }catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));

        exit();
    }
}
?>
