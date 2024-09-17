<?php
require_once __DIR__ . '/../utils/DB.php';
class User {
    protected $db ;

    public function __construct()
    {
        $this->db = new DB() ;
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
                        throw new Exception();
                    }
                }else {
                    throw new Exception();
                }
            }
            else
            {
                throw new Exception();
            }
        } catch (Exception $th) {
            return false;
        }
    }

    public function getUserByEmail($email)
    {
        try {
            $email = mysqli_real_escape_string($this->db->getConnection(),$email);
            $quary = "select * from user where email = '$email'" ;
            if (mysqli_query($this->db->getConnection(),$quary)) {
                $result = mysqli_query($this->db->getConnection(),$quary);
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    return $row;
                }
                else {
                    throw new Exception();
                }
            } 
            else
            {
                throw new Exception();
            }
        } catch (Exception $th) {
            return false;
        }
        
    }

    public function addUser($fname,$lname,$nic,$cotactNo,$email,$address,$password,$type) {
        try {
            $fname = mysqli_real_escape_string($this->db->getConnection(),$fname);
            $lname = mysqli_real_escape_string($this->db->getConnection(),$lname);
            $nic = mysqli_real_escape_string($this->db->getConnection(),$nic);
            $cotactNo = mysqli_real_escape_string($this->db->getConnection(),$cotactNo);
            $email = mysqli_real_escape_string($this->db->getConnection(),$email);
            $address = mysqli_real_escape_string($this->db->getConnection(),$address);
            $type = mysqli_real_escape_string($this->db->getConnection(),$type);
            //$password =mysqli_real_escape_string($this->db->getConnection(),$password);

            $password =password_hash(mysqli_real_escape_string($this->db->getConnection(),$password),PASSWORD_DEFAULT);

            $quary = "INSERT INTO `user`(`fName`, `lName`, `nic`, `contactNo`, `email`, `address`, `password`,`type`) VALUES ('$fname','$lname','$nic','$cotactNo','$email','$address','$password','$type')" ;
            $result = mysqli_query($this->db->getConnection(),$quary);
            if ($result) {
                return mysqli_insert_id($this->db->getConnection());
            }
            else {
                throw new Exception();
            }
        } catch (Exception $th) {
            return false;
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
                    throw new Exception();
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
                throw new Exception();
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
                    if ((string)$token  === $data['token']) {
                        return true;
                    }
                    else {
                        throw new Exception();
                    }
                } else {
                    throw new Exception();
                }
            }else {
                throw new Exception();
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
                throw new Exception();
            }

        } catch (Exception $th) {
            return false;
        }
    }
}

?>