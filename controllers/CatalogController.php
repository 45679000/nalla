<?php 
    $path_to_root = '../../';

    Class Catalogue extends Model{
        public $inputFileName;
        public $is_imported = false;
        public $is_split;
        public $saleno;
        public $broker;
        public $user_id;

        public function importClosingCatalogue(){
            
            // $inputFileName = 'ANJL_SPLIT_CLOSING_SALE_12.2021.xls';
            //  Read your Excel workbook
            try {
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($this->inputFileName);

                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($this->inputFileName);
                if($this->is_split == "true"){
                    $this->readRecords($this->conn,$spreadsheet, 2, 5);
                    $this->readRecords($this->conn,$spreadsheet, 3, 5);
                    $this->readRecords($this->conn,$spreadsheet, 4, 5);
                }else{
                    $this->readRecords($this->conn,$spreadsheet, 3, 5);
                    $this->readRecords($this->conn,$spreadsheet, 4, 5);
                    $this->readRecords($this->conn,$spreadsheet, 5, 5);

                }
               
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($this->inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
            
        }
        public function ittsCatalogueImport($action="display"){
            try {
                if($action=="insert"){
                    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($this->inputFileName);
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                    $reader->setReadDataOnly(true);
                    $spreadsheet = $reader->load($this->inputFileName);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $highestRow = $worksheet->getHighestRow(); // e.g. 10
                    $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
                    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
                    $excelData = $worksheet->toArray();

                    $sql = "INSERT INTO `itts_import`(`Sno`,`producer`, `mark`, `warehouse`, `Lot_no`, `grade`, `invoice_no`, `packages`, `packaging_type`, `net`, `gross`, `price`, `broker_starting_price`, `sale_price`, `buyer`, `Warehouse_location`, `broker`, `dispatch_date`, `receive_date`, `total_tare`, `current_qty`, `current_packages`, `goods_condition`, `warrant_no`, `weight_note_number`, `auction_number`, `auction_date`) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $stmt = $this->conn->prepare($sql);
                    foreach($excelData as $data){
                        for($i=0; $i<27; $i++){
                            $stmt->bindParam($i+1, $data[$i]);
                        }
                        $stmt->execute();
                    }   
                }else if($action=="display"){
                    $rows = $this->conn->query("SELECT * FROM `itts_import`")->fetchAll();
                    return $rows;
                }else if($action=="confirm"){
                            $sql = "UPDATE
                            `closing_cat` AS `dest`,
                            (
                                SELECT
                                    *
                                FROM
                                    `itts_import`
                            ) AS `src`
                        SET
                            `dest`.`pkgs` = `src`.`current_packages`,
                            `dest`.`net` = `src`.`net`,
                            `dest`.`gross` = `src`.`gross`,
                            `dest`.`sale_price` = `src`.`sale_price`
                        WHERE
                            `dest`.`lot` = src.lot_no";
                        
                        $stmt = $this->conn->prepare($sql);
                        $stmt->execute();
                        $sql = "DELETE FROM itts_import";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->execute();
                }else if($action=="cancel"){
                    $sql = "DELETE FROM itts_import";
                    $stmt = $this->conn->prepare($sql);
                }
            }catch(Exception $e){
                    var_dump($e);
                
            
            }

        }
        public function readRecords($pdo, $spreadsheet, $activesheet, $dataStartRow){
            $spreadsheet->setActiveSheetIndex($activesheet);
            $sheet = $spreadsheet->getActiveSheet(); 

            $sheetType = 'Sec';

            if(($activesheet==2 || $activesheet ==3) && $this->is_split == "true"){
                $sheetType = 'Main';
            }
            if(($activesheet==3 || $activesheet ==4) && $this->is_split == "false"){
                $sheetType = 'Main';
            }
        
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();
            $sql = "INSERT INTO `closing_cat_import`(`comment`,  `ware_hse`, `entry_no`, `value`,  `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `buyer_package`, `sale_no`, `broker`, `imported_by`, `category`)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, ?);";
            $excelData = $this->excelToAssociativeArray(3, $spreadsheet, $activesheet);
            $buyer = trim($spreadsheet->getActiveSheet()->getCell('V3'));
            $salePrice = trim($spreadsheet->getActiveSheet()->getCell('U3'));
           
            try {
                $stmt = $pdo->prepare($sql);
                foreach($excelData as $data){
                    $buyerPackage = trim($data[$buyer]);
                    $saleprice = trim($data["Sale Price"]);
                    $stmt->bindParam(1, $data["Comment"]);
                    $stmt->bindParam(2, $data["Ware Hse"]);
                    $stmt->bindParam(3, $data["Entry No"]);
                    $stmt->bindParam(4, $data["Value"]);
                    $stmt->bindParam(5, $data["Lot"]);
                    $stmt->bindParam(6, $data["Company"]);
                    $stmt->bindParam(7, $data["Mark"]);
                    $stmt->bindParam(8, $data["Grade"]);
                    $stmt->bindParam(9, $data["Manf Date"]);
                    $stmt->bindParam(10, $data["RA"]);
                    $stmt->bindParam(11, $data["RP"]);
                    $stmt->bindParam(12, $data["Invoice"]);
                    $stmt->bindParam(13, $data["Pkgs"]);
                    $stmt->bindParam(14, $data["Type"]);
                    $stmt->bindParam(15, $data["Net"]);
                    $stmt->bindParam(16, $data["Gross"]);
                    $stmt->bindParam(17, $data["Kgs"]);
                    $stmt->bindParam(18, $data["Tare"]);
                    $stmt->bindParam(19, $saleprice);
                    $stmt->bindValue(20, $buyerPackage);
                    $stmt->bindParam(21, $this->saleno);
                    $stmt->bindParam(22, $this->broker);
                    $stmt->bindParam(23, $this->user_id);
                    $stmt->bindParam(24, $sheetType);

                    $stmt->execute();
                }
            } catch (Exception $ex) {
                var_dump($ex);
            }
            $this->is_imported = true;
        
        }
       
        public function updateSale(){
            echo "Sale number". $this->broker;
            $query = "UPDATE `closing_cat_import` SET `sale_no`= ? , `broker`= ? WHERE 1";
            try {
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(1, $this->saleno);
                $stmt->bindParam(2, $this->broker);
                $stmt->execute();
            } catch (Exception $ex) {
                var_dump($ex);
            }
          
        }
        public function readImportSummaries(){
            $rows = $this->conn->query("SELECT * FROM `closing_cat_import` WHERE lot REGEXP '^[0-9]+$'")->fetchAll();
            return $rows;
        }
        public function summaryTotal($column, $type){
            $query = "SELECT SUM(".$column.") AS total FROM `closing_cat_import` WHERE lot REGEXP '^[0-9]+$'";
            if($type=='main'){
                $query.= "AND category = 'Main'";
            }else{
                $query.= "AND category = 'Sec'";
            }
            $row=$this->conn->query($query)->fetch();
            return $row;
        }
        public function summaryCount($column, $type){
            $query = "SELECT COUNT(".$column.") AS count FROM `closing_cat_import` WHERE lot REGEXP '^[0-9]+$'";
            if($type=='main'){
                $query.= "AND category = 'Main'";
            }else{
                $query.= "AND category = 'Sec'";
            }
            $row=$this->conn->query($query)->fetch();
            return $row;
        }
        public function confirmCatalogue(){
            $confirmed = false;
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            try {
                $stmt = $this->conn->prepare("REPLACE INTO `closing_cat`(`closing_cat_import_id`, `sale_no`, `broker`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `buyer_package`, `category`, `import_date`, `imported`, `imported_by`, `line_id`)
                                          SELECT `closing_cat_import_id`, `sale_no`, `broker`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `buyer_package`, `category`,`import_date`, `imported`, `imported_by`, md5(CONCAT(trim(broker), trim(sale_no), trim(lot)))
                                          FROM closing_cat_import
                                          WHERE lot REGEXP '^[0-9]+$' AND lot IS NOT NULL"
                                        );
             $stmt->execute();
             $stmt2 = $this->conn->prepare("DELETE FROM closing_cat_import WHERE 1");
             $stmt2->execute();
             $confirmed = true;
             $this->addActivity(1, $this->saleno, $this->user_id);
             return $confirmed;
            } catch (Exception $ex) {
                var_dump($ex);
            }
            
        }
        public function clearImport(){
            $confirmed = false;
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            try {
             $stmt2 = $this->conn->prepare("DELETE FROM closing_cat_import WHERE 1");
             $stmt2->execute();
             $confirmed = true;
             return $confirmed;
            } catch (Exception $ex) {
                var_dump($ex);
            }
            
        }

        public function excelToAssociativeArray($headerRow, $spreadsheet, $activesheet) {
            $spreadsheet->setActiveSheetIndex($activesheet);
            $sheet = $spreadsheet->getActiveSheet(); 
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();
            $title = call_user_func_array('array_merge', $sheet->rangeToArray('A' . $headerRow . ':' . $highestColumn . $headerRow, NULL,TRUE, FALSE));
            
            $arr = array();
            for ($row = 4; $row <= $highestRow; $row++){ 
                $rowData = call_user_func_array('array_merge',$sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL,TRUE, FALSE));
                    $table = array();
                    for($i = 0; $i<22; $i++){
                        if((trim($title[$i])=="Lot") && $this->stringCount($title[$i])>7){
                            break;
                        }else{
                            $table[trim($title[$i])] = $rowData[$i];
                            if(sizeof($table)>6){
                                $arr[$row] = $table;
                            }
                        }
                    }
            }
            return $arr;
        }
        public function stringCount($str){
            return preg_match_all( "/[0-9]/", $str );
        }
        public function addLot($data, $tablename){
            $this->data = $data;
            $this->tablename = $tablename;
            $id = $this->insertQuery();
            return $this->selectOne($id, "closing_cat_import_id");
        }
        public function closingCatalogue($auction = "", $broker = "", $category = ""){
                if($category =="All"){
                    $this->query = "SELECT * FROM closing_cat LEFT JOIN brokers ON brokers.code = closing_cat.broker WHERE sale_no = "."'".$auction. "'". " AND broker = "."'".$broker. "'";
                    return $this->executeQuery();
                }else if($category =="leaf"){
                    $this->query = "SELECT * FROM closing_cat LEFT JOIN brokers ON brokers.code = closing_cat.broker WHERE  sale_no = "."'".$auction. "'". " AND broker = "."'".$broker. "' AND grade IN ('BP1','PF1')";
                    return $this->executeQuery();
                }else if($category=="dust"){
                        $this->query = "SELECT * FROM closing_cat LEFT JOIN brokers ON brokers.code = closing_cat.broker WHERE  sale_no = "."'".$auction. "'". " AND broker = "."'".$broker. "' AND grade IN ('PD','D1')";
                        return $this->executeQuery(); 
                }else{
                    $this->query = "SELECT * FROM closing_cat LEFT JOIN brokers ON brokers.code = closing_cat.broker WHERE sale_no = "."'".$auction. "'". " AND broker = "."'".$broker. "'"." AND category =  "."'".$category ."' ";
                    return $this->executeQuery();
                }
        }
        public function postCatalogueProcess($saleno, $user_id){
            $processed = false;
            try {
                $this->query = "UPDATE closing_cat a
                INNER JOIN  (
                    SELECT md5(CONCAT(trim(b.broker), trim(b.sale_no), trim(b.lot))), AS line_id, value, buyer_package
                    FROM closing_cat_import) b ON  a.line_id = b.line_id          
                SET a.sale_price = b.sale_price, 
                    a.buyer_package = b.buyer_package
                WHERE b.sale_price IS NOT NULL";
                $this->executeQuery();  

                $this->query = "DELETE FROM closing_cat_import WHERE 1";

                $this->executeQuery();

                $processed = true;
                if($saleno == NULL){
                    $saleno = $this->getMaxSaleNo();
                }
                $this->addActivity(3, $saleno, $user_id);
                $this->addActivity(4, $saleno, $user_id);

             return $processed;
            } catch (Exception $ex) {
                var_dump($ex);
            }
            
        }
        public function importValuationCatalogue($saleno, $user_id){
            $processed = false;
            try {
                $this->debugSql = true;
                $this->query = "UPDATE closing_cat a
                INNER JOIN closing_cat_import b ON md5(CONCAT(trim(b.broker), trim(b.sale_no), trim(b.lot))) = a.line_id               
                SET a.value = b.value
                WHERE b.value IS NOT NULL";
                $this->executeQuery();
               
                $this->query = "DELETE FROM closing_cat_import WHERE 1";
                $this->executeQuery();

                $processed = true;
                if($saleno == NULL){
                    $saleno = $this->getMaxSaleNo();
                }
                $this->addActivity(2, $saleno, $user_id);

             return $processed;
            } catch (Exception $ex) {
                var_dump($ex);
            }
            
        }
        public function removeCatalogue($auction = ""){
            $this->query = "DELETE FROM closing_cat WHERE sale_no = "."'".$auction. "'";
            return $this->executeQuery();
        }
        public function maxLow($garden, $grade, $auction){
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $month_id=explode('-',$auction,2)[1]-1;
            $year=explode('-',$auction,2)[0];
            $previousAuction = $year."-".$month_id;
                try {
                    $this->query = "SELECT  max(value) AS max FROM closing_cat WHERE mark = "."'".$garden. "'". " AND grade = "."'".$grade. "'"." AND sale_no =  '".$previousAuction."'";
                    $max = $this->executeQuery();
                    $this->query = "SELECT  min(value) AS min FROM closing_cat WHERE mark = "."'".$garden. "'". " AND grade = "."'".$grade. "'"." AND sale_no =  '".$previousAuction."'";
                    $min = $this->executeQuery();
                    
                    return array_merge(array_merge($min, $max));
                } catch (Exception $ex) {
                    var_dump($ex);       
                 }
            
        
        }

        public function privatePurchases(){
            try {
                $this->query = "SELECT * FROM closing_cat WHERE sale_no like '%P%'";
                return $this->executeQuery();
            } catch (EXCEPTION $ex) {
                var_dump($ex);
            }

        }
        public function addParking($data, $tablename){
            $this->data = $data;
            $this->tablename = $tablename;
            $id = $this->insertQuery();
            return $this->selectOne($id, "id");
        }

        public function stockList(){
            try {
                $this->query = "SELECT * FROM `closing_cat` WHERE allocated = 1";
                return $this->executeQuery();
            } catch (EXCEPTION $ex) {
                var_dump($ex);
            }

        }
        public  function ExcelToPHP($dateValue = 0) {
            $UNIX_DATE = ($dateValue - 25569) * 86400;
            return gmdate("d-m-Y", $UNIX_DATE);        
         }
        public function catalogueDate($auctionid) {
                try {
                    $this->query = "SELECT import_date FROM `closing_cat`";
                    return $this->executeQuery();
                } catch (EXCEPTION $ex) {
                    var_dump($ex);
                }
        }
        public function PrintBrokers(){
            try {
                $this->query = "SELECT * FROM `brokers` WHERE deleted = 0";
                return $this->executeQuery();
            } catch (EXCEPTION $ex) {
                var_dump($ex);
            }
        }
        public function PrintGardens(){
            try {
                $this->query = "SELECT * FROM `mark_country` WHERE deleted = 0";
                return $this->executeQuery();
            } catch (EXCEPTION $ex) {
                var_dump($ex);
            }
        }
        public function PrintGrades(){
            try {
                $this->query = "SELECT * FROM `grades` WHERE deleted = 0";
                return $this->executeQuery();
            } catch (EXCEPTION $ex) {
                var_dump($ex);
            }
        }
        public function totalRowCount($tableName){
			$this->query= "SELECT * FROM $tableName"; 
			$stmt = $this->execute(); 
			$row_count = $stmt->rowCount();
			return $row_count;
		}
        public function PrintStandard(){
            try {
                $this->query = "SELECT * FROM `grading_standard` WHERE deleted = 0";
                return $this->executeQuery();
            } catch (EXCEPTION $ex) {
                var_dump($ex);
            }
        }
        public function PrintGradingCodes(){
            try {
                $this->query = "SELECT * FROM `grading_comments` WHERE deleted = 0";
                return $this->executeQuery();
            } catch (EXCEPTION $ex) {
                var_dump($ex);
            }
        }
        public function PrintLots($id){
            if($id>0){
                try {
                    $this->query = "SELECT * FROM `closing_stock` WHERE stock_id = ".$id;
                    return $this->executeQuery();
                } catch (EXCEPTION $ex) {
                    var_dump($ex);
                }
            }else{
                try {
                    $this->query = "SELECT * FROM `closing_stock`";
                    return $this->executeQuery();
                } catch (EXCEPTION $ex) {
                    var_dump($ex);
                }
            }
            
        }
        public function update($tableName, $value, $id, $columnName){
            $updated = 0;
            try{
                $this->query = "UPDATE $tableName  SET $columnName = '$value' WHERE `stock_id` = $id"; 
                if($this->executeQuery()){
                    $updated = 1;
                }
            }catch(Exception $ex){
                return $ex;
            }
            return $updated;

        }

        public function insertRemarks($remark, $lot){
            $updated = "0";
            try{
                $this->query = "UPDATE closing_cat  SET grading_comment = '$remark' WHERE `lot` = '$lot'";
                $this->executeQuery();
                $this->query = "INSERT INTO grading_remarks(remark) VALUE('$remark')";
                $this->executeQuery();
                
            }catch(Exception $ex){
                return $ex;
            }
            return $updated;

        }
        public function loadRemarks(){
            try{
                $this->query = "SELECT DISTINCT remark FROM grading_remarks";
                $remarks = $this->executeQuery();
                return $remarks;
                
            }catch(Exception $ex){
                return $ex;
            }

        }
        public function clearOffers(){
            try{
                $this->query = "UPDATE closing_cat SET allocated = 0 WHERE allocated = 1";
                $this->executeQuery();
                
            }catch(Exception $ex){
                return $ex;
            }

        }
        public function buyingSummary($saleno){
        
            try{
                $maxSale = $this->getMaxSaleNo();
                if($saleno !=''){
                    $maxSale = $saleno;
                }
                $this->query = "SELECT broker, '$maxSale' AS sale_no, count(lot) AS totalLots, SUM(pkgs) AS totalPkgs, SUM(kgs) AS totalKgs
                FROM closing_cat WHERE sale_no = '$maxSale'
                GROUP BY broker;";
                return $this->executeQuery();
                
            }catch(Exception $ex){
                return $ex;
            }

        }
        public function auctionList(){
            for($i = 0; $i<53; $i++){
                $auction_id = date("Y").'-'.str_pad($i, 2, '0', STR_PAD_LEFT);
                $auctions[$auction_id] = $auction_id;
            }
            return $auctions;
        }
        public function getMaxSaleNo(){
            $this->query = "SELECT MAX(sale_no) AS max_sale
            FROM closing_cat WHERE confirmed = 0 AND buyer_package = 'CSS'";
            $this->debugSql = false;
            $sales = $this->executeQuery();
            return $sales[0]["max_sale"];
        }
        public function postBuyingList($saleno){
            $this->query = "INSERT INTO `auction_activities`(`activity_id`, `auction_no`,  `details`) 
            SELECT 4, '$saleno', details
            FROM activities WHERE id = 4";
            $this->executeQuery();
        }
        public function addActivity($activity, $saleno, $userid){
            if($saleno==""){
                $saleno = $this->saleno;
            }
            $this->query = "SELECT id 
            FROM `auction_activities` 
            WHERE activity_id = $activity AND `auction_no` = '$saleno'";
            $result = $this->executeQuery();

            if(sizeOf($result)==0){
                $this->query = "INSERT INTO `auction_activities`(`activity_id`, `auction_no`,  `details`, `user_id`, completed, emailed) 
                SELECT $activity, '$saleno', details, $userid, 1, 1
                FROM activities WHERE id = $activity";
                $this->executeQuery();
            }
        }



  
}
