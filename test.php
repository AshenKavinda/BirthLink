<?php
require_once 'utils/DB.php';
require_once 'signUp/models/UserModel.php';
$db = new DB();
$model = new UserModel($db);
try {
  $result = $model->addUser("Ashen","kavinda","1111","012121","kjshdkjf","JAHSLKFN","123");
  if ($result) {
      echo 'ok';
  }
  else{
      echo 'no ok';
  }
  
} catch (\Throwable $th) {
  echo "fail";
}

?>