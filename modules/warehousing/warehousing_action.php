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
			<table id="dashboard" class="table">
			<thead>
				<tr>
					<th>SI</th>
					<th>Buyer</th>
					<th>Consignee</th>
					<th>Destination</th>
					<th>Target Vessel</th>
					<th>Status</th>
					<th>Progress</th>
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
					$output .= '<td>'.$shippment['status'].'</td>';
					$output .= '<td>
									<div class="progress" style="height: 15px;">
										<div class="progress-bar bg-info" role="progressbar" style="width:95%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</td>';
					$output .='<td>
						<button id="'.$sino.'"data-toggle="modal" onclick=updateStatus(this) data-target="#updateStatus"><i class="fa fa-cogs btn-sm">Update Status</button>
						</td>
					</tr>		
				';
			}
			$output .= '</tbody>
					</table>';

		}else{
			$output.= "<p>You don't have any active Shippments to track</p>";
		}
		echo $output;

	}
	if(isset($_POST['action']) && $_POST['action'] == "update-status"){
		$newStatus = $_POST['statusChange'];
		$sino = $_POST['sino'];
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
			$output.='<table class="table table-striped table-hover">
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
			<table id="dashboard" class="table">
			<thead>
				<tr>
					<th>SI</th>
					<th>Buyer</th>
					<th>Consignee</th>
					<th>Destination</th>
					<th>Target Vessel</th>
					<th>Status</th>
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
					$output .= '<td>'.$shippment['status'].'</td>';
					$output .='<td>
						<a href="./index.php?view=shipments&action=allocatematerials&id='.$sino.'">
						Allocate Materials</a>
						</td>
					</tr>		
				';
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
			$output.='<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Category</th>
							<th>Allocated</th>
                            <th>Details</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>';
					foreach($allocatedMaterials as $allocated){
						$output.= '
							<tr>';
								$output.='<td>'.$allocated['id'].'</td>';
								$output.='<td>'.$allocated['category'].'</td>';
								$output.='<td>'.$allocated['allocated_total'].'</td>';
								$output.='<td>'.$allocated['details'].'</td>';

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
			echo '<h3 class="text-center mt-5">No materials allocated for this shipment</h3>';
		}

	
	}
	if(isset($_POST['action']) && $_POST['action'] == "load-packing-materials-to-allocate"){
		$packingMaterials = $warehouses->getPackingMaterials();
		$output ="";
		if(count($packingMaterials)>0){
			$output.='<table class="table table-striped table-hover">
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
									<button  id="'.$id.'" onclick=allocateMaterial(this) class="allocate">
										<i class="fa fa-exchange" data-toggle="tooltip" title="Edit">
									</i></button>
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
		$materialid = $_POST['materialid'];
		$sino = $_POST['sino'];
		$totalAllocation = $_POST['totalAllocation'];

		$warehouses->upadateAllocation($materialid, $sino,  $totalAllocation);
	}

	if(isset($_POST['action']) && $_POST['action'] =='show-unclosed'){
		$output = "";
			  $blends = $blendCtrl->fetchBlends();
			  $blendno = isset($_POST['blendno']) ? $_POST['blendno'] : '';
			  if($blendno ==''){
			  if (count($blends) > 0) {
				  $output .="<table style='width:100% !important;'  class='table table-striped table-bordered table-hover thead-dark'>
						  <thead class='thead-dark'>
							<tr>
							  <th>Blend</th>
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
					$columnShipment = $blend['id'].'shipment';
					$columnInput = $blend['id'].'input';
					$columnPolucun = $blend['id'].'pulucon';
					$columnOutput = $blend['id'].'output';
					$columnSweeping = $blend['id'].'sweeping';
					$columnCyclone = $blend['id'].'cyclone';
					$columnDust = $blend['id'].'dust';
					$columnFiber = $blend['id'].'fiber';
					$columnBlendRemnant = $blend['id'].'blendRemnant';
					$columnGainLoss = $blend['id'].'gain_loss';
					  $kgs = $blend['nw']*$blend['Pkgs'];
				  $output.="<tr>
							  <td id='lotEdit'><a href='#' onclick='loadAllocationSummaryForBlends()'>".$blend['contractno']."</a></td>
							  <td>".$blend['Grade']."</td>
							  <td id='$columnShipment'>".$kgs."</td>
							  <td id='$columnInput'>".$inputKgs."</td>
							  <td contentEditable='true' id='$columnOutput'>".$blend['output_kgs']."</td>
							  <td contentEditable='true' id='$columnSweeping'>".$blend['sweeping']."</td>
							  <td contentEditable='true' id='$columnCyclone'>".$blend['cyclone']."</td>
							  <td contentEditable='true' id='$columnDust'>".$blend['dust']."</td>
							  <td contentEditable='true' id='$columnFiber'>".$blend['fiber']."</td>
							  <td contentEditable='true' id='$columnPolucun'>".$blend['pulucon']."</td>
							  <td  id='$columnBlendRemnant'>".$blend['blend_remnant']."</td>
							  <td  id='$columnGainLoss'>".round($blend['gain_loss'],2)."</td>
							  <td>
								<button onclick=closeBlend(this) style='color:green'  
								class='close' id='".$blend['id']."'><i class='fa fa-cog'></i>
								close</button>
							  </td>
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
		  echo json_encode("here");
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

		$warehouses->addClosedBlendToStock($sale_no, $lot, $grade, $fullPkgs, $nw, $nw*$fullPkgs, $standard);

		$response = '
		<table class="table table-bordered" style = "width:inherit;" id="confirm">
		<thead>
			<tr>
				<th>Lot No</th>
				<th>Grade</th>
				<th>Invoice</th>
				<th>Nw</th>
				<th>Pkgs</th>
				<th>Kgs</th>
			</tr>
		</thead>
		<tbody>';
		$response .='<tr>';
		$response .='<td>'.$lot.'</td>';
		$response .='<td>'.$grade.'</td>';
		$response .='<td>'.$invoice.'</td>';
		$response .='<td>'.$nw.'</td>';
		$response .='<td>'.$fullPkgs.'</td>';
		$response .='<td>'.$nw*$fullPkgs.'</td>';
		$response .='</tr>';
		if($remainder !=0){
			$nw = 1;
			$warehouses->addClosedBlendToStock($sale_no, $lot, $grade, $remainder, $nw, $nw*$remainder, $standard);
			$response .='<tr>';
			$response .='<td>'.$lot.'</td>';
			$response .='<td>'.$grade.'</td>';
			$response .='<td>'.$invoice.'</td>';
			$response .='<td>'.$nw.'</td>';
			$response .='<td>'.$remainder.'</td>';
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



?>

