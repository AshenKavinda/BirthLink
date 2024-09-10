<?php
 require_once 'models/Mother.php';
 $user = new Mother();


$result = $user->addUser("Ashen","kavinda","31331","ja;kdnf","jha;ksjdf","jkahkdsj","jsdkjf","11-04-2000");
//echo $result;
if ($result) {
    echo "ok";
}else {
    echo "no";
}


?>