<?php
require_once '../../models/PregnancyNote.php';
require_once '../../models/disease.php';
$disease = new disease();
$pregnancyNote = new PregnancyNote();

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

function loadListItem() {
    try {
        global $disease;
        $result = $disease->getPathalogyDetails();
        $html = '<option value="0" selected>Select Diagnosis</option>';
        while($row = $result->fetch_assoc()) {
            $html .= '<option value="'.$row['dID'].'">'.$row['name'].'</option>';
        }
        http_response_code(200);
        echo $html;
        exit();
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
}


function displayNoteSection() {
    try {
        if (isset($_POST['pID'])) {
            global $pregnancyNote;
            $result = $pregnancyNote->displayByPID($_POST['pID']);
            $table = '<div class="accordion accordion-flush" id="accordionFlushExample">';
            $index = 1; // Initialize a counter to create unique IDs
            while ($row = mysqli_fetch_assoc($result)) {
                $uniqueId = "flush-collapse" . $index; // Create a unique ID
                $table .= '
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#' . $uniqueId . '" aria-expanded="false" aria-controls="' . $uniqueId . '">
                            ' . $row['name'] . ' - ' . $row['date'] . '
                        </button>
                    </h2>
                    <div id="' . $uniqueId . '" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">' . $row['discription'] . '</div>
                        <div class="w-100 d-flex flex-row justify-content-end p-3">
                            <button onclick="deleteItem(' . $row['slID'] . ')" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>';
                $index++;
            }
            $table .= '</div>';
            http_response_code(200);
            echo $table;
            exit();
        } else {
            throw new Exception("System Error!");
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
}

function add() {
    try {
        if (isset($_POST['pID']) && isset($_POST['dID']) && isset($_POST['date'])) {
            global $pregnancyNote;
            $result = $pregnancyNote->add($_POST['pID'],$_POST['dID'],$_POST['date']);
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
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
}

function deleteItem() {
    try {
        if (isset($_POST['slID'])) {
            global $pregnancyNote;
            $result = $pregnancyNote->delete($_POST['slID']);
            if ($result) {
                http_response_code(200);
                exit();
            } else {
                throw new Exception("System Error!");
            }
        }
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th->getMessage()));
        exit();
    }
}
