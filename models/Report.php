<?php

require_once __DIR__ . '/../utils/DB.php';

class Report{

    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function getAllMalnutritionByMonth($date, $string) {
        try {
            $search = "%$string%";
            $query = "
                SELECT * 
                FROM birthlink.babyweightdetails 
                WHERE weight < min_weight_kg 
            ";
    
            if (!empty($string)) {
                $query .= " AND district_name LIKE ?";
            }
    
            if (!empty($date)) {
                $query .= " AND DATE_FORMAT(weight_date, '%Y-%m') = DATE_FORMAT(?, '%Y-%m')";
            }
    
            if (!empty($string)) {
                $query .= " ORDER BY bID, center_name, district_name";
            } else {
                $query .= " ORDER BY bID, center_name";
            }
    
            $stmt = $this->db->getConnection()->prepare($query);
    
            if (!empty($string) && !empty($date)) {
                // Bind both district_name and date
                $stmt->bind_param('ss', $search, $date);
            } elseif (!empty($string)) {
                // Bind only district_name
                $stmt->bind_param('s', $search);
            } elseif (!empty($date)) {
                // Bind only date
                $stmt->bind_param('s', $date);
            }
    
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                return $result;
            } else {
                throw new Exception("Query Error!");
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
            WHERE weight < min_weight_kg order by bID , center_name,district_name;
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