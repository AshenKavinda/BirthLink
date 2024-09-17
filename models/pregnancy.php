<?php
require_once('../utils/DB.php');

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
    
    public function displayPregnancy($pregID)
    {
        try {
            $sql = "Select * from pregnancy where uID = ?";
            $stmt = $this->DB->getConnection()->prepare($sql);
            $stmt->bind_param('i',$pregID);

           if($stmt->execute())
           {
                $result = $stmt->get_result();

                if($result->num_rows>0)
                {
                    return $result;

                }else
                {
                    throw new Exception("No pregnancy found!");
                }
           }
        
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }

    }

}






?>
