<?php

require_once 'utils/MilerMailGun.php';
$mailer = new MailerMailGun();
$emails = ['adeeshananayakkara27@gmail.com'];
$result = $mailer->send($emails,"subject","hello test");
echo $result;


?>