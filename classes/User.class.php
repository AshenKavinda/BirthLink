<?php
require_once('DB.class.php');
class User {

    private $db ;

    public function __construct()
    {
        $this->db = new DB ;
    }

    public function validateUser($username,$password)
    {
        try {
            $vEmail = mysqli_real_escape_string($this->db->getConnection(),$username);
            $vPassword = mysqli_real_escape_string($this->db->getConnection(),$password);
            
            //$quary = "select * from userData where email = '$vEmail'" ;
            $quary = "select * from user where email = '$vEmail'" ;
            if (mysqli_query($this->db->getConnection(),$quary)) {
                $result = mysqli_query($this->db->getConnection(),$quary);
                if (mysqli_num_rows($result)>0) {
                    $row = mysqli_fetch_row($result);
                    //echo $row[7];                   
                    if (password_verify($vPassword,$row[7])) {
                        return true ;
                    }
                    else
                    {
                        return false ;
                    }
                }
                
            }
            else
            {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function getuIDByEmail($username)
    {
        $email = mysqli_real_escape_string($this->db->getConnection(),$username);
        //$quary = "select uID from userData where email = '$email'" ;
        $quary = "select uID from user where email = '$email'" ;
        if (mysqli_query($this->db->getConnection(),$quary)) {
            $result = mysqli_query($this->db->getConnection(),$quary);
            $row = mysqli_fetch_row($result);
            return $row[0] ;
        }
        else
        {
            return 2 ;
        }
    }

    public function addUser($fname,$lname,$nic,$cotactNo,$email,$address,$password) {
        try {
            $fname = mysqli_real_escape_string($this->db->getConnection(),$fname);
            $lname = mysqli_real_escape_string($this->db->getConnection(),$lname);
            $nic = mysqli_real_escape_string($this->db->getConnection(),$nic);
            $cotactNo = mysqli_real_escape_string($this->db->getConnection(),$cotactNo);
            $email = mysqli_real_escape_string($this->db->getConnection(),$email);
            $address = mysqli_real_escape_string($this->db->getConnection(),$address);
            $password = mysqli_real_escape_string($this->db->getConnection(),$password);
            $quary = "INSERT INTO `user`(`fName`, `lName`, `nic`, `contactNo`, `email`, `address`, `password`) VALUES ('$fname','$lname','$nic','$cotactNo','$email','$address','$password')" ;
            $result = mysqli_query($this->db->getConnection(),$quary);
            if ($result) {
                return true;
            }
            else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

?>