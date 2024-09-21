<?php
require_once 'User.php';

class Mother extends User {

    public function addUser($fname, $lname, $nic, $cotactNo, $email, $address, $password,$birthDay=null,$latitude=null,$longitude=null)
    {
        try {
            $birthDay = mysqli_real_escape_string($this->db->getConnection(),$birthDay);
            $uID = Parent::addUser($fname, $lname, $nic, $cotactNo, $email, $address, $password, "mother");
            if ($uID != null) {
                $quary = "insert into mother(uID,birthDay,latitude,longitude) values($uID,'$birthDay',$latitude,$longitude)";
                $result = mysqli_query($this->db->getConnection(),$quary);
                if ($result) {
                    return $uID;
                }
                else {
                    return null;
                }
            }
            else {
                return null;
            }
            
        } catch (Exception $th) {
            return false;
        }
    }

    public function getMothers() {
        try {
            $query = "SELECT u.uID, u.fName, u.lName, u.nic, u.contactNo, u.email, u.address, u.password, u.type, u.token, u.status, m.birthDay, m.latitude, m.longitude FROM user u JOIN mother m ON u.uID = m.uID where type = 'mother'";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                return $result;
            } else {
                throw new Exception("No data found");
            }
        } catch (Throwable $th) {
            // throw new Exception($th->getMessage());
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

    public function getMotherByNIC($nic) {
        try {
            $query = "SELECT u.uID, u.fName, u.lName, u.nic, u.contactNo, u.email, u.address, u.password, u.type, u.token, u.status, m.birthDay, m.latitude, m.longitude FROM user u JOIN mother m ON u.uID = m.uID where type = 'mother' and nic like ?";
            $stmt = $this->db->getConnection()->prepare($query);
            $param = "%$nic%";
            $stmt->bind_param("s",$param);
            
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    return $result;
                } else {
                    throw new Exception("No data found");
                }
            } else {
                throw new Exception("Query Error");
            }
        } catch (Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

}