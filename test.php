<?php
require_once 'models/Midwife.php';
$mid = new Midwife();
try {
    $mid->sendEmail(1);
    echo "ok";
} catch (\Throwable $th) {
    echo $th->getMessage();
}

// require_once 'models/Mother.php';
// $mid = new Mother();
// try {
//     $mid->getMothers();
//     echo "ok";
// } catch (\Throwable $th) {
//     echo $th->getMessage();
// }

?>