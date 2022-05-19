<?php
	session_start();

	header("Access-Control-Allow-Origin: *");
    include_once('../../models/Model.php');
	require "../../vendor/autoload.php";
    include_once('../../database/page_init.php');
	include_once('../../controllers/StockController.php');
	include_once('../../controllers/SalesController.php');
	include_once('../../controllers/PurchasesController.php');

    include '../../controllers/FinanceController.php';
	include '../../controllers/WorkFlow.php';

    $db = new Database();
    $conn = $db->getConnection();
    $finance = new Finance($conn);
	$workFlow = new WorkFlow($conn);
	$stockCtrl = new Stock($conn);
	$salesCtrl = new Sales($conn);
	$purchaseCtrl = new Purchases($conn);


	// Insert Record
	if (isset($_POST['action']) && $_POST['action'] == "save-invoice") {
        $error = "";
		$buyer = isset($_POST['buyer']) ? $_POST['buyer'] : $error ='You must select a client';
        $consignee = isset($_POST['consignee']) ? $_POST['consignee'] : 'SAME AS BUYER';
        $invoice_no = isset($_POST['invoice_no']) ? $_POST['invoice_no'] : $error ='You must enter an invoice_no';
        $invoice_category = isset($_POST['invoice_category']) ? $_POST['invoice_category'] : $error ='You must indicate Invoice Category';
        $port_of_delivery = isset($_POST['port_of_delivery']) ? $_POST['port_of_delivery'] : '';
        $buyer_bank = isset($_POST['buyer_bank']) ? $_POST['buyer_bank'] : '';
        $payment_terms = isset($_POST['payment_terms']) ? $_POST['payment_terms'] : '';
		$pay_bank = isset($_POST['pay_bank']) ? $_POST['pay_bank'] : '';
		$pay_details = isset($_POST['pay_details']) ? $_POST['pay_details'] : '';

		$bank_id = isset($_POST['bank_id']) ? $_POST['bank_id'] : '';
		$container_no = isset($_POST['container_no']) ? $_POST['container_no'] : '';
		$buyer_contract_no = isset($_POST['buyer_contract_no']) ? $_POST['buyer_contract_no'] : '';
		$shipping_marks = isset($_POST['shipping_marks']) ? $_POST['shipping_marks'] : '';
		$other_reference= isset($_POST['other_references']) ? $_POST['other_references'] : '';

		$final_destination= isset($_POST['final_destination']) ? $_POST['final_destination'] : '';
		$description_of_goods = isset($_POST['good_description']) ? $_POST['good_description'] : '';
		$buyer_address = isset($_POST['buyer_address']) ? $_POST['buyer_address'] : '';
		$bl_no = isset($_POST['bl_no']) ? $_POST['bl_no'] : '';
		$hs_code = isset($_POST['hs_code']) ? $_POST['hs_code'] : '';
		$min_tax = isset($_POST['min_tax']) ? $_POST['min_tax'] : '0.00';

        if($error ==""){
          $message = $finance->saveInvoice(
			  $buyer, $consignee, $invoice_no,
			  $invoice_type, $invoice_category, 
			  $port_of_delivery, $buyer_bank, 
			  $payment_terms, $pay_bank, 
			  $pay_details,
			  $container_no,
			  $buyer_contract_no,
			  $shipping_marks,
			  $other_reference,
			  $port_of_delivery,
			  $description_of_goods,
			  $final_destination,
			  $hs_code,
			  $buyer_address,
			  $bl_no,
			  $bank_id,
			  $min_tax
			  
			);
          echo json_encode($message);

        }else{
          $formError["error"]=$error;
          $formError["code"] = 201;

          echo json_encode($formError);

        }
	}
	if (isset($_POST['action']) && $_POST['action'] == "update-invoice") {
        $error = "";
		$buyer = isset($_POST['buyer']) ? $_POST['buyer'] : $error ='You must select a client';
        $consignee = isset($_POST['consignee']) ? $_POST['consignee'] : 'SAME AS BUYER';
        $invoice_no = isset($_POST['invoice_no']) ? $_POST['invoice_no'] : $error ='You must enter an invoice_no';
        $invoice_category = isset($_POST['invoice_category']) ? $_POST['invoice_category'] : $error ='You must indicate Invoice Category';
        $port_of_delivery = isset($_POST['port_of_delivery']) ? $_POST['port_of_delivery'] : '';
        $buyer_bank = isset($_POST['buyer_bank']) ? $_POST['buyer_bank'] : '';
        $payment_terms = isset($_POST['payment_terms']) ? $_POST['payment_terms'] : '';
		$pay_bank = isset($_POST['pay_bank']) ? $_POST['pay_bank'] : '';
		$pay_details = isset($_POST['pay_details']) ? $_POST['pay_details'] : '';

		$bank_id = isset($_POST['bank_id']) ? $_POST['bank_id'] : '';
		$container_no = isset($_POST['container_no']) ? $_POST['container_no'] : '';
		$buyer_contract_no = isset($_POST['buyer_contract_no']) ? $_POST['buyer_contract_no'] : '';
		$shipping_marks = isset($_POST['shipping_marks']) ? $_POST['shipping_marks'] : '';
		$other_reference= isset($_POST['other_references']) ? $_POST['other_references'] : '';

		$final_destination= isset($_POST['final_destination']) ? $_POST['final_destination'] : '';
		$description_of_goods = isset($_POST['good_description']) ? $_POST['good_description'] : '';
		$buyer_address = isset($_POST['buyer_address']) ? $_POST['buyer_address'] : '';
		$bl_no = isset($_POST['bl_no']) ? $_POST['bl_no'] : '';
		$hs_code = isset($_POST['hs_code']) ? $_POST['hs_code'] : '';
		$min_tax = isset($_POST['min_tax']) ? $_POST['min_tax'] : '';
        if($error ==""){
          $message = $finance->updateInvoice(
			  $buyer, $consignee, $invoice_no,
			  $invoice_type, $invoice_category, 
			  $port_of_delivery, $buyer_bank, 
			  $payment_terms, $pay_bank, 
			  $pay_details,
			  $container_no,
			  $buyer_contract_no,
			  $shipping_marks,
			  $other_reference,
			  $port_of_delivery,
			  $description_of_goods,
			  $final_destination,
			  $hs_code,
			  $buyer_address,
			  $bl_no,
			  $bank_id,
			  $min_tax
			  
			);
          echo json_encode($message);

        }else{
          $formError["error"]=$error;
          $formError["code"] = 201;

          echo json_encode($formError);

        }
	}	
	if (isset($_POST['action']) && $_POST['action'] == "unconfirmed-purchase-list") {
		$saleno = $_POST['saleno'];
		$finance->saleno=$saleno;
		$purchases = $finance->readPurchaseList();

		if (sizeOf($purchases) > 0) {
			$output .='<table id="purchaseListTable" class="table table-bordered table-striped table-hover table-sm">
			        <thead class="table-primary">
					<tr>
						<th class="wd-105p">Sale No</th>
						<th class="wd-15p">Broker</th>
						<th class="wd-15p">Lot No</th>
						<th class="wd-15p">Ware Hse.</th>
						<th class="wd-20p">Company</th>
						<th class="wd-15p">Mark</th>
						<th class="wd-10p">Grade</th>
						<th class="wd-10p">Hammer.P</th>
						<th class="wd-25p">Garden Invoice</th>
						<th class="wd-25p">BrokerInvoice</th>
						<th class="wd-25p">Pkgs</th>
						<th class="wd-25p">Net</th>
						<th class="wd-25p">Kgs</th>
						<th class="wd-25p">Actions</th>

					</tr>
			        </thead>
			        <tbody>';
					foreach ($purchases as $purchase){
						$output.='<tr>';
							$id = $purchase["lot"];
							$totalPkgs+=$purchase["pkgs"];
							$totalKgs+=$purchase["net"];
							$output.='<td>'.$purchase["sale_no"].'</td>';
							$output.='<td>'.$purchase["broker"].'</td>';
							$output.='<td>'.$purchase["lot"].'</td>';
							$output.='<td>'.$purchase["ware_hse"].'</td>';
							$output.='<td>'.$purchase["company"].'</td>';
							$output.='<td>'.$purchase["mark"].'</td>';
							$output.='<td>'.$purchase["grade"].'</td>';
							$output.='<td onBlur=updateHammer(this) class="'.$id.'" contentEditable = "true">'.$purchase["sale_price"].'</td>';
							$output.='<td>'.$purchase["invoice"].'</td>';
							$output.='<td onBlur=updateInvoice(this) class="'.$id.'" contentEditable = "true">'.$purchase["broker_invoice"].'</td>';
							$output.='<td onBlur=updatePkgs(this) class="'.$id.'" contentEditable = "true">'.$purchase["pkgs"].'</td>';
							$output.='<td onBlur=updateKgs(this) class="'.$id.'" contentEditable = "true">'.$purchase["kgs"].'</td>';
							$output.='<td onBlur=updateNet(this) class="'.$id.'" contentEditable = "true">'.$purchase["net"].'</td>';
							if($purchase["added_to_stock"]==0){
								$output.='
								<td>
									<a class="confirmLot" id="'.$purchase["lot"].'" style="color:green" data-toggle="tooltip" data-placement="bottom" title="Confirm Lot" >
									<i class="fa fa-check-circle-o" ></i></a>
								</td>';
							}else{
								$output.='
								<td>
									<a class="unconfirmLot" id="'.$purchase["lot"].'" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Remove" >
									<i class="fa fa-times-circle-o" ></i></a>
								</td>';
							}
						
						$output.='</tr>';
					}
					
			$output.= '
			</tbody>';
			$output.='<tfooter>
			<tr>
				<td>Totals</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td id="totalPkgs">'.$totalPkgs.'</td>
				<td></td>
				<td id="totalKgs">'.$totalKgs.'</td>

				<td></td>
				<td></td>
				<td></td>

			</tr>
		</tfooter>

				</table>
				<div style="text-align:center;">
				</div>';
      		echo $output;	
		}else{
			echo '<h3 class="text-center mt-5">There are no pending lots on the purchase list</h3>';
		}

	}
	if(isset($_POST['action']) && $_POST['action'] == "add-lot"){
		$lot = $_POST['lot'];
		$finance->addToStock($lot, 1, 0);
	}
	if(isset($_POST['action']) && $_POST['action'] == "remove-lot"){
		$lot = $_POST['lot'];

		$finance->addToStock($lot, 0, 0);
	}
	if(isset($_POST['action']) && $_POST['action'] == "update-field"){
		$lot = $_POST['lot'];
		$field = $_POST['field'];
		$value = $_POST['value'];
		$saleno = $_POST['saleno'];

		return json_encode ($finance->updateField($lot, $field, $value, $saleno));
	}
	if(isset($_POST['action']) && $_POST['action'] == "update-auction-date"){
		$field = $_POST['field'];
		$value = $_POST['value'];
		$saleno = $_POST['saleno'];

		return json_encode ($finance->updateAuctionDate($field, $value, $saleno));
	}
	if(isset($_POST['action']) && $_POST['action'] == "confirm-purchaselist"){
		$saleno = $_POST['saleno'];
		$finance->confirmPurchaseList($saleno);
	}
	if (isset($_POST['action']) && $_POST['action'] == "confirmed-purchase-list") {
		$saleno = $_POST['saleno'];
		$finance->saleno=$saleno;
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		if($type ==''){
			$type = null;
		}
		$purchases = $finance->confirmedPurchaseList($type);
		$totalPkgs = 0;
		$totalLots = 0;
		$totalKgs = 0;
		$totalNet = 0;
		$totalHammer = 0;
		$totalValue = 0;
		$totalBrokerage = 0;
		$totalbrokerage = 0;
		$totalAmount = 0;
		$totalAfterTax = 0;
		$totalAddon = 0;
		$totalpayable = 0;
		$totalPayableStock = 0;

		if (sizeOf($purchases) > 0) {

			$output .='<table id="purchaseListTable" class="table table-bordered table-striped table-hover table-sm">
			<thead class="table-primary">
							<tr>
								<th>Line No</th>
								<th>Sale No</th>
								<th>DD/MM/YY</th>
								<th>Broker</th>
								<th>Broker Invoice</th>
								<th>Warehouse</th>
								<th>Lot</th>
								<th>Origin</th>
								<th>Mark</th>
								<th>Grade</th>
								<th>Invoice</th>
								<th>Pkgs</th>
								<th>Net</th>
								<th>Kgs</th>
								<th>Auction Hammer Price per Kg(USD)</th>
								<th>Value Ex Auction</th>
								<th>Brokerage Amount 0.5 % on value(USD)</th>
								<th>Final Prompt Value Including Brokerage 0.5 % on value(USD)</th>
								<th>Withholding Tax @ 5% Of Brokerage Amount Payable to Domestic Taxes Dept(USD)</th>
								<th>Prompt Payable to EATTA-TCA After Deduction of W.Tax</th>
								<th>Actions</th>
							</tr>
					</thead>
			        <tbody>';
					foreach ($purchases as $purchase){
						$id = $purchase["lot"];

						$totalLots++;
						$totalPkgs += $purchase['pkgs'];
						$totalKgs += $purchase['net'];
						$totalNet += $purchase['kgs'];


						$afterTax = round(($totalamount) - (5 / 100) * $brokerage, 2);
						$addon = 0;

						$net = $purchase['net'];
						$hammerPrice = round(floatval($purchase['sale_price']/100), 2);
						$valueExAuct = round($net * $hammerPrice, 2);
						$brokerage = round(($valueExAuct) * (0.005), 2);
						$finalPrompt = round($brokerage + $valueExAuct, 2);
						$withholdingTax = round((0.05*$brokerage),2);
						$finalPromptEata = round($finalPrompt-$withholdingTax, 2);
						$totalPayable = round($addon + $hammerPrice, 2);


						$totalBrokerage += $brokerage;
						$totalValue += $valueExAuct;
						$totalHammer += $hammerPrice;
						$totalAmount += $finalPrompt;
						$totalbrokerage += round((0.05 * $brokerage), 2);
						$withholdingTaxTotal += $withholdingTax;
						$totalPromptEata += $finalPromptEata;

						$totalAfterTax += $afterTax;
						$totalAddon += $addon;
						$totalpayable += $totalPayable;


						$totalPayableStock += $totalPayable * $purchase['net'];
						$output.='<tr>';
							$output .= '<td>' . $purchase['line_no'] . '</td>';
							$output .= '<td>' . $purchase['sale_no'] . '</td>';
							$output.='<td onBlur=updateAuctionDate(this) class="'.$id.'" contentEditable = "true">'.$purchase["auction_date"].'</td>';
							$output .= '<td>' . $purchase['broker'] . '</td>';
							$output.='<td onBlur=updateInvoice(this) class="'.$id.'" contentEditable = "true">'.$purchase["broker_invoice"].'</td>';
							$output .= '<td>' . $purchase['ware_hse'] . '</td>';
							$output .= '<td>' . $purchase['lot'] . '</td>';
							$output .= '<td>' . $purchase['origin'] . '</td>';
							$output .= '<td>' . $purchase['mark'] . '</td>';
							$output .= '<td>' . $purchase['grade'] . '</td>';
							$output .= '<td>' . $purchase['invoice'] . '</td>';
							$output.='<td onBlur=updatePkgs(this) class="'.$id.'" contentEditable = "true">'.$purchase["pkgs"].'</td>';
							$output.='<td onBlur=updateKgs(this) class="'.$id.'" contentEditable = "true">'.$purchase["kgs"].'</td>';
							$output.='<td onBlur=updateNet(this) class="'.$id.'" contentEditable = "true">'.$purchase["net"].'</td>';
							$output.='<td onBlur=updateHammer(this) class="'.$id.'" contentEditable = "true">'.$hammerPrice.'</td>';
							$output .= '<td>' . number_format((float)$valueExAuct, 2, '.', '') . '</td>'; //value ex auction
							$output .= '<td>' . number_format((float)$brokerage, 2, '.', '') . '</td>'; // brokerage fee
							$output .= '<td>' . number_format((float)$finalPrompt, 2, '.', '') . '</td>'; //final prompt value
							$output .= '<td>' . number_format((float)$withholdingTax, 2, '.', '') . '</td>';
							$output .= '<td>' . number_format((float)$finalPromptEata, 2, '.', '') . '</td>';
							if($purchase["added_to_stock"]==0){
								$output.='
								<td>
									<a class="confirmLot" id="'.$purchase["buying_list_id"].'" style="color:green" data-toggle="tooltip" data-placement="bottom" title="Confirm Lot" >
									<i class="fa fa-check-circle-o" ></i></a>
								</td>';
							}else{
								$output.='
								<td>
									<a style="color:green; cursor: pointer;" class="unconfirmLot" data-toggle="tooltip" data-placement="bottom" title="Remove"  id="'.$purchase["buying_list_id"].'">
									<i class="fa fa-check">Added to stock</i></a>
								</td>';
							}
							$output .= '</tr>';
						$output.='</tr>';
					}
					
			$output .= '</tbody>';
			$output .= '<tfooter>
						<tr>';
							$output .= '<td><b>TOTALS</td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td><b>' . $totalLots . '</b></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td><b>' . $totalPkgs . '</b></td>'; //pkgs
							$output .= '<td><b>' . round(($totalNet / $totalLots),2) . '</b></td>'; //kgs
							$output .= '<td><b>' . number_format((float)$totalKgs, 2, '.', '') . '</b></td>'; //net
							$output .= '<td><b>' . round(($totalHammer/$totalLots),2) . '</b></td>'; //auction hammer
							$output .= '<td><b>' . number_format((float)$totalValue, 2, '.', '') . '</b></td>'; //value ex auction
							$output .= '<td><b>' . round(($totalBrokerage),2) . '</b></td>'; // brokerage fee
							$output .= '<td><b>' . $totalAmount . '</b></td>'; //final prompt value
							$output .= '<td><b>' . number_format((float)$withholdingTaxTotal, 2, '.', '') . '</b></td>';
							$output .= '<td><b>' . number_format((float)$totalPromptEata, 2, '.', '') . '</b></td>';
							$output .= '<td></td>';


			$output .= '</tr>
						</tfooter>
				</table>';
      		echo $output;	
		}else{
			echo '<h3 class="text-center mt-5">There are no pending lots on the purchase list</h3>';
		}

	}
	if(isset($_POST['action']) && $_POST['action'] == "add_to_stock"){
		$saleno = $_POST['saleno'];
		$id = $_POST['id'];
		// $finance->postToStock($saleno, $id);

		$purchaseCtrl->cart = $finance->pcart($id);
		// print_r($finance->pcart($id));
		$purchaseCtrl->post_purchase();
	}
	if(isset($_POST['action']) && $_POST['action'] == "activity"){	
		$activityid = isset($_POST['id']) ? $_POST['id'] : 0;
		$saleno = isset($_POST['saleno']) ? $_POST['saleno'] : 0;
		$activity = $workFlow->getActivity($activityid, $saleno);
		echo json_encode($activity);

	}
	if(isset($_POST['action']) && $_POST['action'] == "get-unconfirmed-auctions"){	
	    $auctions =  $finance->unconfirmedSales();
		echo json_encode($auctions);

	}
	if (isset($_POST['action']) && $_POST['action'] == "view-invoices") {
		$output = "";
		$invoices = $finance->fetchInvoices('profoma', '');
		if($invoice_no ==''){
			if (count($invoices) > 0) {
				$output .="<table id='invoicetable1' class='table-striped table-bordered table-hover thead-dark table-sm'>
						<thead class='thead-dark'>
							<tr>
							<th>Invoice No</th>
							</tr>
						</thead>
						<tbody>";
				foreach ($invoices as $invoice) {
					$output.="<tr>
						<td><i class='fa fa-folder'></i><a href='#' class='profoma_print'>".$invoice['invoice_no']."</a></td>
						</tr>";
					}
				$output .= "</tbody>
					</table>";
					echo $output;	
			}else{
				echo '<h3 class="text-center mt-5">No records found</h3>';
			}
		}else{
			if (count($invoices) > 0) {
				$output .="<table id='grid' class='table table-striped table-bordered table-hover thead-dark table-sm' style='width:100%;'>
						<thead class='thead-dark'>
							<tr>
							<th>Invoice No</th>
							<th>Buyer</th>
							<th>Consignee</th>
							<th>Category</th>
							<th>Port Of Delivery</th>
							<th>Date Entered</th>
							</tr>
						</thead>
						<tbody>";
				foreach ($invoices as $invoice) {
			$kgs=$invoice['Pkgs']*$invoice['nw'];
			$invoiceid = $invoice['id'];
			$cat = $invoice['invoice_category'];
			$kind = $invoice['invoice_type'];

					$output.="<tr>
						<td><a href='./index.php?view=selectTeas&cat=$cat&kind=$kind&invoice_no=$invoiceid'>".$invoice['invoice_no']."</a></td>
						<td>".$invoice['debtor_ref']."</td>
						<td>".$invoice['consignee']."</td>
						<td>".$invoice['invoice_category']."</td>
						<td>".$invoice['port_of_delivery']."</td>
						<td>".$invoice['date_captured']."</td>
						</tr>";
					}
				$output .= "</tbody>
					</table>";
					echo $output;	
			}else{
				echo '<h3 class="text-center mt-5">No records found</h3>';
			}

		}
	}if(isset($_POST['action']) && $_POST['action'] == 'load-unallocated'){
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$mark = isset($_POST['mark']) ? $_POST['mark'] : 'All';
		$lot = isset($_POST['lot']) ? $_POST['lot'] : 'All';
		$grade = isset($_POST['grade']) ? $_POST['grade'] : 'All';
		$saleno = isset($_POST['saleno']) ? $_POST['saleno'] : 'All';
	  
	  
		$filters = array();
		$filters['saleno'] = 'All';
		$filters['mark'] =  'All';
		$filters['lot'] =  'All';
		$filters['grade'] =  'All';
		$filters['broker'] = 'All';
		$filters['standard'] ='All';
		$filters['gradecode'] = 'All';
	  
	  
	  
		$blendBalance = 0;
		$output ="";
		$stockList = $stockCtrl->readStock("", $filters, 1);
		if (sizeOf($stockList)> 0) {
			$output .='
			<table id="direct_lot" class="table table-sm table-responsive table-striped table-bordered">
			<thead>
				<tr>
					<th>Line No</th>
					<th>Sale No</th>
					<th>DD/MM/YY</th>
					<th>Broker</th>
					<th>Warehouse</th>
					<th>Lot</th>
					<th>Mark</th>
					<th>Grade</th>
					<th>Invoice</th>
					<th>Code</th>
					<th>Pkgs</th>
					<th>Net</th>
					<th>Kgs</th>
					<th>Actions</th>
	  
				</tr>
			</thead>
			<tbody>';
			foreach ($stockList as $stock) {
				$output.='<tr>';
					$output.='<td>'.$stock["line_no"].'</td>';
					$output.='<td>'.$stock["sale_no"].'</td>';
					$output.='<td>'.$stock['import_date'].'</td>';
					$output.='<td>'.$stock["broker"].'</td>';
					$output.='<td>'.$stock["ware_hse"].'</td>';
					$output.='<td>'.$stock["lot"].'</td>';
					$output.='<td>'.$stock["mark"].'</td>';
					$output.='<td>'.$stock["grade"].'</td>';
					$output.='<td>'.$stock["invoice"].'</td>';
					$output.='<td>'.$stock["comment"].'</td>';
					$output.='<td>'.$stock["pkgs"].'</td>';
					$output.='<td>'.$stock["net"].'</td>';
					$output.='<td>'.$stock["kgs"].'</td>';
					if($stock["profoma_invoice_no"] != null){
					  $output.='<td><a style="font-size:8px;">'.$stock["profoma_invoice_no"].'<a/></td>';
					}else{
					  $output.='<td>
					  <a class="addTea" id="'.$stock["stock_id"].'" style="color:green" data-toggle="tooltip" data-placement="bottom" title="Use Tea" >
					  <i class="fa fa-arrow-right" ></i></a>&nbsp&nbsp&nbsp;
					  <a class="splitLot" id="'.$stock["stock_id"].'" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Split Lot">
					  <i class="fa fa-scissors"></i></a>&nbsp&nbsp&nbsp;
					</td>'; 
					}
							 
				$output.='</tr>';
					
			}
			$output.='</tbody>
		</table>';
		}    
	   echo $output;
	}
	if(isset($_POST['action']) && $_POST['action'] == "select-invoice"){	
		$stockid = isset($_POST['stockid']) ? $_POST['stockid'] : '';
		$invoiceid = isset($_POST['invoiceid']) ? $_POST['invoiceid'] : '';
		$finance->invoiceTea($stockid, $invoiceid, $_SESSION['user_id']);
	}
	if(isset($_POST['action']) && $_POST['action'] == "remove-invoice"){	
		$stockid = isset($_POST['id']) ? $_POST['id'] : '';
		$finance->removeInvoiceTea($stockid);
	}
	if(isset($_POST['action']) && $_POST['action'] == "get-sale-no"){	
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$saleno = $stockCtrl->salenoPurchases($type);
		echo json_encode($saleno);
	}
	if(isset($_POST['action']) && $_POST['action'] == "proforma_templates"){	
		$output = "";
		$invoices = $finance->invoiceTemplate();
            $output = '<option disabled="" value="..." selected="">select</option>';
		if (sizeOf($invoices) > 0) {
			foreach($invoices as $sitemp){
				$output .= '<option value="'.$sitemp['id'].'">'.$sitemp['invoice_no'].'</option>';
			}
			echo $output;	
		}else{
			echo '<option disabled="" value="..." selected="">select</option>';
		}
	}
	if(isset($_POST['action']) && $_POST['action'] == "bk-templates"){	
		$output = "";
		$invoices = $finance->bookingFacilityTemplate();
            $output = '<option disabled="" value="..." selected="">select</option>';
		if (sizeOf($invoices) > 0) {
			foreach($invoices as $bktemp){
				$output .= '<option value="'.$bktemp['facility_no'].'">'.$bktemp['facility_no'].'</option>';
			}
			echo $output;	
		}else{
			echo '<option disabled="" value="..." selected="">select</option>';
		}
	}	
	if(isset($_POST['action']) && $_POST['action'] == "edit-si-invoice"){	
		$invoiceno = isset($_POST['id']) ? $_POST['id'] : '';

		$records = $finance->fetchInvoices("", $invoiceno);

		echo json_encode($records);
	}
	if(isset($_POST['action']) && $_POST['action'] == "edit-facility"){	
		$facilityno = isset($_POST['id']) ? $_POST['id'] : '';

		$records = $finance->fetchFacility($facilityno);

		echo json_encode($records);
	}
	if(isset($_POST['action']) && $_POST['action'] == "load-invoice-teas"){
		$invoiceno = isset($_POST['invoice']) ? $_POST['invoice'] : '';

		$records = $finance->loadTeaInvoices($invoiceno);
		if (sizeOf($records)> 0) {
			$output .='
			<table id="added_lots" class="table table-sm  table-striped table-bordered">
			<thead>
				<tr>
					<th>Line No</th>
					<th>Lot</th>
					<th>Origin</th>
					<th>Grade</th>
					<th>Invoice</th>
					<th>Pkgs</th>
					<th>Kgs</th>
					<th>Net</th>
					<th>Final Rate Per Kg</th>
					<th>Actions</th>
	  
				</tr>
			</thead>
			<tbody>';
			foreach ($records as $stock) {
				$output.='<tr id="'.$stock["id"].'">';
					$output.='<td>'.$stock["line_no"].'</td>';
					$output.='<td>'.$stock["lot"].'</td>';
					$output.='<td>'.$stock["country"].'</td>';
					$output.='<td>'.$stock["grade"].'</td>';
					$output.='<td>'.$stock["invoice"].'</td>';
					$output.='<td>'.$stock["pkgs"].'</td>';
					$output.='<td>'.$stock["kgs"].'</td>';
					$output.='<td>'.$stock["net"].'</td>';
					$output.='<td class="profoma_amount" contenteditable="true" id="'.$stock["id"].'">'.$stock["profoma_amount"].'</td>';

					  $output.='<td>
					  <a class="removeTea" id="'.$stock["id"].'" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Remove" >
					  <i class="fa fa-close" ></i></a>&nbsp&nbsp&nbsp;
					</td>'; 
					
							 
				$output.='</tr>';
					
			}
			$output.='</tbody>
		</table>';
		}    
	   echo $output;
	}
	if(isset($_POST['action']) && $_POST['action'] == "remove-invoice-tea"){
		$invoiceno = isset($_POST['id']) ? $_POST['id'] : '';

	}	
	if(isset($_POST['action']) && $_POST['action'] == "load-invoice-teas-blend"){
		$invoiceno = isset($_POST['invoice']) ? $_POST['invoice'] : '';

		$records = $finance->loadBlendTeaInvoices($invoiceno);
			$output .='
			<table id="added_lots" class="table table-sm  table-striped table-bordered">
			<thead>
				<tr>
					<th>Item/STD No.</th>
					<th>Description Of Goods</th>
					<th>Total Nett(Kgs)</th>
					<th>CIF Rate (USD)/Kg</th>
					<th>VAT AMT</th>
					<th>Amount (USD)</th>
					<th>Actions</th>

				</tr>
			</thead>
			<tbody>';
			foreach ($records as $blend) {
				$id = $blend["id"];
				$output.='<tr id="'.$id.'">';
					$output.='<td><textarea name="item" class="updateableText" rows="20" cols="50">'.$blend["item"].'</textarea></td>';
					$output.='<td><textarea class="updateableText" name="description_of_goods" rows="20" cols="20">'.$blend["description_of_goods"].'</textarea></td>';
					$output.='<td class="updateable" name="total_net" contentEditable="true">'.$blend["total_net"].'</td>';
					$output.='<td class="updateable" name="p_cif_rate" contentEditable="true">'.$blend["p_cif_rate"].'</td>';
					$output.='<td class="updateable" name="p_vat_amt" contentEditable="true">'.$blend["p_vat_amt"].'</td>';
					$output.='<td class="updateable" name="p_amount" contentEditable="true">'.$blend["p_amount"].'</td>';
					$output.='<td>
                  <span>
                     <button class="btn btn-danger btn-sm"><i id="'.$id.'" class="remove fa fa-minus" style="color:white"></i></button>
                  </span>
                  </td>';		 
				$output.='</tr>';
					
			}
			$output.='</tbody>';
			$output.='<tfoot>
			<tr>';
			$output.= '<td><button id="add" class="btn btn-success btn-sm text" style="font-size:smaller;"><i class="fa fa-plus" style="color:white"></i></button></td>';       
			$output.= '<td></td>';       
			$output.= '<td></td>';       
			$output.= '<td></td>';       
			$output.= '<td></td>';       
			$output.= '<td></td>';       
			$output.= '<td></td>';       
			$output.='
			</tr>
			</tfoot>';

		$output.='</table>';
		   
	   echo $output;

	}
	if(isset($_POST['action']) && $_POST['action'] == "add-line"){
		$invoiceno = isset($_POST['id']) ? $_POST['id'] : '';
		$finance->addRecord($invoiceno);

	}
	if(isset($_POST['action']) && $_POST['action'] == "update-blend-value"){
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$fieldValue = isset($_POST['value']) ? $_POST['value'] : '';
		$fieldName = isset($_POST['name']) ? $_POST['name'] : '';

		$finance->updateValue($id, $fieldValue, $fieldName);

	}
	if(isset($_POST['action']) && $_POST['action'] == "update-invoice-value"){
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$fieldValue = isset($_POST['value']) ? $_POST['value'] : '';
		$fieldName = isset($_POST['fieldName']) ? $_POST['fieldName'] : '';

		$finance->updateStraightLineValue($id, $fieldValue, $fieldName);

	}
	if(isset($_POST['action']) && $_POST['action'] == "remove-line"){
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$finance->removeRecord($id);

	}
	if(isset($_POST['action']) && $_POST['action'] == "submit-invoice"){
		$invoice_no = isset($_POST['invoice']) ? $_POST['invoice'] : '';
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		// echo $type;
		$cart = $finance->submitInvoice($type, $invoice_no);
		// print_r($cart);
		// $salesCtrl->clean();
		$salesCtrl->cart = $cart;
		print_r($salesCtrl->post_pos_sale());


	}
	if (isset($_POST['action']) && $_POST['action'] == "unbooked_lots") {
		$saleno = $_POST['saleno'];
		$finance->saleno=$saleno;
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		if($type ==''){
			$type = null;
		}
		$purchases = $finance->unpaidLots();
		$totalPkgs = 0;
		$totalLots = 0;
		$totalKgs = 0;
		$totalNet = 0;
		$totalHammer = 0;
		$totalValue = 0;
		$totalBrokerage = 0;
		$totalbrokerage = 0;
		$totalAmount = 0;
		$totalAfterTax = 0;
		$totalAddon = 0;
		$totalpayable = 0;
		$totalPayableStock = 0;

		if (sizeOf($purchases) > 0) {
			$output .='<table id="purchaseListTable" class="table table-bordered table-striped table-hover table-sm">
			<thead class="table-primary">
							<tr>
								<th>Line No</th>
								<th>Sale No</th>
								<th>DD/MM/YY</th>
								<th>Broker</th>
								<th>Broker Invoice</th>
								<th>Warehouse</th>
								<th>Lot</th>
								<th>Origin</th>
								<th>Mark</th>
								<th>Grade</th>
								<th>Invoice</th>
								<th>Pkgs</th>
								<th>Net</th>
								<th>Kgs</th>
								<th>Auction Hammer Price per Kg(USD)</th>
								<th>Withholding Tax @ 5% Of Brokerage Amount Payable to Domestic Taxes Dept(USD)</th>
								<th>Prompt Payable to EATTA-TCA After Deduction of W.Tax</th>
								<th>Actions</th>
							</tr>
					</thead>
			        <tbody>';
					foreach ($purchases as $purchase){
						$id = $purchase["lot"];

						$totalLots++;
						$totalPkgs += $purchase['pkgs'];
						$totalKgs += $purchase['net'];
						$totalNet += $purchase['kgs'];


						$afterTax = round(($totalamount) - (5 / 100) * $brokerage, 2);
						$addon = 0;

						$net = $purchase['net'];
						$hammerPrice = round(floatval($purchase['sale_price']/100), 2);
						$valueExAuct = round($net * $hammerPrice, 2);
						$brokerage = round(($valueExAuct) * (0.005), 2);
						$finalPrompt = round($brokerage + $valueExAuct, 2);
						$withholdingTax = round((0.05*$brokerage),2);
						$finalPromptEata = round($finalPrompt-$withholdingTax, 2);
						$totalPayable = round($addon + $hammerPrice, 2);


						$totalBrokerage += $brokerage;
						$totalValue += $valueExAuct;
						$totalHammer += $hammerPrice;
						$totalAmount += $finalPrompt;
						$totalbrokerage += round((0.05 * $brokerage), 2);
						$withholdingTaxTotal += $withholdingTax;
						$totalPromptEata += $finalPromptEata;

						$totalAfterTax += $afterTax;
						$totalAddon += $addon;
						$totalpayable += $totalPayable;


						$totalPayableStock += $totalPayable * $purchase['net'];
						$output.='<tr>';
							$output .= '<td>' . $purchase['line_no'] . '</td>';
							$output .= '<td>' . $purchase['sale_no'] . '</td>';
							$output.='<td onBlur=updateAuctionDate(this) class="'.$id.'" contentEditable = "true">'.$purchase["auction_date"].'</td>';
							$output .= '<td>' . $purchase['broker'] . '</td>';
							$output.='<td onBlur=updateInvoice(this) class="'.$id.'" contentEditable = "true">'.$purchase["broker_invoice"].'</td>';
							$output .= '<td>' . $purchase['ware_hse'] . '</td>';
							$output .= '<td>' . $purchase['lot'] . '</td>';
							$output .= '<td>' . $purchase['origin'] . '</td>';
							$output .= '<td>' . $purchase['mark'] . '</td>';
							$output .= '<td>' . $purchase['grade'] . '</td>';
							$output .= '<td>' . $purchase['invoice'] . '</td>';
							$output.='<td onBlur=updatePkgs(this) class="'.$id.'" contentEditable = "true">'.$purchase["pkgs"].'</td>';
							$output.='<td onBlur=updateKgs(this) class="'.$id.'" contentEditable = "true">'.$purchase["kgs"].'</td>';
							$output.='<td onBlur=updateNet(this) class="'.$id.'" contentEditable = "true">'.$purchase["net"].'</td>';
							$output.='<td onBlur=updateHammer(this) class="'.$id.'" contentEditable = "true">'.$hammerPrice.'</td>';
							$output .= '<td>' . number_format((float)$withholdingTax, 2, '.', '') . '</td>';
							$output .= '<td>' . number_format((float)$finalPromptEata, 2, '.', '') . '</td>';
							if($purchase["is_booked"]==0){
								$output.='
								<td>
									<a class="confirmLot" id="'.$purchase["buying_list_id"].'" style="color:green" data-toggle="tooltip" data-placement="bottom" title="Book Lot" >
									<i class="fa fa-check-circle-o" ></i></a>
								</td>';
							}else{
								$output.='
								<td>
									<a style="color:green" data-toggle="tooltip" data-placement="bottom" title="Remove" >
									<i class="fa fa-check">Booked:'.$purchase["facility_no"].'</i></a>
								</td>';
							}
							$output .= '</tr>';
						$output.='</tr>';
					}
					
			$output .= '</tbody>';
			$output .= '<tfooter>
						<tr>';
							$output .= '<td><b>TOTALS</td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td><b>' . $totalLots . '</b></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td><b>' . $totalPkgs . '</b></td>'; //pkgs
							$output .= '<td><b>' . round(($totalNet / $totalLots),2) . '</b></td>'; //kgs
							$output .= '<td><b>' . number_format((float)$totalKgs, 2, '.', '') . '</b></td>'; //net
							$output .= '<td><b>' . round(($totalHammer/$totalLots),2) . '</b></td>'; //auction hammer
							$output .= '<td><b>' . number_format((float)$withholdingTaxTotal, 2, '.', '') . '</b></td>';
							$output .= '<td><b>' . number_format((float)$totalPromptEata, 2, '.', '') . '</b></td>';
							$output .= '<td></td>';


			$output .= '</tr>
						</tfooter>
				</table>';
      		echo $output;	
		}else{
			echo '<h3 class="text-center mt-5">There are no pending lots on the purchase list</h3>';
		}

	}
	if(isset($_POST['action']) && $_POST['action'] == "create_booking_facility"){
		unset($_POST["action"]);
		$_POST["created_on"] = date('Y-m-d H:i:s');
		$_POST["created_by"] = $finance->user;

		$facility = $finance->addBookingFacility($_POST);

		echo json_encode($facility);

	}
	if(isset($_POST['action']) && $_POST['action'] == "book-lot"){
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$facility_no = isset($_POST['facility_no']) ? $_POST['facility_no'] : '';
		$finance->bookLot($id, $facility_no);

	}
	if (isset($_POST['action']) && $_POST['action'] == "lot_details") {
		$facility_no = isset($_POST['facility_no']) ? $_POST['facility_no'] : '';

		$purchases = $finance->bookedLots($facility_no);
		$totalPkgs = 0;
		$totalLots = 0;
		$totalKgs = 0;
		$totalNet = 0;
		$totalHammer = 0;
		$totalValue = 0;
		$totalBrokerage = 0;
		$totalbrokerage = 0;
		$totalAmount = 0;
		$totalAfterTax = 0;
		$totalAddon = 0;
		$totalpayable = 0;
		$totalPayableStock = 0;

		if (sizeOf($purchases) > 0) {
			$output .='<table id="purchaseListTable" class="table table-bordered table-striped table-hover table-sm">
			<thead class="table-primary">
							<tr>
								<th>Sale No</th>
								<th>DD/MM/YY</th>
								<th>Broker</th>
								<th>Broker Invoice</th>
								<th>Warehouse</th>
								<th>Lot</th>
								<th>Origin</th>
								<th>Mark</th>
								<th>Grade</th>
								<th>Invoice</th>
								<th>Pkgs</th>
								<th>Net</th>
								<th>Kgs</th>
								<th>Auction Hammer Price per Kg(USD)</th>
								<th>Value Ex Auction</th>
								<th>Brokerage Amount 0.5 % on value(USD)</th>
								<th>Final Prompt Value Including Brokerage 0.5 % on value(USD)</th>
								<th>Withholding Tax @ 5% Of Brokerage Amount Payable to Domestic Taxes Dept(USD)</th>
								<th>Prompt Payable to EATTA-TCA After Deduction of W.Tax</th>
							</tr>
					</thead>
			        <tbody>';
					foreach ($purchases as $purchase){
						$id = $purchase["lot"];

						$totalLots++;
						$totalPkgs += $purchase['pkgs'];
						$totalKgs += $purchase['net'];
						$totalNet += $purchase['kgs'];


						$afterTax = round(($totalamount) - (5 / 100) * $brokerage, 2);
						$addon = 0;

						$net = $purchase['net'];
						$hammerPrice = round(floatval($purchase['sale_price']/100), 2);
						$valueExAuct = round($net * $hammerPrice, 2);
						$brokerage = round(($valueExAuct) * (0.005), 2);
						$finalPrompt = round($brokerage + $valueExAuct, 2);
						$withholdingTax = round((0.05*$brokerage),2);
						$finalPromptEata = round($finalPrompt-$withholdingTax, 2);
						$totalPayable = round($addon + $hammerPrice, 2);


						$totalBrokerage += $brokerage;
						$totalValue += $valueExAuct;
						$totalHammer += $hammerPrice;
						$totalAmount += $finalPrompt;
						$totalbrokerage += round((0.05 * $brokerage), 2);
						$withholdingTaxTotal += $withholdingTax;
						$totalPromptEata += $finalPromptEata;

						$totalAfterTax += $afterTax;
						$totalAddon += $addon;
						$totalpayable += $totalPayable;


						$totalPayableStock += $totalPayable * $purchase['net'];
						$output.='<tr>';
							$output .= '<td>' . $purchase['sale_no'] . '</td>';
							$output.='<td onBlur=updateAuctionDate(this) class="'.$id.'" contentEditable = "true">'.$purchase["auction_date"].'</td>';
							$output .= '<td>' . $purchase['broker'] . '</td>';
							$output.='<td onBlur=updateInvoice(this) class="'.$id.'" contentEditable = "true">'.$purchase["broker_invoice"].'</td>';
							$output .= '<td>' . $purchase['ware_hse'] . '</td>';
							$output .= '<td>' . $purchase['lot'] . '</td>';
							$output .= '<td>' . $purchase['origin'] . '</td>';
							$output .= '<td>' . $purchase['mark'] . '</td>';
							$output .= '<td>' . $purchase['grade'] . '</td>';
							$output .= '<td>' . $purchase['invoice'] . '</td>';
							$output.='<td onBlur=updatePkgs(this) class="'.$id.'" contentEditable = "true">'.$purchase["pkgs"].'</td>';
							$output.='<td onBlur=updateKgs(this) class="'.$id.'" contentEditable = "true">'.$purchase["kgs"].'</td>';
							$output.='<td onBlur=updateNet(this) class="'.$id.'" contentEditable = "true">'.$purchase["net"].'</td>';
							$output.='<td onBlur=updateHammer(this) class="'.$id.'" contentEditable = "true">'.$hammerPrice.'</td>';
							$output .= '<td>' . number_format((float)$valueExAuct, 2, '.', '') . '</td>'; //value ex auction
							$output .= '<td>' . number_format((float)$brokerage, 2, '.', '') . '</td>'; // brokerage fee
							$output .= '<td>' . number_format((float)$finalPrompt, 2, '.', '') . '</td>'; //final prompt value
							$output .= '<td>' . number_format((float)$withholdingTax, 2, '.', '') . '</td>';
							$output .= '<td>' . number_format((float)$finalPromptEata, 2, '.', '') . '</td>';
							$output .= '</tr>';
						$output.='</tr>';
					}
					
			$output .= '</tbody>';
			$output .= '<tfooter>
						<tr>';
							$output .= '<td><b>TOTALS</td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td><b>' . $totalLots . '</b></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td><b>' . $totalPkgs . '</b></td>'; //pkgs
							$output .= '<td><b>' . round(($totalNet / $totalLots),2) . '</b></td>'; //kgs
							$output .= '<td><b>' . number_format((float)$totalKgs, 2, '.', '') . '</b></td>'; //net
							$output .= '<td><b>' . round(($totalHammer/$totalLots),2) . '</b></td>'; //auction hammer
							$output .= '<td><b>' . number_format((float)$totalValue, 2, '.', '') . '</b></td>'; //value ex auction
							$output .= '<td><b>' . round(($totalBrokerage),2) . '</b></td>'; // brokerage fee
							$output .= '<td><b>' . $totalAmount . '</b></td>'; //final prompt value
							$output .= '<td><b>' . number_format((float)$withholdingTaxTotal, 2, '.', '') . '</b></td>';
							$output .= '<td><b>' . number_format((float)$totalPromptEata, 2, '.', '') . '</b></td>';
							$output .= '<td></td>';


			$output .= '</tr>
						</tfooter>
				</table>';
      		echo $output;	
		}else{
			echo '<h3 class="text-center mt-5">There are no  lots on the facility list</h3>';
		}

	}
	if (isset($_POST['action']) && $_POST['action'] == "view-facilities") {

		$purchases = $finance->Facilities($facility_no="all");
	
		// if (sizeOf($purchases) > 0) {
			$output .='	<table class="table card-table table-vcenter text-nowrap">
					<thead>
						<tr>
							<th>Facility No</th>
							<th>Date</th>
							<th>No of Lots</th>
							<th>Status</th>
							<th>Total Amount(USD)</th>
							<th></th>
						</tr>
						<tbody>
						<tr>';
                    if (sizeOf($purchases) > 0) {
                        foreach ($purchases as $purchase) {
                            $totalPayableStock += $totalPayable * $purchase['net'];
                            $output.='<tr>';
                            $output .= '<td><a href="store.html" class="text-inherit">'.$purchase["facility_no"].'</a></td>';
                            $output .= '<td>'.$purchase["value_date"].'</td>';
                            $output .= '<td>'.$purchase["total_lots"].'</td>';
                            $output .= '<td><span class="status-icon bg-warning"></span> pending</td>';
                            $output .= '<td>'."USD:".$purchase["amount"].'</td>';
                            $output .= '<td class="text-right">';
                            if ($purchase["is_processed"]==0) {
                                $output.='<a class="icon"></a>
									<a id="'.$purchase["facility_no"].'" class="btn btn-warning btn-sm process"><i class="fa fa-history"></i> Process</a>';
                            }
                            if ($purchase["is_paid"]==0 && $purchase["is_processed"]==1) {
                                $output.='<a class="icon"></a>
									<a id="'.$purchase["facility_no"].'" class="btn btn-success btn-sm pay"><i class="fa fa-link"></i> Pay</a>';
                            }
                                
                            $output.='</td>';
                            $output.='</tr>';
                        }
                    } else{
						$output = "<p class='m-4'>No records found</p>";
					}
					
			$output .= '</tbody>
		
				</table>';
      		echo $output;	
		}

	// }
	if(isset($_POST['action']) && $_POST['action'] == "process-facility"){
		$facility_no = isset($_POST['facility_no']) ? $_POST['facility_no'] : '';
		$purchaseCtrl->clean();
		$cart = $finance->fcart($facility_no);
		$purchaseCtrl->cart = $cart;
		$purchaseCtrl->process_facility();


	}




	

	
	
	
	
