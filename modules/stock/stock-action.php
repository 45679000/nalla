<?php
	header("Access-Control-Allow-Origin: *");
    include_once('../../models/Model.php');
	include ('../grading/grading.php');
	require "../../vendor/autoload.php";
    include_once('../../database/page_init.php');
    include '../../controllers/StockController.php';
	include ('../../controllers/GradingController.php');    

    
    $db = new Database();
    $conn = $db->getConnection();
    $stock = new Stock($conn);
	$gradingController = new GradingController($conn);

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

    if (isset($_POST['action']) && $_POST['action'] == "update") {

		$name = $_POST['name'];
		$country = $_POST['country'];
        $id = $_POST['id'];
		$garden->updateRecord($id, $name,  $country);
	}
    	// Delete Record	
	if (isset($_POST['action']) && $_POST['action'] == "allocate-stock") {
		$stock_id = isset($_POST['stockId']) ? $_POST['stockId'] : '';
		$fieldValue = isset($_POST['fieldValue']) ? $_POST['fieldValue'] : '';
		$fieldName = isset($_POST['fieldName']) ? $_POST['fieldName'] : '';
		$stock->allocateStock($stock_id, $fieldName, $fieldValue);

	}
	if (isset($_POST['action']) && $_POST['action'] == "stock-allocation") {
		$type = $_POST['type'];
		$allocatedStock =  $stock->allocatedStock($type);
		$clients =  $stock->clients();
		$gradingCodes = $gradingController->loadCodes();
        $gradingStandards = $gradingController->loadStandards();
		$html ="";
		if(sizeOf($allocatedStock)>0){
			$html.='<table id="allocatedStockTable" class="table table-sm table-responsive table-striped table-bordered">
										<thead>
											<tr>
												<th>Line No</th>
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
												<th>Hammer Price</th>
												<th>WHSE</th>
												<th>Code</th>
												<th class="wd-25p">Standard</th>
                                                <th class="wd-25p">Buyer</th>
                                                <th class="wd-25p">Action</th>

											</tr>
										</thead>
                                        <tbody>';
                                        foreach ($allocatedStock as $import){
                                            $id = $import["stock_id"];
											$client_id = $import["client_id"];
											
                                            $html.='<tr>';
												$html.='<td>'.$import["line_no"].'</td>';
												$html.='<td>'.$import["sale_no"].'</td>';
												$html.='<td>'.$import['import_date'].'</td>';
												$html.='<td>'.$import["broker"].'</td>';
                                                $html.='<td>'.$import["ware_hse"].'</td>';
												$html.='<td>'.$import["lot"].'</td>';
                                                $html.='<td>'.$import["country"].'</td>';
                                                $html.='<td>'.$import["mark"].'</td>';
                                                $html.='<td>'.$import["grade"].'</td>';
                                                $html.='<td>'.$import["invoice"].'</td>';
                                                $html.='<td>'.$import["pkgs"].'</td>';
                                                $html.='<td>'.$import["net"].'</td>';
                                                $html.='<td>'.$import["kgs"].'</td>';
												$html.='<td>'.$import["sale_price"].'</td>';
												$html.='<td>'.$import["warehouse"].'</td>';
                                                $html.='
												<td style="width:40vH">
                                                            <select name="comment" id="'.$id.'" onchange="updateStock(this)" class="select2">';
                                                            foreach ($gradingCodes as $code) {
                                                                $html.='<option>'.$import["comment"].'</option>';
                                                                $html.='<option>'.$code['code'].'</option>';
															}
                                                			$html.='</select>
                                                
                                                </td>';
                                                $html.='<td style="width:40vH">
															<select name="standard" id="'.$id.'" onchange="updateStock(this)" class="select2 standard">';
															foreach ($gradingStandards as $standard) {
																$html.='<option>'.$import['standard'].'</option>';
																$html.='<option>'.$standard['standard'].'</option>';
															}
                                                			$html.='</select>
                                                    </td>';
                                                $html.='<td style="width:10vH">
                                                    <select value="'.$client_id.'" name="client_id" id="'.$id.'" onchange="updateStock(this)" class="select2 buyer">';
                                                    foreach ($clients as $client) {
														$debtorid = $client["debtor_no"];
                                                        $html.='<option value="'.$debtorid.'">'.$client['short_name'].'</option>';
                                                    }
                                                        
                                                $html.='</select>
                                                    </td>';
												$html.='<td>
													<a class="splitLot" id="'.$import["stock_id"].'" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Split Lot">
													<i class="fa fa-scissors"></i></a>
												</td>';

											$html.='</tr>';
                                        }
                                $html.= '</tbody>
                        </table>';
		}else{
			$html = "<h3>No Records Returned</h3>";
		}
		echo $html;

	}
	function ExcelToPHP($dateValue = 0) {
		$UNIX_DATE = ($dateValue - 25569) * 86400;
		return gmdate("d-m-Y", $UNIX_DATE);  
	
	}
	if(isset($_POST['action']) && $_POST['action'] == "master-stock"){

		$filters = array();
		$type = $_POST['type'];
		$saleno = isset($_POST['saleno']) ? $_POST['saleno'] : 'All';
		$broker = isset($_POST['broker']) ? $_POST['broker'] : 'All';
		$mark = isset($_POST['mark']) ? $_POST['mark'] : 'All';
		$standard = isset($_POST['standard']) ? $_POST['standard'] : 'All';
		$gradecode = isset($_POST['gradecode']) ? $_POST['gradecode'] : 'All';
		
		$filters['saleno'] = $saleno;
		$filters['broker'] = $broker;
		$filters['mark'] = $mark;
		$filters['standard'] = $standard;
		$filters['gradecode'] = $gradecode;
		switch ($type) {
			case 'purchases':
				$stocks = $stock->readStock($type, $filters);
				break;
			case 'stock':
				$stocks = $stock->readStock($type, $filters);
				break;
			case 'stocka':
				$stocks = $stock->readStock($type, $filters);
				break;
			case 'stocko':
				$stocks = $stock->readStock($type, $filters);
				break;
			case 'stockb':
				$stocks = $stock->readStock($type, $filters);
				break;
			case 'stockup':
				$stocks = $stock->readStock($type, $filters);
				break;
			case 'stockuu':
				$stocks = $stock->readStock($type, $filters);
				break;
			default:
				# code...
				break;
		}
		$output = "";
		if($type =="purchases"){
			if(count($stocks)>0){
		
				$output .= '<table id="closingstocks2" class="table table-striped table-sm  table-bordered table-condensed table-responsive" style="width:100%">
							<thead class="thead-dark">
								<tr>
									<th>Line No</th>
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
									<th>Hammer Price</th>
									<th>Value Ex.Auction</th>
									<th>Code</th>
									<th>WHSE</th>
									<th>Allocation</th>
		
								</tr>
							</thead>
								<tbody>';
									
									foreach ($stocks as $stock){ 
										$net = $stock['net'];
										$hammerPrice = round(floatval($stock['sale_price']), 2);
										$valueExAuct = round($net * $hammerPrice, 2);
		
										$output.='<td>'.$stock['line_no'].'</td>';
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
										$output.='<td>'.$net.'</td>'; //net
										$output.='<td>'.$stock['kgs'].'</td>'; //kgs
										$output.='<td>'.$hammerPrice.'</td>';
										$output.='<td>'.floatval($valueExAuct).'</td>';
										$output.='<td>'.$stock['comment'].'</td>';
										$output.='<td>'.$stock['warehouse'].'</td>';
										$output.='<td>'.$stock['allocation'].'</td>';
		
										$output.='</tr>';
								
									}           
					$output.= '</tbody>';
					$output.='<tfoot style="outline: thin solid black;">
								<tr>
									<th colspan="4">Sub Total <br> Grand Total</th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th colspan="2"></th>
									<th colspan="2"></th>
									<th></th>
									<th colspan="2"></th>
									<th></th>
									<th></th>

								</tr>
							</tfoot>
						</table>';
			}else{
				$output = "No records Found";
		
			}
			echo $output;
		}else{
			if(count($stocks)>0){
				$output .= '<table id="closingstocks" class="display table table-sm  table-striped table-responsive table-bordered" style="width:100%">
				<thead class="thead-dark">
				<tr>
					<th>Line No</th>
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
					<th>Hammer Price</th>
					<th>Value Ex.Auction</th>
					<th>Code</th>
					<th>WHSE</th>
					<th>Allocation</th>
		
				</tr>
			</thead>
				<tbody>';
					
					foreach ($stocks as $stock){ 
						$net = $stock['net'];
						$hammerPrice = round(floatval($stock['sale_price']), 2);
						$valueExAuct = round($net * $hammerPrice, 2);
		
						$output.='<td>'.$stock['line_no'].'</td>';
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
						$output.='<td>'.$net.'</td>'; //net
						$output.='<td>'.$stock['kgs'].'</td>'; //kgs
						$output.='<td>'.$hammerPrice.'</td>';
						$output.='<td>'.floatval($valueExAuct).'</td>';
						$output.='<td>'.$stock['comment'].'</td>';
						$output.='<td>'.$stock['warehouse'].'</td>';
						$output.='<td>'.$stock['allocation'].'</td>';
		
						$output.='</tr>';
				
					}           
		$output.= '</tbody>';
		$output.='<tfoot style="outline: thin solid black;">
							<tr>
								<th colspan="4">Sub Total <br> Grand Total</th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th colspan="2"></th>
								<th colspan="2"></th>
								<th></th>
								<th colspan="2"></th>
								<th></th>
								<th></th>

							</tr>
				</tfoot>
		</table>';
			}else{
				$output = "No records Found";
		
			}
		
			echo $output;
		}
		}
	if(isset($_POST['action']) && $_POST['action'] == "getlot"){
		$id = $_POST["id"];
		$lots = $stock->getLot($id);
		echo json_encode($lots);
		
	}
	if(isset($_POST['action']) && $_POST['action'] == "split"){
		$stockId = isset($_POST['stockId']) ? $_POST['stockId'] : '';
		$Pkgs = isset($_POST['Pkgs']) ? $_POST['Pkgs'] : '';
		$Kgs = isset($_POST['Kgs']) ? $_POST['Kgs'] : '';
		$NewKgs = isset($_POST['NewKgs']) ? $_POST['NewKgs'] : '';
		$NewPkgs = isset($_POST['NewPkgs']) ? $_POST['NewPkgs'] : '';
		$stock->insertSplit($stockId, $Pkgs, $Kgs, $NewKgs, $NewPkgs);

	}
	if(isset($_POST['action']) && $_POST['action'] == "contract-wise"){
		$type = $_POST['type'];
		$allocatedStock =  $stock->contractWiseAllocation();
		$clients =  $stock->clients();
		if (sizeOf($allocatedStock) > 0) {
		$html = "";

		$html .='<table id="allocatedStockTable" class="table table-striped table-bordered table-responsive">
		<thead class="thead-dark">
			<tr>
				<td>Lot</td>
				<td>Sale No</td>
				<td>Broker</td>
				<td>Mark</td>
				<td>Code</td>
				<td>Grade</td>
				<td>Invoice</td>
				<td>Pkgs</td>
				<td>Net</td>
				<td>Kgs</td>
				<td>Hammer.P</td>
				<td>Standard</td>
				<td>Contract No.</td>
			</tr>
		</thead>
		<tbody>';
			$client = "";

			foreach ($allocatedStock as $allocated) {
				$id=$allocated['stock_id'];
				if($client != $allocated['allocation']){
					$client=$allocated['allocation'];
					$html .= '<tr style="background-color:black; border-top:1px black; border-bottom:1px black;">';
					$html .= '<td style="text-align:center; color:white;" colspan="13">'.$client.'</td>';
					$html .= '</tr>';
				}else{
					$html .= '<tr>';
					$html .= '<td>' . $allocated['lot'] . '</td>';
					$html .= '<td>'.  $allocated['sale_no'] . '</td>';
					$html .= '<td>' . $allocated['broker'] . '</td>';
					$html .= '<td>' . $allocated['mark'] . '</td>';
					$html .= '<td>' . $allocated['comment'] . '</td>';
					$html .= '<td>' . $allocated['grade'] . '</td>';
					$html .= '<td>' . $allocated['invoice'] . '</td>';
					$html .= '<td contentEditable="true">' . $allocated['pkgs'] . '</td>';
					$html .= '<td>' . $allocated['net'] . '</td>';
					$html .= '<td>' . $allocated['kgs'] . '</td>';
					$html .= '<td contentEditable="true">' . $allocated['sale_price'] . '</td>';
					$html .= '<td>'. $allocated['standard'] .'</td>';
					$html .= '<td>'.$allocated['allocation'].'</td>';
					$html .= '</tr>';
					$client=$allocated['allocation'];

				}
				
			}

			$html .= '</tbody>
			</table>
		</div>
	</div>';
			echo $html;
		}else{
			echo '<h3 class="text-center mt-5">There are no lots  allocated to any contract</h3>';

		}


	}

	