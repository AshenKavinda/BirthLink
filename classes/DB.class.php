<?php

class DB {
    private $conn ;

    public function __construct()
    {
        $this->conn = mysqli_connect('localhost','root','','finalTest');
    }

    public function getConnection()
    {
        if (mysqli_connect_errno()) {
            die ('<h1>DB Connection Fail</h1>');
        }
        else
        {
            return $this->conn ;
        }
    }
}

?>