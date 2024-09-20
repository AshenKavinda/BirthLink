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
    
}
?>