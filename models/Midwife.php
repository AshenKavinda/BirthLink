<?php
require_once __DIR__ .'/../utils/MailerMailGun.php';
require_once 'User.php';

class Midwife extends User {

    private $mailGun;

    public function __construct()
    {
        $this->db = new DB();
        $this->mailGun = new MailerMailGun();
    }

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

    public function getUserWithMidwife($uID)
    {
        try {
            $uID = intval($uID); // Sanitize input
            $query = "SELECT u.*, m.day1, m.day2, m.centerID
                    FROM user u
                    INNER JOIN midwife m ON u.uID = m.uID
                    WHERE u.uID = $uID";
            
            if ($result = mysqli_query($this->db->getConnection(), $query)) {
                if (mysqli_num_rows($result) > 0) {
                    return mysqli_fetch_assoc($result);
                } else {
                    throw new Exception("No user found with this ID.");
                }
            } else {
                throw new Exception("Query failed: " . mysqli_error($this->db->getConnection()));
            }
        } catch (Exception $th) {
            throw new Exception($th->getMessage());
        }
    }


    public function sendEmail($midID) {
        try {
            $quary = "
            SELECT user.email 
            FROM user
            INNER JOIN pregnancy p ON p.uID = user.uID
            INNER JOIN baby b ON p.pID = b.pID
            INNER JOIN midwife mid ON p.midID = mid.uID
            WHERE (p.status = 1 
            OR TIMESTAMPDIFF(MONTH, b.bDay, CURDATE()) < 60)
            AND mid.uID = ? group by user.email";
            $stmt = $this->db->getConnection()->prepare($quary);
            $stmt->bind_param('i',$midID);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $emails = [];
                while ($row = $result->fetch_assoc()) {
                    $email = $row['email'];
                    // Validate email before adding to array
                    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $emails[] = $email;
                    }
                }
                $midwife = $this->getUserWithMidwife($midID);
                $massage = "First date :".$midwife['day1']."\n"."Second date :".$midwife['day2'];
                $this->mailGun->send($emails,"Your Clinic Dates",$massage);
            } else {
                throw new Exception("Quary Error!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

}

?>