<?php

require_once('tcpdf_include.php');
require_once('../../../database/connection2.php');
require_once('../../../models/Model.php');
require_once('data/reportData.php');

$db = new Database2();
$conn = $db->getConnection();
$rpData = new ReportData($conn);


$rpData->invoiceNo = $_GET["invoiceNo"];
$data = $rpData->proformaInvoiceData();

$tbl = '<html><body>
<table cellspacing="110" cellpadding="1" border="1" align="center">';
$dataSize = sizeof($data);
echo $dataSize;
for($i=0; $i<6; $i++){
        $item = $data[$dataSize];
        $tbl .='<tr>';
        $tbl .='<td colspan="1">'.$item["lot"].'</td>';
        $tbl .='<td colspan="2">'.$item["country"].'</td>';
        $tbl .='<td colspan="2>'.$item["mark"].'</td>';
        $tbl .='<td>'.$item["grade"].'</td>';
        $tbl .='<td>'.$item["invoice"].'</td>';
        $tbl .='<td>'.$item["pkgs"].'</td>';
        $tbl .='<td>'.$item["net"].'</td>';
        $tbl .='<td>'.$item["kgs"].'</td>';
        $tbl .='<td>'.$item["sale_price"].'</td>';
        $tbl .='<td>'.$item["kgs"]*$item["sale_price"].'</td>';
        $tbl .="</tr>";
    

}
$tbl .= '</table>
</body>
</html>';

echo $tbl;