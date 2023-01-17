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
			$output .="<table  class='table table-striped table-sm table-bordered table-hover thead-dark'>
			        <thead class='thead-dark'>
			          <tr>
                  <th>Blend Date</th>
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
                $output .="<table id='grid' style='width:100%;' class='table table-sm table-striped table-bordered table-hover'>
                        <thead class='thead-light'>
                          <tr>
                            <th>Blend Name</th>
                            <th>Contract No</th>
                            <th>Client</th>
                            <th>STD</th>
                            <th>Grade</th>
                            <th>Expected PKgs</th>
                            <th>Expected Kgs</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Blend Sheet</th>
                            <th>Confirm</th>
                          </tr>
                        </thead>
                        <tbody>";
                foreach ($blends as $blend) {
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
                            <td>".$blend['Pkgs']."</td>
                            <td>".$totalKgs."</td>
                            <td>".$status."</td>
                            <td>
                              <a style='color:red' class='editWindow' id='".$blend['id']."'>
                                <i class='fa fa-pencil' ></i>
                                Edit Blend
                              </a>
                            </td>
                            <td>
                              <a style='color:green' data-toggle='modal' 
                                class='blendSheet' id='".$blend['id']."'><i class='fa fa-file'></i>
                                Blend Sheet
                              </a>
                            </td>
                            <td>";
                            if($blend['approved']==0){
                              $output .= "
                              <a onclick='approveBlend(this)' style='color:red' class='confirm' id='".$blend['id']."'>
                                  <i class='fa fa-check' ></i>
                                  Confirm Blend
                                </a>
                              ";
                            }else{
                              $output .= "
                              <a  style='color:green'><i class='fa fa-check' ></i>
                                  Confirmed
                                </a>
                              ";
                            }
                                
                            $output.="</td>
                            <td></td>

                                  
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
  $stock_id = $_POST['stockid'];
  $blendNo = $_POST['blendno'];
  $blendingCtrl->addLotAllocationToBlend($stock_id, $blendNo);
}
if(isset($_POST['action']) && $_POST['action'] == "remove-blend-teas"){
  $id = $_POST['id'];
  $blendno = $_POST['blendno'];
  echo $blendingCtrl->removeLotAllocationFromBlend($id, $blendno);
}
if(isset($_POST['action']) && $_POST['action'] == 'load-unallocated'){
  $type = isset($_POST['type']) ? $_POST['type'] : '';
  $mark = isset($_POST['mark']) ? $_POST['mark'] : 'All';
  $lot = isset($_POST['lot']) ? $_POST['lot'] : 'All';
  $grade = isset($_POST['grade']) ? $_POST['grade'] : 'All';
  $saleno = isset($_POST['saleno']) ? $_POST['saleno'] : 'All';


  $filters = array();
  $filters['saleno'] = 'All';
  $filters['mark'] =  'All';
  $filters['lot'] =  'All';
  $filters['grade'] =  'All';
  $filters['broker'] = 'All';
  $filters['standard'] ='All';
  $filters['gradecode'] = 'All';



  $blendBalance = 0;
  $output ="";
  $stockList = $stockCtrl->readStock("", $filters);
  if (sizeOf($stockList)> 0) {
      $output .='
      <table id="direct_lot" class="table table-sm table-responsive table-striped table-bordered">
      <thead>
          <tr>
              <th>Line No</th>
              <th>Sale No</th>
              <th>DD/MM/YY</th>
							<th>Broker</th>
							<th>Warehouse</th>
              <th>Lot</th>
              <th>Mark</th>
              <th>Grade</th>
              <th>Invoice</th>
              <th>Code</th>
              <th>Pkgs</th>
              <th>Net</th>
              <th>Kgs</th>
              <th>Actions</th>

          </tr>
      </thead>
      <tbody>';
      foreach ($stockList as $stock) {
          $output.='<tr>';
              $output.='<td>'.$stock["line_no"].'</td>';
              $output.='<td>'.$stock["sale_no"].'</td>';
              $output.='<td>'.$stock['import_date'].'</td>';
              $output.='<td>'.$stock["broker"].'</td>';
              $output.='<td>'.$stock["ware_hse"].'</td>';
              $output.='<td>'.$stock["lot"].'</td>';
              $output.='<td>'.$stock["mark"].'</td>';
              $output.='<td>'.$stock["grade"].'</td>';
              $output.='<td>'.$stock["invoice"].'</td>';
              $output.='<td>'.$stock["comment"].'</td>';
              $output.='<td>'.$stock["pkgs"].'</td>';
              $output.='<td>'.$stock["net"].'</td>';
              $output.='<td>'.$stock["kgs"].'</td>';
              if($stock["allocated_contract"] != null){
                $output.='<td><a style="font-size:8px;">'.$stock["allocated_contract"].'<a/></td>';
              }else{
                $output.='<td>
                <a class="addTea" id="'.$stock["stock_id"].'" style="color:green" data-toggle="tooltip" data-placement="bottom" title="Use Tea" >
                <i class="fa fa-arrow-right" ></i></a>&nbsp&nbsp&nbsp;
                <a class="splitLot" id="'.$stock["stock_id"].'" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Split Lot">
                <i class="fa fa-scissors"></i></a>&nbsp&nbsp&nbsp;
              </td>'; 
              }
                       
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
    <table id="alloc" class="table table-sm table-striped table-bordered">
    <thead>
        <tr>
            <th class="wd-15p">Lot</th>
            <th class="wd-15p">Mark</th>
            <th class="wd-25p">Net</th>
            <th class="wd-25p">Pkgs</th>
            <th class="wd-25p">Kgs</th>
            <th class="wd-25p">Alloc</th>
            <th class="wd-25p">Status</th>

        </tr>
    </thead>
    <tbody>';
    foreach ($currentAllocation as $stock) {
        $output.='<tr>';
         
            $output.='<td>'.$stock["lot"].'</td>';
            $output.='<td>'.$stock["mark"].'</td>';
            $output.='<td>'.$stock["net"].'</td>';
            $output.='<td>'.$stock["pkgs"].'</td>';
            $output.='<td>'.$stock["kgs"].'</td>';
            $output.='<td>'.$stock["allocation"].'</td>'; 
            if($stock["confirmed"]==0){
              $output.='<td> 
              <a class="removeAlloc" id="'.$stock["id"].'" style="color:red" data-toggle="tooltip" data-placement="bottom" 
              title="Remove" >
              <i class="fa fa-close" ></i></a>
              </td>'; 
            }else{
              $output.='<td> 
              <a style="color:green">Confirmed</a>
              </td>'; 
            } 
                       
             
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
  // print_r($expected);
  // echo "current";
  // print_r($current); die();

    $output .='
    <table style="table-layout:fixed; width:100%;" id="compositionTable" class="table table-striped table-sm table-condensed table-bordered">
    <tbody>';
    if (sizeOf($expected)> 0) {
      $output.='
        <tr style="padding:2px !important">
            <td style="padding:2px !important; color:red;">Expected Composition</td>
            ';
            foreach ($expected as $code) {
              $output.='<td style="padding:2px !important; color:red;">'.$code['name'].'</td>';
            }
        '</tr>';
        $output.='
        <tr>
            <td></td>
            ';
            foreach ($expected as $code) {
              $output.='<td style="padding:2px !important; color:red;">'.$code['percentage'].'%</td>';
            }
        '</tr>';
    }
    if (sizeOf($current)> 0) {
      $output.='
        <tr>
            <td style="padding:2px !important; color:green;">This Composition</td>
            ';
            foreach ($current as $code) {
              $output.='<td style="padding:2px !important; color:green;">'.$code['grade'].'</td>';
            }
        '</tr>';
        $output.='
        <tr>
            <td style="padding:2px !important; color:green;"></td>
            ';
            foreach ($current as $code) {
              $output.='<td style="padding:2px !important; color:green;>'.$code['percentage'].'%</td>';
            }
        '</tr>';
    }
    $output.='</tbody>
</table>';
        
echo $output;
}
if(isset($_POST['action']) && $_POST['action'] == 'blend-input-summary'){
  $blendno = $_POST['blendno'];
  $totalPkgsBlended = $blendingCtrl->getTotal("blend_teas", "packages", "WHERE blend_no = $blendno");
  $totalKgsBlended = $blendingCtrl->getTotal("blend_teas", "blend_kgs", "WHERE blend_no = $blendno");
  echo json_encode(
    array(
      "kgsIn" => $totalKgsBlended['blend_kgs'],
      "pkgsIn" => $totalPkgsBlended['packages']

    )
  );

}
if (isset($_POST['action']) && $_POST['action'] == "show-all") {
  $blends = $blendingCtrl->fetchBlends();
  $menu = "
  <table id='menuStraight' class='table table-sm table-responsive'>
      <thead>
          <tr>
              <th>Blend Sheets</th>
          </tr>
      </thead>
      <tbody>";
  foreach ($blends as $blend) {
      $menu.='<tr>';
        $menu.='<td>
          <a class="contractBtn" id="'.$blend["id"].'" style="color:blue;"><i class="fa fa-folder-open-o"></i>'.$blend["std_name"]."/".$blend["blend_no"].'</a>
        </td>';
      $menu.='</tr>';

  }
  $menu.="
  </tbody>
  </table>";

  echo $menu;
}