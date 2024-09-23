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

    public function getPregnanciesByDistrictAndMonth($date, $string) {
        try {
            $search = "%$string%";
            $query = "
                select p.`date` as preg_date, ce.name AS center_name, di.name district_name, u.*
                FROM user u
                INNER JOIN pregnancy p ON p.uID = u.uID
                INNER JOIN midwife mid ON p.midID = mid.uID
                INNER JOIN center ce ON ce.centerID = mid.centerID
                INNER JOIN district di ON di.districtID = ce.districtID
                WHERE p.status = 1
            ";
    
            if (!empty($string)) {
                $query .= " AND di.name LIKE ?";
            }
    
            if (!empty($date)) {
                $query .= " AND DATE_FORMAT(p.date, '%Y-%m') = DATE_FORMAT(?, '%Y-%m')";
            }
    
            if (!empty($string)) {
                $query .= " ORDER BY u.uID, ce.name, di.name";
            } else {
                $query .= " ORDER BY u.uID, ce.name";
            }
    
            $stmt = $this->db->getConnection()->prepare($query);

            if (!empty($string) && !empty($date)) {
                $stmt->bind_param('ss', $search, $date); // Bind both district_name and date
            } elseif (!empty($string)) {
                $stmt->bind_param('s', $search); // Bind only district_name
            } elseif (!empty($date)) {
                $stmt->bind_param('s', $date); // Bind only date
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

    public function getVaccinationCoverageByDistrict($string) {
        try {
            $search = "%$string%";
            $query = "SELECT * from vaccination_coverage where District like ?";
    
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param('s',$search);
    
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
    
    
    

        
}

?>