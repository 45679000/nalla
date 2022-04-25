<?php

require_once('tcpdf_include.php');
require_once('../../../database/connection2.php');
require_once('../../../models/Model.php');
require_once('data/reportData.php');

$db = new Database2();
$conn = $db->getConnection();
$rpData = new ReportData($conn);
$myArr = $_GET["invoiceNo"];
$myArray = explode(',', $myArr);
// var_dump($myArray);
$rpData->invoiceArray = $myArray;
$data = $rpData->getData();
// var_dump($data);
$shippingData = $rpData->getShippingData();
// var_dump($shippingData);
function shippmentType($type){
        $teaType = '';
        if($type == 'Straight Line'){
                $teaType = 'LOT DETAILS';
        }else if($type == 'Blend Shippment'){
                $teaType = 'BLEND SHEET';
        }
        return $teaType;
}
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 001');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// $pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' ', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP);
$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
$pdf->setFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->setFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

$pdf->setFont('helvetica', '', 8);
	

$tbl = '<html><body>
<table cellspacing="" border="1" cellpadding="2"  align="center">
<thead>
';
foreach($shippingData as $shippment){
        $tbl .= '<tr><td colspan="15" style="background-color: #CCFCFD;" height="30">CHAMU SUPPLIES LTD - '.shippmentType($shippment['shippment_type']).' - '. $shippment['contract_no'].'- '.$shippment['no_containers_type'].' - '.$shippment['buyer'].' - '.$shippment['destination_total_place_of_delivery'].'</td></tr>';
}
$tbl .= '
<tr>
<td colspan="13"></td>
<td colspan="2"><b>Allocation</b></td>
</tr>
<tr>
        <td align="left"><b>Sale No.</b></td>
        <td align="center"><b>DD/MM/YY</b></td>
        <td align="center"><b>Broker</b></td>
        <td align="center"><b>Warehouse</b></td>
        <td align="center"><b>Lot</b></td>
        <td align="center"><b>Origin</b></td>
        <td align="center"><b>Mark</b></td>
        <td align="center"> <b>Grade</b></td>
        <td align="center"><b>Invoice</b></td>
        <td align="center"><b>Pkgs</b></td>
        <td align="center"><b>Net</b></td>
        <td align="center"> <b>Kgs</b></td>
        <td align="center"><b>Mrp</b></td>
        <td align="center"><b>WHSE</b></td>
        <td align="center"><b>SI/BLend No.</b></td>
</tr>
</thead>';
// $dataSize = sizeof($data);
// echo $dataSize;
$tbl .= '<tbody> ';
foreach($data as $item){
        $tbl .= '<tr style="font-size: 8px;"><td>'.$item['sale_no'].'</td>
        <td>'.$item['import_date'].'</td>
        <td>'.$item['broker'].'</td>
        <td>'.$item['ware_hse'].'</td>
        <td>'.$item['lot'].'</td>
        <td>'.$item['country'].'</td>
        <td>'.$item['mark'].'</td>
        <td>'.$item['grade'].'</td>
        <td>'.$item['invoice'].'</td>
        <td>'.$item['pkgs'].'</td>
        <td>'.$item['net'].'</td>
        <td>'.$item['kgs'].'</td>
        <td>'.$item['mrp_value'].'</td>
        <td>'.$item['warehouse'].'</td>
        <td style="background-color: #FCCCCC">'.$item['allocation'].'</td></tr>';
}
$tbl .= '</tbody>';
$tbl .= '</table>
</body>
</html>';

// echo $tbl;
$pdf->writeHTML($tbl, true, false, false, false, '');
// //Close and output PDF document
$pdf->Output('proformaInvoice.pdf', 'I');