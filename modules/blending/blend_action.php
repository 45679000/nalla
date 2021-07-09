<?php
	// Include config.php file
    include_once('../../models/Model.php');
    include_once('../../database/page_init.php');
    include_once('../../controllers/ShippingController.php');
    include_once('../../controllers/BlendingController.php');

    $shippingCtrl = new ShippingController($conn);
    $blendingCtrl = new BlendingController($conn);

	// Insert Record	
	if (isset($_POST['action']) && $_POST['action'] == "insert") {
		$blendno = isset($_POST['blendno']) ? $_POST['blendno'] : die('blendno required field');
		$clientid = isset($_POST['clientid']) ? $_POST['clientid'] : die('clientidrequired field');
        $stdname = isset($_POST['standard']) ? $_POST['standard'] : die('standard required field');
        $grade = isset($_POST['grade']) ? $_POST['grade'] : die('grade required field');
        $pkgs = isset($_POST['pkgs']) ? $_POST['pkgs'] : die('pkgs required field');
        $nw = isset($_POST['nw']) ? $_POST['nw'] : die('nw required field');
    echo $blendno; 
        $shippingCtrl->saveBlend($blendno, $clientid, $stdname, $grade, $pkgs, $nw);

	}

	// View record
	if (isset($_POST['action']) && $_POST['action'] == "view") {
		$output = "";
        $blends = $blendingCtrl->fetchBlends();
        $blendno = isset($_POST['blendno']) ? $_POST['blendno'] : '';
        if($blendno ==''){
        if (count($blends) > 0) {
			$output .="<table id='grid' class='table table-striped table-bordered table-hover thead-dark'>
			        <thead class='thead-dark'>
			          <tr>
			            <th>Blend No</th>
			            <th>Client</th>
			            <th>STD</th>
			            <th>Grade</th>
                        <th>Pkgs</th>
                        <th>Net</th>
                        <th>Kgs</th>
                        <th>Actions</th>
			          </tr>
			        </thead>
			        <tbody>";
			foreach ($blends as $blend) {
                $kgs = $blend['nw']*$blend['Pkgs'];
			$output.="<tr>
			            <td id='lotEdit'><a href='#' onclick='loadAllocationSummaryForBlends()'>".$blend['blend_no']."</a></td>
			            <td>".$blend['client_name']."</td>
			            <td>".$blend['std_name']."</td>
                        <td>".$blend['Grade']."</td>
                        <td>".$blend['Pkgs']."</td>
                        <td>".$blend['nw']."</td>
                        <td>".$kgs."</td>


			            <td>
                         <a href='./index.php?view=allocateblendteas&blendno=".$blend['id']."' style='color:green' 
                          class='navigate' id='".$blend['id']."'><i class='fa fa-plus'></i></a>&nbsp;
			              <a href='#editModal' style='color:green' data-toggle='modal' 
			              class='editBtn' id='".$blend['id']."'><i class='fa fa-pencil'></i></a>&nbsp;
			              <a href='' style='color:red' class='deleteBtn' id='".$blend['id']."'>
			              <i class='fa fa-trash' ></i></a>
			            </td>
			        </tr>";
				}
			$output .= "</tbody>
      		</table>";
      		echo $output;	
		}else{
			echo '<h3 class="text-center mt-5">No records found</h3>';
		}
    }else{
            $blends = $blendingCtrl->fetchBlends($blendno);
            if (count($blends) > 0) {
                $output .="<table id='grid' class='table table-striped table-bordered table-hover thead-dark'>
                        <thead class='thead-dark'>
                          <tr>
                            <th>Blend No</th>
                            <th>Client</th>
                            <th>STD</th>
                            <th>Grade</th>
                            <th>Out Pkgs</th>
                            <th>Out Net</th>
                            <th>Out Kgs</th>
                            <th>Inpt. Pkgs</th>
                            <th>Inpt. Net</th>
                            <th>Inpt. Kgs</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>";
                foreach ($blends as $blend) {
                    $kgs = $blend['nw']*$blend['Pkgs'];
                    $status = "unconfirmed";
                    if($blend['approved']==1){
                      $status = "Confirmed || Not Closed";
                    }
                $output.="<tr>
                            <td id='lotShow'><a href='#' onclick='loadAllocationSummaryForBlends()'>".$blend['id']."</a></td>
                            <td>".$blend['client_name']."</td>
                            <td>".$blend['std_name']."</td>
                            <td>".$blend['Grade']."</td>
                            <td>".$blend['Pkgs']."</td>
                            <td>".$blend['nw']."</td>
                            <td>".$kgs."</td>
                            <td id='totalPkgs'></td>
                            <td id='totalNet'></td>
                            <td id='totalkgs'></td>
                            <td>".$status."</td>

                            <td>
                             <a onclick='viewAllocations(this)'  style='color:green' 
                              class='view' id='".$blend['id']."'><i class='fa fa-eye'></i></a>&nbsp;
                              <a href='#blendSheet' style='color:green' data-toggle='modal' 
                              class='editBtn' id='".$blend['id']."'><i class='fa fa-file'></i></a>&nbsp;
                              <a href='' style='color:red' class='confirm' id='".$blend['id']."'>
                              <i class='fa fa-check' ></i></a>
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
  if (isset($_POST['action']) && $_POST['action'] == "insert") {
  
      $shippingCtrl->shipmentSummaryBlend($blendno);

}

if (isset($_POST['editId'])) {
  $editId = $_POST['editId'];
  $row = $shippingctrl->getRecordById($editId);
  echo json_encode($row);
}

if (isset($_POST['action']) && $_POST['action'] == "update") {

		$name = $_POST['name'];
		$country = $_POST['country'];
        $id = $_POST['id'];
		$shippingctrl->updateRecord($id, $name,  $country);
}

    	// Delete Record	
if (isset($_POST['deleteId'])) {
  $deleteId = $_POST['deleteId'];
  $shippingCtrl->deletBlend($deleteId);
  echo json_encode(array("msg"=>"Record Deleted Successfully"));
}
//add teas to a blend
if(isset($_POST['action']) && $_POST['action'] == "add-blend-teas"){
  $allocationId = $_POST['allocationid'];
  $blendNo = $_POST['blendno'];
  $allocatedPackages = $_POST['allocatedpackages'];

  $blendingCtrl->addLotAllocationToBlend($allocationId, $blendNo, $allocatedPackages);

}
if(isset($_POST['action']) && $_POST['action'] == 'load-unallocated'){
  $type = isset($_POST['type']) ? $_POST['type'] : '';
  $blendBalance = 0;
  $output ="";
  $stockList = $blendingCtrl->loadUnallocated();
  if (sizeOf($stockList)> 0) {
      $output .='
      <table id="direct_lot" class="table table-striped table-bordered">
      <thead>
          <tr>
              <th class="wd-15p">Lot</th>
              <th class="wd-15p">Mark</th>
              <th class="wd-10p">Grade</th>
              <th class="wd-25p">Invoice</th>
              <th class="wd-25p">Pkgs IN.Stck</th>
              <th class="wd-25p">Allocate Pkgs</th>
              <th class="wd-25p">Net</th>
              <th class="wd-25p">Kgs</th>
              <th class="wd-25p">Code</th>
              <th class="wd-25p">Allocation</th>
              <th class="wd-25p">Select</th>

          </tr>
      </thead>
      <tbody>';
      foreach ($stockList as $stock) {
          $output.='<tr>';
              $packagesToAllocate = $stock["packages"];
              if($stock["selected_for_shipment"]== NULL){
                $packagesToAllocate = $stock["allocated_pkgs"];
              }
              $output.='<td>'.$stock["lot"].'</td>';
              $output.='<td>'.$stock["mark"].'</td>';
              $output.='<td>'.$stock["grade"].'</td>';
              $output.='<td>'.$stock["invoice"].'</td>';
              $output.='<td><div id="availablepackages">'.$stock["allocated_pkgs"].'</td>';
              $output.='<td><div id="allocatedpackages" contenteditable="true">'.$packagesToAllocate.'</div></td>';
              $output.='<td>'.$stock["net"].'</td>';
              $output.='<td>'.$stock["kgs"].'</td>';
              $output.='<td>'.$stock["comment"].'</td>';
              $output.='<td>'.$stock["standard"].'</td>';
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
}
if(isset($_POST['action']) && $_POST['action'] =='blend-shippment-summary'){
  echo json_encode($blendingCtrl->shipmentSummaryBlend($_POST['blendno']));
}