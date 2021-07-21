<?php
class Users{
    // database connection and table name
    private $conn;
    public $username;
    public $password;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    public function authenticateUser(){
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $user_id = $this->basicAuth($this->username, $this->password);
            $userDetails = $this->readOne(  'users',
                                            'user_id',
                                             $user_id
                                        );
            if($userDetails['user_id'] != null){
                $_SESSION["user_id"] =     $userDetails['user_id'];
                $_SESSION["user_name"] =   $userDetails['user_name'];
                $_SESSION["full_name"] =   $userDetails['full_name'];
                $_SESSION["email"] =       $userDetails['email'];
                $_SESSION["role_id"] =     $userDetails['role_id'];
                $userLevels = $this->readOne('access_levels',
                                            'role_id',
                                            $userDetails['role_id']
                                        );

                $_SESSION["menu"] = $userLevels['menu_name'];
                $otp = $this->generateOtp($user_id);
                if($otp != null){
                    $mailer = new Mailer("<p>OTP CODE: ".$otp."</p>", $userDetails['email'], "OTP");
                    $is_sent = $mailer->sendEmail($userDetails['email']);
                    if($is_sent==1){
                        $_SESSION["otp"] = $otp;
                        $_SESSION["message"] = "Enter the verification code sent to your email";
                    }
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
        switch($role){
            case '1':
                header("location:dashboard.php");
                exit();

            case '2':
                header("location:dashboard.php");
                exit();

            case '3':
                header("location:dashboard.php");
                exit();

            case '4':
                header("location:dashboard.php");
                exit();
            case '5':
                header("location:../modules/warehousing/index.php?view=dashboard");
                exit();

            default:
                echo "Wrong Username or Password";
        }
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
    
    
    
}
?>