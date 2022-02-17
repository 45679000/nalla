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

class Invoices extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = 'images/header.png';
        $this->Image($image_file, 10, 10, 200, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
          
        $this->SetY(-15);
        // Set font
        // $this->SetFont('helvetica', 'I', 8);
        // // Page number

        $image_file = 'images/footer.png';
        $this->Image($image_file, 0, 278, 210, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

    }
}

$pdf = new Invoices(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Nicola Asuni');
$pdf->setTitle('TCPDF Example 048');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' ', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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

$rpData->invoiceNo = trim($_GET["invoiceNo"]);
$data = $rpData->proformaInvoiceData();
$teaForInvoice = $rpData->loadTeas();
$address = str_replace(',', ',<br />',$data[0]['address']);
$consignee = $data[0]['consignee'];
$exporter = $data[0]['exporter'];
$descriptionOfGoods = $data[0]['good_description'];
$port_of_discharge = $data[0]['port_of_discharge'];
$final_destination = $data[0]['final_destination'];
$terms_of_delivery = $data[0]['pay_details'];
$other_references = $data[0]['other_references'];
$buyer_contract_no = $data[0]['buyer_contract_no'];
$invoiceno = $data[0]['invoice_no'];
$date = date_format(date_create($data[0]['date_captured']),"d.m.Y");
// $address = str_replace(',', ',<br />',$data[0]['address']);
// $consignee = $data[0]['consignee'];
// $exporter = $data[0]['exporter'];
// $descriptionOfGoods = $data[0]['good_description'];
// $port_of_discharge = $data[0]['port_of_discharge'];
// $final_destination = $data[0]['final_destination'];
// $terms_of_delivery = $data[0]['pay_details'];
// $other_references = $data[0]['other_references'];
// $buyer_contract_no = $data[0]['buyer_contract_no'];
// $invoiceno = $data[0]['invoice_no'];
// $date = date_format(date_create($data[0]['date_captured']),"d.m.Y");
// -----------------------------------------------------------------------------


$pdf->MultiCell(180,6,"<b>PROFORMA INVOICE</b>", 1, 'C',false,$ln = 1,$x = '15',$y = '30',true,  0,  true,true, 0, 'T',false);

$pdf->setFont('helvetica', '', 6);
$pdf->MultiCell(125,20,'<b>BUYER</b><br><span style="width:5px;">'.$address.'</span>', 1, 'J',false,$ln = 1,$x = '15',$y = '36',true,  0,  true,true, 0, 'T',false);
$pdf->MultiCell(27.5,8,"<u><b>Invoice No:</b></u><br>$invoiceno", 0, 'J',false,$ln = 1,$x = '140',$y = '36',true,  0,  true,true, 0, 'T',false);
$pdf->MultiCell(27.5,8,"<u><b>Date:</b></u><br>$date", 0, 'J',false,$ln = 1,$x = '167.5',$y = '36',true,  0,  true,true, 0, 'T',false);
$pdf->MultiCell(55,8,"", 1, 'J',false,$ln = 1,$x = '140',$y = '36',true,  0,  true,true, 0, 'T',false);

$pdf->MultiCell(55,6,"<b>Buyer's Contract No. & Date</b><br>$buyer_contract_no", 1, 'J',false,$ln = 1,$x = '140',$y = '44',true,  0,  true,true, 0, 'T',false);
$pdf->MultiCell(125,12,"<u><b>CONSIGNEE:</b></u><br>$consignee", 1, 'J',false,$ln = 1,$x = '15',$y = '56',true,  0,  true,true, 0, 'T',false);
$pdf->MultiCell(125,7,"<u><b>EXPORTER:</b></u><br>$exporter", 1, 'J',false,$ln = 1,$x = '15',$y = '68',true,  0,  true,true, 0, 'T',false);
$pdf->MultiCell(55,26,"<b>Other Reference</b><br><br>$other_references", 1, 'J',false,$ln = 1,$x = '140',$y = '50',true,  0,  true,true, 0, 'T',false);
$pdf->MultiCell(180,7,"<u><b>Description of Goods:</b></u><br>$descriptionOfGoods", 1, 'J',false,$ln = 1,$x = '15',$y = '76',true,  0,  true,true, 0, 'T',false);
$pdf->MultiCell(62.5,6,"<u><b>country of origin:</b></u><br>KENYA", 1, 'J',false,$ln = 1,$x = '15',$y = '83',true,  0,  true,true, 0, 'T',false);
$pdf->MultiCell(62.5,6,"<u><b>Port of Loading:</b><br>Mombasa</u>", 1, 'J',false,$ln = 1,$x = '77.5',$y = '83',true,  0,  true,true, 0, 'T',false);
$pdf->MultiCell(62.5,6,"<u><b>Port of Discharge:</b></u><br>$port_of_discharge", 1, 'J',false,$ln = 1,$x = '15',$y = '89',true,  0,  true,true, 0, 'T',false);
$pdf->MultiCell(62.5,6,"<u><b>Final Destination:</b></u><br>$final_destination", 1, 'J',false,$ln = 1,$x = '77.5',$y = '89',true,  0,  true,true, 0, 'T',false);
$pdf->MultiCell(55,12,"<u><b>Terms of Delivery and Payment:</b></u><br>$terms_of_delivery", 1, 'J',false,$ln = 1,$x = '140',$y = '83',true,  0,  true,true, 0, 'T',false);

$pdf->setFont('helvetica', 'B', 5);
// set cell padding
$pdf->setCellPaddings(0.5, 0.5, 0.5, 0.5);
// -----------------------------------------------------------------------------
$pdf->Cell(120,6,"Description of goods: origin, Marks, Grade, Invoice Nos. & No of Pkgs",1,0,'L');
$pdf->MultiCell(15, 6, 'Each Nett Per Pkg/Break-up', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 6, 'Total Nett Quantity',1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 6, 'Total Rate per KG', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 6, 'Final Amount', 1, 'C', 0, 0, '', '', true);

$pdf->Ln();
$pdf->Cell(15, 4, 'Lot', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(15, 4, 'Origin', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(30, 4, 'Garden',1, 'C', 0, 0, '', '', true);
$pdf->Cell(15, 4, 'Grade', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(30, 4, 'Invoice', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(15, 4, 'Packages', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(15, 4, 'KGS', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(15, 4, 'KGS', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(15, 4, 'USD/Kg', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(15, 4, 'USD', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->Cell(15, 4, '', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(15, 4, '', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(30, 4, '',1, 'C', 0, 0, '', '', true);
$pdf->Cell(15, 4, '', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(30, 4, '', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(15, 4, '', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(15, 4, '', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(15, 4, '', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(15, 4, '', 1, 'C', 0, 0, '', '', true);
$pdf->Cell(15, 4, '', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->setFont('helvetica', '', 6);



$w = array(10, 20, 40, 35, 40, 45);
$tbl = '<table cellspacing="0" cellpadding="1" border="1" align="center">';
$dataSize = sizeof($data)+3;
$total = 0;
$totalPackages = 0; 
$totalKgs = 0; 
// $pdf->Cell(15,4,$item["rate_per_kg"],1,0,'C');
// $pdf->Cell(15,4,$item["kgs"]*$item["rate_per_kg"],1,0,'C');
foreach($teaForInvoice as $item) {
    $pdf->Cell(15,4,$item["lot"],1,0,'C');
    $pdf->Cell(15,4,$item["country"],1,0,'C');
    $pdf->Cell(30,4,$item["mark"],1,0,'C');
    $pdf->Cell(15,4,$item["grade"],1,0,'C');
    $pdf->Cell(30,4,$item["invoice"],1,0,'C');
    $pdf->Cell(15,4,$item["pkgs"],1,0,'C');
    $pdf->Cell(15,4,$item["net"],1,0,'C');
    $pdf->Cell(15,4,$item["kgs"],1,0,'C');
    $pdf->Cell(15,4,$item["profoma_amount"],1,0,'C');
    $pdf->Cell(15,4,$item["kgs"]*$item["profoma_amount"],1,0,'C');

    $total += $item["final_amount"];
    $totalPackages += $item["pkgs"];
    $totalKgs += $item["kgs"];
    $pdf->Ln();
    $fill=!$fill;
}
    $pdf->Cell(105,4,"TOTAL",1,0,'L');
    $pdf->Cell(15,4,$totalPackages,1,0,'C');
    $pdf->Cell(15,4,"",1,0,'L');
    $pdf->Cell(15,4, $totalKgs,1,0,'C');
    $pdf->Cell(15,4,"",1,0,'L');
    $pdf->Cell(15,4,number_format((float)$total, 2, '.', ''),1,0,'C');

    $pdf->Ln();

    $pdf->Cell(135,4,"MINIMUM TAX @ 1% OF VALUE AS PER KENYA GOVERNMAENT LAW (FINANCE ACT 2020)",1,0,'L');
    $pdf->Cell(15,4,"1%",1,0,'C');
    $pdf->Cell(15,4,"",1,0,'L');

    $pdf->Cell(15,4,number_format((float)0.01*$total,2),1,0,'C');

    $pdf->Ln();


    $pdf->Cell(105,4,"GRAND TOTAL AMOUNT",1,0,'L');
    $pdf->Cell(15,4,$totalPackages,1,0,'C');
    $pdf->Cell(15,4,"",1,0,'L');
    $pdf->Cell(15,4, $totalKgs,1,0,'C');
    $pdf->Cell(15,4,"",1,0,'L');
    $pdf->Cell(15,4,number_format((float)(0.01*$total)+(+$total),2),1,0,'C');

// -----------------------------------------------------------------------------
$pdf->Ln();

$amount_in_words= "Us Dollars ".ucfirst($converter->convert($total));
$container_no = $data[0]["container_no"];
$bl_no = $data[0]["bl_no"];
$hs_code = $data[0]["hs_code"];
$shipping_marks = $data[0]["shipping_marks"];
$pay_bank = str_replace(',', ',<br />', $data[0]["pay_bank"]);



$html = <<<EOD
<table cellspacing="6" cellpadding="1" border="0">
<tr>
<td height="20" colspan="2"><u><b>Total Amount (In Words): $amount_in_words</b></u></td>
</tr>
<tr>
<td height="20" rowspan="1"><u><b>CONTAINER NO. $container_no</b></u></td>
<td height="20" rowspan="1"><u><b>BL NO. $bl_no</b></u></td>
</tr>
<tr>
<td height="20" rowspan="1"><u><b>H.S.CODE: $hs_code</b></u></td>
<td height="20" rowspan="1"><u><b>SHIPPING MARKS:. $shipping_marks</b></u></td>
</tr>
<tr>
<td height="100"  colspan="2"><b>Our Bank Details: <br>$pay_bank</b></td>
</tr>
</table>
EOD;

$pdf->writeHTMLCell(0, 50, '', '', $html, 'LRTB', 1, 0, true, 'L', true);


// $pdf->writeHTML($tbl, false, false, false, false, '');
// -----------------------------------------------------------------------------
//Close and output PDF document
$pdf->Output('proformaInvoice.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+


