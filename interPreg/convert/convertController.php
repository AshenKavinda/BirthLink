<?php
session_start();
require_once '../../models/baby.php';
$baby = new baby();

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

function addToSession() {
    try {
        if (isset($_POST['bDay']) && isset($_POST['gender']) && isset($_POST['pID'])) {
            $item = array(
                "pID" => $_POST['pID'],
                "bDay" => $_POST['bDay'],
                "birthNo" => $_POST['birthNo'],
                "gender" => $_POST['gender']
            );

            if (!isset($_SESSION['baby'])) {
                $_SESSION['baby'] = array();
            }
            $_SESSION['baby'][] = $item;
            http_response_code(200);
            exit();
        } else {
            throw new Exception("System error!");
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
}

function displaySesstion() {
    try {
        if (isset($_SESSION['baby'])) {
            $html = '';
            $slNo = 1;
            foreach ($_SESSION['baby'] as $index => $item) {
                $html .= '
                <tr>
                    <td>'.$slNo.'</td>
                    <td>'.$item['pID'].'</td>
                    <td>'.$item['bDay'].'</td>
                    <td>'.$item['birthNo'].'</td>
                    <td>'.$item['gender'].'</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-start">
                            <button class="btn btn-danger mx-3" onclick="deleteItem('.$index.')">Delete</button>
                        </div>
                    </td>
                </tr>
                ';
                $slNo++;
            }
            http_response_code(200);
            echo $html;
            exit();
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
}

function addDatabase() {
    try {
        if (isset($_SESSION['baby'])) {
            foreach ($_SESSION['baby'] as $index => $item) {
                $pid = $item['pID'];
                $bDay = $item['bDay'];
                $birthNo = $item['birthNo'];
                $gender = $item['gender'];
                global $baby;
                $baby->add($pid,$bDay,$birthNo,$gender);
            }
            http_response_code(200);
        } else {
            throw new Exception("System Error!");
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
}

function deleteItem() {
    if (isset($_SESSION['baby'])) {
        if (isset($_POST['index'])) {
            unset($_SESSION['baby'][$_POST['index']]);
            http_response_code(200);
        }
    }
}

function clearSesstion() {
    if (isset($_SESSION['baby'])) {
        unset($_SESSION['baby']);
        http_response_code(200);
    }
}

?>

