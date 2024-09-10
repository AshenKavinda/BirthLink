<?php
require_once 'User.php';

class Mother extends User {

    public function addUser($fname, $lname, $nic, $cotactNo, $email, $address, $password,$birthDay=null)
    {
        try {
            $birthDay = mysqli_real_escape_string($this->db->getConnection(),$birthDay);
            $uID = Parent::addUser($fname, $lname, $nic, $cotactNo, $email, $address, $password, "mother");
            if ($uID != false) {
                $quary = "insert into mother(uID,birthDay) values($uID,'$birthDay')";
                $result = mysqli_query($this->db->getConnection(),$quary);
                if ($result) {
                    return $uID;
                }
                else {
                    throw new Exception();
                }

            }
            else {
                throw new Exception();
            }
            
        } catch (Exception $th) {
            return false;
        }
    }
}