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
            $update = "update weight set status = 1 where bID = ?";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmtupdate = $this->db->getConnection()->prepare($update);
            $stmt->bind_param('ids',$bID,$weight,$date);
            $stmtupdate->bind_param('i',$bID);
            if ($stmt->execute()) {
                if ($stmtupdate->execute()) {
                    return true;
                } else {
                    throw new Exception("update Unsuccessful!");
                }
            } else {
                throw new Exception("insert Unsuccessful!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function delete($bid) {
        try {
            $selectAll="select * from weight where bID = ? order by slNO desc";
            $delete = "delete from weight where date = ? and bID = ? and status =  1";
            $update = "update weight set status = 0 where bID = ?";
            $stmtselectAll = $this->db->getConnection()->prepare($selectAll);
            $stmtdelete = $this->db->getConnection()->prepare($delete);
            $stmtupdate = $this->db->getConnection()->prepare($update);
            $stmtselectAll->bind_param('i',$bid);
            $stmtupdate->bind_param('i',$bid);
            if ($stmtselectAll->execute()) {
                $result = $stmtselectAll->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    
                    $stmtdelete->bind_param('si',$row['date'],$bid);
                    if ($stmtdelete->execute()) {
                        if ($stmtdelete->affected_rows > 0) {
                            if ($stmtupdate->execute()) {
                                if ($stmtupdate->affected_rows > 0) {
                                    return true;
                                }
                                else {
                                    throw new Exception("Status update unsuccessful!");
                                }
                            } else {
                                throw new Exception("Status quary error!");
                            }
                        } else {
                            throw new Exception("Last Record deleted rigth now!");
                        }
                    } else {
                        throw new Exception("Delete Error!");
                    }
                } else {
                    throw new Exception("select result empty!");
                }
                
            } else {
                throw new Exception("bid not found!");
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