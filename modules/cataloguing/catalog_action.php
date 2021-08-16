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
                    <th>Lots</th>
					<th>Kgs</th>
					<th>Pkgs</th>
				</tr>
			</thead>
			<tbody>';
			foreach($catalogs as $catalog){
				$output .= '<tr>';
					$output .= '<td>'.$catalog['sale_no'].'</td>';
					$output .= '<td>'.$catalog['broker'].'</td>';
					$output .= '<td>'.$catalog['totalLots'].'</td>';
					$output .= '<td>'.$catalog['totalKgs'].'</td>';
					$output .= '<td>'.$catalog['totalPkgs'].'</td>';
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
		echo json_encode(array("status"=>"Buying list sent"));
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
	
	
	
	
?>

