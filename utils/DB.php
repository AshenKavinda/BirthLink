<?php
class DB {
    private $conn ;

    public function __construct()
    {
        try {
            $this->conn = mysqli_connect('localhost','root','','birthlink');
        } catch (\Throwable $th) {
            die('<h1>DB Connection Fail</h1> ' . mysqli_connect_error());
        }
        
    }
    
    public function getConnection()
    {
        try {
            if (!mysqli_connect_errno()) {
                return $this->conn;
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
        
    }

    public function closeConnection() {
        try {
            $this->conn->close();
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}

?>

