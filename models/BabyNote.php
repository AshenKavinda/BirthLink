<?php
require_once __DIR__ . '/../utils/DB.php';
class BabyNote {
    protected $db ;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function displayBybID($bID) {
        try {
            $quary = "select nb.slID, d.`name` , d.`discription` , nb.`date` from noteBaby nb inner join disease d on nb.dID = d.dID where nb.bID = ?";
            $stmt = $this->db->getConnection()->prepare($quary);
            $stmt->bind_param("i",$bID);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
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

    public function add($bID,$dID,$date) {
        try {
            $quary = "insert into noteBaby(bID, dID, `date`) values(?,?,?)";
            $stmt = $this->db->getConnection()->prepare($quary);
            $stmt->bind_param("iis",$bID,$dID,$date);
            if ($stmt->execute()) {
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
            $quary = "delete from noteBaby where slID = ?";
            $stmt = $this->db->getConnection()->prepare($quary);
            $stmt->bind_param("i",$slID);
            if ($stmt->execute()) {
                return true;
            }else {
                throw new Exception("Mysql quary unsuccessful!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }


}