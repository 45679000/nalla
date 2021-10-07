<?php
	$path_to_root = '../../';
    include_once($path_to_root.'/models/Model.php');
    include_once($path_to_root.'/database/page_init.php');
	include ($path_to_root.'controllers/WarehouseController.php');
	include ($path_to_root.'controllers/BlendingController.php');
	include ($path_to_root.'controllers/ShippingController.php');
	include ($path_to_root.'controllers/StockController.php');

	$stock = new Stock($conn);
	$blendCtrl = new BlendingController($conn);
	$warehouses = new WarehouseController($conn);
	$shippingCtr = new ShippingController($conn);

	if (isset($_POST['action']) && $_POST['action'] == "dashboard-summary-totals") {

		$shipped =  $warehouses->computeTotals("shipped")[0]['totalKgs'];
		$awaitingShipment =  $warehouses->computeTotals("unshipped")[0]['totalKgs'];
		$totalStockKgs = $stock->totalKgs();
		$unclosedBlends = $blendCtrl->totalBlendedTeas("unclosed"); 

		echo json_encode(
			array(
				"shippedKgs"=>$shipped,
				"awaitingShipment"=>$awaitingShipment,
				"kgsInstock"=>$totalStockKgs,
				"unclosedBlends"=>$unclosedBlends
	
		   )
		);
	}
	if(isset($_POST['action']) && $_POST['action'] == "shipments"){
		$shippments= $shippingCtr->unshippedSi();
		$output = "";
		if(count($shippments)>0){
			$output .= '
			<table id="dashboard" class="table table-sm table-hover table-responsive">
			<thead>
				<tr>
					<th>SI</th>
					<th>Buyer</th>
					<th>Consignee</th>
					<th>Destination</th>
					<th>Target Vessel</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>';
			foreach($shippments as $shippment){
				$sino = $shippment['instruction_id'];
				$output .= '<tr>';

					$output .= '<td>'.$shippment['contract_no'].'</td>';
					$output .= '<td>'.$shippment['buyer'].'</td>';
					$output .= '<td>'.$shippment['consignee'].'</td>';
					$output .= '<td>'.$shippment['destination_total_place_of_delivery'].'</td>';
					$output .= '<td>'.$shippment['target_vessel'].'</td>';
					if($shippment['status']!=="Shipped"){
						$output .='
						<td>
							<a id="'.$sino.'" data-toggle="modal" onclick=updateStatus(this) data-target="#updateStatus">
								<i class="fa fa-cogs btn-sm">Update Status</i>
							</a>
						</td>';
					}else{
						$output .='
						<td>
							<a id="'.$sino.'" data-toggle="modal">
								<i class="fa fa-check btn-sm">Shipped</i>
							</a>
						</td>';
					}
					
					$output .='</tr>';
			}
			$output .= '</tbody>
					</table>';

		}else{
			$output.= "<p>You don't have any active Shippments to track</p>";
		}
		echo $output;

	}
	if(isset($_POST['action']) && $_POST['action'] == "update-status"){
		$newStatus = $_POST['value'];
		$sino = $_POST['id'];
		$warehouses->shipmentUpdateStatus($newStatus, $sino);

	}
	if(isset($_POST['action']) && $_POST['action'] == "load-warehouses"){
		$warehouse = $warehouses->getWarehouses();
		$output ="";
		if(count($warehouse)>0){
			$output.='<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Code</th>
							<th>Name</th>
							<th>Location</th>
                            <th>Details</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>';
					foreach($warehouse as $warehouse){
						$output.= '
							<tr>';
								$output.='<td>'.$warehouse['id'].'</td>';
								$output.='<td>'.$warehouse['code'].'</td>';
								$output.='<td>'.$warehouse['name'].'</td>';
								$output.='<td>'.$warehouse['location'].'</td>';
								$output.='<td>'.$warehouse['details'].'</td>';

								$output.='<td>
									<a  class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
									<a  class="deleteBtn"><i class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></a>
								</td>
							</tr>';
					}
		$output.='</tbody>
		</table>';
		echo $output;
		}else{
			echo '<h3 class="text-center mt-5">No records found</h3>';
		}

		
		
	}
	if(isset($_POST['action']) && $_POST['action'] == "add-warehouse"){
		unset($_POST['action']);
		$warehouses->create($_POST);
	}
	if(isset($_POST['action']) && $_POST['action'] == "load-packing-materials"){
		$packingMaterials = $warehouses->getPackingMaterials();
		$output ="";
		if(count($packingMaterials)>0){
	
			
				$output.='<table style="width:100%;" id="packing-materials" class="table table-striped  table-bordered table-sm table-hover">
				<thead>
						<tr>
							<th>ID</th>
							<th>Category</th>
							<th>Totals</th>
                            <th>Details</th>
							<th>Actions</th>

						</tr>
					</thead>
					<tbody>';
					foreach($packingMaterials as $packingMaterial){
						$output.= '
							<tr>';
								$output.='<td>'.$packingMaterial['id'].'</td>';
								$output.='<td>'.$packingMaterial['category'].'</td>';
								$output.='<td>'.$packingMaterial['in_stock'].'</td>';
								$output.='<td>'.$packingMaterial['description'].'</td>';

								$output.='<td class="'.$packingMaterial['category'].'">
									<a id="'.$packingMaterial['id'].'" class="adjust" data-toggle="modal"><i class="fa fa-exchange" data-toggle="tooltip" title="Adjust">Adjust Levels</i></a>
								</td>
							</tr>';
					}
		$output.='</tbody>
		</table>';
		echo $output;
		}else{
			echo '<h3 class="text-center mt-5">No records found</h3>';
		}

	}
	if(isset($_POST['action']) && $_POST['action'] == "shipment"){
		$sino = isset($_POST['sino']) ? $_POST['sino'] : '';
		if($sino !=null){
			$shippments= $shippingCtr->unshippedSi($sino);

		}else{
			$shippments= $shippingCtr->unshippedSi();

		}
		$output = "";
		if(count($shippments)>0){
			$output .= '
			<table id="shippment" class="table table-sm table-responsive table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>SI</th>
					<th>Buyer</th>
					<th>Consignee</th>
					<th>Destination</th>
					<th>Target Vessel</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>';
			foreach($shippments as $shippment){
				$sino = $shippment['instruction_id'];
				$contractno = $shippment['contract_no'];
				$output .= '<tr>';

					$output .= '<td>'.$shippment['contract_no'].'</td>';
					$output .= '<td>'.$shippment['buyer'].'</td>';
					$output .= '<td>'.$shippment['consignee'].'</td>';
					$output .= '<td>'.$shippment['destination_total_place_of_delivery'].'</td>';
					$output .= '<td>'.$shippment['target_vessel'].'</td>';
					
					if($shippment['status']!=="Shipped"){
						$output .='
						<td id="'.$contractno.'">
							<a class="allocatem" id="'.$sino.'">
							<i class="fa fa-plus"></i>
							Allocate Materials</a>
						</td>';
					}else{
						$output .='
						<td>
							<a id="'.$sino.'" data-toggle="modal">
								<i class="fa fa-check btn-sm">Shipped</i>
							</a>
						</td>';
					}
			}
			$output .= '</tbody>
					</table>';

		}else{
			$output.= "<p>You don't have any active Shippments to track</p>";
		}
		echo $output;

	}
	if(isset($_POST['action']) && $_POST['action'] == "load-si-allocation"){

		$allocatedMaterials = $warehouses->materialAllocation($_POST['sino']);
		$output ="";
		if(count($allocatedMaterials)>0){
			$output.='<table id="alloct" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>Material</th>
							<th>Allocated</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>';
					foreach($allocatedMaterials as $allocated){
						$output.= '
							<tr>';
								$output.='<td>'.$allocated['category'].'</td>';
								$output.='<td>'.$allocated['allocated_total'].'</td>';
								$output.='<td>
									<a id="'.$allocated['id'].'" class="deleteBtn"><i class="fa fa-trash btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"></i></a>
								</td>
							</tr>';
					}
		$output.='</tbody>
		</table>';
		echo $output;
		}else{
			echo '<h3 class="text-center mt-5">No materials allocated for this shipment</h3>';
		}

	
	}
	if(isset($_POST['action']) && $_POST['action'] == "load-packing-materials-to-allocate"){
		$packingMaterials = $warehouses->getPackingMaterials();
		$output ="";
		if(count($packingMaterials)>0){
			$output.='<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Category</th>
							<th>IN Stock</th>
                            <th>To Allocate</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>';
					foreach($packingMaterials as $packingMaterial){
						$id = $packingMaterial['id'];
						$selectedId = $id."id";
						$selectedtotal = $id."selected";

						$output.= '
							<tr>';
								$output.='<td id="'.$selectedId.'">'.$packingMaterial['id'].'</td>';
								$output.='<td>'.$packingMaterial['category'].'</td>';
								$output.='<td>'.$packingMaterial['in_stock'].'</td>';
								$output.='<td id="'.$selectedtotal.'" contentEditable="true"></td>';
								$output.='<td>
									<a  id="'.$id.'"  class="allocate">
										<i class="fa fa-plus" data-toggle="tooltip" title="Edit">Add
									</i></a>
								</td>
							</tr>';
					}
		$output.='</tbody>
		</table>';
		echo $output;
		}else{
			echo '<h3 class="text-center mt-5">No records found</h3>';
		}

	}
	if(isset($_POST['action']) && $_POST['action'] == "allocate-material"){
		$materialid = $_POST['material'];
		$sino = $_POST['pk'];
		$totalAllocation = $_POST['value'];

		$warehouses->upadateAllocation($materialid, $sino,  $totalAllocation);
	}
	if(isset($_POST['action']) && $_POST['action'] == "adjust_level"){

		$materialid = $_POST['material'];
		$totalAllocation = $_POST['total'];
		$details = $_POST["details"];

		$warehouses->addjustLevels($materialid, $totalAllocation, $details);
	}

	if(isset($_POST['action']) && $_POST['action'] =='blend-status'){
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$status = 0;
		if($type == "closed"){
			$status = 1;
		}
		$blends = $blendCtrl->fetchBlendByStatus($status);

		$output = "";
			  $blendno = isset($_POST['blendno']) ? $_POST['blendno'] : '';
			  if($blendno ==''){
			  if (count($blends) > 0) {
				  $output .="<table style='width:100% !important;'  class='table table-sm table-responsive table-striped table-bordered table-hover thead-dark'>
						  <thead class='thead-dark'>
							<tr>
							  <th>Blend</th>
							  <th>STD</th>
							  <th>Grade</th>
							  <th>Shippment</th>
							  <th>Blend Input</th>
							  <th>Blend Output</th>
							  <th>Sweepings</th>
							  <th>Cyclone</th>
							  <th>Dust</th>
							  <th>Fiber</th>
							  <th>Polucon</th>
							  <th>Blend Remnant</th>
							  <th>Gain/Loss</th>
							  <th>Actions</th>
							</tr>
						  </thead>
						  <tbody>";
				  foreach ($blends as $blend) {
					$inputKgs = $blendCtrl->totalBlendedPerBlend($blend['id']);
					if($blend['output_kgs'] != null){
						$inputKgs = $blend['output_kgs'];
					}

					  $kgs = $blend['nw']*$blend['Pkgs'];
				  $output.="<tr>
							  <td id='lotEdit'><a href='#' onclick='loadAllocationSummaryForBlends()'>".$blend['contractno']."</a></td>
							  <td>".$blend['blend_no']."</td>
							  <td>".$blend['Grade']."</td>
							  <td class='shippment'>".$kgs."</td>
							  <td class='inputpkgs'>".$inputKgs."</td>
							  <td>".$blend['output_kgs']."</td>
							  <td>".$blend['sweeping']."</td>
							  <td>".$blend['cyclone']."</td>
							  <td>".$blend['dust']."</td>
							  <td>".$blend['fiber']."</td>
							  <td>".$blend['pulucon']."</td>
							  <td>".$blend['blend_remnant']."</td>
							  <td>".$blend['gain_loss']."</td>";

							  $output.="<td>";
								if($status == 1){
									$output.="<span><i class='fa fa-check'></i>
									closed</span>";
								}else{
									$output.="<a style='color:green'  
									class='close' id='".$blend['id']."'><i class='fa fa-cog'></i>
									close</a>";
								}
								
								$output.="</td>
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


	  if(isset($_POST['action']) && $_POST['action'] == "close_blend"){
		  $id = $_POST['blendid'];
		  $output = $_POST['blendOutput'];
		  $shippment = $_POST['blendShipment'];
		  $sweeping = $_POST['Sweeping'];
		  $cyclone = $_POST['Cyclone'];
		  $dust = $_POST['Dust'];
		  $fiber = $_POST['Fiber'];
		  $remnant = $_POST['BlendRemnant'];
		  $gain_loss = $_POST['GainLoss'];
		  $pulucon = $_POST['pulucon'];;
			$warehouses->closeBlend($id, $output, $sweeping, $cyclone, $dust, $fiber, $remnant, $gain_loss, $pulucon);

		$blendDetails = $blendCtrl->fetchBlends($id);

		$fullPkgs = intdiv($blendDetails[0]['blend_remnant'], $blendDetails[0]['nw']);
		$remainder = $blendDetails[0]['blend_remnant']%$blendDetails[0]['nw'];
		$standard = $blendDetails[0]['std_name'];
		$lot = $blendDetails[0]['std_name']."/".$blendDetails[0]['blendid'];
		$invoice = $blendDetails[0]['contractno'];
		$sale_date = $blendDetails[0]['date_'];
		$grade = $blendDetails[0]['Grade'];
		$nw = $blendDetails[0]['nw'];
		$sale_no = $blendDetails[0]['sale_no'];
		$destination = $blendDetails[0]['destination'];

		$lineno = $warehouses->genLineNo($id);

		$warehouses->addClosedBlendToStock( $id, $lineno, $sale_no, $lot, $grade, $fullPkgs, $nw, $nw*$fullPkgs, $standard);

		$response = '
		<table class="table table-sm table-bordered" style = "width:inherit;" id="confirm">
		<thead>
			<tr>
				<th>Line No</th>
				<th>Lot No</th>
				<th>Grade</th>
				<th>Invoice</th>
				<th>Origin</th>
				<th>Nw</th>
				<th>Pkgs</th>
				<th>Kgs</th>
			</tr>
		</thead>
		<tbody>';
		$response .='<tr>';
		$response .='<td>'.$lineno.'</td>';
		$response .='<td>'.$lot.'</td>';
		$response .='<td>'.$grade.'</td>';
		$response .='<td>'.$invoice.'</td>';
		$response .='<td>'.$destination.'</td>';
		$response .='<td>'.$nw.'</td>';
		$response .='<td>'.$fullPkgs.'</td>';
		$response .='<td>'.$nw*$fullPkgs.'</td>';
		$response .='</tr>';
		if($remainder !=0){
			$nw = 1;
			$lineno = $warehouses->genLineNo($id);

			$warehouses->addClosedBlendToStock($id,$lineno, $sale_no, $lot, $grade, $remainder, $nw, $nw*$remainder, $standard);
			$response .='<tr>';
			$response .='<td>'.$lineno.'</td>';
			$response .='<td>'.$lot.'</td>';
			$response .='<td>'.$grade.'</td>';
			$response .='<td>'.$invoice.'</td>';
			$response .='<td>'.$destination.'</td>';
			$response .='<td>'.$remainder.'</td>';
			$response .='<td>'.$nw.'</td>';
			$response .='<td>'.$nw*$remainder.'</td>';
			$response .='</tr>';
		}


		'</tbody>
	  
		</table>';

		echo $response;
	}
	if(isset($_POST['action']) && $_POST['action'] == "add-packing materials"){
		unset($_POST['action']);
		$warehouses->addPackagingMaterials($_POST);
	}
	if(isset($_POST['action']) && $_POST['action'] == "allocated-materials"){
		$allocatedMaterials = $warehouses->materialAllocation("");
		$output ="";
		if(count($allocatedMaterials)>0){
			$output.='<table id="alloctions" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>SI</th>
							<th>Material</th>
							<th>Allocated</th>
						</tr>
					</thead>
					<tbody>';
					foreach($allocatedMaterials as $allocated){
						$output.= '
							<tr>';
								$output.='<td>'.$allocated['contract_no'].'</td>';
								$output.='<td>'.$allocated['category'].'</td>';
								$output.='<td>'.$allocated['allocated_total'].'</td>';
								$output.='</tr>';
					}
		$output.='</tbody>
		</table>';
		echo $output;
		}else{
			echo '<h3 class="text-center mt-5">No materials allocated for this shipment</h3>';
		}
	}
	

	
	
?>

