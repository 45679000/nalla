<?php
// (A) CONNECT TO DATABASE - CHANGE SETTINGS TO YOUR OWN!
$dbhost = 'localhost';
$dbname = 'chamu';
$dbchar = 'utf8';
$dbuser = 'root';
$dbpass = '';
$pdo = new PDO(
  "mysql:host=$dbhost;charset=$dbchar;dbname=$dbname",
  $dbuser, $dbpass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES, false
  ]
);
require "../vendor/autoload.php";

$inputFileName = 'ANJL_SPLIT_CLOSING_SALE_12.2021.xls';

//  Read your Excel workbook
try {
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
    $reader->setReadDataOnly(true);
    $spreadsheet = $reader->load($inputFileName);

} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

readrecords($pdo,$spreadsheet, 2);
readrecords($pdo,$spreadsheet, 3);
readrecords($pdo,$spreadsheet, 4);

function readrecords($pdo, $spreadsheet, $activesheet){
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

