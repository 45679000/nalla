<?php 
    // $path_to_root = '../../';

    Class Stock extends Model{
        public $saleno;
        public $broker;
        
        public function salenoPurchases($type){
            $query = "SELECT sale_no FROM buying_list ";
            if($type=='A'){
                $query.=" WHERE source = 'A' AND added_to_stock = 1";
            }elseif($type=='P'){
                $query.=" WHERE source = 'P' AND added_to_stock = 1";
            }
            $query.=" GROUP BY sale_no ORDER BY sale_no DESC";

           $this->query = $query;
           return $this->executeQuery();
            
        }

        public function loadOpeningStock($filters){
            try {
                $this->debugSql = false;
                $current_year = date("Y");
                 $query = "SELECT line_no, shippments.confirmed, shippments.mrp_value, shippments.id AS shipped, closing_stock.`stock_id`, `sale_no`, `broker`, `comment`, `ware_hse`, `value`, `lot`, closing_stock.`mark`, 
                  `grade`, `invoice`, allocated_whse AS warehouse, `type`, `sale_price`, `standard`, DATE_FORMAT(`auction_date`,'%d/%m/%Y') AS import_date, 
                  `allocated`, `selected_for_shipment`, approval_id, 0_debtors_master.debtor_ref, a.country,  client_id, profoma_invoice_no,
                  closing_stock.pkgs, closing_stock.kgs,
                  (CASE WHEN allocation IS NULL THEN 
                     CONCAT(COALESCE(0_debtors_master.short_name, ' ', standard))
                  ELSE 
                     allocation
                  END) AS allocation, kgs,  net, allocation AS allocated_contract
                  FROM closing_stock 
                  LEFT JOIN 0_debtors_master ON closing_stock.client_id = 0_debtors_master.debtor_no
                  LEFT JOIN (SELECT mark AS garden, country FROM mark_country GROUP BY mark) AS a ON a.garden = closing_stock.mark 
                  LEFT JOIN (SELECT code, id FROM grading_comments GROUP BY code) AS b ON b.code = closing_stock.comment 
                  LEFT JOIN shippments ON shippments.stock_id = closing_stock.stock_id 
                  WHERE (is_shipped = 0 OR is_shipped IS NULL) AND sale_no NOT LIKE '%$current_year%' ";
                  foreach($filters as $key=>$value){
                    $query.= " AND $key = '$value'";
                  }
                 $query.= " GROUP BY closing_stock.stock_id ORDER BY line_no, lot  DESC";
 
                 $this->query = $query;
                 return $this->executeQuery();
                 
                 } catch (Exception $th) {
                     var_dump($th);
                 }
                 

        }
        public function loadTotalStock($filters){
            try {
                $this->debugSql = false;
                $current_year = date("Y");
                 $query = "SELECT line_no, shippments.confirmed, shippments.mrp_value, shippments.id AS shipped, closing_stock.`stock_id`, `sale_no`, `broker`, `comment`, `ware_hse`, `value`, `lot`, closing_stock.`mark`, 
                  `grade`, `invoice`, allocated_whse AS warehouse, `type`, `sale_price`, `standard`, DATE_FORMAT(`auction_date`,'%d/%m/%Y') AS import_date, 
                  `allocated`, `selected_for_shipment`, approval_id, 0_debtors_master.debtor_ref, a.country,  client_id, profoma_invoice_no,
                  closing_stock.pkgs, closing_stock.kgs,
                  (CASE WHEN allocation IS NULL THEN 
                     CONCAT(COALESCE(0_debtors_master.short_name, ' ', standard))
                  ELSE 
                     allocation
                  END) AS allocation, kgs,  net, allocation AS allocated_contract
                  FROM closing_stock 
                  LEFT JOIN 0_debtors_master ON closing_stock.client_id = 0_debtors_master.debtor_no
                  LEFT JOIN (SELECT mark AS garden, country FROM mark_country GROUP BY mark) AS a ON a.garden = closing_stock.mark 
                  LEFT JOIN (SELECT code, id FROM grading_comments GROUP BY code) AS b ON b.code = closing_stock.comment 
                  LEFT JOIN shippments ON shippments.stock_id = closing_stock.stock_id 
                  WHERE (is_shipped = 0 OR is_shipped IS NULL) ";
                  foreach($filters as $key=>$value){
                    $query.= " AND $key = '$value'";
                  }
                 $query.= " GROUP BY closing_stock.stock_id ORDER BY line_no, lot  DESC";
 
                 $this->query = $query;
                 return $this->executeQuery();
                 
                 } catch (Exception $th) {
                     var_dump($th);
                 }
                 

        }
        public function loadPurchases($filters){
            try {
                $this->debugSql = false;
                $current_year = date("Y");
                 $query = "SELECT c.line_no, bl.`buying_list_id`, bl.`sale_no`, bl.`broker`, bl.`comment`, bl.`ware_hse`, bl.`value`, bl.`lot`, a.`mark`, bl.`grade`, bl.`invoice`,  bl.warehouse, bl.`type`, bl.`sale_price`, bl.`standard`, 
                 DATE_FORMAT(bl.`auction_date`,'%d/%m/%Y') AS import_date, bl.`allocated`, 
                 0_debtors_master.debtor_ref, a.country, bl.pkgs, bl.kgs, (CASE WHEN c.allocation IS NULL THEN CONCAT(COALESCE(0_debtors_master.short_name, ' ', c.standard)) ELSE c.allocation END) AS allocation, bl.kgs, bl.net, bl.allocation AS allocated_contract
                 FROM buying_list bl
                 INNER JOIN closing_stock c ON c.sale_no = bl.sale_no AND c.broker = bl.broker AND c.lot = bl.lot 
                 LEFT JOIN 0_debtors_master ON c.client_id = 0_debtors_master.debtor_no 
                 LEFT JOIN (SELECT mark, country FROM mark_country GROUP BY mark) AS a ON a.mark = bl.mark 
                 LEFT JOIN (SELECT code, id FROM grading_comments GROUP BY code) AS b ON b.code = bl.comment 
                 WHERE bl.sale_no LIKE '%$current_year%' ";
                  foreach($filters as $key=>$value){
                    $query.= " AND $key = '$value'";
                  }
                  $query.= " GROUP BY bl.lot, bl.invoice, bl.broker, bl.sale_no
                  ORDER BY bl.sale_no, bl.lot ASC";
 
                 $this->query = $query;
                 return $this->executeQuery();
                 
                 } catch (Exception $th) {
                     var_dump($th);
                 }
                 

        }
        public function loadBlendedTea($filters){
            try {
                $this->debugSql = false;
                $current_year = date("Y");
                 $query = "SELECT line_no, shippments.confirmed, shippments.mrp_value, shippments.id AS shipped, closing_stock.`stock_id`, `sale_no`, `broker`, `comment`, `ware_hse`, `value`, `lot`, closing_stock.`mark`, 
                  `grade`, `invoice`, allocated_whse AS warehouse, `type`, `sale_price`, `standard`, DATE_FORMAT(`auction_date`,'%d/%m/%Y') AS import_date, 
                  `allocated`, `selected_for_shipment`, approval_id, 0_debtors_master.debtor_ref, a.country,  client_id, profoma_invoice_no,
                  closing_stock.pkgs, closing_stock.kgs,
                  (CASE WHEN allocation IS NULL THEN 
                     CONCAT(COALESCE(0_debtors_master.short_name, ' ', standard))
                  ELSE 
                     allocation
                  END) AS allocation, kgs,  net, allocation AS allocated_contract
                  FROM closing_stock 
                  LEFT JOIN 0_debtors_master ON closing_stock.client_id = 0_debtors_master.debtor_no
                  LEFT JOIN (SELECT mark AS garden, country FROM mark_country GROUP BY mark) AS a ON a.garden = closing_stock.mark 
                  LEFT JOIN (SELECT code, id FROM grading_comments GROUP BY code) AS b ON b.code = closing_stock.comment 
                  LEFT JOIN shippments ON shippments.stock_id = closing_stock.stock_id 
                  WHERE (is_shipped = 0 OR is_shipped IS NULL) AND is_blend_balance = 1 ";
                  foreach($filters as $key=>$value){
                    $query.= " AND $key = '$value'";
                  }
                 $query.= " GROUP BY closing_stock.stock_id ORDER BY line_no, lot  DESC";
 
                 $this->query = $query;
                 return $this->executeQuery();
                 
                 } catch (Exception $th) {
                     var_dump($th);
                 }
                 

        }
        public function loadOriginalTea($filters){
            try {
                $this->debugSql = false;
                $current_year = date("Y");
                 $query = "SELECT line_no, shippments.confirmed, shippments.mrp_value, shippments.id AS shipped, closing_stock.`stock_id`, `sale_no`, `broker`, `comment`, `ware_hse`, `value`, `lot`, closing_stock.`mark`, 
                  `grade`, `invoice`, allocated_whse AS warehouse, `type`, `sale_price`, `standard`, DATE_FORMAT(`auction_date`,'%d/%m/%Y') AS import_date, 
                  `allocated`, `selected_for_shipment`, approval_id, 0_debtors_master.debtor_ref, a.country,  client_id, profoma_invoice_no,
                  closing_stock.pkgs, closing_stock.kgs,
                  (CASE WHEN allocation IS NULL THEN 
                     CONCAT(COALESCE(0_debtors_master.short_name, ' ', standard))
                  ELSE 
                     allocation
                  END) AS allocation, kgs,  net, allocation AS allocated_contract
                  FROM closing_stock 
                  LEFT JOIN 0_debtors_master ON closing_stock.client_id = 0_debtors_master.debtor_no
                  LEFT JOIN (SELECT mark AS garden, country FROM mark_country GROUP BY mark) AS a ON a.garden = closing_stock.mark 
                  LEFT JOIN (SELECT code, id FROM grading_comments GROUP BY code) AS b ON b.code = closing_stock.comment 
                  LEFT JOIN shippments ON shippments.stock_id = closing_stock.stock_id 
                  WHERE (is_shipped = 0 OR is_shipped IS NULL) AND is_blend_balance = 0 ";
                  foreach($filters as $key=>$value){
                    $query.= " AND $key = '$value'";
                  }
                 $query.= " GROUP BY closing_stock.stock_id ORDER BY line_no, lot  DESC";
 
                 $this->query = $query;
                 return $this->executeQuery();
                 
                 } catch (Exception $th) {
                     var_dump($th);
                 }
                 

        }
        public function readStock($type="", $filters, $proforma=0){
            $saleno = $filters['saleno'];
            $broker = $filters['broker'];
            $mark =  $filters['mark'];
            $standard = $filters['standard'];
            $gradecode = $filters['gradecode'];

            if($type=="purchases"){
                try {
                    $this->debugSql = false;
                    $query = "SELECT c.line_no, bl.`buying_list_id`, bl.`sale_no`, bl.`broker`, bl.`comment`, bl.`ware_hse`, bl.`value`, bl.`lot`, a.`mark`, bl.`grade`, bl.`invoice`,  bl.warehouse, bl.`type`, bl.`sale_price`, bl.`standard`, 
                    DATE_FORMAT(bl.`auction_date`,'%d/%m/%Y') AS import_date, bl.`allocated`, 
                    0_debtors_master.debtor_ref, a.country, bl.pkgs, bl.kgs, (CASE WHEN c.allocation IS NULL THEN CONCAT(COALESCE(0_debtors_master.short_name, ' ', c.standard)) ELSE c.allocation END) AS allocation, bl.kgs, bl.net, bl.allocation AS allocated_contract
                    FROM buying_list bl
                    INNER JOIN closing_stock c ON c.sale_no = bl.sale_no AND c.broker = bl.broker AND c.lot = bl.lot 
                    LEFT JOIN 0_debtors_master ON c.client_id = 0_debtors_master.debtor_no 
                    LEFT JOIN (SELECT mark, country FROM mark_country GROUP BY mark) AS a ON a.mark = bl.mark 
                    LEFT JOIN (SELECT code, id FROM grading_comments GROUP BY code) AS b ON b.code = bl.comment 
                    WHERE bl.sale_no NOT LIKE '%2020%' ";

                    if($saleno !== 'All'){
                        $query.= " AND bl.sale_no = '$saleno' ";
                    }
                    if($broker !== 'All'){
                        $query.= " AND bl.broker = '$broker' ";
                    }
                    if($mark !== 'All'){
                        $query.= " AND bl.mark = '$mark' ";
                    }
                    if($standard !== 'All'){
                        $query.= " AND bl.standard = '$standard' ";
                    }
                    if($gradecode !== 'All'){
                        $query.= " AND b.id = '$gradecode' ";
                    }

                    $query.= " GROUP BY bl.lot, bl.invoice, bl.broker, bl.sale_no
                    ORDER BY bl.sale_no, bl.lot ASC";
                    $this->query = $query;
                    return $this->executeQuery();
                    } catch (Exception $th) {
                    var_dump($th);
                }
                
            }else{
                try {
               $this->debugSql = false;

                $query = "SELECT line_no, shippments.confirmed, shippments.mrp_value, shippments.id AS shipped, closing_stock.`stock_id`, `sale_no`, `broker`, `comment`, `ware_hse`, `value`, `lot`, a.`mark`, 
                 `grade`, `invoice`, allocated_whse AS warehouse, `type`, `sale_price`, `standard`, DATE_FORMAT(`auction_date`,'%d/%m/%Y') AS import_date, 
                 `allocated`, `selected_for_shipment`, approval_id, 0_debtors_master.debtor_ref, a.country,  client_id, profoma_invoice_no,
                 closing_stock.pkgs, closing_stock.kgs,
                 (CASE WHEN allocation IS NULL THEN 
                    CONCAT(COALESCE(0_debtors_master.short_name, ' ', standard))
                 ELSE 
                    allocation
                 END) AS allocation, kgs,  net, allocation AS allocated_contract
                 FROM closing_stock 
                 LEFT JOIN 0_debtors_master ON closing_stock.client_id = 0_debtors_master.debtor_no
                 LEFT JOIN (SELECT mark, country FROM mark_country GROUP BY mark) AS a ON a.mark = closing_stock.mark 
                 LEFT JOIN (SELECT code, id FROM grading_comments GROUP BY code) AS b ON b.code = closing_stock.comment ";
                if($proforma == 1){
                    $query.= " LEFT JOIN shippments ON shippments.stock_id = closing_stock.stock_id ";
                }else{
                    $query.= " LEFT JOIN shippments ON shippments.stock_id = closing_stock.stock_id WHERE is_shipped = 0 OR is_shipped IS NULL ";

                }
                if($saleno !== 'All'){
                    $query.= " AND sale_no = '$saleno' ";
                }
                if($broker !== 'All'){
                    $query.= " AND broker = '$broker' ";
                }
                if($mark !== 'All'){
                    $query.= " AND mark = '$mark' ";
                }
                if($standard !== 'All'){
                    $query.= " AND standard = '$standard' ";
                }
                if($gradecode !== 'All'){
                    $query.= " AND b.id = '$gradecode' ";
                }
                if($type == "stocko"){
                    $query.= " AND is_blend_balance = 0";

                }
                if($type == "stockb"){
                    $query.= " AND is_blend_balance = 1";
                }
                if($type == "stocka"){
                    $query.= " AND shippments.id IS NOT NULL";
                }
                if($type == "stockpu"){
                    $query.= " AND shippments.id IS NULL AND paid = 1";
                }
                if($type == "stockpuu"){
                    $query.= " AND shippments.id IS NULL AND paid = 0";
                }
                $query.= " GROUP BY closing_stock.stock_id ORDER BY line_no, lot  DESC";

                $this->debugSql = false;
                $this->query = $query;
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
        public function reconciliateStock(){
            $this->query = "SELECT closing_stock.stock_id,sale_no, broker, lot, mark, invoice, allocation, shippments.pkgs_shipped, shippments.is_shipped FROM closing_stock LEFT JOIN shippments ON shippments.stock_id = closing_stock.stock_id ORDER BY `closing_stock`.`sale_no` DESC";
            return $this->executeQuery();
        }
        public function markAsShipped($stock_id){
            $query = "UPDATE shippments SET is_shipped = 1 WHERE stock_id = $stock_id";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute();
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

        public function allocateStock($stock_id, $fieldName, $fieldValue){
               $this->debugSql = true;
                $this->query = "UPDATE `closing_stock` SET $fieldName = '$fieldValue'
                WHERE `stock_id` = '$stock_id'";
                $this->executeQuery();
              
        }
        public function allocatedStock($type){
            $this->debugSql = false;
            $this->query = "SELECT line_no, shippments.id AS shipped, closing_stock.`stock_id`, `sale_no`, `broker`, `comment`, `ware_hse`, `value`, `lot`, a.`mark`, 
            `grade`, `invoice`, allocated_whse AS warehouse, `type`, `sale_price`, `standard`, DATE_FORMAT(`import_date`,'%d/%m/%Y') AS import_date, 
            `allocated`, `selected_for_shipment`, approval_id, 0_debtors_master.debtor_ref, a.country,  client_id, profoma_invoice_no,
            closing_stock.pkgs, closing_stock.kgs,
            (CASE WHEN allocation IS NULL THEN 
               CONCAT(COALESCE(0_debtors_master.short_name, ' ', standard))
            ELSE 
               allocation
            END) AS allocation, kgs,  net, allocation AS allocated_contract
            FROM closing_stock 
            LEFT JOIN 0_debtors_master ON closing_stock.client_id = 0_debtors_master.debtor_no
            LEFT JOIN (SELECT mark, country FROM mark_country GROUP BY mark) AS a ON a.mark = closing_stock.mark 
            LEFT JOIN (SELECT code, id FROM grading_comments GROUP BY code) AS b ON b.code = closing_stock.comment 
            LEFT JOIN shippments ON shippments.stock_id = closing_stock.stock_id WHERE shippments.id IS NULL ORDER BY line_no DESC";
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
            $this->query = "SELECT debtor_no, debtor_ref, short_name
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
            $this->query = "INSERT INTO `closing_stock`(`line_no`, `sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, `imported`, `imported_by`,  `is_blend_balance`, `allocated_whse`, `paid`) 
            SELECT `line_no`, `sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, $NewPkgs, `type`, `net`, `gross`, $NewKgs, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, `imported`, `imported_by`,  `is_blend_balance`, `allocated_whse`, `paid`
            FROM closing_stock WHERE stock_id = $stockId";
            $result = $this->executeQuery();
            $this->query = "UPDATE closing_stock SET pkgs = $Pkgs, kgs = $Kgs WHERE stock_id = $stockId";
            $this->executeQuery();
        }
        public function contractWiseAllocation(){
            $this->debugSql = false;
            $condition = " WHERE allocation IS NOT NULL ";
            $this->query = "SELECT stock_id, sale_no, debtor_ref, short_name, broker, mark, grade, sale_price, lot, net, invoice,
            comment, standard, pkgs, kgs, 0_debtors_master.short_name, allocation
            FROM closing_stock b
            LEFT JOIN 0_debtors_master  ON 0_debtors_master.debtor_no = b.client_id"
            .$condition. "
            ORDER BY allocation ASC";
            return $this->executeQuery();
        }

        public function stockGrid($dataList){
            $output = "";
            $subTotal = 0;
            if(count($dataList)>0){
				$output .= '<table id="closingstocks" class="display table table-sm  table-striped table-responsive table-bordered" style="width:100%">
				<thead class="thead-dark">
				<tr>
					<th>Line No</th>
					<th>Sale No</th>
					<th>DD/MM/YY</th>
					<th>Broker</th>
					<th>Warehouse</th>
					<th>Lot</th>
					<th>Origin</th>
					<th>Mark</th>
					<th>Grade</th>
					<th>Invoice</th>
					<th>Pkgs</th>
					<th>Net</th>
					<th>Kgs</th>
					<th>Hammer Price</th>
					<th>Value Ex.Auction</th>
                    <th>Value Inclusive <br> of brokerage fee(0.5%)</th>
					<th>Code</th>
					<th>WHSE</th>
					<th>Allocation</th>
		
				</tr>
			</thead>
				<tbody>';
					
					foreach ($dataList as $stock){ 
						$net = $stock['kgs'];
						$hammerPrice = round(floatval($stock['sale_price']), 2);
						$valueExAuct = round($net * $hammerPrice, 2);
                        $brokerage = round(($valueExAuct) * (0.005), 2);
                        $finalPrompt = round($brokerage + $valueExAuct, 2);
                        $subTotal += $finalPrompt;

						$output.='<td>'.$stock['line_no'].'</td>';
						$output.='<td>'.$stock['sale_no'].'</td>';
						$output.='<td>'.$stock['import_date'].'</td>';
						$output.='<td>'.$stock['broker'].'</td>';
						$output.='<td>'.$stock['ware_hse'].'</td>';
						$output.='<td>'.$stock['lot'].'</td>';
						$output.='<td>'.$stock['country'].'</td>';
						$output.='<td>'.$stock['mark'].'</td>';
						$output.='<td>'.$stock['grade'].'</td>';
						$output.='<td>'.$stock['invoice'].'</td>';
						$output.='<td>'.$stock['pkgs'].'</td>'; //pkgs
						$output.='<td>'.$stock['net'].'</td>'; //net
						$output.='<td>'.$stock['kgs'].'</td>'; //kgs
						$output.='<td>'.$hammerPrice.'</td>';
						$output.='<td>'.floatval($valueExAuct).'</td>';
                        $output.='<td>'.floatval($finalPrompt).'</td>';
						$output.='<td>'.$stock['comment'].'</td>';
						$output.='<td>'.$stock['warehouse'].'</td>';
						$output.='<td>'.$stock['allocation'].'</td>';
		
						$output.='</tr>';
				
					}           
		$output.= '</tbody>';
		$output.='<tfoot style="outline: thin solid black;">
							<tr>
								<th colspan="4">Sub Total <br> Grand Total</th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th colspan="2"></th>
								<th colspan="2"></th>
								<th></th>
								<th></th>
                                <th></th>
								<th></th>
								<th></th>

							</tr>
				</tfoot>
		</table>';
			}else{
				$output = "No records Found";
		
			}
		
			echo $output;

        }
   
    }

?>

