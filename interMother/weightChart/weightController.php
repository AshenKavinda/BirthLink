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