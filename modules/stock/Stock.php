<?php 
    $path_to_root = '../../';

    Class Stock extends Model{
        public $saleno;
        public $broker;
    
        public function readStock(){
            $query = "SELECT * FROM `closing_cat` WHERE sale_no =? AND broker = ? AND buyer_package = 'CSS'";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->saleno);
            $stmt->bindParam(2, $this->broker);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
        }
        
    }

?>