<?php

require_once __DIR__ . '/../utils/DB.php';

class Weight{

    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function add($bID,$weight,$date) {
        try {
            $query = "insert into weight(bID,weight,date) values(?,?,?)";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param('ids',$bID,$weight,$date);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function delete($bid,$date) {
        try {
            $query = "delete from weight where date = ? and bid = ?";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param('si',$date,$bid);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function display($uID) {
        try {
            $query = "select date,weight from weight where bid = ? order by date";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param('i',$uID);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    return $result;
                } else {
                    throw new Exception("No data found!");
                }
            } else {
                throw new Exception("Database error!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
    
}

?>