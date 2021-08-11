<?php 
    // $path_to_root = '../../';

    Class Stock extends Model{
        public $saleno;
        public $broker;
        
        public function readPurchaseList(){
            $query = "SELECT `closing_cat_import_id`, `sale_no`, `broker`, `category`, `comment`, `ware_hse`, 
            `entry_no`, `value`, `lot`, `company`, closing_cat.`mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`,
             `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, 
             `imported`, `imported_by`, `allocated`, `added_to_stock`, `grading_comment`, `max_bp`, `target`, 
             mark_country.country AS origin
            FROM `closing_cat` 
            LEFT JOIN mark_country ON mark_country.mark = closing_cat.mark
            WHERE  buyer_package='CSS' AND sale_no = '".$this->saleno."' AND confirmed = 1
            GROUP BY lot, broker, pkgs";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
        }

        public function readStock($type="", $condition="WHERE 1"){
            if($type=="purchases"){
                try {
                    $this->debugSql = false;
                    $this->query = "SELECT `sale_no`, `broker`, `comment`, `ware_hse`, `value`, `lot`, mark_country.`mark`,
                     `grade`, `invoice`, warehouse, `type`, `sale_price`, `standard`, 
                     DATE_FORMAT(`import_date`,'%d/%m/%y') AS import_date, `allocated`,  mark_country.country, allocation, 
                     pkgs, net AS kgs, kgs AS net, comment
                     FROM closing_cat 
                    LEFT JOIN mark_country ON  mark_country.mark = closing_cat.mark
                    WHERE added_to_stock = 1 AND confirmed= 1 
                    GROUP BY lot 
                    ORDER BY sale_no, lot ASC";
                    return $this->executeQuery();
                    } catch (Exception $th) {
                    var_dump($th);
                }
                
            }else{
                try {
                $this->query = "SELECT closing_stock.`stock_id`, `sale_no`, `broker`, `comment`, `ware_hse`, `value`, `lot`, mark_country.`mark`, 
                 `grade`, `invoice`, allocated_whse AS warehouse, `type`, `sale_price`, `standard`, DATE_FORMAT(`import_date`,'%d/%m/%Y') AS import_date, 
                 `allocated`, `selected_for_shipment`, approval_id, 0_debtors_master.debtor_ref, mark_country.country,  client_id, 
                 (CASE WHEN shippments.id IS NULL THEN pkgs ELSE (pkgs-(sum(pkgs_shipped))) END) 
                 AS pkgs, 
                 (CASE WHEN shippments.id IS NULL THEN kgs ELSE (kgs-(sum(shipped_kgs))) END) AS kgs,
                 (CASE WHEN allocation IS NULL THEN 
                    CONCAT(COALESCE(0_debtors_master.short_name, ' ', standard))
                 ELSE 
                    allocation
                 END) AS allocation, kgs,  net
                 FROM closing_stock 
                 LEFT JOIN 0_debtors_master ON closing_stock.client_id = 0_debtors_master.debtor_no 
                 LEFT JOIN mark_country ON mark_country.mark = closing_stock.mark 
                 LEFT JOIN shippments ON shippments.stock_id = closing_stock.stock_id  
                ".$condition
                ." GROUP BY stock_id";
                $this->debugSql = false;
                return $this->executeQuery();
                
                } catch (Exception $th) {
                    var_dump($th);
                }
                

            }
            
        }

        public function unconfrimedPurchaseList(){
            $this->query = "SELECT * FROM `closing_cat` WHERE  buyer_package = 'CSS' AND closing_cat.added_to_stock = 0;
            ORDER BY sale_no, lot DESC";
            return $this->executeQuery();
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

        public function addPrivatePurchase($post){
            unset($post['action']);
            $this->debugSql = true;
            $this->data = $post;
            $this->tablename = "closing_cat";
            $id = $this->insertQuery();
            return $id;
        
        }
        public function allocateStock($stock_id, $fieldName, $fieldValue){
                $this->debugSql = true;
                $this->query = "UPDATE `closing_stock` SET $fieldName = '$fieldValue'
                WHERE `stock_id` = '$stock_id'";
                $this->executeQuery();
              
        }
        public function allocatedStock($type){
            $this->debugSql = false;

            $condition = "WHERE 1";
            if($type=="unallocated"){
                $condition.=" AND client_id IS NULL OR client_id = 0 ";
            }else{
                $condition.=" AND  client_id != 0 ";
            }
            $this->query = "SELECT stock_id, sale_no, debtor_ref, broker, mark, grade, sale_price, lot, net, invoice,
            comment, standard, pkgs, kgs, 0_debtors_master.short_name
            FROM closing_stock b
            LEFT JOIN 0_debtors_master  ON 0_debtors_master.debtor_no = b.client_id "
            .$condition. "
            ORDER BY client_id ASC";
            return $this->executeQuery();
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
        public function getLot($id){
            $this->query = "SELECT * FROM closing_stock WHERE stock_id = ".$id;
            return $this->executeQuery();
        }
        public function insertSplit($stockId, $Pkgs, $Kgs, $NewKgs, $NewPkgs){
            $this->debugSql = false;
            $this->query = "UPDATE closing_stock SET pkgs = $Pkgs, kgs = $Kgs WHERE stock_id = $stockId";
            $this->executeQuery();
            $this->debugSql = false;
            $this->query = "INSERT INTO `closing_stock`(`sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, `imported`, `imported_by`,  `is_blend_balance`, `allocated_whse`, `paid`) 
            SELECT `sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, $NewPkgs, `type`, `net`, `gross`, $NewKgs, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, `imported`, `imported_by`,  `is_blend_balance`, `allocated_whse`, `paid`
            FROM closing_stock WHERE stock_id = $stockId";
            $this->executeQuery();
        }
   
    }

?>

