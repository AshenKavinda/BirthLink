<?php
require_once '../../models/PregnancyNote.php';
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