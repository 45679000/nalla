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
// print_r($myArray);
$rpData->invoiceArray = $myArray;
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
$pdf->SetAuthor('Chamu');
$pdf->SetTitle('Blend Sheet');
$pdf->SetSubject('Blend sheet');
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
foreach($myArray as $arr){
        // // add a page
        $data = $rpData->getBlendData($arr);
        $pdf->AddPage();
        $shippingData = $rpData->getBlendsShippingData($arr);
        $pdf->setFont('helvetica', '', 8);
                

        $tbl = '<html><body>
        <table cellspacing="" border="1" cellpadding="2"  align="center">
        <thead>
        ';
        $tbl .= '<tr><td colspan="15" style="background-color: #CCFCFD;" height="30">'.$shippingData[0]['header'].'</td></tr>';
        $tbl .= '
        <tr>
        <td colspan="13"></td>
        <td colspan="2"><b>Allocation</b></td>
        </tr>
        <tr>
                <td align="left"><b>Sale No.</b></td>
                <td colspan="2" align="center"><b>DD/MM/YY</b></td>
                <td align="center"><b>Broker</b></td>
                <td align="center" ><b>Warehouse</b></td>
                <td align="center"><b>Lot</b></td>
                <td align="center"><b>Origin</b></td>
                <td align="center"> <b>Grade</b></td>
                <td align="center"><b>Invoice</b></td>
                <td align="center"><b>Pkgs</b></td>
                <td align="center"><b>Net</b></td>
                <td align="center"> <b>Kgs</b></td>
                <td align="center"><b>WHSE</b></td>
                <td align="center" colspan="2"><b>SI/BLend No.</b></td>
        </tr>
        </thead>';
        $tbl .= '<tbody> ';
        $totalPkgs;
        $totalKgs;
        foreach($data as $item){
                $totalPkgs +=$item['blended_packages'];
                $totalKgs +=$item['kgs'];
                $tbl .= '<tr style="font-size: 8px;"><td>'.$item['sale_no'].'</td>
                <td colspan="2">'.$item['import_date'].'</td>
                <td>'.$item['broker'].'</td>
                <td >'.$item['ware_hse'].'</td>
                <td>'.$item['lot'].'</td>
                <td>'.$item['country'].'</td>
                <td>'.$item['grade'].'</td>
                <td>'.$item['invoice'].'</td>
                <td>'.$item['blended_packages'].'</td>
                <td>'.$item['net'].'</td>
                <td>'.$item['kgs'].'</td>
                <td>'.$item['warehouse'].'</td>
                <td style="background-color: #FCCCCC" colspan="2">'.$item['allocation'].'</td></tr>';
        }
        $tbl .= '
        <tr>
        <td colspan="9" align="left"><b>SHIPPING MARKS: </b>'.$shippingData[0]['contractno'].'</td>
        <td>'.$totalPkgs.'</td>
        <td></td>
        <td>'.$totalKgs.'</td>
        <td colspan="3"></td>
        </tr>';
        $tbl .= '
        <tr>
        <td colspan="3" align="left"><b>NOTE: </b></td>
        <td colspan="12">'.$data[0]['shipping_marks'].'</td>
        </tr>';
        $tbl .= '</tbody>';
        $tbl .= '</table>
        </body>
        </html>';

        $pdf->writeHTML($tbl, true, false, false, false, '');
        // //Close and output PDF document
}
$pdf->Output('proformaInvoice.pdf', 'I');
