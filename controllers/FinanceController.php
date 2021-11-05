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

            $this->query = "INSERT INTO `auction_activities`(`activity_id`, `auction_no`,  `details`) 
            SELECT 5, '$saleno', details
            FROM activities WHERE id = 5";
            $this->executeQuery();
        }
        public function updateField($lotId, $fieldId, $value, $saleno){
            $this->query = "UPDATE buying_list SET $fieldId = '$value'
            WHERE lot = '$lotId' AND sale_no LIKE '%$saleno%'";
            $this->debugSql = true;
            return $this->executeQuery();

        }
        public function confirmedPurchaseList($type=null){
            $this->debugSql = false;
            $query = "SELECT `line_no`,`buying_list_id`, `sale_no`, `broker`, `category`, `comment`, `ware_hse`, 
            `entry_no`, `value`, `lot`, `company`, buying_list.`mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`,
             `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, 
             `imported`, `imported_by`, `allocated`, `added_to_plist`, `grading_comment`, `max_bp`, `target`, 
             mark_country.country AS origin, `broker_invoice`, DATE_FORMAT(`auction_date`, '%d/%m/%Y') AS auction_date, added_to_stock
            FROM `buying_list` 
            LEFT JOIN mark_country ON mark_country.mark = buying_list.mark
            WHERE  buyer_package='CSS' AND sale_no LIKE '%".$this->saleno."%' AND confirmed = 1 ";
            if($type !=null){
                if($type=='P'){
                    $query.=" AND source = 'P'";
                }elseif($type=='A'){
                    $query.=" AND source = 'A'";

                }
            }
            $query.="GROUP BY lot, broker, invoice, pkgs
            ORDER BY line_no DESC";
            $this->query = $query;
            
            return $this->executeQuery();
        }
        public function postToStock($saleno, $buying_list_id){
            $this->debugSql = false;
            
            $lineno = $this->genLineNo($buying_list_id);
            $this->query = "UPDATE buying_list SET line_no = '$lineno' WHERE buying_list_id = $buying_list_id";
            $this->executeQuery();

            $this->query = "INSERT INTO `closing_stock`(`line_no`,`sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, 
            `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`,  `kgs`,
             `sale_price`, `standard`, `buyer_package`, `import_date`)
             SELECT `line_no`, `sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`,
            `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `kgs`, `net`, 
            sale_price/100, `standard`, `buyer_package`, buying_list.auction_date
            FROM `buying_list`
            WHERE buying_list_id = $buying_list_id";

            $this->executeQuery();
            $this->debugSql = false;

            $this->query = "UPDATE auction_activities SET completed = 1 WHERE activity_id = 5 AND auction_no = '$saleno'";
            $this->executeQuery();

            $this->query = "UPDATE buying_list SET added_to_stock = 1 WHERE buying_list_id = $buying_list_id";
            $this->executeQuery();

            $this->debugSql = false;

            $this->query = "INSERT INTO `auction_activities`(`activity_id`, `auction_no`,  `details`) 
            SELECT 6, '$saleno', activities.details
            FROM activities 
            LEFT JOIN auction_activities ON auction_activities.activity_id = activities.id
            WHERE activities.id = 6  AND activity_id != 6";
            $this->executeQuery();
        }
        public function saveInvoice($buyer, $consignee, $invoice_no,
        $invoice_type, $invoice_category, 
        $port_of_delivery, $buyer_bank, 
        $payment_terms, $pay_bank, 
        $pay_details,
        $container_no,
        $buyer_contract_no,
        $shipping_marks,
        $other_reference,
        $port_of_discharge,
        $description_of_goods,
        $final_destination,
        $hs_code,
        $buyer_address,
        $bl_no,
        $bank_id

        ){
                $type = 'profoma';
                try {
                $this->conn->beginTransaction();
                $query = "REPLACE INTO `tea_invoices`(`buyer`, `consignee`, `invoice_no`, `invoice_type`, `invoice_category`, `port_of_discharge`, 
                `buyer_bank`, `payment_terms`, `pay_bank`, `pay_details`, `date_captured`, `port_of_delivery`, `other_references`, 
                `container_no`, `buyer_contract_no`, `shipping_marks`, `good_description`, `final_destination`, `hs_code`, `buyer_address`, `bl_no`, `bank_id`) 
                VALUES(?,?,?,?,?,?,?,?,?,?,CURRENT_DATE,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(1, $buyer);
                $stmt->bindParam(2, $consignee);
                $stmt->bindParam(3, $invoice_no);
                $stmt->bindParam(4, $type);
                $stmt->bindParam(5, $invoice_category);
                $stmt->bindParam(6, $port_of_delivery);
                $stmt->bindParam(7, $buyer_bank);
                $stmt->bindParam(8, $payment_terms);
                $stmt->bindParam(9, $pay_bank);
                $stmt->bindParam(10, $pay_details);
                $stmt->bindParam(11, $final_destination);
                $stmt->bindParam(12, $other_reference);
                $stmt->bindParam(13, $container_no);
                $stmt->bindParam(14, $buyer_contract_no);
                $stmt->bindParam(15, $shipping_marks);
                $stmt->bindParam(16, $description_of_goods);
                $stmt->bindParam(17, $final_destination);
                $stmt->bindParam(18, $hs_code);
                $stmt->bindParam(19, $buyer_address);
                $stmt->bindParam(20, $bl_no);
                $stmt->bindParam(21, $bank_id);

           

                $stmt->execute();
                $this->conn->commit();
                } catch (Exception $ex) {
                    var_dump($ex);
                }
                

                // $this->query = "SELECT invoice_no FROM tea_invoices WHERE invoice_no = '$invoice_no'";
                // $results = $this->executeQuery();
    
                // if(count($results)==0){
                //     $error = "invoice no $invoice_no Failed to save successfully contact support";
                //     $response["error"] = $error;
                //     $response["code"] = 201;
    
                // }else{
                //     $success = "Invoice no $invoice_no has been created succesfully, click the + button to add teas to this Invoice no";
                //     $response["success"] = $success;
                //     $response["code"] = 200;
    
                // }
                $success = "Invoice no $invoice_no has been created succesfully, click the + button to add teas to this Invoice no $hs_code";
                $response["success"] = $success;
                $response["code"] = 200;
            
            return $response;
    
        }
        public function unconfirmedSales(){
            $this->debugSql = false;
            $this->query = "SELECT closing_cat.sale_no, count(lot) AS totalLots, sum(pkgs) AS totalPkgs, sum(net) AS totalKgs
            FROM closing_cat
            INNER JOIN auction_activities ON auction_activities.auction_no = closing_cat.sale_no
            WHERE activity_id = 4 AND buyer_package = 'CSS' AND closing_cat.confirmed = 0
            GROUP BY sale_no";
            return $this->executeQuery();
        }
        public function invoiceTemplate(){
            $this->debugSql = false;

            $this->query = "SELECT * FROM tea_invoices";
            return $this->executeQuery();

        }
        public function fetchInvoices($type, $invoiceno){
            if($invoiceno ==''){
                $this->debugSql = false;
                $this->query = "SELECT *
                FROM tea_invoices 
                LEFT JOIN 0_debtors_master ON tea_invoices.buyer = 0_debtors_master.debtor_no 
                WHERE invoice_type = '$type'";
                return $this->executeQuery();
            }else{
                $this->debugSql = false;

                $this->query = "SELECT *
                FROM tea_invoices 
                LEFT JOIN 0_debtors_master ON tea_invoices.buyer = 0_debtors_master.debtor_no 
                WHERE id = $invoiceno";
                return $this->executeQuery();
            }
            // $this->debugSql = "true";
       
        }
        public function paymentTerms(){
            $this->query = "SELECT * FROM `0_payment_terms`";
            return $this->executeQuery();
        }
        public function fetchErpClients(){
            $this->query = "SELECT * FROM `0_debtors_master` WHERE tea_buyer=1";
            return $this->executeQuery();
        }
        public function fetchErpBanks(){
            $this->debugSql = false;
            $this->query = "SELECT * FROM `0_bank_accounts` WHERE inactive = 0";
            return $this->executeQuery();
        }
        public function getInvoiceNo($id){
            $this->debugSql = false;
            $this->query = "SELECT `invoice_no` FROM `tea_invoices` WHERE id = $id";
            $results = $this->executeQuery();
            return $results[0]['invoice_no'];
        }
        public function invoiceTea($stockid, $invoiceno, $user){
            $this->debugSql = true;
            $this->conn->beginTransaction();
            $this->query = "INSERT INTO `invoice_teas`(`invoice_no`, `stock_id`, `profoma_amount`, `time_stamp`, `created_by`) 
            SELECT '$invoiceno',$stockid,sale_price,CURRENT_TIMESTAMP, $user
            FROM closing_stock
            WHERE stock_id = $stockid";
            $this->executeQuery();

            $this->query = "UPDATE closing_stock SET profoma_invoice_no = '$invoiceno' WHERE stock_id = $stockid";
            $this->executeQuery();
            if($this->success>1){
                $this->conn->commit();
            }
        }
        public function removeInvoiceTea($stockid){
            $this->debugSql = true;
            $this->query = "DELETE FROM ";
            $this->query = "UPDATE closing_stock SET profoma_invoice_no = NULL WHERE stock_id = $stockid";
            $this->executeQuery();
        }
        public function genLineNo($buying_list_id){
            $this->debugSql = true;
            $this->query = "SELECT MAX(SUBSTRING(line_no, -7)) AS line_no FROM closing_stock";
            $rows = $this->executeQuery();
            $id = ((int)$rows[0]['line_no'])+1;

            $this->query = "SELECT DATE_FORMAT(CURRENT_DATE, '%y') AS date_part, SUBSTRING(sale_no, 6, 2) AS week_part, source, LPAD($id, 10, '0') AS id_part
            FROM buying_list WHERE buying_list_id = $buying_list_id";
            $row = $this->executeQuery();
            if(sizeOf($row)>0){
                if(($row[0]['date_part'] != null) && ($row[0]['week_part'] != null) && ($row[0]['source'] != null) && ($row[0]['id_part'] != null)){
                    $lineno = $row[0]['date_part'].$row[0]['week_part'].$row[0]['source'].$row[0]['id_part']; 
                }
            }else{
                $lineno = -1;
            }

            return $lineno;

        }
        public function numberTowords($num){

            $ones = array(
            0 =>"ZERO",
            1 => "ONE",
            2 => "TWO",
            3 => "THREE",
            4 => "FOUR",
            5 => "FIVE",
            6 => "SIX",
            7 => "SEVEN",
            8 => "EIGHT",
            9 => "NINE",
            10 => "TEN",
            11 => "ELEVEN",
            12 => "TWELVE",
            13 => "THIRTEEN",
            14 => "FOURTEEN",
            15 => "FIFTEEN",
            16 => "SIXTEEN",
            17 => "SEVENTEEN",
            18 => "EIGHTEEN",
            19 => "NINETEEN",
            "014" => "FOURTEEN"
            );
            $tens = array( 
            0 => "ZERO",
            1 => "TEN",
            2 => "TWENTY",
            3 => "THIRTY", 
            4 => "FORTY", 
            5 => "FIFTY", 
            6 => "SIXTY", 
            7 => "SEVENTY", 
            8 => "EIGHTY", 
            9 => "NINETY" 
            ); 
            $hundreds = array( 
            "HUNDRED", 
            "THOUSAND", 
            "MILLION", 
            "BILLION", 
            "TRILLION", 
            "QUARDRILLION" 
            ); /*limit t quadrillion */
            $num = number_format($num,2,".",","); 
            $num_arr = explode(".",$num); 
            $wholenum = $num_arr[0]; 
            $decnum = $num_arr[1]; 
            $whole_arr = array_reverse(explode(",",$wholenum)); 
            krsort($whole_arr,1); 
            $rettxt = ""; 
            foreach($whole_arr as $key => $i){    
            while(substr($i,0,1)=="0")
                    $i=substr($i,1,5);
                        if($i < 20){ 
                            /* echo "getting:".$i; */
                            $rettxt .= $ones[$i]; 
                            }elseif($i < 100){ 
                            if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
                            if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
                            }else{ 
                            if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
                            if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
                            if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
                            } 
                            if($key > 0){ 
                            $rettxt .= " ".$hundreds[$key]." "; 
                            }
                        } 
                        if($decnum > 0){
                            $rettxt .= " and ";
                            if($decnum < 20){
                            $rettxt .= $ones[$decnum];
                            }elseif($decnum < 100){
                            $rettxt .= $tens[substr($decnum,0,1)];
                            $rettxt .= " ".$ones[substr($decnum,1,1)];
                            }
                        }
            return $rettxt;
        }
        public function loadTeaInvoices($invoice_no){
            $this->debugSql = false;
            $this->query = "SELECT line_no, invoice_teas.id, invoice_teas.stock_id, sale_no, broker, closing_stock.mark, lot, grade, invoice, pkgs, net,
            kgs, invoice_teas.profoma_amount,  mark_country.country
            FROM invoice_teas
            INNER JOIN closing_stock ON closing_stock.stock_id = invoice_teas.stock_id
            LEFT JOIN mark_country ON  mark_country.mark = closing_stock.mark
            WHERE invoice_no = '$invoice_no'
            GROUP BY stock_id";
            return $this->executeQuery();
            
        }
        public function loadBlendTeaInvoices($invoice_no){
            $this->debugSql = false;
            $this->query = "SELECT *
            FROM blend_invoice_line_no
            WHERE invoice_no = '$invoice_no'";
            return $this->executeQuery();
            
        }
        public function addRecord($invoice_no){
            try {
               $this->debugSql = true;
               $this->query = "INSERT INTO `blend_invoice_line_no`(`invoice_no`) VALUES('$invoice_no')";
               $this->executeQuery();
            } catch (\Throwable $th) {
               throw $th;
            }
         
            return json_encode(array("added"=>"true"));
         
         }
         public function updateValue($id, $fieldValue, $fieldName){
            try {
                $this->debugSql = true;

                $this->query = "UPDATE blend_invoice_line_no SET $fieldName = '$fieldValue' WHERE id = $id";
                $this->executeQuery();
            } catch (\Throwable $th) {
               //throw $th;
            }
            return json_encode(array("updated"=>"true"));
        }
        public function removeRecord($id){
            try {
               $this->debugSql = true;
               $this->query = "DELETE FROM `blend_invoice_line_no` WHERE id= $id";
               $this->executeQuery();
            } catch (\Throwable $th) {
               throw $th;
            }
         
            return json_encode(array("added"=>"true"));
         
         }

        

   
    }
    
    

?>

