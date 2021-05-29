<?php
// (A) CONNECT TO DATABASE - CHANGE SETTINGS TO YOUR OWN!
$connost = 'localhost';
$dbname = 'chamu';
$dbchar = 'utf8';
$dbuser = 'root';
$dbpass = '';
$pdo = new PDO(
  "mysql:host=$connost;charset=$dbchar;dbname=$dbname",
  $dbuser, $dbpass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES, false
  ]
);

// (B) PHPSPREADSHEET TO LOAD EXCEL FILE
require "../vendor/autoload.php";
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load("ANJL_SPLIT_CLOSING_SALE_12.2021.xlsx");

$spreadsheet->setActiveSheetIndex(2);
$worksheet = $spreadsheet->getActiveSheet(3);

// (C) READ DATA + IMPORT
$sql = "INSERT INTO `closing_cat_import`(`comment`, `empty_col1`, `ware_hse`, `entry_no`, `value`) 
VALUES (?,?,?,?)";
foreach ($worksheet->getRowIterator() as $row) {
  // (C1) FETCH DATA FROM WORKSHEET

  $cellIterator = $row->getCellIterator();
    //skip missing rows
    
  $cellIterator->setIterateOnlyExistingCells(false);
  $data = [];
  foreach ($cellIterator as $cell) { 
      $data[] = $cell->getValue(); 
    }

  // (C2) INSERT INTO DATABASE
//   print_r($data);
try {
  for($i=0; $i<count($data); $i++){
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(1, $data[$i]);
      $stmt->bindParam(2, $data[$i]);
      $stmt->bindParam(3, $data[$i]);
      $stmt->bindParam(4, $data[$i]);
      $stmt->execute();
  }
  } catch (Exception $ex) { 
     var_dump($stmt);
     echo $ex->getMessage() . "<br>";
}
  $stmt = null;
}

// (D) CLOSE DATABASE CONNECTION
if ($stmt !== null) { $stmt = null; }
if ($pdo !== null) { $pdo = null; }