<?php
	header("Access-Control-Allow-Origin: *");
    include_once('../../models/Model.php');
	include ('../grading/grading.php');
	require "../../vendor/autoload.php";
    include_once('../../database/page_init.php');
    include '../../controllers/StockController.php';
    
    $db = new Database();
    $conn = $db->getConnection();
    $stock = new Stock($conn);

	// Insert Record	
	if (isset($_POST['action']) && $_POST['action'] == "insert") {
		$insertRecord = $stock->addPrivatePurchase($_POST);
		echo json_encode(array("message"=>"Saved Successfully"));
	}

	if(isset($_POST['action']) && $_POST['action'] == "generate-lables"){
		$grading = new Grading($conn);
		$offered = $grading->readOffers();
		print_labels($offered);
		echo json_encode(array("message"=>"Saved Successfully"));

	}
	// View record
	if (isset($_POST['action']) && $_POST['action'] == "purchase-list") {
		$output = "";

		$purchaseList = $stock->unconfrimedPurchaseList();
		if (sizeOf($purchaseList) > 0) {
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
						<th class="wd-25p">Garden Invoice</th>
						<th class="wd-25p">BrokerInvoice</th>
						<th class="wd-25p">Pkgs</th>
						<th class="wd-25p">Net</th>
						<th class="wd-25p">Kgs</th>
					
					</tr>
			        </thead>
			        <tbody>';
					foreach ($purchaseList as $purchase){
						$output.='<tr>';
							$id = $purchase["lot"];
							$output.='<td>'.$purchase["sale_no"].'</td>';
							$output.='<td>'.$purchase["broker"].'</td>';
							$output.='<td>'.$purchase["lot"].'</td>';
							$output.='<td>'.$purchase["ware_hse"].'</td>';
							$output.='<td>'.$purchase["company"].'</td>';
							$output.='<td>'.$purchase["mark"].'</td>';
							$output.='<td>'.$purchase["grade"].'</td>';
							$output.='<td>'.$purchase["invoice"].'</td>';
							$output.='<td contentEditable = "true"></td>';
							$output.='<td id="'.$id.'pkgs" contentEditable = "true">'.$purchase["pkgs"].'</td>';
							$output.='<td id="'.$id.'net" contentEditable = "true">'.$purchase["net"].'</td>';
							$output.='<td id="'.$id.'kgs" contentEditable = "true">'.$purchase["kgs"].'</td>';
							if($purchase["added_to_stock"]==0){
								$output.='
								<td>
									<form method="post">
										<input type="hidden" name="lot" value="'.$purchase["lot"].'"></input>
										<button style="" type="submit" id="allocated" name="add" value="1">add</button>
									</form>
								</td>';
							}else{
								$output.='
								<td>
									<form method="post">
										<input type="hidden" name="lot" value="'.$purchase["lot"].'"></input>
										<button style="" type="submit" id="unallocated" name="add" value="0">remove</button>
									</form>
								</td>';
							}
						
						$output.='</tr>';
					}
					
			$output.= '
			</tbody>
				</table>
				<div style="text-align:center;">
					<form method="post">
						<input type="hidden" name="lot" value="'.$purchase["lot"].'"></input>
						<button style="" type="submit" id="confirm" name="confirm" value="1">Confirm</button>
					</form>
				</div>';
      		echo $output;	
		}else{
			echo '<h3 class="text-center mt-5">There are no pending lots on the purchase list</h3>';
		}
	}

	// Edit Record	
	if ((isset($_POST['action'])) && $_POST['action'] =="stock-list") {


	$stocks = $stock->readStock($condition="WHERE lot IN(SELECT lot FROM closing_stock)");
		$purchaseList = $stock->unconfrimedPurchaseList();
		if (sizeOf($purchaseList) > 0) {
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
						<th class="wd-25p">Invoice</th>
						<th class="wd-25p">Pkgs</th>
						<th class="wd-25p">Type</th>
						<th class="wd-25p">Net</th>
						<th class="wd-25p">Gross</th>
						<th class="wd-25p">Kgs</th>
						<th class="wd-25p">Value</th>
						<th class="wd-25p">Comment</th>
						<th class="wd-25p">Standard</th>
					</tr>
			        </thead>
			        <tbody>';
					foreach ($purchaseList as $purchase){
						$output.='<tr>';
							$output.='<td>'.$purchase["sale_no"].'</td>';
							$output.='<td>'.$purchase["broker"].'</td>';
							$output.='<td>'.$purchase["lot"].'</td>';
							$output.='<td>'.$purchase["ware_hse"].'</td>';
							$output.='<td>'.$purchase["company"].'</td>';
							$output.='<td>'.$purchase["mark"].'</td>';
							$output.='<td>'.$purchase["grade"].'</td>';
							$output.='<td>'.$purchase["invoice"].'</td>';
							$output.='<td>'.$purchase["pkgs"].'</td>';
							$output.='<td>'.$purchase["type"].'</td>';
							$output.='<td>'.$purchase["net"].'</td>';
							$output.='<td>'.$purchase["gross"].'</td>';
							$output.='<td>'.$purchase["kgs"].'</td>';
							$output.='<td>'.$purchase["value"].'</td>';
							$output.='<td>'.$purchase["comment"].'</td>';
							$output.='<td>'.$purchase["standard"].'</td>';
							if($purchase["added_to_stock"]==0){
								$output.='
								<td>
									<form method="post">
										<input type="hidden" name="lot" value="'.$purchase["lot"].'"></input>
										<button style="" type="submit" id="allocated" name="add" value="1">add</button>
									</form>
								</td>';
							}else{
								$output.='
								<td>
									<form method="post">
										<input type="hidden" name="lot" value="'.$purchase["lot"].'"></input>
										<button style="" type="submit" id="unallocated" name="add" value="0">remove</button>
									</form>
								</td>';
							}
						
						$output.='</tr>';
					}
					
			$output.= '
			</tbody>
				</table>
				<div style="text-align:center;">
					<form method="post">
						<input type="hidden" name="lot" value="'.$purchase["lot"].'"></input>
						<button style="" type="submit" id="confirm" name="confirm" value="1">Confirm</button>
					</form>
				</div>';
      		echo $output;	
		}else{
			echo '<h3 class="text-center mt-5">There are no pending lots on the purchase list</h3>';
		}
		
	}

    if (isset($_POST['action']) && $_POST['action'] == "update") {

		$name = $_POST['name'];
		$country = $_POST['country'];
        $id = $_POST['id'];
		$garden->updateRecord($id, $name,  $country);
	}

    	// Delete Record	
	if (isset($_POST['action']) && $_POST['action'] == "allocate-stock") {
		$stock_id = isset($_POST['stock_id']) ? $_POST['stock_id'] : '';
		$buyer = isset($_POST['client']) ? $_POST['client'] : '';
		$standard = isset($_POST['standard']) ? $_POST['standard'] : '';
		$pkgs = isset($_POST['pkgs']) ? $_POST['pkgs'] : '';
		$mrpValue = isset($_POST['mrp']) ? $_POST['mrp'] : '';
		$warehouse = isset($_POST['warehouseLocation']) ? $_POST['warehouseLocation'] : '';
		$stock->allocateStock($stock_id, $buyer, $standard, $mrpValue,  $pkgs, $warehouse);
	}
	if (isset($_POST['action']) && $_POST['action'] == "stock-allocation") {
		$allocatedStock =  $stock->allocatedStock();
		$clients =  $stock->clients();

		$html = "";

		$html .='<table id="allocatedStockTable" class="table table-striped table-bordered">
		<thead class="thead-dark">
			<tr>
				<td>Lot</td>
				<td>Sale No</td>
				<td>Broker</td>
				<td>Mark</td>
				<td>Code</td>
				<td>Grade</td>
				<td>Invoice</td>
				<td>Allocated Pkgs</td>
				<td>Net</td>
				<td>Buying Price</td>
				<td>MRP Value</td>
				<td>Client</td>
				<td>Standard</td>
				<td>Actions</td>
			</tr>
		</thead>
		<tbody>';
		
			foreach ($allocatedStock as $allocated) {
				$id=$allocated['allocation_id'];
				$allocations = $allocated['buyerstandard'];

				$html .= '<td>' . $allocated['lot'] . '</td>';
				$html .= '<td><div>' . $allocated['sale_no'] . '</div></td>';
				$html .= '<td>' . $allocated['broker'] . '</td>';
				$html .= '<td>' . $allocated['mark'] . '</td>';
				$html .= '<td>' . $allocated['comment'] . '</td>';
				$html .= '<td>' . $allocated['grade'] . '</td>';
				$html .= '<td>' . $allocated['invoice'] . '</td>';
				$html .= '<td contentEditable="true">' . $allocated['allocated_pkgs'] . '</td>';
				$html .= '<td>' . $allocated['net'] . '</td>';
				$html .= '<td>' . $allocated['sale_price'] . '</td>';
				$html .= '<td contentEditable="true">' . $allocated['mrp_value'] . '</td>'; //auction hammer
				$html .= '<td>'. $allocated['debtor_ref'] .'</td>';
				$html .= '<td>'. $allocated['standard'] .'</td>';
				$html .= '<td>
                         <button  style="color:green" 
                          class="navigate" id="'.$id.'"><i class="fa fa-plus">Allocate</i> </button>&nbsp;
			            </td>';
				$html .= '</tr>';
			}

			$html .= '</tbody>
			</table>
		</div>
	</div>';
			echo $html;

	}
	function ExcelToPHP($dateValue = 0) {
		$UNIX_DATE = ($dateValue - 25569) * 86400;
		return gmdate("d-m-Y", $UNIX_DATE);  
	
	}
	if(isset($_POST['action']) && $_POST['action'] == "master-stock"){
		$type = $_POST['type'];
		$condition = "WHERE 1";
		switch ($type) {
			case 'purchases':
				$stocks = $stock->readStock($type, $condition);
				break;
			case 'stock':
				$stocks = $stock->readStock($type, $condition);
				break;
			case 'stocka':
				$stocks = $stock->readStock($type, $condition);
				break;
			case 'stocko':
				$stocks = $stock->readStock($type, $condition);
				break;
			case 'stockb':
				$stocks = $stock->readStock($type, $condition);
				break;
			case 'stockup':
				$stocks = $stock->readStock($type, $condition);
				break;
			case 'stockuu':
				$stocks = $stock->readStock($type, $condition);
				break;
			default:
				# code...
				break;
		}
		$output = "";
		if($type =="purchases"){
			if(count($stocks)>0){

				$output .= '<table id="closingstocks" class="table table-striped table-bordered" style="width:80%">
							<thead class="thead-dark">
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
									<th>Code</th>
									<th>WHSE</th>
									<th>Allocation</th>

								</tr>
							</thead>
								<tbody>';
									$totalPkgs = $stock->sumTotal("pkgs","closing_cat");
									$totalKgs = $stock->sumTotal("kgs", "closing_cat");
									$totalNet = $stock->sumTotal("net", "closing_cat");
									foreach ($stocks as $stock){ 
										$output.='<td>'.$stock['sale_no'].'</td>';
										$output.='<td>'.$stock['import_date'].'</td>';
										$output.='<td>'.$stock['broker'].'</td>';
										$output.='<td>'.$stock['ware_hse'].'</td>';
										$output.='<td>'.$stock['lot'].'</td>';
										$output.='<td>'.$stock['country'].'</td>';
										$output.='<td>'.$stock['mark'].'</td>';
										$output.='<td>'.$stock['grade'].'</td>';
										$output.='<td>'.$stock['invoice'].'</td>'; 
										$output.='<td>'.$stock['pkgs'].'</td>'; //pkgs
										$output.='<td>'.$stock['net'].'</td>'; //net
										$output.='<td>'.$stock['kgs'].'</td>'; //kgs
										$output.='<td>'.$stock['comment'].'</td>';
										$output.='<td>'.$stock['warehouse'].'</td>';
										$output.='<td>'.$stock['allocation'].'</td>';

										$output.='</tr>';
								
									}           
					$output.= '</tbody>';
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
									<td>'.$totalPkgs.'</td>
									<td>'.$totalNet.'</td>
									<td>'.$totalKgs.'</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>

								</tr>
							</tfooter>
						</table>';
			}else{
				$output = "No records Found";

			}
			echo $output;
		}else{
			if(count($stocks)>0){
				$output .= '<table id="closingstocks" class="table table-striped table-bordered" style="width:80%">
							<thead class="thead-dark">
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
									<th>Code</th>
									<th>WHSE</th>
									<th>Allocation</th>

								</tr>
							</thead>
								<tbody>';
									$totalPkgs = $stock->sumTotal("allocated_pkgs","stock_allocation");
									$totalKgs = $stock->sumTotal("kgs", "closing_stock");
									$totalNet = $stock->sumTotal("net", "closing_stock");
									foreach ($stocks as $stock){ 
										$output.='<td>'.$stock['sale_no'].'</td>';
										$output.='<td>'.$stock['import_date'].'</td>';
										$output.='<td>'.$stock['broker'].'</td>';
										$output.='<td>'.$stock['ware_hse'].'</td>';
										$output.='<td>'.$stock['lot'].'</td>';
										$output.='<td>'.$stock['country'].'</td>';
										$output.='<td>'.$stock['mark'].'</td>';
										$output.='<td>'.$stock['grade'].'</td>';
										$output.='<td>'.$stock['invoice'].'</td>'; 
										$output.='<td>'.$stock['pkgs'].'</td>'; //pkgs
										$output.='<td>'.$stock['net'].'</td>'; //net
										$output.='<td>'.$stock['kgs'].'</td>'; //kgs
										$output.='<td>'.$stock['comment'].'</td>';
										$output.='<td>'.$stock['warehouse'].'</td>';
										$output.='<td>'.$stock['allocation'].'</td>';

										$output.='</tr>';
								
									}           
					$output.= '</tbody>';
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
									<td>'.$totalPkgs.'</td>
									<td>'.$totalNet.'</td>
									<td>'.$totalKgs.'</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>

								</tr>
							</tfooter>
						</table>';
			}else{
				$output = "No records Found";

			}
			echo $output;
		}
	}
