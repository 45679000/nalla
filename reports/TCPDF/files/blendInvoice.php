<?php    
    // $path_to_root = "../";
    // $path_to_root1 = "../";
    // include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
    // include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
	// include_once('../../models/Model.php');
    // require_once('tcpdf.php');
    // require_once('../database/connection2.php');
    // require_once('../models/Model.php');
    require_once('../tcpdf.php');
    // include('./vendor/autoload.php');
    require_once('../../../database/connection2.php');
    require_once('../../../models/Model.php');
    require_once('data/reportData.php');
    include "../../../vendor/autoload.php";

    use TNkemdilim\MoneyToWords\Converter;  

    $converter = new Converter("", "cents");

	// db connect
    $db = new Database2();
    $conn = $db->getConnection();
    $rpData = new ReportData($conn);

    $rpData->invoiceNo = trim($_GET["invoiceNo"]);
    $data = $rpData->proformaInvoiceData();
    $address = str_replace(',', ',<br />',$data[0]['address']);
    $consignee = $data[0]['consignee'];
    $exporter = $data[0]['exporter'];
    $port_of_discharge = $data[0]['port_of_discharge'];
    $final_destination = $data[0]['final_destination'];
    $terms_of_delivery = $data[0]['pay_details'];
    $other_references = $data[0]['other_references'];
    $buyer_contract_no;
    $invoiceno = $data[0]['invoice_no'];
    $date = date_format(date_create($data[0]['date_captured']),"d.m.Y");

	$invoiceBlend = $rpData->loadBlendInvoice();
	$descriptionOfGoods;
	$stdNo = $invoiceBlend['item'];
	$totalNet ;
	$cifRate ;
	$vatAmount ;
	$totalAmount;
	$subTotal;
	function goodsDescription($invoiceBlend)
	{
		foreach ($invoiceBlend as $item) {
			$GLOBALS['descriptionOfGoods'] .= $item['description_of_goods'].'<br /><br/>';
		}
		// $GLOBALS['descriptionOfGoods'];
	}
	goodsDescription($invoiceBlend);
	function stdNumber($invoiceBlend)
	{
		foreach ($invoiceBlend as $item) {
			$GLOBALS['stdNo'] .= $item['item'].'<div></div>';
		}
		// $GLOBALS['descriptionOfGoods'];
	}
	stdNumber($invoiceBlend);
	function totalNet($invoiceBlend)
	{
		foreach ($invoiceBlend as $item) {
			$GLOBALS['totalNet'] .= $item['total_net'].'<div></div>';
		}
		// $GLOBALS['descriptionOfGoods'];
	}
	totalNet($invoiceBlend);
	function cifRate($invoiceBlend)
	{
		foreach ($invoiceBlend as $item) {
			$GLOBALS['cifRate'] .= $item['p_cif_rate'].'<div></div>';
		}
		// $GLOBALS['descriptionOfGoods'];
	}
	cifRate($invoiceBlend);
	function vatAmount($invoiceBlend)
	{
		foreach ($invoiceBlend as $item) {
			$GLOBALS['vatAmount'] .= $item['c_vat_amt'].'<div></div>';
		}
		// $GLOBALS['descriptionOfGoods'];
	}
	vatAmount($invoiceBlend);
	function totalAmount($invoiceBlend)
	{
		foreach ($invoiceBlend as $item) {
			$GLOBALS['totalAmount'] .= $item['p_amount'].'<div></div>';
		}
		// $GLOBALS['descriptionOfGoods'];
	}
	totalAmount($invoiceBlend);
	function subTotal($invoiceBlend)
	{
		foreach ($invoiceBlend as $item) {
			$GLOBALS['subTotal'] += $item['total_net'].'<div></div>';
		}
		// $GLOBALS['descriptionOfGoods'];
	}
	subTotal($invoiceBlend);
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
	
    // $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
	

    $content = '';
    $content .= '';
	$tbl = '
	<div></div>
	<div border="1">
			<table cellspacing="0" cellpadding="3" border="">
				
				<tr>
					<td><b style="font-size:16px">CHAMU SUPPLIES LIMITED</b>
					<br />
						<span style="font-size:12px">P.O Box 86040-80100</span>
						<div></div>	
						<b><u>Mombasa, Kenya</u></b>
					<br />
					</td>
					<td align="right"><b style="font-size:16px">Profoma Invoice</b></td>
				</tr>
			</table>
			<div></div>
		<table border="1" cellpadding="2" cellspacing="0">
			<thead>
				<tr style="font-size: 8px;">
					<td width="428"><b>Invoice To</b></td>
					<td width="70" align="center"><b><u>VAT REG NO</u></b></td>
					<td width="70" align="center"><b><u>Tax Date</u></b></td>
					<td width="70" align="center"><b><u>Invoice</b></u></td>	
				</tr>
			</thead>
			<tr style="font-size: 10px;">
				<td width="428">BASU TEE HANDELSGESELLCHAFT MBH.
				<br />
				POPPENBUTTELER BOGEN 74,
				<br />
				D-22399, HAMBURG,
				<br />
				GERMANY
				<br />
				<br />
				</td>
				<td width="70" align="center">P051410947X</td>
				<td width="70" align="center">2021-12-30</td>
				<td width="70" align="center">'.$invoiceno.'</td>
			</tr>
		</table>
		<div></div>
		<table border="1" cellpadding="2" cellspacing="0" height="200">
			<thead>
			<tr style="font-size: 8px;">
				<td width="80" align="left"><b>Item /STD No.</b></td>
				<td width="200" align="center"><b>Description of Goods</b></td>
				<td width="114" align="center"><b>Total Nett (Kgs)</b></td>
				<td width="84" align="center"> <b>CIF <br /> Rate <br />(USD)/Kg</b></td>
				<td width="60" align="center"><b>VAT AMT</b></td>
				<td width="100" align="center"><b>Amount(USD)</b></td>
			</tr>
			</thead>
			<tbody>		
				<tr style="font-size: 10px;">
					<td width="80" align="center" height="" border="0">'.$stdNo.'<div></div></td>
					<td width="200" >'.$descriptionOfGoods.'
						<div></div><div></div><div></div><div></div>
					</td>
					<td width="114" align="center">'.$totalNet.'</td>
					<td width="84" align="center">'.$cifRate.'</td>
					<td width="60" align="center">'.$vatAmount.'</td>
					<td align="center" width="100" >'.$totalAmount.'</td>
				</tr>
			</tbody>
			</table>
			';
		// foreach($invoiceBlend as $item){
		// 	$GLOBALS['tbl'] .='	
		// 	<tbody>		
		// 		<tr style="font-size: 10px;">
		// 			<td width="80" align="center" height="" border="0">'.$buyer_contract_no.'<div></div></td>
		// 			<td width="200" >'.$descriptionOfGoods.'
		// 				<div></div><div></div><div></div><div></div>
		// 			</td>
		// 			<td width="114" align="center">15000</td>
		// 			<td width="84" align="center">3.82</td>
		// 			<td width="60" align="center">0</td>
		// 			<td align="center" width="100" >57300</td>
		// 		</tr>
		// 	</tbody>
		// 	</table>';
		// }
		
		$tbl .='
		<table border="1" cellpadding="4">
		<tr style="font-size: 8px;">
			<td>Us dollars Fifty Two Thousand Two Hundred Thirty Three and Cents Sixty Two Only
			</td>
		</tr>	
		</table>
		<table border="1" cellpadding="5" style="font-size: 10px;">

			<tr>
				<td width="448">Vat Summary</td>
				<td width="100">Sub total</td>
				<td width="90">'.$subTotal.'</td>
			</tr>
			<tr>
				<td width="448"><b>PORT OF DELIVERY: '.$port_of_discharge.'</b><br /><b>CONSIGNEE:</b>'.$consignee.'</td>
				<td width="100">VAT TOTAL (US $)</td>
				<td width="90">0</td>
			</tr>

			<tr>
			<td width="448">PAYMENT TERMS: '.$payment_terms.'</td>
			<td width="100">TOTAL(US $)</td>
			<td width="90">57300</td>
			</tr>
			<tr>
			<td width="448" style="border: none;"></td>
			<td width="100" style="font-size:9px">Payments/Credits</td>
			<td width="90">0.00</td>
			</tr>
			<tr>
			<td width="448"></td>
			<td width="100" style="font-size:9px">Balance Due</td>
			<td width="90">57300</td>
			</tr>
		</table>
		<div border="" cellpadding="6">
			<table border="0" >
				<tr height="100">
					<u style="font-size: 16px;"><b>Our Bank Details</b></u> <div></div>MOMBASA SUPREME CENTRE <br />MOI AVENUE <br />MOMBASA
				</tr>
				<div></div>
				<div></div>
			</table>
			
		</div>
	</div>
	';

	$pdf->writeHTML($tbl, true, false, false, false, '');
	// $pdf->writeHTML($tblTwo, true, false, false, false, '');
	// $pdf->writeHTML($tableThree, true, false, false, false, '');
    // $obj_pdf->writeHTML($content);
    $pdf->Output("sample.pdf", 'I');

    // -------------------------------------------------------------------

?>
