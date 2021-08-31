<?php
	$path_to_root = '../../';
    include_once($path_to_root.'/models/Model.php');
    include_once($path_to_root.'/database/page_init.php');
	include ($path_to_root.'controllers/GradingController.php');    
    include ($path_to_root.'controllers/CatalogController.php');    


	$gradingController = new GradingController($conn);
	$CatalogController = new Catalogue($conn);

   
	if(isset($_POST['action']) && $_POST['action'] == "grading-codes"){
        $gradingCodes = $gradingController->loadCodes();
            
            $output='<table class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="wd-15p">#</th>
                        <th class="wd-15p">Code</th>
                        <th class="wd-20p">Comment</th>                                        
                    </tr>
                </thead>
                <tbody>';
                $output .="";
                foreach ($gradingCodes as $gradeCode){
                    $output.='<tr>';
                        $output.='<td>'.$gradeCode["id"].'</td>';
                        $output.='<td>'.$gradeCode["code"].'</td>';
                        $output.='<td>'.$gradeCode["description"].'</td>';
                    $output.='</tr>';
                }
            $output.= '</tbody>
                </table>';
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
    if (isset($_POST['action']) && $_POST['action'] == "editPrivate") {
        $id = isset($_POST['editId']) ? $_POST['editId'] : '';
		$row = $gradingController->getPrivatePurchase($id);
        echo json_encode($row);
	}
	if (isset($_POST['action']) && $_POST['action'] == "insert") {
		$insertRecord = $gradingController->addPrivatePurchase($_POST);
		echo json_encode(array("message"=>"Saved Successfully"));
	}
	if(isset($_POST['action']) && $_POST['action'] == "load-private-purchases"){

		$saleno = isset($_POST['saleno']) ? $_POST['saleno'] : '';
		$broker = isset($_POST['broker']) ? $_POST['broker'] : '';
		$category = isset($_POST['category']) ? $_POST['category'] : '';
		$privatePurchases = $gradingController->loadPrivatePurchases($saleno, $broker, $category);
		$output = "";
			$output='<table id="closingprivatePurchases" class="table table-striped table-bordered" style="width:100%">
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
                                                <th class="wd-25p">Sale Price</th>
                                                <th class="wd-25p">Buyer Package</th>
                                                <th class="wd-25p">Actions</th>

											</tr>
										</thead>
                                        <tbody>';
                                        foreach ($privatePurchases as $purchase){
                                            $output.='<tr>';
                                                $id = $purchase["closing_cat_import_id"];
												$output.='<td>'.$purchase["sale_no"].'</td>';
                                                $output.='<td>'.$purchase["lot"].'</td>';
												$output.='<td>'.$purchase["broker"].'</td>';
                                                $output.='<td>'.$purchase["ware_hse"].'</td>';
                                                $output.='<td>'.$purchase["company"].'</td>';
                                                $output.='<td>'.$purchase["mark"].'</td>';
                                                $output.='<td>'.$purchase["grade"].'</td>';
                                                $output.='<td>'.$purchase["invoice"].'</td>';
                                                $output.='<td>'.$purchase["type"].'</td>';
                                                $output.='<td>'.$purchase["pkgs"].'</td>';
                                                $output.='<td>'.$purchase["kgs"].'</td>';
                                                $output.='<td>'.$purchase["net"].'</td>';
                                                $output.='<td>'.$purchase["value"].'</td>';
                                                $output.='<td>'.$purchase["sale_price"].'</td>';
                                                $output.='<td>'.$purchase["buyer_package"].'</td>';
                                                $output.='<td>';
                                                    if($purchase["confirmed"]==0){
                                                        $output.="<i id='$id' class='editBtn fa fa-edit text-success'>Edit</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                        $output.="<i id='$id' class='deleteBtn fa fa-trash text-danger'>Delete</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" ;

                                                    }  
                                                
                                                $output.='</td>';

											$output.='</tr>';
                                        }
                                $output.= '</tbody>
                        </table>';
						
		echo $output;

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
    if(isset($_POST['action']) && $_POST['action'] == "grading-table"){

		$saleno = isset($_POST['saleno']) ? $_POST['saleno'] : '';
		$broker = isset($_POST['broker']) ? $_POST['broker'] : '';
		$category = isset($_POST['category']) ? $_POST['category'] : '';
		$imports = $CatalogController->closingCatalogue($saleno, $broker , $category);
        $gradingCodes = $gradingController->loadCodes();
        $gradingStandards = $gradingController->loadStandards();
        $remarks = $gradingController->loadRemarks();
		$html = "";
		if(sizeOf($imports)>0){
			$html='<table id="closingimports" class="table table-striped table-bordered" style="width:100%">
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
                                                <th class="wd-25p">Net</th>
                                                <th class="wd-25p">Kgs</th>
                                                <th class="wd-25p">Value</th>
												<th>Max/low</th>
                                                <th class="wd-25p">Code</th>
                                                <th class="wd-25p">Standard</th>
                                                <th class="wd-25p">Comments</th>

											</tr>
										</thead>
                                        <tbody>';
                                        foreach ($imports as $import){
                                            $id = $import["closing_cat_import_id"];
											$maxlow = $CatalogController->maxLow(trim($import['mark']), trim($import['grade']), trim($import['sale_no']));
                                            $html.='<tr>';
												$html.='<td>'.$import["sale_no"].'</td>';
												$html.='<td>'.$import["broker"].'</td>';
												$html.='<td>'.$import["lot"].'</td>';
                                                $html.='<td>'.$import["ware_hse"].'</td>';
                                                $html.='<td>'.$import["company"].'</td>';
                                                $html.='<td>'.$import["mark"].'</td>';
                                                $html.='<td>'.$import["grade"].'</td>';
                                                $html.='<td>'.$import["invoice"].'</td>';
                                                $html.='<td>'.$import["pkgs"].'</td>';
                                                $html.='<td>'.$import["kgs"].'</td>';
                                                $html.='<td>'.$import["net"].'</td>';
                                                $html.='<td>'.$import["value"].'</td>';
												$html.='<td><span style = "color:red">'.$maxlow['max'].' / </span>'
												.'<span style = "color:green">'.$maxlow['low'].'</span>'
												.$maxlow['max'].'</td>';
                                                $html.='<td style="width:40vH">
                                                            <select name="comment" id="'.$id.'" onchange="updateValue(this)" class="select2">';
                                                            foreach ($gradingCodes as $code) {
                                                                $html.='<option>'.$import["comment"].'</option>';
                                                                $html.='<option>'.$code['code'].'</option>';
                                                            }
                                                                
                                                $html.='</select>
                                                
                                                </td>';
                                                $html.='<td style="width:40vH">
                                                <div>
                                                    <select name="standard" id="'.$id.'" onchange="updateValue(this)" class="select2 standard">';
                                                    foreach ($gradingStandards as $standard) {
                                                        $html.='<option>'.$import['standard'].'</option>';
                                                        $html.='<option>'.$standard['standard'].'</option>';
                                                    }
                                                        
                                                $html.='</select>
                                                    </div>';
                                                $html.='<td style="width:30vH">
                                                <input name="grading_comment" id="'.$id.'" onchange="updateValue(this)"  value="'.$import['grading_comment'].'" list="remarks" class="remarks">
                                                <datalist id="remarks">';
                                                foreach ($remarks as $remark) {
                                                    $html.='<option>'.$remark['remark'].'</option>';
                                                };
                                                  
                                                $html.='</datalist>                                        
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
	if(isset($_POST['action']) && $_POST['action'] == "update-grading"){
		$value = $_POST['fieldValue'];
        $columnName = $_POST['fieldName'];
        $id = $_POST['fieldKey'];
		$updated = $CatalogController->updateClosingCat($value, $id, $columnName);
        echo json_encode(array("updated"=>$updated));
	}
	if(isset($_POST['action']) && $_POST['action'] == "grading-bids"){

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
                                                <th class="wd-25p">Code</th>
                                                <th class="wd-25p">Standard</th>
                                                <th class="wd-25p">Bid</th>
                                                <th class="wd-25p">Actions</th>

											</tr>
										</thead>
                                        <tbody>';
                                        foreach ($imports as $import){
                                            $id = $import["closing_cat_import_id"];
											$target = $import["target"];
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
                                                $html.='<td style="width:40vH">'.$import["comment"].'</td>';
                                                $html.='<td style="width:40vH">'.$import['standard'].'</div>';
                                                $html.='<td><input style="width:50px" name="max_bp" id="'.$id.'" onchange="updateValue(this)"  value="'.$import['max_bp'].'"></td>';
                                                $html.='<td>';
													if($target==0){
														$html.='<button onclick="bid(this)" id="'.$id.'" name="target" value="1" class="btn btn-success btn-sm">add bid</button>';
													}else{
														$html.='<button onclick="bid(this)" id="'.$id.'" name="target" value="0" class="btn btn-danger btn-sm">remove bid</button>';

													}
												$html.='</td>';

											$html.='</tr>';
                                        }
                                $html.= '</tbody>
                        </table>';
		}else{
			$html = "<h3>No Records Returned</h3>";
		}
		echo $html;

	}
	if (isset($_POST['action']) && $_POST['action'] == "update") {
		$insertRecord = $gradingController->updatePrivatePurchase($_POST);
		echo json_encode(array("message"=>"Saved Successfully"));
	}
	if (isset($_POST['action']) && $_POST['action'] == "delete") {
		$id = $_POST['id'];
		$insertRecord = $gradingController->deletePrivatePurchase($id);
		echo json_encode(array("message"=>"Delete Successfully"));
	}

	
	
	
?>