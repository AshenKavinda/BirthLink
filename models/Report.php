<?php

require_once __DIR__ . '/../utils/DB.php';

class Report{

    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function getAllMalnutritionByMonth($date) {
        try {
            $quary = "
            SELECT * 
            FROM birthlink.babyweightdetails 
            WHERE weight < min_weight_kg 
            AND DATE_FORMAT(weight_date, '%Y-%m') = DATE_FORMAT(?, '%Y-%m');
            ";
            $stmt = $this->db->getConnection()->prepare($quary);
            $stmt->bind_param('s',$date);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                return $result;
            } else {
                throw new Exception("Quary Error!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function getAllMalnutrition() {
        try {
            $quary = "
            SELECT * 
            FROM birthlink.babyweightdetails 
            WHERE weight < min_weight_kg order by bID;
            ";
            $stmt = $this->db->getConnection()->prepare($quary);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                return $result;
            } else {
                throw new Exception("Quary Error!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
        
}

?>