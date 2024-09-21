<?php

require_once __DIR__ . '/../utils/DB.php';

class growth{

    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function getAllGrowth() {
        try {
            $quary = "select * from growth";
            $stmt = $this->db->getConnection()->prepare($quary);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                return $result;
            } else {
                throw new Exception("Database Error!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function addGrowthRecord($babyID,$growthID,$selectedDate)
    {
        try {
            $sql = "insert into babygrowth(bID,gid,happenedDate) values(?,?,?)";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bind_param('iis',$babyID,$growthID,$selectedDate);
            
            if($stmt->execute()){
    
                return true;
    
            }else{
    
                throw new Exception("Inserting growth record unsuccessful!");
            }
    
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    
    }

    public function autoAdd($bID) {
        try {
            $quary = "insert into babygrowth(bID,gid) values(?,?)";
            $stmt = $this->db->getConnection()->prepare($quary);
            for ($i=1; $i < 10; $i++) { 
                $stmt->bind_param('ii',$bID,$i);
                $stmt->execute();
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function removeGrowthRecord($babyID,$growthID)
    {
        try {

            $sql = "delete from babygrowth where bID=? and gid=?";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bind_param('ii',$babyID,$growthID);
            
            if($stmt->execute()){
    
                return true;
    
            }else{
    
                throw new Exception("Couldn't remove record!");
            }
    
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function getGrowthDetails($babyID)
    {
        try {

            $sql = "SELECT 
                        bg.*, 
                        g.development, 
                        g.expectedMonths
                    FROM 
                        babygrowth bg
                    INNER JOIN 
                        growth g ON bg.gid = g.gid
                    WHERE 
                        bg.bID = ?";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bind_param('i',$babyID);

            if($stmt->execute()){

                $result = $stmt->get_result();

                if($result->num_rows > 0){

                    return $result;

                }else{

                    throw new Exception("No records found for the specified baby ID!");
                }
            }else{
                throw new Exception("Failed to execute query.");
            }
        } catch (\Throwable $th) {

            throw new Exception($th->getMessage());
        }
        
    }

}

    

   
?>