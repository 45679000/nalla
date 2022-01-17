<?php 
 ob_start();

    $path_to_root = "../";
    $path_to_root1 = "../";
    // include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
	include_once('../../models/Model.php');

    include_once ($path_to_root.'setting.php');
    $amount_in_words = "Us Dollars Fifty Two Thousand Two Hundred Thirty Three and Cents Sixty Two Only";
    include_once('../tcpdf/tcpdf/tcpdf.php');

	$url = $_SERVER['REQUEST_URI'];
	$url_components = parse_url($url);
	parse_str($url_components['query'], $params);
	$invoiceNumber = $params['invoiceno'];
	$connect = mysqli_connect("localhost", "iano","manemaniac", "chams");
	$query = "SELECT * FROM `tea_invoices` WHERE invoice_no= '$invoiceNumber'";
    $result = mysqli_query($connect, $query);
	$tableData = mysqli_fetch_array($result);

    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $obj_pdf->SetCreator(PDF_CREATOR);
    $obj_pdf->SetTitle("Users");
    $obj_pdf->setHeaderData("","",PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $obj_pdf->setHeaderFont(Array(PDF_FONT_SIZE_MAIN,'',PDF_FONT_SIZE_MAIN));
    $obj_pdf->setFooterFont(Array(PDF_FONT_SIZE_MAIN,'',PDF_FONT_SIZE_MAIN));
    $obj_pdf->SetDefaultMonospacedFont('helvetica');
    $obj_pdf->setFooterMargin(PDF_MARGIN_FOOTER);
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5',PDF_MARGIN_RIGHT);
    $obj_pdf->setPrintHeader(false);
    $obj_pdf->setPrintFooter(false);
    $obj_pdf->SetAutoPageBreak(TRUE, 10);
    $obj_pdf->SetFont('times','',12);

    $obj_pdf->AddPage();

    $content = '';
    $content .= '';
	$tbl = '
	<div border="1">
			<table cellspacing="0" cellpadding="3" border="">
				
				<tr>
					<td><b>CHAMU SUPPLIES LIMITED</b>
					<br />
						P.O Box 86040-80100
						<div></div>	
						Mombasa, Kenya
					<br />
					'.$invoiceNumber.'
					</td>
					<td align="right"><b>Profoma Invoice</b></td>
				</tr>
			</table>
			<div></div>
		<table border="1" cellpadding="2" cellspacing="0">
			<thead>
				<tr style="font-size: 8px;">
					<td width="300"><b>Invoice To</b></td>
					<td width="70" align="center"><b><u>VAT REG NO</u></b></td>
					<td width="70" align="center"><b><u>Tax Date</u></b></td>
					<td width="70" align="center"><b><u>Invoice</b></u></td>	
				</tr>
			</thead>
			<tr style="font-size: 10px;">
				<td width="300">BASU TEE HANDELSGESELLCHAFT MBH.
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
				<td width="70" align="center">BTH 2387</td>
			</tr>
		</table>
		<div></div>
		<table border="1" cellpadding="2" cellspacing="0" height="200">
			<thead>
			<tr style="font-size: 8px;">
				<td width="60" align="left"><b>Item /STD No.</b></td>
				<td width="140" align="center"><b>Description of Goods</b></td>
				<td width="100" align="center"><b>Total Nett (Kgs)</b></td>
				<td width="70" align="center"> <b>CIF <br /> Rate <br />(USD)/Kg</b></td>
				<td width="60" align="center"><b>VAT AMT</b></td>
				<td width="80" align="center"><b>Amount(USD)</b></td>
			</tr>
			</thead>
			<tr style="font-size: 10px;">
				<td width="60" align="center" height="" border="0">'.$tableData['container_no'].'<div></div>'.$tableData['date_captured'].'</td>
				<td width="140" >'.$tableData['good_description'].' <div></div>Duly Stiched and Marked as reuired UNPALLETIZED SHIPMENT: '.$tableData['shipping_marks'].'<div></div></td>
				<td width="100" align="center">15000</td>
				<td width="70" align="center">3.82</td>
				<td width="60" align="center">0</td>
				<td align="center" width="80" >57300</td>
			</tr>
		</table>
		<table border="1" cellpadding="2">
		<tr style="font-size: 8px;">
			<td>Us dollars Fifty Two Thousand Two Hundred Thirty Three and Cents Sixty Two Only
			</td>
		</tr>	
		</table>
		<table border="1" cellpadding="5" cellspacing="" style="font-size: 10px;">

			<tr>
				<td width="320">Vat Summary</td>
				<td width="100">Sub total</td>
				<td width="90">57300</td>
			</tr>
			<tr>
				<td width="320"><b>PORT OF DELIVERY: '.$tableData['port_of_delivery'].'</b><br /><b>CONSIGNEE:</b>'.$tableData['consignee'].'</td>
				<td width="100">VAT TOTAL (US $)</td>
				<td width="90">0</td>
			</tr>

			<tr>
			<td width="320">PAYMENT TERMS: '.$tableData['payment_terms'].'</td>
			<td width="100">TOTAL(US $)</td>
			<td width="90">57300</td>
			</tr>
			<tr>
			<td width="320"></td>
			<td width="100">Payments/Credits</td>
			<td width="90">0.00</td>
			</tr>
			<tr>
			<td width="320"></td>
			<td width="100">Balance Due</td>
			<td width="90">57300</td>
			</tr>
		</table>
		<div border="">
			<table border="0" cellpadding="2">
				<tr height="100">
					<b>Our Bank Details</b> <br />MOMBASA SUPREME CENTRE <br />MOI AVENUE <br />MOMBASA
				</tr>
				<br></br>
				<br></br>
			</table>
			
		</div>
	</div>
	';

	$obj_pdf->writeHTML($tbl, true, false, false, false, '');
    // $obj_pdf->writeHTML($content);
    $obj_pdf->Output("sample.pdf", 'I');

	function invoicePdf($buyer, $consignee,$invoice_no, $invoice_type, $invoice_category,$port_of_delivery, $buyer_bank, $payment_terms, $pay_bank, $pay_details, $container_no, $buyer_contract_no, $shipping_marks,$other_reference, $port_of_discharge,$description_of_goods, $final_destination,$hs_code, $buyer_address, $bl_no, $bank_id){
		$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$obj_pdf->SetTitle("Users");
		$obj_pdf->setHeaderData("","",PDF_HEADER_TITLE, PDF_HEADER_STRING);
		$obj_pdf->setHeaderFont(Array(PDF_FONT_SIZE_MAIN,'',PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_SIZE_MAIN,'',PDF_FONT_SIZE_MAIN));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->setFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5',PDF_MARGIN_RIGHT);
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, 10);
		$obj_pdf->SetFont('times','',12);

		$obj_pdf->AddPage();

		$aTbl = '
		<div border="1">
				<table cellspacing="0" cellpadding="3" border="">
					
					<tr>
						<td><b>CHAMU SUPPLIES LIMITED</b>
						<br />
							P.O Box 86040-80100
							<div></div>	
							Mombasa, Kenya
						</td>
						<td align="right"><b>Profoma Invoice</b></td>
					</tr>
				</table>
				<div></div>
			<table border="1" cellpadding="2" cellspacing="0">
				<thead>obj_pdf->Output("sample.pdf");
					<tr style="font-size: 8px;">
						<td width="300"><b>Invoice To</b></td>
						<td width="70" align="center"><b><u>VAT REG NO</u></b></td>
						<td width="70" align="center"><b><u>Tax Date</u></b></td>
						<td width="70" align="center"><b><u>Invoice</b></u></td>	
					</tr>
				</thead>
				<tr style="font-size: 10px;">
					<td width="300"obj_pdf->Output("sample.pdf");>BASU TEE HANDELSGESELLCHAFT MBH.
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
					<td width="70" align="center">BTH 2387</td>
				</tr>
			</table>
			<div></div>
			<table border="1" cellpadding="2" cellspacing="0" height=obj_pdf->Output("sample.pdf");"200">
				<thead>
				<tr style="font-size: 8px;">
					<td width="60" align="left"><b>Item /STD No.</b></td>
					<td width="140" align="center"><b>Description of Goods</b></td>
					<td width="100" align="center"><b>Total Nett (Kgs)</b></td>
					<td width="70" align="center"> <b>CIF <br /> Rate <br />(USD)/Kg</b></td>
					<td width="60" align="center"><b>VAT AMT</b></td>
					<td width="80" obj_pdf->Output("sample.pdf");
				</thead>
				<tr style="font-size: 10px;">
					<td width="60" align="center" height="" border="0">1.</td>
					<td width="140" >XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br /><br /></td>
					<td width="100" >XXXX<br />XXXX</td>
					<td width="70" >XXXX<br />XXXX</td>
					<td width="60" >XXXX</td>
					<td align="center" width="80" >XXXX<br />XXXX</td>
				</tr>
			</table>
			<table border="1" cellpadding="2">
			<tr style="font-size: 8px;">
				<td>Us dollars Fifty Two Thousand Two Hundred Thirty Three and Cents Sixty Two Only
				</td>
			</tr>	
			</table>
			<table border="1" cellpadding="5" cellspacing="" style="font-size: 10px;">

				<tr>
					<td width="320">Vat Summary</td>
					<td width="100">Sub total</td>
					<td width="90">57300</td>
				</tr>
				<tr>
					<td width="320"><b>PORT OF DELIVERY: PORT QASIM,PAKISTAN </b><br /><b>CONSIGNEE:</b>  MEEZAN BANK LTD.,H-91A,DARYALAL STREET JORDIA BAZAR,KARACHI,PAKISTAN</td>
					<td width="100">VAT TOTAL (US $)</td>
					<td width="90">0</td>
				</tr>

				<tr>
				<td width="320">PAYobj_pdf->Output("sample.pdf");AL(US $)</td>
				<td width="90">57300</td>
				</tr>
				<tr>
				<td width="320"></td>
				<td width="100">Payments/Credits</td>
				<td width="90">0.00</td>
				</tr>
				<tr>
				<td width="320"></td>
				<td width="100">Balance Due</td>
				<td width="90">57300</td>
				</tr>
			</table>
			<div border="">
				<table border="0" cellpadding="2">
					<tr height="100">
						<b>Our Bank Details</b> <br />MOMBASA SUobj_pdf->Output("sample.pdf");PREME CENTRE <br />MOI AVENUE <br />MOMBASA
					</tr>
					<br></br>
					<br></br>
				</table>
				
			</div>
		</div>
		';
		$obj_pdf->writeHTML($aTbl, true, false, false, false, '');
		return $obj_pdf->Output("sample.pdf", 'I');
	}
?>

       