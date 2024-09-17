<?php

require_once('../utils/DB.php');

class baby{

    private $DB;

    public function __construct()
    {
        $this->DB = new DB();
        
    }
}


?>