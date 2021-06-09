<?php 
    $path_to_root = '../../';

    Class Stock extends Model{
        public $saleno;
        public $broker;
    
        public function readPurchaseList(){
            $query = "SELECT * FROM `closing_cat` WHERE sale_no =? OR sale_no = ? AND buyer_package = 'CSS'";
        
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->saleno);
            $stmt->bindValue(2, 'PRVT-'.$this->saleno);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
        }
 
        public function parking(){
            $query = "SELECT * FROM `parking`";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
        }

        public function addPrivatePurchase($data){
            $inserted = 0;
            $sql = "INSERT INTO `closing_cat`(`ware_hse`,  `value`, `lot`, `grade`, `manf_date`,`invoice`, `pkgs`, `type`,
            `net`, `gross`, `kgs`, `sale_price`, `buyer_package`, `sale_no`, `broker`, `imported_by`, `category`, `mark`, `company`)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
            try {
                $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(1, $data["ware_hse"]);
                    $stmt->bindParam(2, $data["value"]);
                    $stmt->bindParam(3, $data["lot"]);
                    $stmt->bindParam(4, $data["grade"]);
                    $stmt->bindParam(5, $data["manf_date"]);
                    $stmt->bindParam(6, $data["invoice"]);
                    $stmt->bindParam(7, $data["pkgs"]);
                    $stmt->bindParam(8, $data["type"]);
                    $stmt->bindParam(9, $data["net"]);
                    $stmt->bindParam(10, $data["gross"]);
                    $stmt->bindParam(11, $data["kgs"]);
                    $stmt->bindParam(12, $data["sale_price"]);
                    $stmt->bindValue(13, "CSS");
                    $stmt->bindParam(14, $data["sale_no"]);
                    $stmt->bindParam(15, $data["broker"]);
                    $stmt->bindValue(16, "1");
                    $stmt->bindParam(17, $data["category"]);
                    $stmt->bindParam(18, $data["mark"]);
                    $stmt->bindParam(19, $data["company"]);

                    $stmt->execute();
                    $inserted = 1;

            } catch (Exception $ex) {
                var_dump($ex);
            }
            return $inserted;
        
        }
    }

?>

