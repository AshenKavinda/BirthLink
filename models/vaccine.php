<?php

require_once __DIR__ . '/../utils/DB.php';

class vaccine{

    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function getAll() {
        try {
            $query = "Select * from vaccinations";
            $stmt = $this->db->getConnection()->prepare($query);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    return $result;
                } else {
                    throw new Exception("Table Empty!");
                }
            } else {
                throw new Exception("Quary Error!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function addAllVaccines($bid,$birthDate) {
        $query = "INSERT INTO babyVaccine(bID, vID, doseDate) VALUES(?, ?, ?)";
        $stmt = $this->db->getConnection()->prepare($query);

        $this->db->getConnection()->begin_transaction();

        try {
            $vaccinations = $this->getAll();
            $doseDates = [];
            while ($row = $vaccinations->fetch_assoc()) {
                $doseDate = new DateTime($birthDate);
                $doseDate->modify("+{$row['age']} months");
                $doseDates[] = [
                    'vID' => $row['vID'],
                    'doseDate' => $doseDate->format('Y-m-d')
                ];
            }


            foreach ($doseDates as $item) {
                $stmt->bind_param('iis', $bid, $item['vID'], $item['doseDate']);
                if (!$stmt->execute()) {
                    throw new Exception('Error inserting record for vaccine ID ' . $item['vID']);
                }
            }

            $this->db->getConnection()->commit();
            return true;

        } catch (Exception $e) {
            $this->db->getConnection()->rollback();
            throw new Exception($e->getMessage());  
        }

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
                        vaccinations v ON bv.vID = v.vID
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

   public function addNewVaccine($name,$age)
   {
        try {
            $sql = "insert into vaccinations(age,vaccineName) values(?,?)";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bind_param('ss',$age,$name);
               
            if($stmt->execute()){
    
                return true;
    
            }else{
    
                throw new Exception("Vaccination record unsuccessful!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    
   }



   public function deleteVaccine($vID){

    try {
        $sql = "delete from vaccinations where vID = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i',$vID);
             
        if($stmt->execute()){

            return true;

        }else{

            throw new Exception("Couldn't fetch vaccine records!");
        }
    } catch (\Throwable $th) {
        throw new Exception($th->getMessage());
    }
    
   }

   public function updateVaccine($vID,$name,$age){

    try {
        $sql = "update vaccinations set age = ?, vaccineName = ? where vID = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('ssi',$age,$name,$vID);
             
        if($stmt->execute()){

            return true;

        }else{

            throw new Exception("Couldn't update vaccine records!");
        }
    } catch (\Throwable $th) {
        throw new Exception($th->getMessage());
    }

   }

   public function getVaccine($vID){

    try {
        $sql = "select * from vaccinations where vID = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i',$vID);
             
        if($stmt->execute()){

            $result = $stmt->get_result();

            return $result;

        }else{

            throw new Exception("Couldn't get vaccine record!");
        }
    } catch (\Throwable $th) {
        throw new Exception($th->getMessage());
    }
   }
}

?>