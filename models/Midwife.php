<?php
require_once 'User.php';

class Midwife extends User {

    public function addMidwife($fname, $lname, $nic,$email,$contactNo, $address, $password,$center) {
        try {
            $uID = parent::addUser($fname, $lname, $nic, $contactNo, $email, $address, $password, "midwife");


            $quary = "INSERT INTO midwife(uID,centerID) VALUES ($uID,$center)";
            $result = mysqli_query($this->db->getConnection(),$quary); 
            
        } catch (Exception $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function allMidwifes(){
        try {
            $query = "SELECT user.uID, user.email, user.fName, user.lName, user.nic, user.contactNo,user.email, user.address, center.name 
            FROM user
            JOIN midwife ON user.uID = midwife.uID
            JOIN center ON midwife.centerID = center.centerID
            WHERE user.type = 'midwife'";
            
            $result = mysqli_query($this->db->getConnection(),$query);


            if ($result) {
                return $result;
            } else {
                throw new Exception("No data found");
            }
        } catch (Throwable $th) {
            throw new Exception($th->getMessage());
        }

    }

    public function searchMidwifes($mID){
        try {
            $query = "SELECT user.uID, user.email, user.fName, user.lName, user.nic, user.contactNo,user.email, user.address, center.centerID 
            FROM user
            JOIN midwife ON user.uID = midwife.uID
            JOIN center ON midwife.centerID = center.centerID
            WHERE user.type = 'midwife' AND user.uID = '$mID'";
            
            $result = mysqli_query($this->db->getConnection(),$query);


            if ($result) {
                return $result;
            } else {
                throw new Exception("No data found");
            }
        } catch (Throwable $th) {
            throw new Exception($th->getMessage());
        }

    }

    public function deleteMidwife($id){
        try{

            $query = "DELETE FROM midwife WHERE uID = '$id'";
            mysqli_query($this->db->getConnection(),$query);

            parent::deleteUser($id);


        }
        catch(Exception $th){
            throw new Exception($th->getMessage());
        }
    }

    public function getAll(){
        try {
            $query = "SELECT * FROM center";
            $result = mysqli_query($this->db->getConnection(),$query);

            if ($result) {
                return $result;
            } else {
                throw new Exception("No data found");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function getMidwifeById($oID){
        try{
            return parent::getUserById($oID,"officer");

        }catch(Exception $th){
            throw new Exception($th->getMessage());
        }
    }

    public function updateMidwife($uID,$fname, $lname, $nic,$email,$contactNo,$address,$center){
        try {
            $query = "UPDATE midwife SET centerID = '$center' WHERE uID = '$uID'";
            $result = mysqli_query($this->db->getConnection(),$query);

            return parent::updateUser($uID,$fname, $lname, $nic,$contactNo,$email,$address);

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function set($firstDate,$seconddate,$mid){

        try{
            $query = "UPDATE midwife SET day1='$firstDate', day2='$seconddate' WHERE uID = $mid";
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

    public function displaydates($uid) {
        try {
            $query = "SELECT day1, day2 FROM midwife WHERE uID = $uid";
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