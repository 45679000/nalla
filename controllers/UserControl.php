<?php

class UserController extends Model{
    // database connection and table name
    public $username;
    public $password;
    // constructor with $db as database connection

    public function readOne($tablename, $pk, $id){
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sql = "SELECT * FROM ".$tablename. " WHERE ". $pk ." = ?";
        try{
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $num = $stmt->rowCount();
            if($num>0){      
                $row = $stmt->fetch(PDO::FETCH_ASSOC);   
                return $row;      
            } 
        }catch(Exception $ex){
            var_dump($ex);
        }
           
}
    public function basicAuth($username, $password){
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sql = "SELECT * FROM users WHERE user_name = ? AND password = ?";
        try{
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $password);
            $stmt->execute();
            $num = $stmt->rowCount();
            if($num>0){      
                $row = $stmt->fetch(PDO::FETCH_ASSOC);   
                return $row['user_id'];      
            }else{
                return -1;
            }
        }catch(Exception $ex){
            var_dump($ex);
        }

    }
    public function redirectUser($role){
        $redirectPath = "";
        switch($role){
            case '1':
                $redirectPath = "../views/dashboard.php";
                exit();

            case '2':
                $redirectPath = "../views/dashboard.php";
                exit();

            case '3':
                $redirectPath = "../views/dashboard.php";
                exit();

            case '4':
                $redirectPath = "../views/dashboard.php";
                exit();
            case '5':
                $redirectPath = "../modules/warehousing/index.php?view=dashboard";
                exit();
            case '6':
                $redirectPath = "../modules/cataloguing/index.php?view=dashboard";
                exit();
            default:
                echo "Wrong Username or Password";
        }
        return $redirectPath;
    }

    
	
    public function getTotal($tablename, $field, $condition){
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sql = "SELECT COUNT($field) AS $field FROM ".$tablename. " ".$condition;
        try{
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $num = $stmt->rowCount();
            if($num>0){      
                $row = $stmt->fetch(PDO::FETCH_ASSOC);   
                return $row;      
            } 
        }catch(Exception $ex){
            var_dump($ex);
        }
    }
    public function getTodaysActiveUserList(){
        $this->query = "SELECT users.user_id, users.user_name, users.password, users.full_name, users.email, users.last_login, roles.role_name, users.image,
         departments.department_name
        FROM users
        LEFT JOIN roles ON roles.role_id = users.role_id
        LEFT JOIN departments ON departments.department_id = users.department_id
        WHERE  DATE(last_login)  = current_date";
        return $this->executeQuery();

    }
    public function getActiveUserList(){
        $this->query = "SELECT users.user_id, users.user_name, users.password, users.full_name, users.email, users.last_login, roles.role_name, users.image,
         departments.department_name
        FROM users
        LEFT JOIN roles ON roles.role_id = users.role_id
        LEFT JOIN departments ON departments.department_id = users.department_id
        WHERE  users.is_active  = 1";
        return $this->executeQuery();

    }
    public function getActiveDepartments(){
        $this->query = "SELECT departments.department_id, departments.department_name, users.full_name 
        FROM departments
        LEFT JOIN users ON users.user_id = departments.department_leader
        WHERE  departments.is_active  = 1";
        return $this->executeQuery();

    }

    public function addUser($post){
        $this->data = $post;
        $this->tablename = "users";
        $id = $this->insertQuery();
        return $this->selectOne($id, "user_id");

    }
    public function removeUser($id){
        $this->query = "DELETE FROM `users` WHERE users.user_id = $id";
        $record = $this->executeQuery();
        return $record;
    }
}
?>