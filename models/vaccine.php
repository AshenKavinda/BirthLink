<?php

require_once __DIR__ . '/../utils/DB.php';

class vaccine{

    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function calculateDoseDates($birthDate) {
        // Define the vaccine schedule with respective age in months
        $vaccineSchedule = [
            ['age' => 0, 'vaccine' => 'BCG'],
            ['age' => 2, 'vaccine' => 'Triple + Hep B 1st dose'],
            ['age' => 2, 'vaccine' => 'Polio 1st dose'],
            ['age' => 2, 'vaccine' => 'Hib 1st dose'],
            ['age' => 4, 'vaccine' => 'Triple + Hep B 2nd dose'],
            ['age' => 4, 'vaccine' => 'Polio 2nd dose'],
            ['age' => 4, 'vaccine' => 'Hib 2nd dose'],
            ['age' => 6, 'vaccine' => 'Triple + Hep B 3rd dose'],
            ['age' => 6, 'vaccine' => 'Polio 3rd dose'],
            ['age' => 6, 'vaccine' => 'Hib 3rd dose'],
            ['age' => 9, 'vaccine' => 'Measles'],
            ['age' => 15, 'vaccine' => 'MMR'],
            ['age' => 18, 'vaccine' => 'Triple'],
            ['age' => 18, 'vaccine' => 'Polio'],
            ['age' => 18, 'vaccine' => 'Hib'],
            ['age' => 60, 'vaccine' => 'DT'], // School entry is typically around 4-5 years (60 months)
            ['age' => 60, 'vaccine' => 'Polio'],
            ['age' => 60, 'vaccine' => 'MMR']
        ];
    
        $doseDates = [];
    
        foreach ($vaccineSchedule as $vaccine) {
            $doseDate = new DateTime($birthDate);
            $doseDate->modify("+{$vaccine['age']} months");
            $doseDates[] = [
                'vaccine' => $vaccine['vaccine'],
                'doseDate' => $doseDate->format('Y-m-d')
            ];
        }
    
        return $doseDates;
    }

    public function addAllVaccines($bid,$birthDate) {
        $doseDates = $this->calculateDoseDates($birthDate); 
        $query = "INSERT INTO babyVaccine(bID, vID, doseDate) VALUES(?, ?, ?)";
        $stmt = $this->db->getConnection()->prepare($query);

        $this->db->getConnection()->begin_transaction();

        try {
            for ($i = 0; $i < count($doseDates); $i++) { 
                $vID = $i + 1; 
                $doseDate = $doseDates[$i]['doseDate']; 

                $stmt->bind_param('iis', $bid, $vID, $doseDate);

                if (!$stmt->execute()) {
                    throw new Exception('Error inserting record for vaccine ID ' . $vID);
                }
            }
            $this->db->getConnection()->commit();
            return true;

        } catch (Exception $e) {
            $this->db->getConnection()->rollback();
            return false;
            
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

   public function getVaccineDetails()
   {
        try {
            $sql = "select * from vaccinations";
            $stmt = $this->db->getConnection()->prepare($sql);
          
               
            if($stmt->execute()){

                $result = $stmt->get_result();
    
                return $result;
    
            }else{
    
                throw new Exception("Couldn't fetch vaccine records!");
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