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

    public function displayBaby($uID)
    {
        try {
            $sql = "
            SELECT b.*, p.uID
            FROM baby b
            INNER JOIN pregnancy p ON b.pID = p.pID
            INNER JOIN user u ON p.uID = u.uID
            WHERE p.uID = ? ORDER BY b.bID ASC";
            
    
            $stmt = $this->db->getConnection()->prepare($sql);
  
            $stmt->bind_param('i', $uID);
    
            if ($stmt->execute()) {
             
                $result = $stmt->get_result();
    
                if ($result->num_rows > 0) {
                    return $result;
                } else {
                    throw new Exception("No records found for the specified user ID!");
                }
            } else {
                throw new Exception("Failed to execute query.");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
        
}

?>