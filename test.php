<?php
 require_once 'models/User.php';
 $user = new User();


$result = $user->addUser("wqe","qwe","qeqwe","wqertert","wqe;ee","wqe","qwe","wqe");
//echo $result;
if ($result) {
    echo "ok";
}else {
    echo "no";
}

//  require_once 'models/Pregnancy.php';
//  $preg = new PregnancyNote();

//  try {
//     $result = $preg->displayByPID(1);

//     while($row = mysqli_fetch_assoc($result)){
//        echo $row['name'] . "<br>";
//     }
//  } catch (\Throwable $th) {
//     echo $th;
//  }

// require_once 'utils/Mailer.class.php';
// $mailer = new Mailer();
// $emails= 'kavindahemarathna321@gmail.com,adeeshananayakkara27@gmail.com,mchanuka72@gmail.com';
// $mailer->send($emails,"Helloooooo","pakaya");

// if ($mailer) {
//     echo "ok";
// }else {
//     echo "no";
// }


?>