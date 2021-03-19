<?php 
    $path_to_root = '../../';

    Class Catalogue extends Model{
        public $inputFileName;
        public $is_imported = false;
        public $saleno;
        public $broker;

        public function importClosingCatalogue(){
            $inputFileName = 'ANJL_SPLIT_CLOSING_SALE_12.2021.xls';
            //  Read your Excel workbook
            try {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($this->inputFileName);
                $this->readRecords($this->conn,$spreadsheet, 2);
                $this->readRecords($this->conn,$spreadsheet, 3);
                $this->readRecords($this->conn,$spreadsheet, 4);
                
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
        }
        public function readRecords($pdo, $spreadsheet, $activesheet){
            $spreadsheet->setActiveSheetIndex($activesheet);
            $sheet = $spreadsheet->getActiveSheet(); 
        
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();
        
            $sql = "INSERT INTO `closing_cat_import`(`comment`, `empty_col1`, `ware_hse`, `entry_no`, `value`, `empty_col2`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `buyer_package`)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
            for ($row = 5; $row <= $highestRow; $row++){ 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL,TRUE, FALSE);
                   try {
                    $stmt = $pdo->prepare($sql);
                    $parmid = 1;
        
                    for($i = 0; $i<22; $i++){
                        $stmt->bindParam($parmid, $rowData[0][$i]);

                        $parmid++;
        
                    }
                    $stmt->execute();
        
                   } catch (Exception $th) {
                   
                   }
            
            }
            $this->is_imported = true;
        
        }
       
        public function updateSale(){
            echo "Sale number". $this->broker;
            $query = "UPDATE `closing_cat_import` SET `sale_no`= ? , `empty_col1`= ? WHERE 1";
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
                $query.= "AND grade = 'BP1' OR grade = 'PF1'";
            }else{
                $query.= "AND grade != 'BP1' OR grade != 'PF1'";
            }
            $row=$this->conn->query($query)->fetch();
            return $row;
        }
        public function summaryCount($column, $type){
            $query = "SELECT COUNT(".$column.") AS count FROM `closing_cat_import` WHERE lot REGEXP '^[0-9]+$'";
            if($type=='main'){
                $query.= "AND grade = 'BP1' OR grade = 'PF1'";
            }else{
                $query.= "AND grade != 'BP1' OR grade != 'PF1'";
            }
            $row=$this->conn->query($query)->fetch();
            return $row;
        }
        public function confirmCatalogue(){
            $confirmed = false;
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            try {
                $stmt = $this->conn->prepare("INSERT INTO `closing_cat`(`closing_cat_import_id`, `sale_no`, `broker`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `buyer_package`, `import_date`, `imported`, `imported_by`)
                                          SELECT `closing_cat_import_id`, `sale_no`, `empty_col1`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `buyer_package`, `import_date`, `imported`, `imported_by`
                                          FROM closing_cat_import
                                          WHERE lot REGEXP '^[0-9]+$'"
                                        );
                    $stmt->execute();

             $stmt2 = $this->conn->prepare("DELETE FROM closing_cat_import WHERE 1");
             $stmt2->execute();
            } catch (Exception $ex) {
                var_dump($ex);
            }
            
        }
    }

?>