<?php

require_once('../utils/DB.php');

class baby{

    private $DB;

    public function __construct()
    {
        $this->DB = new DB();
        
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
            
    
            $stmt = $this->DB->getConnection()->prepare($sql);
  
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