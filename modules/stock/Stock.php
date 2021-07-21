<?php 
    // $path_to_root = '../../';

    Class Stock extends Model{
        public $saleno;
        public $broker;
    
        public function readPurchaseList(){
            $query = "SELECT SELECT `closing_cat_import_id`, `sale_no`, `broker`, `category`, `comment`, `ware_hse`, 
            `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, `imported`, `imported_by`, `allocated`, `added_to_stock`, `grading_comment`, `max_bp`, `target`
            FROM `closing_cat` 
            WHERE  buyer_package = 'CSS' AND sale_no = '".$this->saleno."'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
        }

        public function readStock($condition="WHERE 1"){
            try {
                $query = "SELECT stock_allocation.allocation_id, closing_stock.`stock_id`, `sale_no`, `broker`, 
            `comment`, `ware_hse`,  `value`, `lot`,  mark_country.`mark`, `grade`, `invoice`, 
            (CASE WHEN stock_allocation.allocated_pkgs IS NULL THEN stock_allocation.allocated_pkgs ELSE closing_stock.pkgs END) AS pkgs, closing_stock.allocated_whse AS warehouse,
            `type`, `net`,  (stock_allocation.allocated_pkgs * net) AS `kgs`,  `sale_price`, stock_allocation.`standard`, 
            DATE_FORMAT(`import_date`,'%d/%m/%y') AS import_date, `imported`,  `allocated`, `selected_for_shipment`, `current_allocation`, `is_blend_balance`,
              stock_allocation.si_id, stock_allocation.shipped,
            stock_allocation.approval_id, 0_debtors_master.debtor_ref, blend_teas.id AS selected_for_shipment, 
            blend_teas.packages AS blended_packages, 
            CONCAT(COALESCE(stock_allocation.`standard`,''),' ',COALESCE(0_debtors_master.short_name,'')) AS allocation,
            mark_country.country
            FROM closing_stock 
            LEFT JOIN stock_allocation ON closing_stock.stock_id = stock_allocation.stock_id
            LEFT JOIN 0_debtors_master ON stock_allocation.client_id = 0_debtors_master.debtor_no
            LEFT JOIN blend_teas ON blend_teas.allocation_id = stock_allocation.allocation_id 
            LEFT JOIN mark_country ON  mark_country.mark = closing_stock.mark
            ".$condition
            ." GROUP BY stock_allocation.stock_id";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
            } catch (Exception $th) {
                var_dump($th);
            }
            
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
        public function allocateStock($stock_id, $buyer, $standard, $mrpValue, $pkgs, $warehouse){
            try {
                $query = "INSERT INTO `stock_allocation`( `stock_id`, `client_id`, `standard`,`allocated_pkgs`, `mrp_value`, `warehouse`)
                VALUES (?,?,?,?,?,?)";
               $stmt = $this->conn->prepare($query);
               $stmt->bindParam(1, $stock_id);
               $stmt->bindParam(2, $buyer);
               $stmt->bindParam(3, $standard);
               $stmt->bindParam(4, $pkgs);
               $stmt->bindParam(5, $mrpValue);
               $stmt->bindParam(6, $warehouse);

               $stmt->execute();
            } catch (Exception $th) {
                var_dump($th);   
             }

        }
        public function allocatedStock(){
            $query = "SELECT allocation_id, sale_no, debtor_ref, broker, mark, grade, sale_price, lot, allocated_pkgs, net, invoice, mrp_value,
            allocated_pkgs*net AS net_allocation,  si_id, shipped, max_offered_price, c.debtor_ref, comment, a.standard,
            CONCAT(COALESCE(c.debtor_ref, ''), ' ', COALESCE(a.standard,'')) AS buyerstandard 
            FROM closing_stock b
            LEFT JOIN stock_allocation a ON a.stock_id = b.stock_id
            LEFT JOIN 0_debtors_master c ON c.debtor_no = a.client_id
            WHERE deallocated = 0
            ORDER BY buyerstandard ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
        }
        public function sumTotal($columnname, $tablename){
            $this->query = "SELECT SUM($columnname) AS total FROM $tablename";
            $totals = $this->executeQuery(); 
            
            return $totals[0]['total'];
        }
        public function totalKgs(){
            $this->query = "SELECT SUM(kgs) AS total
             FROM stock_allocation
             LEFT JOIN closing_stock ON closing_stock.stock_id = stock_allocation.stock_id";
            $totals = $this->executeQuery(); 
            
            return $totals[0]['total'];
        }
        public function clients(){
            $this->query = "SELECT debtor_no, debtor_ref
            FROM 0_debtors_master
            WHERE tea_buyer = 1";
            return $this->executeQuery(); 
            
        }
   
    }

?>

