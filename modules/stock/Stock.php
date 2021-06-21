<?php 
    // $path_to_root = '../../';

    Class Stock extends Model{
        public $saleno;
        public $broker;
    
        public function readPurchaseList(){
            $query = "SELECT * FROM `closing_cat` WHERE  buyer_package = 'CSS' AND sale_no = '".$this->saleno."'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
        }

        public function readStock($condition="WHERE 1"){
            $query = "SELECT * FROM `closing_stock` ".$condition;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
        }

        public function unconfrimedPurchaseList(){
            $query = "SELECT * FROM `closing_cat` WHERE  buyer_package = 'CSS' AND lot NOT IN (SELECT lot FROM closing_stock)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
        }

        public function readAllPurchaseList(){
            $query = "SELECT * FROM `closing_cat` WHERE  buyer_package = 'CSS'";
        
            $stmt = $this->conn->prepare($query);
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
        public function addToStock($lotId, $add=0, $confirmed =0){
            if($add == 1){
                $query = "UPDATE closing_cat SET added_to_stock = 1 WHERE lot = '$lotId'";
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
            }
            if($add == 0){
                $query = "UPDATE closing_cat SET added_to_stock = 0 WHERE lot = '$lotId'";
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
            }

            if($confirmed == 1){
                $query2 = "INSERT INTO `closing_stock`(`sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`,
                `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`,
                `tare`, `sale_price`, `standard`,  `import_date`)
                SELECT `sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`,
                `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`,
                `tare`, `sale_price`, `standard`,  `import_date`
                FROM closing_cat WHERE added_to_stock = 1 AND lot NOT IN(SELECT lot FROM closing_stock)";
                $stmt2 = $this->conn->prepare($query2);
                $stmt2->execute();
            }
     
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
        public function allocateStock($stock_id, $buyer, $mrpValue, $offerPrice, $pkgs){
            try {
                $query = "INSERT INTO `stock_allocation`( `stock_id`, `buyer_standard`, `allocated_pkgs`,  `max_offered_price`, `mrp_value`)
                VALUES (?,?,?,?,?)";
               $stmt = $this->conn->prepare($query);
               $stmt->bindParam(1, $stock_id);
               $stmt->bindParam(2, $buyer);
               $stmt->bindParam(3, $pkgs);
               $stmt->bindParam(4, $offerPrice);
               $stmt->bindParam(5, $mrpValue);
               $stmt->execute();
            } catch (Exception $th) {
                var_dump($th);   
             }

        }
        public function allocatedStock(){
            $query = "SELECT allocation_id, sale_no, broker, mark, grade, sale_price, lot, allocated_pkgs, kgs, invoice, mrp_value,
            allocated_pkgs*kgs AS net_allocation, buyer_standard, si_id, shipped, max_offered_price, c.standard as buyerstandard
            FROM closing_stock b
            LEFT JOIN stock_allocation a ON a.stock_id = b.stock_id
            LEFT JOIN grading_standard c ON c.id = a.buyer_standard 
            WHERE deallocated = 0";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
        }
    }

?>

