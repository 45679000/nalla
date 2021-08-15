<?php
	header("Access-Control-Allow-Origin: *");
    include_once('../../models/Model.php');
	require "../../vendor/autoload.php";
    include_once('../../database/page_init.php');
    include '../../controllers/FinanceController.php';
	include '../../controllers/WorkFlow.php';

    $db = new Database();
    $conn = $db->getConnection();
    $finance = new Finance($conn);
	$workFlow = new WorkFlow($conn);
	// Insert Record	
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
						$auctionHammer = round(($purchase['sale_price'] / $purchase['kgs']), 2);
						$addon = 0;
						$totalPayable = round($addon + $auctionHammer, 2);
						$hammerPrice = round(floatval($purchase['sale_price']) / $purchase['kgs'], 2);

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
	if(isset($_POST['action']) && $_POST['action'] == "save-invoice"){	
		$finance->saveInvoice($_POST);	
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
	

	

	

