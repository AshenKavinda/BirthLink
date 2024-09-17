<?php

require_once __DIR__ . '/../utils/DB.php';

class Weight{

    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function add($bID,$weight,$date) {
        try {
            $query = "insert into weight(bID,weight,date) values(?,?,?)";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param('ids',$bID,$weight,$date);
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