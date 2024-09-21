<?php

require_once __DIR__ . '/../utils/DB.php';

class center{

    private $db;

    public function __construct()
    {
        $this->db = new DB();

    }

    public function getAllProvinces()
    {
        try {
            $query = "Select * from province";
            $stmt = $this->db->getConnection()->prepare($query);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    return $result;
                } else {
                    throw new Exception("Table Empty!");
                }
            } else {
                throw new Exception("Query Error!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
  
    }

    public function getAllDistricts()
    {
        try {
            $query = "Select * from district";
            $stmt = $this->db->getConnection()->prepare($query);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    return $result;
                } else {
                    throw new Exception("Table Empty!");
                }
            } else {
                throw new Exception("Query Error!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
  
    }

    public function getAllAreas()
    {
        try {
            $query = "Select * from area";
            $stmt = $this->db->getConnection()->prepare($query);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    return $result;
                } else {
                    throw new Exception("Table Empty!");
                }
            } else {
                throw new Exception("Query Error!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        } 
  
    }

    public function addNewCenter($centerName,$proID,$disID,$areaID)
    {
        try {
            $query = "insert into center(name,provinceid,districtID,areaID) values (?,?,?,?)";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param('siii',$centerName,$proID,$disID,$areaID);
            if ($stmt->execute()) {

                return true;
                
            } else {
                throw new Exception("Query Error!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        } 
  
    }

    public function getCenter($centerID){

        
        try {
            $query = "select * from center where centerID = ?";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param('i',$centerID);
            if ($stmt->execute()) {

                $result = $stmt->get_result();
                if($result->num_rows>0)
                {
                    return $result;
                    
                }else{
                    throw new Exception(("No reord founds for centers!"));
                }
                
                
            } else {
                throw new Exception("Query Error!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        } 

    }

    public function updateCenter($centerID,$centerName,$provinceID,$districtID,$areaID){

        try {
            $query = "update center set name = ?, provinceid = ?, districtID =?, areaID = ? where centerID = ? ";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param('siiii',$centerName,$provinceID,$districtID,$areaID,$centerID);
            if ($stmt->execute()) {

                return true;
                
            } else {
                throw new Exception("Query Error!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        } 



    }

    public function deleteCenter($centerID){

        try {
            $query = "delete from center where centerID = ?";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param('i',$centerID);
            if ($stmt->execute()) {

                return true;
                
            } else {
                throw new Exception("Query Error!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        } 
    }

    public function getAllCenters()
    {
        try {
            $query = "SELECT 
                            c.centerID,
                            c.name AS centerName,
                            p.name AS provinceName,
                            d.name AS districtName,
                            a.name AS areaName
                        FROM 
                            center c
                        INNER JOIN 
                            province p ON c.provinceid = p.provinceid
                        INNER JOIN 
                            district d ON c.districtID = d.districtID
                        INNER JOIN 
                            area a ON c.areaID = a.areaID;
                        ";

            $stmt = $this->db->getConnection()->prepare($query);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    return $result;
                } else {
                    throw new Exception("Table Empty!");
                }
            } else {
                throw new Exception("Query Error!");
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
  
    }
}







?>