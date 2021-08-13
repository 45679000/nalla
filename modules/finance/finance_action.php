<?php
	header("Access-Control-Allow-Origin: *");
    include_once('../../models/Model.php');
	require "../../vendor/autoload.php";
    include_once('../../database/page_init.php');
    include '../../controllers/FinanceController.php';
    
    $db = new Database();
    $conn = $db->getConnection();
    $finance = new Finance($conn);

	// Insert Record	
	if (isset($_POST['action']) && $_POST['action'] == "unconfirmed-purchase-list") {
		$saleno = $_POST['saleno'];
		$finance->saleno=$saleno;
		$purchases = $finance->readPurchaseList();

		if (sizeOf($purchases) > 0) {
			$output .='<table id="purchaseListTable" class="table table-striped table-hover">
			        <thead>
					<tr>
						<th class="wd-15p">Sale No</th>
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
									<button  onClick="addLot(this)" class="add" name="lot" id="'.$purchase["lot"].'">Add</button>
								</td>';
							}else{
								$output.='
								<td>
									<button  onClick="removeLot(this)" class="remove" name="lot" id="'.$purchase["lot"].'">Remove</button>
								</td>';
							}
						
						$output.='</tr>';
					}
					
			$output.= '
			</tbody>';
			$output.='<tfooter style="outline: thin solid black;">
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
		</tfooter>;

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
		$totalKgs = 0;
		$totalLots = 0;

		if (sizeOf($purchases) > 0) {
			

			$output .='<table  id="purchaseListTable" class="table table-striped table-hover">
			        <thead>
						<th class="wd-15p">Sale No</th>
						<th class="wd-15p">Broker</th>
						<th class="wd-15p">Lot No</th>
						<th class="wd-15p">Ware Hse.</th>
						<th class="wd-20p">Company</th>
						<th class="wd-15p">Mark</th>
						<th class="wd-10p">Grade</th>
						<th class="wd-25p">Garden Invoice</th>
						<th class="wd-25p">BrokerInvoice</th>
						<th class="wd-25p">Pkgs</th>
						<th class="wd-25p">Net</th>
						<th class="wd-25p">Kgs</th>
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
							$output.='<td>'.$purchase["invoice"].'</td>';
							$output.='<td onBlur=updateInvoice(this) class="'.$id.'" contentEditable = "true">'.$purchase["broker_invoice"].'</td>';
							$output.='<td onBlur=updatePkgs(this) class="'.$id.'" contentEditable = "true">'.$purchase["pkgs"].'</td>';
							$output.='<td onBlur=updateKgs(this) class="'.$id.'" contentEditable = "true">'.$purchase["kgs"].'</td>';
							$output.='<td onBlur=updateNet(this) class="'.$id.'" contentEditable = "true">'.$purchase["net"].'</td>';
						
						$output.='</tr>';
					}
					
			$output.= '
			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>'.$totalPkgs.'</td>
					<td></td>
					<td>'.$totalKgs.'</td>
				</tr>
			</tfoot>
				</table>
				<div style="text-align:center;">
						<button onClick="postToStock(this)" style="" type="submit" id="confirm" name="confirm" value="1">Post to Departments</button>
				</div>';
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
	

	

	

