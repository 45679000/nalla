<?php
	header("Access-Control-Allow-Origin: *");
    include_once('../../models/Model.php');
	require "../../vendor/autoload.php";
    include_once('../../database/page_init.php');
    include '../../controllers/FinanceController.php';
	include '../../controllers/WorkFlow.php';
	include_once('../../controllers/StockController.php');


    $db = new Database();
    $conn = $db->getConnection();
    $finance = new Finance($conn);
	$workFlow = new WorkFlow($conn);
	$stockCtrl = new Stock($conn);

	// Insert Record
	if (isset($_POST['action']) && $_POST['action'] == "save-invoice") {
        $error = "";
		$buyer = isset($_POST['buyer']) ? $_POST['buyer'] : $error ='You must select a client';
        $consignee = isset($_POST['consignee']) ? $_POST['consignee'] : $error ='You must select a consignee';
        $invoice_no = isset($_POST['invoice_no']) ? $_POST['invoice_no'] : $error ='You must select a invoice_no';
        $invoice_type = isset($_POST['invoice_type']) ? $_POST['invoice_type'] : $error ='Type missing';
        $invoice_category = isset($_POST['invoice_category']) ? $_POST['invoice_category'] : $error ='You must indicate Invoice Category';
        $port_of_delivery = isset($_POST['port_of_delivery']) ? $_POST['port_of_delivery'] : $error ='You must indicate contract No';
        $buyer_bank = isset($_POST['buyer_bank']) ? $_POST['buyer_bank'] : $error = 'You must enter sale no';
        $payment_terms = isset($_POST['payment_terms']) ? $_POST['payment_terms'] : $error ='You must indicate the payment_terms';
		$pay_bank = isset($_POST['pay_bank']) ? $_POST['pay_bank'] : $error ='You must indicate the Pay Bank';
		$pay_details = isset($_POST['pay_details']) ? $_POST['pay_details'] : $error ='You must indicate the pay_details';

        
        if($error ==""){
          $message = $finance->saveInvoice($buyer, $consignee, $invoice_no, $invoice_type, $invoice_category,  $port_of_delivery, $buyer_bank, $payment_terms, $pay_bank, $pay_details);
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
	if(isset($_POST['action']) && $_POST['action'] == "confirm-purchaselist"){
		$saleno = $_POST['saleno'];
		$finance->confirmPurchaseList($saleno);
	}
	if (isset($_POST['action']) && $_POST['action'] == "confirmed-purchase-list") {
		$saleno = $_POST['saleno'];
		$finance->saleno=$saleno;
		$purchases = $finance->confirmedPurchaseList();
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
								<th>Final Sales Invoice Price Per Kg(USD)</th>
								<th>Final Sales Invoice Value(USD)</th>
					
							</tr>
					</thead>
			        <tbody>';
					foreach ($purchases as $purchase){
						$totalLots++;
						$totalPkgs += $purchase['pkgs'];
						$totalKgs += $purchase['net'];
						$totalNet += $purchase['kgs'];

						$brokerage = round(($purchase['sale_price'] * $purchase['pkgs']) * (0.5 / 100), 2);
						$value = round($purchase['sale_price'] * $purchase['pkgs'], 2);
						$totalamount = round($brokerage + $value, 2);
						$afterTax = round(($totalamount) - (5 / 100) * $brokerage, 2);
						$auctionHammer = round(($purchase['sale_price']/100), 2);
						$addon = 0;
						$totalPayable = round($addon + $auctionHammer, 2);
						$hammerPrice = round(floatval($purchase['sale_price']/100), 2);

						$totalBrokerage += $brokerage;
						$totalValue += $value;
						$totalHammer += $hammerPrice;
						$totalAmount += $totalamount;
						$totalbrokerage += (5 / 100) * $brokerage;

						$totalAfterTax += $afterTax;
						$totalAddon += $addon;
						$totalpayable += $totalPayable;

						$totalPayableStock += $totalPayable * $purchase['net'];
						$output.='<tr>';
							$output .= '<td>' . $purchase['sale_no'] . '</td>';
							$output .= '<td>' . $purchase['auction_date'] . '</td>';
							$output .= '<td>' . $purchase['broker'] . '</td>';
							$output .= '<td>' . $purchase['ware_hse'] . '</td>';
							$output .= '<td>' . $purchase['lot'] . '</td>';
							$output .= '<td>' . $purchase['origin'] . '</td>';
							$output .= '<td>' . $purchase['mark'] . '</td>';
							$output .= '<td>' . $purchase['grade'] . '</td>';
							$output .= '<td>' . $purchase['invoice'] . '</td>';
							$output .= '<td>' . $purchase['pkgs'] . '</td>'; //pkgs
							$output .= '<td>' . $purchase['kgs'] . '</td>'; //net
							$output .= '<td>' . $purchase['net'] . '</td>'; //kgs
							$output .= '<td>' . $hammerPrice . '</td>'; //auction hammer
							$output .= '<td>' . $value . '</td>'; //value ex auction
							$output .= '<td>' . $brokerage . '</td>'; // brokerage fee
							$output .= '<td>' . $totalAmount . '</td>'; //final prompt value
							$output .= '<td>' . (5 / 100) * $brokerage . '</td>';
							$output .= '<td>' . $afterTax . '</td>';
							$output .= '<td>' . $totalPayable . '</td>';
							$output .= '<td>' . $totalPayable * $purchase['net'] . '</td>';
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
							$output .= '<td><b>' . $totalLots . '</b></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td></td>';
							$output .= '<td><b>' . $totalPkgs . '</b></td>'; //pkgs
							$output .= '<td><b>' . round($totalNet / $totalLots) . '</b></td>'; //kgs
							$output .= '<td><b>' . $totalKgs . '</b></td>'; //net
							$output .= '<td><b>' . $totalHammer . '</b></td>'; //auction hammer
							$output .= '<td><b>' . $totalValue . '</b></td>'; //value ex auction
							$output .= '<td><b>' . $totalBrokerage . '</b></td>'; // brokerage fee
							$output .= '<td><b>' . $totalAmount . '</b></td>'; //final prompt value
							$output .= '<td><b>' . $totalbrokerage . '</b></td>';
							$output .= '<td><b>' . $totalAfterTax . '</b></td>';
							$output .= '<td><b>' . $totalpayable . '</b></td>';
							$output .= '<td><b>' . $totalPayableStock . '</b></td>';

			$output .= '</tr>
						</tfooter>
				</table>';
      		echo $output;	
		}else{
			echo '<h3 class="text-center mt-5">There are no pending lots on the purchase list</h3>';
		}

	}
	if(isset($_POST['action']) && $_POST['action'] == "approve-purchaselist"){
		$saleno = $_POST['saleno'];
		$finance->postToStock($saleno);
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
	// View record
	if (isset($_POST['action']) && $_POST['action'] == "view-invoices") {
		$output = "";
		$invoice_no = isset($_POST['invoiceno']) ? $_POST['invoiceno'] : '';
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$invoices = $finance->fetchInvoices($type, $invoice_no);
		if($invoice_no ==''){
			if (count($invoices) > 0) {
				$output .="<table id='grid' class='table table-striped table-bordered table-hover thead-dark table-sm'>
						<thead class='thead-dark'>
							<tr>
							<th>Invoice No</th>
							<th>Buyer</th>
							<th>Consignee</th>
							<th>Category</th>
							<th>Port Of Delivery</th>
							<th>Buyer Bank</th>
							<th>Pay Bank</th>
							<th>Payment Details</th>
							<th>Date</th>
							<th>Actions</th>
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
						<td>".$invoice['buyer_bank']."</td>
						<td>".$invoice['pay_bank']."</td>
						<td>".$invoice['pay_details']."</td>
						<td>".$invoice['date_captured']."</td>
						<td>

							<a class='printInvoice' onlick='printReport(this)' style='color:red' data-toggle='tooltip' data-placement='bottom' title='Remove Tea' >
					  		<i class='fa fa-file' ></i></a>&nbsp&nbsp&nbsp;
							</td>
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
	}
	if(isset($_POST['action']) && $_POST['action'] == 'load-unallocated'){

		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$mark = isset($_POST['mark']) ? $_POST['mark'] : '';
		$lot = isset($_POST['lot']) ? $_POST['lot'] : '';
		$grade = isset($_POST['grade']) ? $_POST['grade'] : '';
		$saleno = isset($_POST['saleno']) ? $_POST['saleno'] : '';
	  
		
		$condition=" WHERE pkgs>0 ";
		if($mark=='' && $grade == '' && $lot == '' && $saleno == ''){
		  $condition = $condition;
		}else{
		  if($saleno !=null){
			$condition.=" AND closing_stock.sale_no = '".$saleno."'";
		  }if($mark !=null){
			$condition.=" AND closing_stock.mark = '".$mark."'";
		  }if($grade !=null){
			$condition.=" AND closing_stock.grade = '".$grade."'";
		  }if($lot !=null){
			$condition.=" AND closing_stock.lot = '".$lot."'";
		  }
		}
		$blendBalance = 0;
		$output ="";
		$stockList = $stockCtrl->readStock("", $condition);
		if (sizeOf($stockList)> 0) {
			$output .='
			<table id="direct_lot" class="table table-striped table-bordered table-sm">
			<thead>
				<tr>
					<th class="col-sm-2">Sale No</th>
					<th class="wd-15p">Lot</th>
					<th class="wd-15p">Mark</th>
					<th class="wd-10p">Grade</th>
					<th class="wd-25p">Invoice</th>
					<th class="wd-25p">Code</th>
					<th class="wd-25p">Pkgs</th>
					<th class="wd-25p">Net</th>
					<th class="wd-25p">Kgs</th>
					<th class="wd-25p">Actions</th>
	  
				</tr>
			</thead>
			<tbody>';
			foreach ($stockList as $stock) {
				$output.='<tr>';
					$output.='<td>'.$stock["sale_no"].'</td>';
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
					  <i class="fa fa-check" ></i></a>&nbsp&nbsp&nbsp;
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
	  }else{
	  }
	
	  if(isset($_POST['action']) && $_POST['action'] == "load-allocated"){	
		$id = isset($_POST['invoiceid']) ? $_POST['invoiceid'] : '';
		$invoiceno = $finance->getInvoiceNo($id);
		$condition = " WHERE closing_stock.profoma_invoice_no = '$invoiceno'";
		$stockList = $stockCtrl->readStock("", $condition);
		if (sizeOf($stockList)> 0) {
			$output .='
			<table id="direct_lot" class="table table-striped table-bordered table-sm">
			<thead>
				<tr>
					<th class="col-sm-2">Sale No</th>
					<th class="wd-15p">Lot</th>
					<th class="wd-15p">Mark</th>
					<th class="wd-10p">Grade</th>
					<th class="wd-25p">Invoice</th>
					<th class="wd-25p">Code</th>
					<th class="wd-25p">Pkgs</th>
					<th class="wd-25p">Net</th>
					<th class="wd-25p">Kgs</th>
					<th class="wd-25p">Actions</th>
	  
				</tr>
			</thead>
			<tbody>';
			foreach ($stockList as $stock) {
				$output.='<tr>';
					$output.='<td>'.$stock["sale_no"].'</td>';
					$output.='<td>'.$stock["lot"].'</td>';
					$output.='<td>'.$stock["mark"].'</td>';
					$output.='<td>'.$stock["grade"].'</td>';
					$output.='<td>'.$stock["invoice"].'</td>';
					$output.='<td>'.$stock["comment"].'</td>';
					$output.='<td>'.$stock["pkgs"].'</td>';
					$output.='<td>'.$stock["net"].'</td>';
					$output.='<td>'.$stock["kgs"].'</td>';
					if($stock["profoma_invoice_no"] != null){
					  $output.='<td>
					  <a class="removeTea" id="'.$stock["stock_id"].'" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Remove Tea" >
					  <i class="fa fa-close" ></i></a>&nbsp&nbsp&nbsp;
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
		$invoiceno = $finance->getInvoiceNo($invoiceid);
		$finance->invoiceTea($stockid, $invoiceno);
	}
	if(isset($_POST['action']) && $_POST['action'] == "remove-invoice"){	
		$stockid = isset($_POST['stockid']) ? $_POST['stockid'] : '';
		$finance->removeInvoiceTea($stockid);
	}

	