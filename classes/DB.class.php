<?php
class DB {
    private $conn ;

    public function __construct()
    {
        $this->conn = mysqli_connect('localhost','root','','finalTest');
        //$this->conn = mysqli_connect('fdb1029.awardspace.net','4500285_birthlink','apiBLink#1','4500285_birthlink');
    }

    public function getConnection()
    {
        if (mysqli_connect_errno()) {
            die('<h1>DB Connection Fail</h1> ' . mysqli_connect_error());
        }
        else
        {
            return $this->conn;
        }
    }
}

