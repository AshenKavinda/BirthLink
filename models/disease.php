<?php

require_once __DIR__ . '/../utils/DB.php';

class disease{

    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function updateDisease($dID,$name,$discription){

        try {

            $sql = "update disease set name = ?, discription = ? where dID = ?";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bind_param('ssi',$name,$discription,$dID);
            
            if($stmt->execute()){
    
                return true;
    
            }else{
    
                throw new Exception("Inserting pathalogy record unsuccessful!");
            }
    
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }


    }

    public function getDisease($dID){

        try {

            $sql = "select * from disease where dID = ?";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bind_param('i',$dID);
            
            if($stmt->execute()){

                $result = $stmt->get_result();
    
                return $result;
    
            }else{
    
                throw new Exception("Couldn't read pathology!");
            }
    
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }

    }

    public function addNewDisease($name,$condition){

        try {

            $sql = "insert into disease(name,discription) values(?,?)";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bind_param('ss',$name,$condition);
            
            if($stmt->execute()){
    
                return true;
    
            }else{
    
                throw new Exception("Inserting pathalogy record unsuccessful!");
            }
    
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }

    }

    public function deleteDisease($dID){

        try {

            $sql = "delete from disease where dID = ?";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bind_param('i',$dID);
            
            if($stmt->execute()){
    
                return true;
    
            }else{
    
                throw new Exception("Pathalogy record deleted unsuccessful!");
            }
    
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function getPathalogyDetails(){

        try {

            $sql = "select * from disease";
            $stmt = $this->db->getConnection()->prepare($sql);
            
            if($stmt->execute()){

                $result = $stmt->get_result();
    
                return $result;
    
            }else{
    
                throw new Exception("Couldn't read pathologies!");
            }
    
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }

    }
}

?>