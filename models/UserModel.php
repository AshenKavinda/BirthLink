<?php
class UserModel {
    private $db ;

    public function __construct($db)
    {
        $this->db = $db ;
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
                        return "200" ;
                    }
                    else
                    {
                        return "404" ;
                    }
                }
                
            }
            else
            {
                return "404";
            }
        } catch (Exception $th) {
            return "400";
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
            //$password =mysqli_real_escape_string($this->db->getConnection(),$password);

            $password =password_hash(mysqli_real_escape_string($this->db->getConnection(),$password),PASSWORD_DEFAULT);

            $quary = "INSERT INTO `user`(`fName`, `lName`, `nic`, `contactNo`, `email`, `address`, `password`,`type`) VALUES ('$fname','$lname','$nic','$cotactNo','$email','$address','$password','mother')" ;
            $result = mysqli_query($this->db->getConnection(),$quary);
            if ($result) {
                return true;
            }
            else {
                return false;
            }
        } catch (Exception $th) {
            throw $th;
        }
    }

    public function verifyEmail($email) {
        try {
            $quary = "select * from user where email = '$email'";
            $result = mysqli_query($this->db->getConnection(),$quary);
            if ($result) {
                if (mysqli_num_rows($result)>0) {
                    return true;
                }
                else {
                    return false;
                }
            }
        } catch (Exception $th) {
            return false;
        }

    }

    public function setToken($email) {
        try {
            $token = mt_rand(10000,99999);
            $quary = "update user set token = $token where email = '$email'";
            $result =  mysqli_query($this->db->getConnection(),$quary);
            if ($result) {
                return $token;
            }else {
                return false;
            }
        } catch (Exception $th) {
            return false;
        }
    }

    public function matchToken($email,$token) {
        try {
            $quary = "select * from user where email = '$email'";
            $result = mysqli_query($this->db->getConnection(),$quary);
            if ($result) {
                if ($data = mysqli_fetch_assoc($result)) {
                    if ($token  === $data['token']) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
            }
        } catch (Exception $th) {
            return false;
        }
    }

    public function updatePasswordByEmail($email,$password) {
        try {
            $hashPassword = password_hash($password,PASSWORD_DEFAULT);
            $quary = "update user set password = '$hashPassword' where email = '$email'";
            $result = mysqli_query($this->db->getConnection(),$quary);
            if ($result) {
                return true;
            }
            else {
                return false;
            }

        } catch (Exception $th) {
            return false;
        }
    }
}

?>