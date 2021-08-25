<?php
	$path_to_root = '../../';
    include_once($path_to_root.'/models/Model.php');
    include_once($path_to_root.'/database/page_init.php');

	include ($path_to_root.'controllers/CatalogController.php');

	$CatalogController = new Catalogue($conn);

	if(isset($_POST['action']) && $_POST['action'] == "list-buying"){
		$sale_no = isset($_POST['saleno']) ? $_POST['saleno'] : '';
		$catalogs= $CatalogController->buyingSummary($sale_no);
		$output = '';
		if(count($catalogs)>0){
			$output .= '
			<table id="buyingListTable" class="table table-bordered table-striped table-hover table-sm">
			<thead class="table-primary">
				<tr>
					<th>Auction</th>
					<th>Broker</th>
					<th>Lot</th>
                    <th>Sale Price</th>
					<th>Mark</th>
					<th>Net</th>
					<th>Kgs</th>
					<th>Pkgs</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>';
			foreach($catalogs as $catalog){
				$output .= '<tr>';
					$output .= '<td>'.$catalog['sale_no'].'</td>';
					$output .= '<td>'.$catalog['broker'].'</td>';
					$output .= '<td>'.$catalog['lot'].'</td>';
					$output .= '<td>'.$catalog['sale_price'].'</td>';
					$output .= '<td>'.$catalog['mark'].'</td>';
					$output .= '<td>'.$catalog['net'].'</td>';
					$output .= '<td>'.$catalog['pkgs'].'</td>';
					$output .= '<td>'.$catalog['kgs'].'</td>';
					if(($catalog["added_to_plist"]==0) && ($catalog["confirmed"]==0)){
						$output.='
						<td>
							<a class="confirmLot" id="'.$catalog["lot"].'" style="color:green" data-toggle="tooltip" data-placement="bottom" title="Confirm Lot" >
							<i class="fa fa-check-circle-o" >Confirm</i></a>
						</td>';
					}else if(($catalog["added_to_plist"]==1) && ($catalog["confirmed"]==0)){
						$output.='
						<td>
							<a class="unconfirmLot" id="'.$catalog["lot"].'" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Remove" >
							<i class="fa fa-times-circle-o" >Remove</i></a>
						</td>';
					}else{
						$output.='
						<td>
							<a style="color:green" data-toggle="tooltip" data-placement="bottom" title="Confirmed" >
							<i class="fa fa-check" ></i>Confirmed</a>
						</td>';
					}
					'</tr>';
			}
			$output .= '</tbody>
					</table>';

		}else{
			$output.= "<p>You don't have any Buying For this Sale</p>";
		}
		echo $output;

	}
	if(isset($_POST['action']) && $_POST['action'] == "get-max-saleno"){
		$saleno= $CatalogController->getMaxSaleNo();
		echo json_encode(array("sale_no"=>$saleno));

	}
	if(isset($_POST['action']) && $_POST['action'] == "post-buyinglist"){
		$saleno = isset($_POST['saleno']) ? $_POST['saleno'] : '';
		$approved = $CatalogController->postBuyingList($saleno);
		echo json_encode(array("status"=>"Purchases In the List Have Been Confirmed And forwarded to Finance"));
	}
	if(isset($_POST['action']) && $_POST['action'] == "confirm-valuation"){
		$saleno = isset($_POST['saleno']) ? $_POST['saleno'] : '';
		$userid = isset($_POST['userid']) ? $_POST['userid'] : '';

		$CatalogController->importValuationCatalogue($saleno, $userid);
		echo json_encode(array("status"=>"Confirmed"));
	}
	if(isset($_POST['action']) && $_POST['action'] == "confirm-post"){
		$saleno = isset($_POST['saleno']) ? $_POST['saleno'] : '';
		$userid = isset($_POST['userid']) ? $_POST['userid'] : '';

		$CatalogController->postCatalogueProcess($saleno, $userid);
		echo json_encode(array("status"=>"Confirmed"));
	}
	if(isset($_POST['action']) && $_POST['action'] == "add-lot"){
		$lot = $_POST['lot'];
		$CatalogController->confirmToPurchaseList($lot, 1, 0);
	}
	if(isset($_POST['action']) && $_POST['action'] == "remove-lot"){
		$lot = $_POST['lot'];

		$CatalogController->confirmToPurchaseList($lot, 0, 0);
	}
	
	
	
	
?>

