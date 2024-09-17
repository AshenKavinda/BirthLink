<?php 
require_once __DIR__ . '/../utils/DB.php';
class SetClinicDate{
    protected $db;

    public function __construct(){
        $this->db = new DB;
    }

    public function set($firstDate,$seconddate){

        try{
            $query = "UPDATE clinicdates SET day1='$firstDate', day2='$seconddate' WHERE dateID = 11";
            $result = mysqli_query($this->db->getConnection(),$query);

            if($result){
                return true;
            }else{
                return false;
            }

        }catch(\Throwable $th){
            throw new Exception($th->getMessage());
        }
    }

    public function displaydates() {
        try {
            $query = "SELECT day1, day2 FROM clinicdates WHERE dateID = 11";
            $result = mysqli_query($this->db->getConnection(), $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                return [
                    "day1" => $row['day1'],
                    "day2" => $row['day2']
                ];
            } else {
                return [
                    "day1" => null,
                    "day2" => null
                ];
            }

        } catch(\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}

?>