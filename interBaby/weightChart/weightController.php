<?php
require_once '../../models/Weight.php';
$weight = new Weight();

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

function addWeight() {
    try {
        if (isset($_POST['weight']) && isset($_POST['bID']) && isset($_POST['date'])) {
            global $weight;
            $result = $weight->add($_POST['bID'],$_POST['weight'],$_POST['date']);
            if ($result) {
                http_response_code(200);
                exit();
            } else {
                throw new Exception("System Error!");
            }
        } else {
            throw new Exception("System Error!");
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error'=>$th->getMessage()));
        exit();
    }
}

function deleteLast() {
    try {
        if (isset($_POST['bID'])) {
            global $weight;
            $date = date('Y-m-d');
            $result = $weight->delete($_POST['bID'],$date);
            if ($result) {
                http_response_code(200);
                exit();
            } else {
                throw new Exception("Last Record deleted rigth now!");
            }
        } else {
            throw new Exception("bid not found!");
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
}

function getData() {
    try {
        if (isset($_POST['bID'])) {
            global $weight;
            $result = $weight->display($_POST['bID']);
            if ($result != null) {
                $dates = [];
                $weights = [];
                while ($row = $result->fetch_assoc()) {
                    $dates[] = $row['date'];
                    $weights[] = $row['weight'];
                }
                http_response_code(200);
                echo json_encode(['dates' => $dates, 'weights' => $weights]);
                exit();
            } else {
                throw new Exception("Result is null");
            }
        } else {
            throw new Exception("bid not found!");
        }
    }  catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
}


?>