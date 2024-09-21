<?php
require_once __DIR__ . '/../utils/DB.php';

class SelectMother {
    protected $db;

    public function __construct() {
        $this->db = new DB();
    }

    public function getMothers() {
        try {
            $query = "SELECT * FROM user WHERE type = ?";
            $stmt = $this->db->getConnection()->prepare($query);
            $type = 'mother';
            $stmt->bind_param("s", $type);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                return $result;
            } else {
                throw new Exception("No data found");
            }
        } catch (Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function getMotherById($uid) {
        try {
            $query = "SELECT * FROM user WHERE uID = ? AND type = ?";
            $stmt = $this->db->getConnection()->prepare($query);
    
            $type = "mother";
            $stmt->bind_param('is',$uid,$type);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                return $result;
            } else {
                throw new Exception("No data found");
            }
        } catch (Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}

?>
