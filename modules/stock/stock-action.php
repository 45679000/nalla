<?php
	header("Access-Control-Allow-Origin: *");
    include_once('../../models/Model.php');
	include ('../grading/grading.php');
	require "../../vendor/autoload.php";
    include_once('../../database/page_init.php');
    include 'Stock.php';
    
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

	// Edit Record	
	if (isset($_POST['editId'])) {
		$editId = $_POST['editId'];
		$row = $garden->getRecordById($editId);
		echo json_encode($row);
	}

    if (isset($_POST['action']) && $_POST['action'] == "update") {

		$name = $_POST['name'];
		$country = $_POST['country'];
        $id = $_POST['id'];
		$garden->updateRecord($id, $name,  $country);
	}

    	// Delete Record	
	if (isset($_POST['deleteId'])) {
		$deleteId = $_POST['deleteId'];
		$row = $garden->delete($deleteId);
		echo json_encode(array("msg"=>"Record Deleted Successfully"));
	}
	function print_labels($offered){


		$tableStart='<table>';
		$cellsOdd = '';
		$cellsEven = '';
		
		$rowsStart = '<tr>';
		$rowsEnd = '</tr>';
		
		$total = sizeof($offered);
			foreach($offered as $offer){
				if($total%3==0){
					$cellsEven.= '
					<td style="padding-left:30px; padding-bottom:30px; padding-top:10px;">
						<table>
							<tr>
								<td><b>SALE:'.$offer['sale_no'].'</b></td>
								<td>DATE: '.ExcelToPHP($offer['manf_date']). '</td> 
							</tr>
							<tr>
								<td>'.$offer['mark'].'</td>
								<td>'.$offer['grade'].'</td>  
							</tr> 
							<tr>
								<td>PKGS: '.$offer['pkgs'].'</td>
								<td><b>LOT#: '.$offer['lot'].'</b></td>
							</tr>
							<tr>
								<td>WGHT:<b>'.$offer['net'].'</b></td>
								<td>Invoice:<b>'.$offer['invoice'].'</b></td>
							</tr>
						</table>
					</td>';
				}else{
					$cellsOdd.= '
					<td style="padding-left:30px; padding-bottom:30px; padding-top:10px;">
							<table>
							<tr>
								<td><b>SALE:'.$offer['sale_no'].'</b></td>
								<td>DATE: '.ExcelToPHP($offer['manf_date']). '</td> 
							</tr>
							<tr>
								<td>'.$offer['mark'].'</td>
								<td>'.$offer['grade'].'</td>  
							</tr> 
							<tr>
								<td>PKGS: '.$offer['pkgs'].'</td>
								<td><b>LOT#: '.$offer['lot'].'</b></td>
							</tr>
							<tr>
								<td>WGHT:<b>'.$offer['net'].'</b></td>
								<td>Invoice:<b>'.$offer['invoice'].'</b></td>
							</tr>
						</table>
					</td> 
					';
				}
						
			$total--;
			} 
		$tableEnd ='</table>'; 
		  
		$html = $tableStart;
		$html.= $rowsStart;
		$html .=$cellsOdd;
		$html.= $rowsEnd;
		$html.= $rowsStart;
		$html .=$cellsEven;
		$html.= $rowsEnd;
		$html.=$tableEnd;
	 
		ob_start();//Enables Output Buffering
		$mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 'tempDir' => __DIR__ . '../../reports/files', 	'default_font' => 'dejavusans']);
		$mpdf->WriteHTML($html);
		ob_end_clean();//End Output Buffering
		$mpdf->Output("../../reports/files/labels.pdf", "F");
	
		
	}
	function ExcelToPHP($dateValue = 0) {
		$UNIX_DATE = ($dateValue - 25569) * 86400;
		return gmdate("d-m-Y", $UNIX_DATE);  
	
	}


?>