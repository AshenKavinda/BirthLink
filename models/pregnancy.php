<?php
require_once __DIR__ . '/../utils/DB.php';

class pregnancy
{
    private $DB;

    public function __construct()
    {
        $this->DB = new DB();

    }

    public function add($userID,$pregnancyDate)
    {
        try {

            $sql = "INSERT INTO pregnancy(uID, date) VALUES (?, ?)";
            $stmt = $this->DB->getConnection()->prepare($sql);
            $stmt->bind_param('is', $userID, $pregnancyDate);
    
            if ($stmt->execute()) {
    
              return true;

            } else {
                return false;    
            }
            
        } catch (\Throwable $th) {

            throw new Exception($th->getMessage());
            
        }

    }

    public function disablePregnancy($pid) {
        try {
            $query = "update pregnancy set status = 0 where pID=?";
            $stmt = $this->DB->getConnection()->prepare($query);
            $stmt->bind_param('i',$pid);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
    
    public function displayPregnancy($uID)
    {
        try {
            $sql = "
                    SELECT p.*, u.uID
                    FROM pregnancy p
                    INNER JOIN `user` u ON p.uID = u.uID
                    WHERE p.status = 1 AND p.uID = ? ORDER BY p.pID ASC";
                                                        
            $stmt = $this->DB->getConnection()->prepare($sql);
            $stmt->bind_param('i',$uID);

           if($stmt->execute())
           {
                $result = $stmt->get_result();
                return $result;
           }
        
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }

    }

}






?>
