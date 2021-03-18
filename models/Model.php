<?php 
class Model{
    public $query;
    public $conn;
    public $tablename;
    public $data = array();
    public $conditions = array();
    public $parameters = array();
    public $limit;
    public function __construct($db){
        $this->conn = $db;
    }

    public function insertQuery(){
        $columnString = implode(',', array_keys($data));
        $valueString = implode(',', array_fill(0, count($data), '?'));

        $stmt = $this->conn->prepare("INSERT INTO ".$this->$tablename." ({$columnString}) VALUES ({$valueString})");
        $stmt->execute(array_values($data));
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
    public function selectOne($id){
        $row = $this->conn->query("SELECT * FROM ".$this->tablename." WHERE id = ?");
        $stmt->execute([$id]); 
        $row = $stmt->fetch();;
        return $row;
    }
    public function selectMany(){
        $rows = $pdo->query("SELECT * FROM ".$this->tablename)->fetchAll();
        return $rows;
    }
    public function executeQuery(){
        $rows = $pdo->query($this->query)->fetchAll();
        return $rows;
    }


}