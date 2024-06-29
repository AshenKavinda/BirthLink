<?php
require_once('DB.class.php');
class SignIn {

    private $db ;

    public function __construct()
    {
        $this->db = new DB ;
    }

    public function validate($username,$password)
    {
        $vEmail = mysqli_real_escape_string($this->db->getConnection(),$username);
        $vPassword = mysqli_real_escape_string($this->db->getConnection(),$password);
        
        $quary = "select * from userData where email = '$vEmail' and password = '$vPassword' " ;
        if (mysqli_query($this->db->getConnection(),$quary)) {
            $result = mysqli_query($this->db->getConnection(),$quary);
            if (mysqli_num_rows($result)>=1) {
                return 1 ;
            }
            else
            {
                return 0 ;
            }
        }
        else
        {
            return 2;
        }
        try {
            

        } catch (\Throwable $th) {
            //return 3 ;
        }

    }

    public function getuIDByEmail($username)
    {
        $email = mysqli_real_escape_string($this->db->getConnection(),$username);
        $quary = "select uID from userData where email = '$email'" ;
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
}

?>