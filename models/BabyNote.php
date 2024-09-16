<?php
require_once __DIR__ . '/../utils/DB.php';
class BabyNote {
    protected $db ;

    public function __construct()
    {
        $this->db = new DB() ;
    }

    public function displayByPID($pID) {
        try {
            $quary = "select np.slID, d.`name` , d.`discription` , np.`date` from noteBaby np inner join disease d on np.dID = d.dID where np.pID = ?";
            $stmt = 
            $result = mysqli_query($this->db->getConnection(),$quary);
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    return $result;
                }
                else {
                    throw new Exception("no record found!");
                }
            }else {
                throw new Exception("Mysql quary unsuccessful!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function add($pID,$dID,$date) {
        try {
            $quary = "insert into notePreg(pID, dID, `date`) values($pID,$dID,'$date')";
            $result = mysqli_query($this->db->getConnection(),$quary);
            if ($result) {
                return true;
            }else {
                throw new Exception("Mysql quary unsuccessful!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function delete($slID) {
        try {
            $quary = "delete from notePreg where slID = $slID";
            $result = mysqli_query($this->db->getConnection(),$quary);
            if ($result) {
                return true;
            }else {
                throw new Exception("Mysql quary unsuccessful!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }


}