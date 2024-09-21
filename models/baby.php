<?php

require_once __DIR__ . '/../utils/DB.php';
require_once 'pregnancy.php';

class baby{

    private $db;
    private $pregnancy;

    public function __construct()
    {
        $this->db = new DB();
        $this->pregnancy = new pregnancy();
    }

    function add($pid, $bDay, $birthNo, $gender) {
        try {
            // Begin transaction
            $this->db->getConnection()->begin_transaction();
    
            $query = "INSERT INTO baby(pID, bDay, birthNumber, gender) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param("isss", $pid, $bDay, $birthNo, $gender);
    
            if ($stmt->execute()) {
                $result = $this->pregnancy->disablePregnancy($pid);
    
                if ($result) {
                    $this->db->getConnection()->commit();
                    return $stmt->insert_id;
                } else {
                    // Rollback if disablePregnancy fails
                    $this->db->getConnection()->rollback();
                    return false;
                }
            } else {
                // Rollback if insert fails
                $this->db->getConnection()->rollback();
                return false;
            }
        } catch (\Throwable $th) {
            // Rollback on exception
            $this->db->getConnection()->rollback();
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

    public function getBabyByBID($bID) {
        try {
            $query = 'select * from baby where bID = ?';
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param('i',$bID);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                return $result;
            }else {
                throw new Exception('Quary Error!');
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
        
}

?>