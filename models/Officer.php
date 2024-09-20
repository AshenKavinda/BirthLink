<?php
require_once 'User.php';

class Officer extends User {
    public function addOfficer($fname, $lname, $nic,$email,$contactNo, $address, $password) {
        try {
            parent::addUser($fname, $lname, $nic, $contactNo, $email, $address, $password, "officer");
        } catch (Exception $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function allOfficers(){
        try{
            return parent::selectAll("officer");
        }catch(Exception $th){
            throw new Exception($th->getMessage());
        }
    }

    public function getOfficerById($oID){
        try{
            return parent::getUserById($oID,"officer");

        }catch(Exception $th){
            throw new Exception($th->getMessage());
        }
    }

    public function updateOfficer($uID,$fname, $lname, $nic,$contactNo,$email,$address){
        try{
            return parent::updateUser($uID,$fname, $lname, $nic,$email,$contactNo,$address);
        }
        catch(Exception $th){
            throw new Exception($th->getMessage());
        }
    }

    public function deleteOfficer($id){
        try{
            parent::deleteUser($id);
        }
        catch(Exception $th){
            throw new Exception($th->getMessage());
        }
    }
    
}


?>
