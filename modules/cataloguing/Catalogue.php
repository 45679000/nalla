<?php 
    $path_to_root = '../../';

    Class Catalogue extends Model{
        public $inputFileName;
        public function importClosingCatalogue(){
            // $inputFileName = 'ANJL_SPLIT_CLOSING_SALE_12.2021.xls';
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
        
        }
        public function readImportSummaries(){
            $query = "SELECT * FROM `closing_cat_import` WHERE lot REGEXP '^[0-9]+$'";
        }
    }
?>