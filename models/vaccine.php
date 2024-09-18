<?php

require_once __DIR__ . '/../utils/DB.php';

class vaccine{

    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function removeVaccineRecord($babyID,$vaccineID)
    {
        try {

            $sql = "update babyvaccine set givenDate = null where bID = ? and vID = ?";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bind_param('ii',$babyID,$vaccineID);
            
    
            if($stmt->execute()){
    
                return true;
    
            }else{
    
                throw new Exception("Couldn't remove record!");
            }
    
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function getVaccinationDetails($babyID)
    {
        try {
            $sql = "SELECT 
                        bv.bID, 
                        bv.vID, 
                        v.age, 
                        v.vaccineName, 
                        bv.doseDate, 
                        bv.givenDate
                    FROM 
                        babyVaccine bv
                    INNER JOIN 
                        vaccine v ON bv.vID = v.vID
                    WHERE 
                        bv.bID = ?; 
                    ";

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

   public function updateVaccineRecord($babyID,$vaccineID,$givenDate)
   {
    try {

        $sql = "update babyvaccine set givenDate = ? where bID = ? and vID = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('sii',$givenDate,$babyID,$vaccineID);
        

        if($stmt->execute()){

            return true;

        }else{

            throw new Exception("Vaccination record unsuccessful!");
        }

    } catch (\Throwable $th) {
        throw new Exception($th->getMessage());
    }

   }
}











?>