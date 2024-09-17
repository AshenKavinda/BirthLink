<?php

require_once __DIR__ . '/../utils/DB.php';

class baby{

    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    function add($pid,$bDay,$birthNo,$gender) {
        try {
            $query = "insert into baby(pID,bDay,birthNumber,gender)values(?,?,?,?)";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param("isss",$pid,$bDay,$birthNo,$gender);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}


?>