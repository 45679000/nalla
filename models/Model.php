<?php 
class Model{
    public $query;
    public $conn;
    public $tablename;
    public $data;
    public $conditions = array();
    public $parameters = array();
    public $limit;
    public function __construct($db){
        $this->conn = $db;
    }

    public function insertQuery(){
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $columnString = implode(',', array_keys($this->data));
        $valueString = implode(',', array_fill(0, count($this->data), '?'));
        try {
            $stmt = $this->conn->prepare("INSERT INTO ".$this->tablename." ({$columnString}) VALUES ({$valueString})");
            $stmt->execute(array_values($this->data));
            return $this->conn->lastInsertId();
        } catch (Exception $ex) {
            echo $ex;
        }
      
    
    }
    public function selectQuery(){
        $sql = $this->query;
        $conditions = $this->conditions;
        $parameters = $this->parameters;
        if ($conditions){
            $sql .= " WHERE ".implode(" AND ", $conditions);
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }
    public function selectOne($id, $id_name){
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        try {
            $row = $this->conn->query("SELECT * FROM ".$this->tablename." WHERE ".$id_name." =".$id)->fetchAll();
            return $row;
        } catch (Exception $ex) {
            var_dump($ex);
        }
     
    }
    public function selectMany(){
        $rows = $this->conn->query("SELECT * FROM ".$this->tablename)->fetchAll();
        return $rows;
    }
    public function executeQuery(){
        $rows = $this->conn->query($this->query)->fetchAll();
        return $rows;
    }
    public function softDelete($pk, $tablename){
        $this->conn->query("UPDATE  ".$tablename." SET is_deleted = true WHERE id = ".$pk);
        return "Record Deleted";
    }


}