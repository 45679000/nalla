<?php
require '../modules/mailer/sendEmail.php';

class UserController extends Model{
    // database connection and table name
    public $username;
    public $password;
    // constructor with $db as database connection

    public function authenticateUser(){
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $user_id = $this->basicAuth($this->username, $this->password);
            $userDetails = $this->readOne(  'users',
                                            'user_id',
                                             $user_id
                                        );
            $userDept = $this->readOne( 'departments',
                                        'department_id',
                                        $userDetails['department_id']
                                        );
            
            if($userDetails['user_id'] != null){
                $this->sessionManager->user_id =  $userDetails['user_id'];
                $this->sessionManager->user_name =  $userDetails['user_name'];
                $this->sessionManager->full_name =  $userDetails['full_name'];
                $this->sessionManager->email =  $userDetails['email'];
                $this->sessionManager->role_id =  $userDetails['role_id'];
                $this->sessionManager->user_department =  $userDetails['user_department'];

                $img = explode("/",$userDetails['image'],  "2");

                $this->sessionManager->image =  $img[1];


                $userLevels = $this->readOne('access_levels',
                                            'role_id',
                                            $userDetails['role_id']
                                        );
                $this->sessionManager->menu = $userLevels['menu_name'];

                $otp = $this->generateOtp($user_id);
                
                if($otp != null){
                    
                    $mailer = new Mailer("<p>OTP CODE: ".$otp."</p>", $userDetails['email'], "OTP");
                    // $is_sent = $mailer->sendEmail($userDetails['email']);
                    // if($is_sent==1){
                        $this->sessionManager->otp=$otp;
                    //     $this->sessionManager->message="Enter the verification code sent to your email";

                    // }else {
                    //     var_dump($is_sent); die();
                    // }
                }
                // $_SESSION["connection"] = $this->conn;



            }

    }
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

    
    public function generateOtp($user_id){
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $fourRandomDigit = mt_rand(1000,9999);
        $sql = "UPDATE `users` SET `two_factor_auth_code`= ? WHERE user_id = ?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $fourRandomDigit);
            $stmt->bindParam(2, $user_id);

            $stmt->execute();
            return $fourRandomDigit;
        } catch (Exception $ex) {
            echo $ex;
        }
    }
	
	public function deleteStaff($StaffId){
        $deleted = false;
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = "UPDATE `staff` SET `IsDeleted` = true
		 WHERE StaffId = ".$StaffId;
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $deleted = true;
        } catch (Exception $ex) {
            echo $ex;
        }
        return $deleted;
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
    public function generatePassword($length = 5){
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
     
    }
    public function resetPassword($password, $id){
        $id = $_POST["id"];
        $this->tablename = "users";
        $record = $this->selectOne($id, "user_id");

        $mailer = new Mailer("<p>User Name: ".$record[0]['email'] ."</p> Password:".$password, "", "Password Reset");
        $is_sent = $mailer->sendEmail($record[0]['email']);

        if($is_sent){
            $this->query = "UPDATE users SET password = md5('$password') WHERE user_id = $id";
            $this->executeQuery();
            echo json_encode(array("reset"=>"sucess"));

        }
        else 
            echo json_encode(array("reset"=>"failed"));

    }
    public function forgotPassword($password, $username){
        $id = $_POST["id"];
        $this->query = "SELECT * FROM `users` WHERE users.user_name = '$username'";
        $record = $this->executeQuery();
        if($record){
            $mailer = new Mailer("<p>User Name: ".$record[0]['email'] ."</p> Password:".$password, "", "Password Reset");
            $is_sent = $mailer->sendEmail($record[0]['email']);
    
            if($is_sent){
                $this->query = "UPDATE users SET password = md5('$password') WHERE users.user_name = '$username'";
                $this->executeQuery();
                echo "success";
    
            }
            else {
                echo json_encode(array("reset"=>"failed"));
            }
        } else {
            echo "error";
        }
        
    }
}
?>