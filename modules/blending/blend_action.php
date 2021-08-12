<?php
	// Include config.php file
    include_once('../../models/Model.php');
    include_once('../../database/page_init.php');
    include_once('../../controllers/ShippingController.php');
    include_once('../../controllers/BlendingController.php');
    include_once('../../controllers/StockController.php');

    $shippingCtrl = new ShippingController($conn);
    $blendingCtrl = new BlendingController($conn);
    $stockCtrl = new Stock($conn);

	// Insert Record	
	if (isset($_POST['action']) && $_POST['action'] == "insert") {
        $error = "";
		    $clientid = isset($_POST['clientid']) ? $_POST['clientid'] : $error ='You must select a client';
        $stdname = isset($_POST['standard']) ? $_POST['standard'] : $error ='You must select a standard';
        $grade = isset($_POST['grade']) ? $_POST['grade'] : $error ='You must select a Grade';
        $pkgs = isset($_POST['pkgs']) ? $_POST['pkgs'] : $error ='You must indicate Output packages';
        $nw = isset($_POST['nw']) ? $_POST['nw'] : $error ='You must indicate Output net';
        $contractno = isset($_POST['contractno']) ? $_POST['contractno'] : $error ='You must indicate contract No';
        $sale_no = isset($_POST['sale_no']) ? $_POST['sale_no'] : $error = 'You must enter sale no';
        $blendid = isset($_POST['blendid']) ? $_POST['blendid'] : $error ='You must indicate the Blend no';
        $blendno = 'STD'.$stdname.'/'.$blendid;
        if($error ==""){
          $message = $blendingCtrl->saveBlend($blendno, $clientid, $stdname, $grade, $pkgs, $nw, $blendid, $contractno, $sale_no);
          echo json_encode($message);

        }else{
          $formError["error"]=$error;
          $formError["code"] = 201;

          echo json_encode($formError);

        }
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
                  <th>Sale No</th>
			            <th>Blend Name</th>
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
        $kgs=$blend['Pkgs']*$blend['nw'];
        $blendid = $blend['id'];

			    $output.="<tr>
                  <td>".$blend['sale_no']."</td>
			            <td><a href='./index.php?view=allocateblendteas&blendno=$blendid'>".$blend['blend_no']."</a></td>
			            <td>".$blend['client_name']."</td>
			            <td>".$blend['std_name']."</td>
                  <td>".$blend['Grade']."</td>
                  <td>".$blend['Pkgs']."</td>
                  <td>".$blend['nw']."</td>
                  <td>".$kgs."</td>
			            <td>
                  <a href='./index.php?view=allocateblendteas&blendno=$blendid' style='color:green'  
                  class='navigate' id=".$blendid."><i class='fa fa-plus'></i></a>&nbsp;

			              <a href='#editModal' style='color:green' data-toggle='modal' 
			              class='editBtn' id=".$blendid."><i class='fa fa-pencil'></i></a>&nbsp;
			              <a href='' style='color:red' class='deleteBtn' id=".$blendid.">
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
            $totalKgs = $blendingCtrl->selectedKgs($blendno);
            $compositions = $blendingCtrl->expectedComposition($blendno);
            $currentComposition = $blendingCtrl->currentComposition($blendno);
            if (count($blends) > 0) {
                $output .="<table id='grid' class='table table-striped table-bordered table-hover thead-dark'>
                        <thead class='thead-dark'>
                          <tr>
                            <th>Blend Name</th>
                            <th>Contract No</th>
                            <th>Client</th>
                            <th>STD</th>
                            <th>Grade</th>
                            <th>Expected Kgs</th>
                            <th>Input Kgs</th>
                            <th>Status</th>
                            <th>View Added Teas</th>
                            <th>Add Teas</th>
                            <th>Blend Sheet</th>
                            <th>Confirm Blendsheet</th>
                          </tr>
                        </thead>
                        <tbody>";
                foreach ($blends as $blend) {
                    $kgs = $blend['nw']*$blend['Pkgs'];
                    $status = "unconfirmed";
                    $blendnoid = $blend["id"]."blend";
                    if($blend['approved']==1){
                      $status = "Confirmed || Not Closed";
                    }
                $output.="<tr>
                            <td>".$blend['blend_no']."</td>
                            <td id='$blendnoid'>".$blend['contractno']."</td>
                            <td>".$blend['client_name']."</td>
                            <td>".$blend['std_name']."</td>
                            <td>".$blend['Grade']."</td>
                            <td>".$kgs."</td>
                            <td>".$totalKgs."</td>
                            <td>".$status."</td>
                            <td>
                            <a onclick=editBlend(this)  style='color:red' class='confirm' id='".$blend['id']."'>
                            <i class='fa fa-pencil' ></i>
                          </a>
                          Edit Blend</a>
                            </td>
                            <td>
                              <a onclick='viewAllocations(this)'  style='color:green' 
                                class='view' id='".$blend['id']."'><i class='fa fa-eye'></i>
                              View Teas</a>
                            </td>
                            <td>
                              <a onclick='viewBlendSheet(this)' style='color:green' data-toggle='modal' 
                              class='editBtn' id='".$blend['id']."'><i class='fa fa-file'></i>
                              </a>
                            Blend Sheet</a>
                            </td>
                            <td>
                                <a onclick='approveBlend(this)' style='color:red' class='confirm' id='".$blend['id']."'>
                                <i class='fa fa-check' ></i>
                              </a>
                              Confirm Blend</a>
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
  
if (isset($_POST['editId'])) {
  $editId = $_POST['editId'];
  $row = $blendingCtrl->fetchBlends($editId);
  echo json_encode($row);
}

if (isset($_POST['action']) && $_POST['action'] == "update") {

		$standard = $_POST['standard'];
    $blendid = $_POST['blendid'];
    $contractno = $_POST['contractno'];
    $grade = $_POST['grade'];
    $pkgs = $_POST['pkgs'];
    $nw = $_POST['nw'];
    $id = $_POST['edit-form-id'];
    $saleno = $_POST['sale_no'];
    $clientid = $_POST['clientid'];


		$blendingCtrl->updateBlendMaster($id, $standard,  $blendid, $contractno, $grade, $pkgs, $nw, $saleno, $clientid);
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
  $allocatedKgs = $_POST['allocatedKgs'];
  $split = $_POST['split'];

  $blendingCtrl->addLotAllocationToBlend($allocationId, $blendNo, $allocatedPackages, $allocatedKgs, $split);
}
if(isset($_POST['action']) && $_POST['action'] == "remove-blend-teas"){
  $allocationId = $_POST['allocationid'];
  echo $blendingCtrl->removeLotAllocationFromBlend($allocationId);
}


if(isset($_POST['action']) && $_POST['action'] == 'load-unallocated'){
  $type = isset($_POST['type']) ? $_POST['type'] : '';
  $mark = isset($_POST['mark']) ? $_POST['mark'] : '';
  $lot = isset($_POST['lot']) ? $_POST['lot'] : '';
  $grade = isset($_POST['grade']) ? $_POST['grade'] : '';
  $saleno = isset($_POST['saleno']) ? $_POST['saleno'] : '';

  
  $condition=" WHERE pkgs>0 ";
  if($mark=='' && $grade == '' && $lot == '' && $saleno == ''){
    $condition = $condition;
  }else{
    if($saleno !=null){
      $condition.=" AND closing_stock.sale_no = '".$saleno."'";
    }if($mark !=null){
      $condition.=" AND closing_stock.mark = '".$mark."'";
    }if($grade !=null){
      $condition.=" AND closing_stock.grade = '".$grade."'";
    }if($lot !=null){
      $condition.=" AND closing_stock.lot = '".$lot."'";
    }
  }
  $blendBalance = 0;
  $output ="";
  $stockList = $stockCtrl->readStock("", $condition);
  if (sizeOf($stockList)> 0) {
      $output .='
      <table id="direct_lot" class="table table-striped table-bordered">
      <thead>
          <tr>
              <th class="wd-15p">Sale No</th>
              <th class="wd-15p">Lot</th>
              <th class="wd-15p">Mark</th>
              <th class="wd-10p">Grade</th>
              <th class="wd-25p">Invoice</th>
              <th class="wd-25p">Code</th>
              <th class="wd-25p">Pkgs</th>
              <th class="wd-25p">Net</th>
              <th class="wd-25p">Kgs</th>
              <th class="wd-25p">Actions</th>

          </tr>
      </thead>
      <tbody>';
      foreach ($stockList as $stock) {
          $output.='<tr>';
              $output.='<td>'.$stock["sale_no"].'</td>';
              $output.='<td>'.$stock["lot"].'</td>';
              $output.='<td>'.$stock["mark"].'</td>';
              $output.='<td>'.$stock["grade"].'</td>';
              $output.='<td>'.$stock["invoice"].'</td>';
              $output.='<td>'.$stock["comment"].'</td>';
              $output.='<td>'.$stock["pkgs"].'</td>';
              $output.='<td>'.$stock["net"].'</td>';
              $output.='<td>'.$stock["kgs"].'</td>';
              $output.='<td>
						        <a style="color:green" data-toggle="tooltip" data-placement="bottom" title="Use Tea" >
			              <i class="fa fa-arrow-right" ></i></a>&nbsp&nbsp&nbsp;
                    <a style="color:red" data-toggle="tooltip" data-placement="bottom" title="Split Lot">
			              <i class="fa fa-scissors"></i></a>&nbsp&nbsp&nbsp;
			            </td>';          
          $output.='</tr>';
              
      }
      $output.='</tbody>
  </table>';
  }    
 echo $output;
}else{
}
if(isset($_POST['action']) && $_POST['action'] =='blend-shippment-summary'){
  echo json_encode($blendingCtrl->shipmentSummaryBlend($_POST['blendno']));
}
if(isset($_POST['action']) && $_POST['action'] =='show-unclosed'){
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

  }
}
if(isset($_POST['action']) && $_POST['action'] == 'approve-blend'){
  $blendno = $_POST['blendno'];
  $blendingCtrl->approveBlend($blendno);
}
if(isset($_POST['action']) && $_POST['action'] == 'edit-blend'){
  $blendno = $_POST['blendno'];
  $blendingCtrl->clearFromShippment($blendno);
}
if(isset($_POST['action']) && $_POST['action'] == 'current-allocation'){
  $blendno = $_POST['blendno'];
  $currentAllocation = $blendingCtrl->showCurrentBlendAllocation($blendno);
  $output ='';

  if (sizeOf($currentAllocation)> 0) {
    $output .='
    <table id="direct_lot" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="wd-15p">Lot</th>
            <th class="wd-25p">Net</th>
            <th class="wd-25p">Pkgs</th>
            <th class="wd-25p">Kgs</th>
            <th class="wd-25p">Allocation</th>
            <th class="wd-25p">Actions</th>

        </tr>
    </thead>
    <tbody>';
    foreach ($currentAllocation as $stock) {
        $output.='<tr>';
         
            $output.='<td>'.$stock["lot"].'</td>';
            $output.='<td>'.$stock["net"].'</td>';
            $output.='<td>'.$stock["pkgs"].'</td>';
            $output.='<td>'.$stock["kgs"].'</td>';
            $output.='<td>'.$stock["allocation"].'</td>';  
            $output.='<td></td>';               
             
        $output.='</tr>';
            }

    $output.='</tbody>
</table>';
        }
echo $output;
}
if(isset($_POST['action']) && $_POST['action'] == 'composition'){
  $blendno = $_POST['blendno'];
  $expected = $blendingCtrl->expectedComposition($blendno);
  $current = $blendingCtrl->currentComposition($blendno);

    $output .='
    <table style="height:200px;" id="compositionTable" class="table table-striped table-sm table-condensed table-bordered">
    <tbody style="height:20vH";>';
    if (sizeOf($expected)> 0) {
      $output.='
        <tr style="padding:0px !important">
            <td style="padding:0px !important">Code</td>
            ';
            foreach ($expected as $code) {
              $output.='<td style="padding:0px !important">'.$code['name'].'</td>';
            }
        '</tr>';
        $output.='
        <tr style="width:1%">
            <td>Percentage</td>
            ';
            foreach ($expected as $code) {
              $output.='<td>'.$code['percentage'].'%</td>';
            }
        '</tr>';
    }
    if (sizeOf($current)> 0) {
      $output.='
        <tr style="width:1%">
            <td>Current</td>
            ';
            foreach ($current as $code) {
              $output.='<td>'.$code['grade'].'</td>';
            }
        '</tr>';
        $output.='
        <tr style="width:1%">
            <td>Expected</td>
            ';
            foreach ($current as $code) {
              $output.='<td>'.$code['percentage'].'%</td>';
            }
        '</tr>';
    }
    $output.='</tbody>
</table>';
        
echo $output;


}




