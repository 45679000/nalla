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
	if(isset($_POST['action']) && $_POST['action'] == "confirm-preauction"){
		$saleno = isset($_POST['saleno']) ? $_POST['saleno'] : '';
		$userid = isset($_POST['userid']) ? $_POST['userid'] : '';
		$broker = isset($_POST['broker']) ? $_POST['broker'] : '';

		$CatalogController->saleno = $saleno;
		$CatalogController->user_id = $userid;
		$CatalogController->broker = $broker;

		$CatalogController->confirmCatalogue();
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
	if(isset($_POST['action']) && $_POST['action'] == "view-catalog"){

		$saleno = isset($_POST['saleno']) ? $_POST['saleno'] : '';
		$broker = isset($_POST['broker']) ? $_POST['broker'] : '';
		$category = isset($_POST['category']) ? $_POST['category'] : '';
		$imports = $CatalogController->closingCatalogue($saleno, $broker , $category);
		$html = "";
		if(sizeOf($imports)>0){
			$html='<table id="closingimports" class="table table-striped table-bordered" style="width:100%">
										<thead>
											<tr>
												<th class="wd-15p">Sale No</th>
												<th class="wd-15p">Lot No</th>
												<th class="wd-15p">Broker</th>
												<th class="wd-15p">Ware Hse.</th>
												<th class="wd-20p">Company</th>
												<th class="wd-15p">Mark</th>
												<th class="wd-10p">Grade</th>
                                                <th class="wd-25p">Invoice</th>
                                                <th class="wd-25p">Type</th>
                                                <th class="wd-25p">Pkgs</th>
                                                <th class="wd-25p">Net</th>
                                                <th class="wd-25p">Kgs</th>
                                                <th class="wd-25p">Value</th>
												<th>Max/low</th>
                                                <th class="wd-25p">Sale Price</th>
                                                <th class="wd-25p">Buyer Package</th>

											</tr>
										</thead>
                                        <tbody>';
                                        foreach ($imports as $import){
											$maxlow = $CatalogController->maxLow(trim($import['mark']), trim($import['grade']), trim($import['sale_no']));
                                            $html.='<tr>';
												$html.='<td>'.$import["sale_no"].'</td>';
                                                $html.='<td>'.$import["lot"].'</td>';
												$html.='<td>'.$import["broker"].'</td>';
                                                $html.='<td>'.$import["ware_hse"].'</td>';
                                                $html.='<td>'.$import["company"].'</td>';
                                                $html.='<td>'.$import["mark"].'</td>';
                                                $html.='<td>'.$import["grade"].'</td>';
                                                $html.='<td>'.$import["invoice"].'</td>';
                                                $html.='<td>'.$import["type"].'</td>';
                                                $html.='<td>'.$import["pkgs"].'</td>';
                                                $html.='<td>'.$import["kgs"].'</td>';
                                                $html.='<td>'.$import["net"].'</td>';
                                                $html.='<td>'.$import["value"].'</td>';
												$html.='<td><span style = "color:red">'.$maxlow['max'].' / </span>'
												.'<span style = "color:green">'.$maxlow['low'].'</span>'
												.$maxlow['max'].'</td>';
                                                $html.='<td>'.$import["sale_price"].'</td>';
                                                $html.='<td>'.$import["buyer_package"].'</td>';
											$html.='</tr>';
                                        }
                                $html.= '</tbody>
                        </table>';
		}else{
			$html = "<h3>The selection Does not seem to have any Records</h3>";
		}
						
		echo $html;

	}

	if(isset($_POST['action']) && $_POST['action'] == "view-labels"){
		$saleno = isset($_POST['saleno']) ? $_POST['saleno'] : '';
		$broker = isset($_POST['broker']) ? $_POST['broker'] : '';
		$category = isset($_POST['category']) ? $_POST['category'] : '';
		$imports = $CatalogController->closingCatalogue($saleno, $broker , $category);
		$html = "";
		if(sizeOf($imports)>0){
			$html='<table id="tasting" class="table table-striped table-bordered" style="width:100%">
										<thead>
											<tr>
												<th class="wd-15p">Lot No</th>
												<th class="wd-15p">Sale No</th>
												<th class="wd-15p">Broker</th>
												<th class="wd-15p">Ware Hse.</th>
												<th class="wd-20p">Company</th>
												<th class="wd-15p">Mark</th>
												<th class="wd-10p">Grade</th>
                                                <th class="wd-25p">Invoice</th>
                                                <th class="wd-25p">Type</th>
                                                <th class="wd-25p">Pkgs</th>
                                                <th class="wd-25p">Net</th>
                                                <th class="wd-25p">Kgs</th>
                                                <th class="wd-25p">Value</th>
                                                <th class="wd-25p">SELECT</th>

											</tr>
										</thead>
                                        <tbody>';
                                        foreach ($imports as $import){
											$id = $import["closing_cat_import_id"];
                                            $html.='<tr>';
                                                $html.='<td>'.$import["lot"].'</td>';
												$html.='<td>'.$import["sale_no"].'</td>';
												$html.='<td>'.$import["broker"].'</td>';
                                                $html.='<td>'.$import["ware_hse"].'</td>';
                                                $html.='<td>'.$import["company"].'</td>';
                                                $html.='<td>'.$import["mark"].'</td>';
                                                $html.='<td>'.$import["grade"].'</td>';
                                                $html.='<td>'.$import["invoice"].'</td>';
                                                $html.='<td>'.$import["type"].'</td>';
                                                $html.='<td>'.$import["pkgs"].'</td>';
                                                $html.='<td>'.$import["kgs"].'</td>';
                                                $html.='<td>'.$import["net"].'</td>';
                                                $html.='<td>'.$import["value"].'</td>';
												if($import["allocated"]==0){
													$html.='<td><input id="'.$id.'" type="checkbox" class="unallocated" name="unallocated" value="0"></td>';
												}else{
													$html.='<td><input id="'.$id.'" type="checkbox" class="allocated" name="allocated" value="1" checked></td>';
												}
											$html.='</tr>';
                                        }
                                $html.= '</tbody>
                        </table>';
		}else{
			$html = "<h3>The selection Does not seem to have any Records</h3>";
		}
						
		echo $html;

	}
	if(isset($_POST['action']) && $_POST['action'] == "offer"){
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$columnValue = isset($_POST['columnValue']) ? $_POST['columnValue'] : '';
		
		$CatalogController->Offers($columnValue, $id);

	}
	if(isset($_POST['action']) && $_POST['action'] == "clear-selected"){
		$saleno = isset($_POST['saleno']) ? $_POST['saleno'] : '';
		
		$CatalogController->ClearOffers($saleno);

	}


	
	
?>

