<?php
/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
// $path_to_root = "../../";
// include_once($path_to_root . "config_db.php");


class Database{
  
    // specify your own database credentials
    private $host = "localhost";
    public $db_name;
    public $username;
    public $password;
    public $conn;
    public $validToken = false;
    public $companyid;
    public $tbpref;
  
    public function init($id){
        $this->conn = null;
        // $this->db_name= $db_connections[$id]['dbname'];
        // $this->username= $db_connections[$id]['dbuser'];
        // $this->password= $db_connections[$id]['dbpassword'];
        // $this->host= 'localhost:3307';
        // $this->tbpref= $db_connections[$id]['tbpref'];

        $this->db_name= 'techsava_diocese_erp';
        $this->username= 'techsava_diocese_erp';
        $this->password= 'diocese_erp';
        $this->host= 'localhost';
        $this->tbpref= '0_';
        
    
    }
    public function getConnection(){
        $host = 'localhost';
        $db   = 'techsava_diocese_erp';
        $user = 'root';
        $pass = '';
        $port = "3306";
        $charset = 'utf8mb4';

        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
        try {
            $pdo = new \PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
        return $pdo;
  
    }
    public function authenticate($username, $password){
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $authenticatedUser = -1;
        $encrypt = md5($password);
        
        try {
            $sql = "SELECT * FROM ".$this->tbpref."users WHERE user_id = ? AND password = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $encrypt);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row); 
                    $authenticatedUser= $row['id'];
                }

            return $authenticatedUser;
        } catch (Exception $th) {
            echo $th;
        }
    }
    public function invoiceShare($username, $password){
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $authenticatedUser = -1;
        $encrypt = md5($password);
        try {
            $sql = "SELECT * FROM `0_users` WHERE user_id = ? AND password = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $encrypt);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row); 
                    $authenticatedUser= $row['id'];
                }
            return $authenticatedUser;
        } catch (Exception $th) {
            echo $th;
        }
    }
}

?>






