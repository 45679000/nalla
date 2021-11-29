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
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$shippments= $shippingCtr->shippmentByStatus("", $type);

		$output = "";
		if(count($shippments)>0){
			$output .= '
			<table id="'.$type.'" class="table table-responsive w-auto table-sm table-bordered table-hover">
			<thead class="table-primary">
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
							<select class="shipment-status form-control form-control-sm" id="'.$sino.'">
								<option>Pending</option>
								<option>Received</option>
								<option>Blended</option>
								<option>Shipped</option>
							</select>
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
			$output.='<table class="table table-striped table-bordered table-hover">
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
					$serial = 1;

					foreach($warehouse as $warehouse){
						$id = $warehouse["id"];
						$output.= '
							<tr id='.$id.'>';
								$output.='<td>'.$serial.'</td>';
								$output.='<td>'.$warehouse['code'].'</td>';
								$output.='<td>'.$warehouse['name'].'</td>';
								$output.='<td>'.$warehouse['location'].'</td>';
								$output.='<td>'.$warehouse['details'].'</td>';

								$output.='<td>
									<a  class="edit " data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
									<a  class="deleteBtn"><i class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></a>
								</td>
							</tr>';
							$serial ++;

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
		$warehouses->addWarehouse($_POST);
	}
	if(isset($_POST['action']) && $_POST['action'] == "get-warehouse"){
		$id = $_POST["id"];
		$warehouse = $warehouses->getWarehouses($id)[0];

		echo json_encode(array(
			"id"=>$warehouse["id"],
			"code"=>$warehouse["code"],
			"name"=>$warehouse["name"],
			"location"=>$warehouse["location"],
			"details"=>$warehouse["details"]
			 )
		);
	
	}
	if(isset($_POST['action']) && $_POST['action'] == "get_packing_material_by_id"){
		$id = $_POST["id"];
		$record = $warehouses->getPackingMaterials($id);
		echo json_encode($record);
	
	}
	if(isset($_POST['action']) && $_POST['action'] == "add-material-types"){
		unset($_POST['action']);
		$warehouses->addMaterialTypes($_POST);
	}
	if(isset($_POST['action']) && $_POST['action'] == "load-packing-materials"){
		$packingMaterials = $warehouses->getPackingMaterials();
		$output ="";
		if(count($packingMaterials)>0){
				$output.='<table style="width:100%;" id="packing-materials" class="table table-striped  table-bordered table-sm table-hover">
				<thead>
						<tr>
							<th>id</th>
							<th>Material</th>
							<th>UOM</th>
							<th>Warehouse</th>
							<th>Location</th>
							<th>In stock</th>
							<th>Used</th>
							<th>Unit Cost</th>
							<th>Total Value(Ksh)</th>
							<th>Total Value(USD)</th>
                            <th>Details</th>
							<th>Actions</th>

						</tr>
					</thead>
					<tbody>';
					$serial = 1;
					foreach($packingMaterials as $packingMaterial){
						$id=$packingMaterial['id'];
						if($packingMaterial['is_bonded']){
							$output.= '
							<tr id="'.$id.'" class="text-light bg-dark">';
						}else{
							$output.= '
							<tr id="'.$id.'">';
						}
						
								$output.='<td>'.$serial.'</td>';
								$output.='<td>'.$packingMaterial['name'].'</td>';
								$output.='<td>'.$packingMaterial['uom'].'</td>';
								$output.='<td>'.$packingMaterial['warehouse'].'</td>';
								$output.='<td>'.$packingMaterial['location'].'</td>';
								$output.='<td><a class="stockadd" href="#">'.$packingMaterial['available'].'</a></td>';
								$output.='<td><a class="stockuse" href="#">'.$packingMaterial['allocated'].'</a></td>';
								$output.='<td>'.$packingMaterial['unit_cost'].'</td>';
								$output.='<td>'.$packingMaterial['total_value_ksh'].'</td>';
								$output.='<td>'.$packingMaterial['total_value_usd'].'</td>';
								$output.='<td>'.$packingMaterial['description'].'</td>';
								$output.='<td><a id="'.$packingMaterial['id'].'" class="adjust" data-toggle="modal"><i class="fa fa-exchange" data-toggle="tooltip" title="Adjust">Adjust Levels</i></a></td>

					
							</tr>';
							$serial ++;
					}
		$output.='</tbody>
		</table>';
		echo $output;
		}else{
			echo '<h3 class="text-center mt-5">No records found</h3>';
		}

	}
	if(isset($_POST['action']) && $_POST['action'] == "load-material-types"){
		$packingMaterialsTypes = $warehouses->getMaterialTypes();
		$output ="";
		if(count($packingMaterialsTypes)>0){
				$output.='<table style="width:100%;" id="packing-materials" class="table table-striped  table-bordered table-sm table-hover">
				<thead>
						<tr>
							<th>id</th>
							<th>Type</th>
							<th>UOM</th>
                            <th>UNIT COST</th>
							<th>Description</th>
							<th>Actions</th>

						</tr>
					</thead>
					<tbody>';
					$serial = 1;

					foreach($packingMaterialsTypes as $packingMaterial){
						$id = $packingMaterial['id'];
						$output.= '
							<tr>';
								$output.='<td>'.$serial.'</td>';
								$output.='<td>'.$packingMaterial['name'].'</td>';
								$output.='<td>'.$packingMaterial['uom'].'</td>';
								$output.='<td>'.$packingMaterial['unit_cost'].'</td>';
								$output.='<td>'.$packingMaterial['description'].'</td>';
								$output.='<td>
								<a id="'.$packingMaterial['id'].'" class="delete">
									<i class="fa fa-trash text-danger" data-toggle="tooltip" title="Delete"></i></a>&nbsp;&nbsp;

									<a href="#editModal" style="color:green" data-toggle="modal"  class="editBtn" id="'.$id.'"><i class="fa fa-pencil"></i></a>
							</td>
							</tr>';

							$serial ++;
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
			<thead class="bg-secondary text-light">
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
		$allocatedMaterials = $warehouses->materialAllocationBySi($_POST['sino']);
		$output ="";
		if(count($allocatedMaterials)>0){
			$output.='<table id="siAllocation" class="table table-striped  table-bordered table-sm table-hover">
					<thead>
						<tr>
							<th>Material</th>
							<th>Allocated</th>
							<th>Allocated By</th>
							<th>Allocated On</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>';
					foreach($allocatedMaterials as $allocated){
						$output.= '
							<tr>';
								$output.='<td>'.$allocated['material'].'</td>';
								$output.='<td>'.$allocated['total'].'</td>';
								$output.='<td>'.$allocated['full_name'].'</td>';
								$output.='<td>'.$allocated['allocated_on'].'</td>';
								$output.='<td>
									<a id="'.$allocated['id'].'" class="deleteBtn"><i class="fa fa-trash text-danger" data-toggle="tooltip" title="Delete"></i></a>
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
							<th>Type</th>
							<th>Warehouse</th>
							<th>IN Stock</th>
                            <th>Allocate</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>';
					$serial = 1;

					foreach($packingMaterials as $packingMaterial){
						$id = $packingMaterial['id'];
						$selectedId = $id."id";
						$selectedtotal = $id."selected";
						$type_id = $packingMaterial['type_id'];
						$output.= '
							<tr>';
								$output.='<td id="'.$selectedId.'">'.$serial.'</td>';
								$output.='<td>'.$packingMaterial['name'].'</td>';
								$output.='<td>'.$packingMaterial['warehouse'].'</td>';
								$output.='<td>'.$packingMaterial['available'].'</td>';
								$output.='<td id="'.$selectedtotal.'" contentEditable="true"></td>';
								$output.='<td class="'.$type_id.'">
									<a  id="'.$id.'"  class="allocate"><i class="fa fa-plus fa-lg text-danger" data-toggle="tooltip" title="Allocate"></i></a>
								</td>
							</tr>';
							$serial++;
					}
		$output.='</tbody>
		</table>';
		echo $output;
		}else{
			echo '<h3 class="text-center mt-5">No records found</h3>';
		}

	}
	if(isset($_POST['action']) && $_POST['action'] == "adjust_material_stock"){
		unset($_POST["action"]);
		$_POST["allocated_by"] = $warehouses->user;
		$_POST["allocated_on"] = date("Y-m-d H:i:s");
		$warehouses->upadateAllocation($_POST);
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
				  $output .="<table style='width:100% !important;'  class='table table-sm table-striped table-bordered table-hover thead-dark'>
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
					if($blend['output_pkgs'] != null){
						$inputKgs = $blend['output_pkgs'];
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
									$output.="<span>
									<i class='fa fa-check'></i>closed</span>";
								}else{
									$output.="<a href=./index.php?view=closeblends&blendno=".$blend['id']." style='color:green' class='close' id='".$blend['id']."'><i class='fa fa-file'> Blend Outurn Form</i></a>";
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
		  $pulucon = $_POST['pulucon'];
		  $warehouses->closeBlend($id, $output, $sweeping, $cyclone, $dust, $fiber, $remnant, $gain_loss, $pulucon);
		
	}
	if(isset($_POST['action']) && $_POST['action'] == "add-packing materials"){
		unset($_POST['action']);
		$warehouses->addPackagingMaterials($_POST);
	}
	if(isset($_POST['action']) && $_POST['action'] == "allocated-materials"){
		$allocatedMaterials = $warehouses->materialAllocationBySi("");
		$output ="";
		if(count($allocatedMaterials)>0){
			$output.='<table id="stockAllocation" class="table table-bordered table-striped table-hover">
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
								$output.='<td>'.$allocated['material'].'</td>';
								$output.='<td>'.$allocated['total'].'</td>';
								$output.='</tr>';
					}
		$output.='</tbody>
		</table>';
		echo $output;
		}else{
			echo '<h3 class="text-center mt-5">No materials allocated for this shipment</h3>';
		}
	}
	if(isset($_POST['action']) && $_POST['action'] == "add-line"){
		$blendno = $_POST['id'];
		$warehouses->addBlendLine($blendno);
	}
	if(isset($_POST['action']) && $_POST['action'] == "remove-line"){
		$id = $_POST['id'];
		$warehouses->updateBlendLine($id, "is_deleted", "1");
		$warehouses->updateBlendLine($id, "deleted_by", $_SESSION["user_id"]);

		echo json_encode(array("status"=>"removed"));
	}
	if(isset($_POST['action']) && $_POST['action'] == "load-blend-lines"){
		$blendno = $_POST['id'];
		$blendlines = $warehouses->loadBlendLines($blendno);
		$output .='<table class="table table-sm table-bordered" style = "width:inherit;" id="confirm">
		<thead>
			<tr>
				<th>Line No</th>
				<th>Blend Date</th>
				<th>Sale No</th>
				<th>Lot No</th>
				<th>Grade</th>
				<th>Invoice</th>
				<th>Origin</th>
				<th>Mark</th>
				<th>Nw</th>
				<th>Pkgs</th>
				<th>Kgs</th>

			</tr>
		</thead>
		<tbody>';

		foreach ($blendlines as $blend) {
			$kgs = $blend['net']*$blend['pkgs'];
			$net = $blend['net'];
			$pkgs = $blend['pkgs'];
			$id = $blend['id'];
			$mark = $blend['mark'];


		$output.="<tr id='$id'>
					<td>".$blend['line_no']."</td>
					<td>".$blend['date_posted']."</td>
					<td>".$blend['sale_no']."</td>
					<td>".$blend['lot_no']."</td>
					<td>".$blend['grade']."</td>
					<td>".$blend['lot_no']."</td>
					<td>".$blend['origin']."</td>
					<td>
					<select value ='$mark' class='select2 mark'>
						<option>BLENDED TEA</option>
						<option>SIEVED DUST</option>
					</select></td>
					<td><input value='$net' name='net' class='editable'></input></td>
					<td><input value='$pkgs' name='pkgs' class='editable'></input></td>
					<td class='kgs'>".$kgs."</td>
					<td><i class='fa fa-minus btn remove btn-danger btn-sm'></i></td>";
  
		}
		$output .= "</tbody>
		</table>";

		echo $output;	
		



	}
	if(isset($_POST['action']) && $_POST['action'] == "close-parameter"){
		$blendno = $_POST['id'];
		$shippment = $warehouses->blendShippment($blendno);
		$inputKgs = $blendCtrl->totalBlendedPerBlend($blendno);

		echo json_encode(array("shippment"=>$shippment, "inputkgs"=>$inputKgs));
	}
	if(isset($_POST['action']) && $_POST['action'] == "update-field"){
		$id = $_POST['id'];
		$fieldName = isset($_POST['fieldName']) ? $_POST['fieldName'] : '';
		$fieldValue = isset($_POST['fieldValue']) ? $_POST['fieldValue'] : '';

		$warehouses->updateBlendLine($id, $fieldName, $fieldValue);
		echo json_encode(array("status"=>"updated"));
	}
	if(isset($_POST['action']) && $_POST['action'] == "delete-warehouse"){
		$pk = $_POST['id'];
		$warehouses->softDelete($pk, "warehouses");
		echo json_encode(array("status"=>"Deleted"));
	}
	if(isset($_POST['action']) && $_POST['action'] == "delete-warehouse"){
		$pk = $_POST['id'];
		$warehouses->softDelete($pk, "warehouses");
		echo json_encode(array("status"=>"Deleted"));
	}
	if(isset($_POST['action']) && $_POST['action'] == "edit-material-type"){
		$id = isset($_POST['editId']) ? $_POST['editId'] : ''; 
		$warehouses->tablename = "material_types";
		$row = $warehouses->getRecordById($id);
		echo json_encode($row);
	}
	if(isset($_POST['action']) && $_POST['action'] == "delete-material-type"){
		$id = isset($_POST['id']) ? $_POST['id'] : ''; 
		$row = $warehouses->softDelete($id, "material_types");
		echo json_encode($row);
	}
	if(isset($_POST['action']) && $_POST['action'] == "bonded_stock"){
		$type_id = isset($_POST['type_id']) ? $_POST['type_id'] : ''; 
		$row = $warehouses->getBondedWarehouseStock($type_id);
		if($row[0]["available"]>0){
			echo json_encode(array("success"=>1, "message"=>"Available For Transfer". $row[0]["available"]. $row[0]["uom"] . " of ". $row[0]["name"]));
		}else{
			echo json_encode(array("success"=>0, "message"=>"There are no enough Materials On the Bonded,  Warehouse You cannot Complete This Transfer"));
		}

	}
	if(isset($_POST['action']) && $_POST['action'] == "view-allocation"){
		$id = isset($_POST['id']) ? $_POST['id'] : ''; 
		$event = isset($_POST['event']) ? $_POST['event'] : ''; 

		$materialAllocation = $warehouses->getMaterialAllocation($id, $event);
		$output ="";
		if(count($materialAllocation)>0){
				$output.='<table style="width:100%;" id="allocations" class="table table-striped  table-bordered table-sm table-hover">
				<thead>
						<tr>
							<th>id</th>
							<th>Details</th>
							<th>Total</th>
                            <th>Date</th>
							<th>User</th>
						</tr>
					</thead>
					<tbody>';
					$serial = 1;

					foreach($materialAllocation as $materialAllocation){
						$id = $materialAllocation['id'];
						$output.= '
							<tr>';
								$output.='<td>'.$serial.'</td>';
								$output.='<td>'.$materialAllocation['details'].'</td>';
								$output.='<td>'.$materialAllocation['total'].'</td>';
								$output.='<td>'.$materialAllocation['allocated_on'].'</td>';
								$output.='<td>'.$materialAllocation['full_name'].'</td>';
							'</td>
							</tr>';

							$serial ++;
					}
		$output.='</tbody>
		</table>';
		echo $output;
		}else{
			echo '<h3 class="text-center mt-5">No records found</h3>';
		}

	}
	if(isset($_POST['action']) && $_POST['action'] == "allocate-material-si"){
		unset($_POST["action"]);
		$_POST["allocated_by"] = $warehouses->user;
		$_POST["allocated_on"] = date("Y-m-d H:i:s");
		$warehouses->upadateAllocation($_POST);

	}
	if(isset($_POST['action']) && $_POST['action'] == "unallocate-si"){
		unset($_POST["action"]);
		$_POST["deleted_by"] = $warehouses->user;
		$_POST["deleted_on"] = date("Y-m-d H:i:s");
		$warehouses->unAllocate($_POST);

	}
	
	
?>

