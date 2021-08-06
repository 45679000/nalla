<?php 
    // $path_to_root = '../../';

    Class Finance extends Model{
        public $saleno;
        public $broker;
        
        public function readPurchaseList(){
            $this->debugSql = false;
            $this->query = "SELECT `closing_cat_import_id`, `sale_no`, `broker`, `category`, `comment`, `ware_hse`, 
            `entry_no`, `value`, `lot`, `company`, closing_cat.`mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`,
             `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, 
             `imported`, `imported_by`, `allocated`, `added_to_stock`, `grading_comment`, `max_bp`, `target`, 
             mark_country.country AS origin, `broker_invoice`
            FROM `closing_cat` 
            LEFT JOIN mark_country ON mark_country.mark = closing_cat.mark
            WHERE  buyer_package='CSS' AND sale_no = '".$this->saleno."' AND confirmed = 0
            GROUP BY lot, broker, pkgs";
            
            return $this->executeQuery();
        }

        public function readStock($type="", $condition="WHERE 1"){
            if($type=="purchases"){
                try {
                    $this->query = "SELECT * FROM closing_cat 
                    LEFT JOIN mark_country ON  mark_country.mark = closing_cat.mark
                    WHERE added_to_stock = 1 ORDER BY sale_no, lot ASC";
                    return $this->executeQuery();
                    } catch (Exception $th) {
                    var_dump($th);
                }
                
            }else{
                try {
                $this->query = "SELECT stock_allocation.allocation_id, closing_stock.`stock_id`, `sale_no`, `broker`, 
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
     
        }
        public function confirmPurchaseList($saleno){
            $this->debugSql = true;
            $this->query = "UPDATE closing_cat SET confirmed = 1 WHERE added_to_stock = 1 AND sale_no = '$saleno'";
            $this->executeQuery();
        }
        public function updateField($lotId, $fieldId, $value, $saleno){
            $this->query = "UPDATE closing_cat SET $fieldId = '$value'
            WHERE lot = '$lotId' AND sale_no = '$saleno'";
            $this->debugSql = true;
            return $this->executeQuery();

        }
        public function confirmedPurchaseList(){
            $this->debugSql = false;
            $this->query = "SELECT `closing_cat_import_id`, `sale_no`, `broker`, `category`, `comment`, `ware_hse`, 
            `entry_no`, `value`, `lot`, `company`, closing_cat.`mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`,
             `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, 
             `imported`, `imported_by`, `allocated`, `added_to_stock`, `grading_comment`, `max_bp`, `target`, 
             mark_country.country AS origin, `broker_invoice`
            FROM `closing_cat` 
            LEFT JOIN mark_country ON mark_country.mark = closing_cat.mark
            WHERE  buyer_package='CSS' AND sale_no = '".$this->saleno."' AND confirmed = 1
            GROUP BY lot, broker, pkgs";
            
            return $this->executeQuery();
        }
        public function postToStock($saleno){
            $this->debugSql = true;

            $this->query = "INSERT INTO `closing_stock`(`sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, 
            `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`,  `kgs`,
             `sale_price`, `standard`, `buyer_package`)
             SELECT  `sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`,
            `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `kgs`, `net`, 
            `sale_price`, `standard`, `buyer_package`
            FROM `closing_cat`
            WHERE confirmed = 1 AND lot NOT IN (SELECT lot FROM closing_stock WHERE sale_no = '$saleno')";

            $this->executeQuery();
            $this->debugSql = true;

            $this->query = "INSERT INTO `stock_allocation`(`stock_id`,  `standard`)
            SELECT stock_id,  standard
            FROM `closing_stock`
            WHERE sale_no = '$saleno' AND stock_id NOT IN (SELECT stock_id FROM closing_stock)";

            $this->executeQuery();

        }
        public function saveInvoice($post){
        $this->data = $post;
        $this->tablename = "tea_invoices";
        $id = $this->insertQuery();
        return $id;
        }
   
    }

?>

