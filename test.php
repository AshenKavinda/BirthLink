<?php
// require_once 'models/Midwife.php';
// $mid = new Midwife();
// try {

//     $response = $mid->sendEmail(11);
//     echo $response;

//     $mid->sendEmail(1);
//     echo "ok";

// } catch (\Throwable $th) {
//     echo $th->getMessage();
// }

require_once 'utils/MailerMailGun.php';
$mid = new MailerMailGun();
try {
    $response = $mid->send('adeeshananayakkara27@gmail.com',"Helooooooooo","helloo");
    echo $response;
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