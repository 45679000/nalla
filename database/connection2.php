<?php
class Database2{
  
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "chamu";
    private $username = "chamu";
    private $password = "";
    public $conn;
    public $validToken = false;

    // get the database connection
    public function getConnection(){
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password, $options);
            $this->conn->exec("set names utf8mb4"); 
        }catch(PDOException $exception){
        }
  
        return $this->conn;
    }
}
?>
