<?php

require_once('tcpdf_include.php');
require_once('../../../database/connection2.php');
require_once('../../../models/Model.php');
require_once('data/reportData.php');
include "../../../vendor/autoload.php";

use TNkemdilim\MoneyToWords\Converter;  

$converter = new Converter("", "cents");


$db = new Database2();
$conn = $db->getConnection();
$rpData = new ReportData($conn);


$data = $rpData->getBlendsShippingData();
// $rpData->invoiceNo = trim($_GET["invoiceNo"]);
// var_dump($_GET['invoiceNo']);
// $data = $rpData->getShippingData();
// $gardens = $rpData->getAllGardens();
echo $data[0]['header'];

// foreach($data as $element){
//     if
//     echo $element['header'];
//     echo '</br>';
// }
// }
// echo date("Y-m-d", strtotime(44452));
?>
