<?php
class Database2{
  
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "chamu";
    private $username = "chamu";
    private $password = "Trymenot123#$$";
    public $conn;
    public $validToken = false;
  
    // get the database connection
    public function getConnection2(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }
}
?>
