<?php
session_start();
header("Access-Control-Allow-Origin: *");
include '../../database/connection.php';
include '../../models/Model.php';
include '../../controllers/ShippingController.php';
include '../../controllers/WorkFlow.php';



$db = new Database();
$conn = $db->getConnection();
$action = isset($_POST['action']) ? $_POST['action'] : '';
$shippingCtrl = new ShippingController($conn);
$workflow = new WorkFlow($conn);
echo $action;
if($action=='add-si'){
    unset($_POST['action']);
    $resp = $shippingCtrl->saveSI($_POST, 1);
    $_SESSION['si_type'] = $_POST['shippment_type'];
    $_SESSION['current_si_id'] = $resp;
    if($resp !=null){
        echo json_encode(array("success"=>"true", "message"=>"Saved Successfully", "id"=>$resp, "shipment_type"=>$_POST['shippment_type']));
    }else{
        echo json_encode(array("success"=>"false", "message"=>"There are some errors in the Form record not saved"));

    }
}else if($action=='update-si'){
    $shippingCtrl->saveSI($post, 1);
}else if($action=='load-active-si'){
    if(isset($_SESSION['current-si-id'])){
        echo json_encode($shippingCtrl->getAtciveShippingInstructions($_SESSION['current-si-id']));
    }
}else if($action=='load-unallocated'){
  $type = isset($_POST['type']) ? $_POST['type'] : '';
  $blendBalance = 0;
  $output ="";
  $stockList = $shippingCtrl->loadUnallocated();
  if (sizeOf($stockList)> 0) {
      $output .='
      <table id="direct_lot" class="table table-striped table-bordered">
      <thead>
          <tr>
              <th class="wd-15p">Lot</th>
              <th class="wd-15p">Mark</th>
              <th class="wd-10p">Grade</th>
              <th class="wd-25p">Invoice</th>
              <th class="wd-25p">Pkgs Available</th>
              <th class="wd-25p">This Allocation</th>
              <th class="wd-25p">Net</th>
              <th class="wd-25p">Kgs</th>
              <th class="wd-25p">Code</th>
              <th class="wd-25p">MRP Value</th>
              <th class="wd-25p">Allocation</th>
              <th class="wd-25p">Select</th>

          </tr>
      </thead>
      <tbody>';
      foreach ($stockList as $stock) {
          $output.='<tr>';
              $packagesToAllocate = $stock["shipped_packages"];
              $allocation = $stock["allocation"];
              $pk = $stock["allocation_id"];
              $packagesToAllocateId = $stock["allocation_id"]."packages";
              $kgsToAllocateId = $stock["allocation_id"]."kgs";
              $netToAllocateId = $stock["allocation_id"]."net";

              $mrp = $stock["mrp_value"];
              $id=$stock["allocation_id"];
              if($stock["selected_for_shipment"]!= NULL){
                $id=$stock["selected_for_shipment"];
              }
              if($stock["selected_for_shipment"]== NULL){
                $packagesToAllocate = $stock["pkgs"];
              }
              if($stock["si_no"] !=null){
                $allocation = $stock["si_no"];
              }
              $output.='<td>'.$stock["lot"].'</td>';
              $output.='<td>'.$stock["mark"].'</td>';
              $output.='<td>'.$stock["grade"].'</td>';
              $output.='<td>'.$stock["invoice"].'</td>';
              $output.='<td >'.$stock["pkgs"].'</td>';
              $output.='<td onblur="updateKgs(this)" contentEditable = "true" class="'.$pk.'">'.$packagesToAllocate.'</td>';
              $output.='<td id="'.$netToAllocateId.'">'.$stock["net"].'</td>';
              $output.='<td contentEditable = "true" id="'.$kgsToAllocateId.'">'.$stock["kgs"].'</td>';
              $output.='<td>'.$stock["comment"].'</td>';
              $output.='<td><input class="'.$pk.'" onblur="updateMrp(this)" value="'.$mrp.'"></input></td>';
              $output.='<td id="'.$id.'allocation">'.$allocation.'</td>';
              if($stock["selected_for_shipment"]== NULL){
                  $output.='
                  <td>
                      <button id="'.$stock["allocation_id"].'"  
                          type="button" 
                          class="allocate" 
                          onClick="callAction(this)"
                          name="allocated">
                          <i class="fa fa-plus"></i>                        
                          </button>
                  </td>';
              }else{
                  $output.='
                  <td>
                      <button id="'.$stock["selected_for_shipment"].'"
                          type="button" 
                          class="deallocate"
                          onClick="callAction(this)"
                          name="allocated">
                          <i class="fa fa-minus"></i>
                      </button>
                  </td>';                
              }                
          $output.='</tr>';
              }

      $output.='</tbody>
  </table>';
          }
 echo $output;
}else if($action=='allocate-shipment'){

    $allocationid = isset($_POST['allocationid']) ? $_POST['allocationid'] : die('missing id');
    $packages = isset($_POST['packages']) ? $_POST['packages'] : die('missing packages');
    $kgsToShip = isset($_POST['shippedKgs']) ? $_POST['shippedKgs'] : die('missing packages');

    $siNo = isset($_POST['siNo']) ? $_POST['siNo'] : die('missing contract no');
    $shippingCtrl->allocateForShippment($allocationid, $siNo, $packages, "straight", $kgsToShip);
    echo json_encode(array("status"=>"Lot allocated successfully"));

}else if($action=='remove-shipment'){
    $id = isset($_POST['id']) ? $_POST['id'] : die();
  
    $shippingCtrl->removeFromShipment($id);

    echo json_encode(array("status"=>"Lot Unallocated successfully"));

}else if($action=='shippment-summary'){
    $shipment = $shippingCtrl->shipmentSummaries($_POST['siNo']);
    $output ='';

    if(count($shipment)>0){
        $siNo =  $shipment['siNo'];
        $totalLots =  $shipment['totalLots'];
        $totalPkgs =  $shipment['totalpkgs'];
        $totalkgs =  $shipment['totalkgs'];
        $lotDetailsView = $shipment['lotDetailsView'];
        $lotDetailsEdit = $shipment['lotDetailsEdit'];
        $clientName = $shipment['clientName'];
        $approvalStatus = $shipment['approvalStatus'];

        $output .= '
        <table class="table table-sm table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Lots</th>
                <th>Pkgs</th>
                <th>kgs</th>
                <th>View Allocations</th>
                <th>Print Lot Detail</th>
                <th>Contract No</th>
                <th>Status</th>
                <th>Action</th>

            </tr>
        </thead>
        <tr>
            <td class="counter-value">'.$totalLots.'</td>
            <td class="counter-value">'.$totalPkgs.'</td>
            <td class="counter-value">'.$totalkgs.'</td>
            <td >'.$lotDetailsView.'</td>
            <td >'.$lotDetailsEdit.'</td>
            <td><input id="contractno" onBlur="updateContractNo(this)" value="'.$siNo.'"></input></td>
            <td id="lotStatus">'.$approvalStatus.'</td>
            <td>
                <button id="1" style="background-color:green; color:white" onClick="addApproval(this)" class="fa fa-check"></button>
            </td>

        </tr>
    </table>
';
    }
    echo $output;
    
}

else if($action=='blend'){
    $_SESSION['blend_details'] = $_POST;
    echo json_encode(array("success"=>200, "message"=>"Blend Saved"));
}else if($action=="si-template"){
    $output = "";
    $siTemp = $shippingCtrl->loadSItemplates(0);
            $output = '<option disabled="" value="..." selected="">select</option>';
    if (sizeOf($siTemp) > 0) {

         foreach($siTemp as $sitemp){
            $output .= '<option value="'.$sitemp['instruction_id'].'">'.$sitemp['contract_no'].'||'.$sitemp['si_date'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
}else if($action=='shipment-teas'){
    $output ="";
    $totalLots=0;
    $totalPkgs=0;
    $totalKgs=0;
    $totalAmount=0;
    $totalGross=0;
    $blendList = $shippingCtrl->loadActiveBlend();
    $stockList = $shippingCtrl->loadSelectedForshipment();
    if (sizeOf($blendList)> 0) {
        if($_POST['type']=="blend"){
            $output .='
        <table id="shippmentTeasBlend" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class="wd-15p">Blend No</th>
                <th class="wd-15p">Sale No</th>
                <th class="wd-15p">STD Name</th>
                <th class="wd-15p">Grade</th>
                <th class="wd-20p">Client Name</th>
                <th class="wd-15p">NW</th>
                <th class="wd-10p">Output Pkgs</th>
                <th class="wd-25p">Input Pkgs</th>
                <th class="wd-25p">LIST<th/>
            </tr>
        </thead>
        <tbody>';
        foreach ($blendList as $blend) {
            $output.='<tr>';
                $output.='<td>'.$blend["blend_no"].'</td>';
                $output.='<td>'.$blend["sale_no"].'</td>';
                $output.='<td>'.$blend["std_name"].'</td>';
                $output.='<td>'.$blend["Grade"].'</td>';
                $output.='<td>'.$blend["client_name"].'</td>';
                $output.='<td>'.$blend["nw"].'</td>';
                $output.='<td>'.$blend["output_pkgs"].'</td>';
                $output.='<td>'.$blend["output_pkgs"].'</td>'; 
                $output.='<td><a id="list" href="#" onclick="loadAllocationSummaryForBlends()">List</a></td>'; 
     
            $output.='</tr>';

            $output.='</tbody>
        </table>';
                }
       

        }else{
        $output .='
        <table id="shippmentTeas" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class="wd-15p">Sale No</th>
                <th class="wd-15p">Broker</th>
                <th class="wd-15p">Lots No</th>
                <th class="wd-15p">Ware Hse.</th>
                <th class="wd-20p">Company</th>
                <th class="wd-15p">Mark</th>
                <th class="wd-10p">Grade</th>
                <th class="wd-25p">Invoice</th>
                <th class="wd-25p">Type</th>
                <th class="wd-25p">Pkgs</th>
                <th class="wd-25p">Net</th>
                <th class="wd-25p">Gross</th>
                <th class="wd-25p">Value</th>
                <th class="wd-25p">Comment</th>
                <th class="wd-25p">Standard</th>

            </tr>
        </thead>
        <tbody>';
        foreach ($stockList as $stock) {
            $totalLots++;
            $totalPkgs+=$stock["pkgs"];
            $totalKgs+=$stock["net"];
            $totalAmount+=$stock["value"];
            $totalGross+=$stock["gross"];
            $output.='<tr>';
                $output.='<td>'.$stock["sale_no"].'</td>';
                $output.='<td>'.$stock["broker"].'</td>';
                $output.='<td>'.$stock["lot"].'</td>';
                $output.='<td>'.$stock["ware_hse"].'</td>';
                $output.='<td>'.$stock["company"].'</td>';
                $output.='<td>'.$stock["mark"].'</td>';
                $output.='<td>'.$stock["grade"].'</td>';
                $output.='<td>'.$stock["invoice"].'</td>';
                $output.='<td>'.$stock["type"].'</td>';
                $output.='<td>'.$stock["pkgs"].'</td>';
                $output.='<td>'.$stock["net"].'</td>';
                $output.='<td>'.$stock["gross"].'</td>';
                $output.='<td>'.$stock["value"].'</td>';
                $output.='<td>'.$stock["comment"].'</td>';
                $output.='<td>'.$stock["standard"].'</td>';             
            $output.='</tr>';
                }
                $output.='<tr style="background-color:green; color:white; border:none;">';            
                    $output.='<td><b>TOTALS</td>';
                    $output.='<td></td>';
                    $output.='<td></td>';
                    $output.='<td><b>'.$totalLots.'</b></td>';
                    $output.='<td></td>';
                    $output.='<td></td>';
                    $output.='<td></td>';
                    $output.='<td></td>'; 
                    $output.='<td></td>';
                    $output.='<td><b>'.$totalPkgs.'</b></td>'; //pkgs
                    $output.='<td><b>'.$totalKgs.'</b></td>'; //net
                    $output.='<td><b>'. $totalGross.'</b></td>'; //net
                    $output.='<td><b>'.$totalAmount.'</b></td>'; //final prompt value
                    $output.='<td></td>'; 
                    $output.='<td></td>'; 

                   
     
            $output.='</tr>';

        $output.='</tbody>
    </table>';
            }
        }
   echo $output;
}else if($action=="edit-si"){
    if(isset($_POST['id'])){
        $siRecord = $shippingCtrl->loadSItemplates($_POST['id']);
        echo json_encode($siRecord);
    }else{
        echo json_encode(array("error_code"=>404, "message"=>"Si Not Found"));

    }       
}else if ($action=="allocate-blend"){
    $id = isset($_POST['id']) ? $_POST['id'] : die();
    $pkgs = isset($_POST['pkgs']) ? $_POST['pkgs'] : die();
    $shippingCtrl->allocateBlend($id, $pkgs);
}else if($action=="confirm-shippment"){
    if(isset($_POST['id'])){
        $siRecord = $shippingCtrl->loadSItemplates($_POST['id']);
        echo json_encode($siRecord);
    }else{
        echo json_encode(array("error_code"=>404, "message"=>"Si Not Found"));

    }       
}else if($action=='add-blend'){
    unset($_POST['action']);
    $resp = $shippingCtrl->saveBlend($_POST);
    $_SESSION['blend-id'] = $_POST['id'];
    $_SESSION['blend-id'] = $resp;

    if($resp !=null){
        echo json_encode(array("success"=>"true", "message"=>"Saved Successfully", "shipment-type"=>$_SESSION['shipment-type']));
    }else{
        echo json_encode(array("success"=>"false", "message"=>"There are some errors in the Form record not saved"));

    }
}else if($_POST['action']=="session-data"){
    echo json_encode($_SESSION);

}else if($action=="complete"){
    $shippingCtrl->completeShipment($_POST["type"], 1);
}else if($action=='load-packing-materials'){
    $output = "";
    $packingMaterials = $shippingCtrl->viewPackingMaterials();
    if (sizeOf($packingMaterials)> 0) {
        $output='<table id="packingMaterials" class="table table-striped table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
                            <th>Warehouse</th>
							<th>in_stock</th>
                            <th>Allocation for current si</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>';
                            foreach($packingMaterials as $packing){
                                $allocated = $packing['allocated'];
                                $id = $packing['id'];
                                $output.= '
                                    <tr>
                                        <td>'.$packing['id'].'</td>
                                        <td>'.$packing['name'].'</td>
                                        <td>'.$packing['warehouse'].'</td>
                                        <td>'.$packing['in_stock'].'</td>
                                        <td>
                                            <input name="a'.$id.'" value="'.$allocated.'"></input>
                                        </td>';
                                            $output.='
                                            <td>
                                                <button id="a'.$packing["id"].'" style="background:green; width:50px; color:white;" type="button"   name="allocated"><i class="fa fa-plus"></i></button>

                                                <button id="b'.$packing["id"].'" style="background:red; width:50px; color:white;" type="button"   name="allocated"><i class="fa fa-minus"></i></button>
                                            </td>';             
                            }
                        $output.='</tr>';
  
                   $output.=' 
					</tbody>
				</table>';
            }else{
                $output.="Materials Out of Stock";
            }
                echo $output;
    }

else if($action == 'load_blend_summary'){
    $output ="";
    $totalLots=0;
    $totalPkgs=0;
    $totalKgs=0;
    $totalAmount=0;
    $totalGross=0;
    $stockList = $shippingCtrl->loadSelectedForshipment();
    $output ='
        <table id="shippmentTeasSummary" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class="wd-15p">Sale No</th>
                <th class="wd-15p">Broker</th>
                <th class="wd-15p">Lots No</th>
                <th class="wd-15p">Mark</th>
                <th class="wd-10p">Grade</th>
                <th class="wd-25p">Invoice</th>
                <th class="wd-25p">Type</th>
                <th class="wd-25p">Pkgs</th>
                <th class="wd-25p">Net</th>
                <th class="wd-25p">Kgs</th>
                <th class="wd-25p">Standard</th>

            </tr>
        </thead>
        <tbody>';
        foreach ($stockList as $stock) {
            $totalLots++;
            $totalPkgs+=$stock["current_allocation"];
            $totalKgs+=$stock["current_allocation"]*$stock["pkgs"];
            $totalAmount+=$stock["sale_price"];
            $totalGross+=$stock["gross"];
            $output.='<tr>';
                $output.='<td>'.$stock["sale_no"].'</td>';
                $output.='<td>'.$stock["broker"].'</td>';
                $output.='<td>'.$stock["lot"].'</td>';
                $output.='<td>'.$stock["mark"].'</td>';
                $output.='<td>'.$stock["grade"].'</td>';
                $output.='<td>'.$stock["invoice"].'</td>';
                $output.='<td>'.$stock["type"].'</td>';
                if($stock["current_allocation"]> 0){
                    $output.='<td>'.$stock["current_allocation"].'</td>';
                }else{
                    $output.='<td>'.$stock["pkgs"].'</td>';
                    $totalKgs += $stock["net"]*$stock["pkgs"];
                }
                $output.='<td>'.$stock["net"].'</td>';
                $output.='<td>'.$totalKgs.'</td>';
                $output.='<td>'.$stock["standard"].'</td>';             
            $output.='</tr>';
                }
                $output.='<tr style="background-color:green; color:white; border:none;">';            
                    $output.='<td><b>TOTALS</td>';
                    $output.='<td></td>';
                    $output.='<td></td>';
                    $output.='<td><b>'.$totalLots.'</b></td>';
                    $output.='<td></td>';
                    $output.='<td></td>';
                    $output.='<td></td>';
                    $output.='<td></td>'; 
                    $output.='<td></td>';
                    $output.='<td><b>'.$totalPkgs.'</b></td>'; //pkgs
                    $output.='<td><b>'.$totalKgs.'</b></td>'; //net
                    $output.='<td><b>'. $totalGross.'</b></td>'; //net
                    $output.='<td><b>'.$totalAmount.'</b></td>'; //final prompt value
                    $output.='<td></td>'; 
                    $output.='<td></td>'; 

                   
     
            $output.='</tr>';

        $output.='</tbody>
    </table>';
    echo $output;
}else if($action=="load-clients"){
    $output = "";
    $clients = $shippingCtrl->fetchErpClients();
            $output = '<option disabled="" value="..." selected="">select</option>';
    if (sizeOf($clients) > 0) {

         foreach($clients as $client){
            $output .= '<option value="'.$client['debtor_no'].'">'.$client['name'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
}else if($action=="load-standard"){
    $output = "";
    $standard = $shippingCtrl->fetchStandards();
            $output = '<option disabled="" value="..." selected="">select</option>';
    if (sizeOf($standard) > 0) {

         foreach($standard as $standard){
            $output .= '<option value="'.$standard['standard'].'">'.$standard['standard'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }

}else if($action=="add-workfow"){
    $approvalId = isset($_POST['id']) ? $_POST['id'] : die('id missing');
    $userid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : die('user id missing');
    $approvePerson = isset($_POST['approve_person']) ? $_POST['approve_person'] : die( 'approval person missing');
    $details = isset($_POST['details']) ? $_POST['details'] : die('Detail Missing');
    $workflow->addApproval($approvalId, $userid, "", $approvePerson, $details);
}else if($action=="client-allocation"){
    $clientid = isset($_POST['id']) ? $_POST['id'] :die('client id missing');
    $output ="";
    $allocations = $shippingCtrl->loadAllocated($clientid);
      if (sizeOf($allocations)> 0) {
        $output .='
        <table id="direct_lot" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class="wd-15p">Lot</th>
                <th class="wd-15p">Mark</th>
                <th class="wd-10p">Grade</th>
                <th class="wd-25p">Invoice</th>
                <th class="wd-25p">Kgs</th>
                <th class="wd-25p">Net</th>
                <th class="wd-25p">Code</th>
                <th class="wd-25p">Std/client</th>
                <th class="wd-25p">Select</th>

            </tr>
        </thead>
        <tbody>';
        foreach ($allocations as $stock) {
            $output.='<tr>';
                $output.='<td>'.$stock["lot"].'</td>';
                $output.='<td>'.$stock["mark"].'</td>';
                $output.='<td>'.$stock["grade"].'</td>';
                $output.='<td>'.$stock["invoice"].'</td>';
                $output.='<td>'.$stock["kgs"].'</td>';
                $output.='<td>'.$stock["net"].'</td>';
                $output.='<td>'.$stock["comment"].'</td>';
                $output.='<td>'.$stock["standard"].'</td>';
                if($stock["selected_for_shipment"]==0){
                    $output.='
                    <td>
                        <button id="'.$stock["stock_id"].'"  
                            type="button" 
                            class="allocate" 
                            onClick="callAction(this)"
                            name="allocated">
                            <i class="fa fa-plus"></i>                        
                            </button>
                    </td>';
                }else{
                    $output.='
                    <td>
                        <button id="'.$stock["stock_id"].'"
                            type="button" 
                            class="deallocate"
                            onClick="callAction(this)"
                            name="allocated">
                            <i class="fa fa-minus"></i>
                        </button>
                    </td>';                
                }                
            $output.='</tr>';
                }

        $output.='</tbody>
    </table>';
            }
   echo $output;

}else if($action=="load-grades"){
    $output = "";
    $grades = $shippingCtrl->fetchGrades()();
            $output = '<option disabled="" value="..." selected="">select</option>';
    if (sizeOf($grades) > 0) {

         foreach($grades as $grade){
            $output .= '<option value="'.$grade['name'].'">'.$grade['name'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
}else if($action=="update-mrp"){
    $id = $_POST["id"];
    $mrp = $_POST["mrp"];
    $shippingCtrl->updateMrp($id, $mrp);

}

else{
    echo json_encode(array("error_code"=>404, "message"=>"Action not found"));
}

?>
