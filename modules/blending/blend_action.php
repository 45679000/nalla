<?php
	// Include config.php file
    include_once('../../models/Model.php');
    include_once('../../database/page_init.php');

	include_once('../../controllers/ShippingController.php');

    $shippingCtrl = new ShippingController($conn);

	// Insert Record	
	if (isset($_POST['action']) && $_POST['action'] == "insert") {
		$blendno = isset($_POST['blendno']) ? $_POST['blendno'] : die('blendno required field');
		$clientid = isset($_POST['clientid']) ? $_POST['clientid'] : die('clientidrequired field');
        $stdname = isset($_POST['stdname']) ? $_POST['stdname'] : die('stdname required field');
        $grade = isset($_POST['grade']) ? $_POST['grade'] : die('grade required field');
        $pkgs = isset($_POST['pkgs']) ? $_POST['pkgs'] : die('pkgs required field');
        $nw = isset($_POST['nw']) ? $_POST['nw'] : die('nw required field');
echo $blendno; 
        $shippingCtrl->saveBlend($blendno, $clientid, $stdname, $grade, $pkgs, $nw);

	}

	// View record
	if (isset($_POST['action']) && $_POST['action'] == "view") {
		$output = "";
        $blends = $shippingCtrl->fetchBlends();
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
                         <a href='./index.php?view=allocateblendteas&blendno=".$blend['blend_no']."' style='color:green' 
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
            $blends = $shippingCtrl->fetchBlends($blendno);
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
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>";
                foreach ($blends as $blend) {
                    $kgs = $blend['nw']*$blend['Pkgs'];
                $output.="<tr>
                            <td id='lotShow'><a href='#' onclick='loadAllocationSummaryForBlends()'>".$blend['blend_no']."</a></td>
                            <td>".$blend['client_name']."</td>
                            <td>".$blend['std_name']."</td>
                            <td>".$blend['Grade']."</td>
                            <td>".$blend['Pkgs']."</td>
                            <td>".$blend['nw']."</td>
                            <td>".$kgs."</td>
                            <td id='totalPkgs'></td>
                            <td id='totalNet'></td>
                            <td id='totalkgs'></td>

                            <td>
                             <a href='./index.php?view=allocateblendteas&blendno=".$blend['blend_no']."' style='color:green' 
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
        }	
	}
    if (isset($_POST['action']) && $_POST['action'] == "insert") {
		
        $shippingCtrl->shipmentSummaryBlend($blendno);

	}


	// Edit Record	
	// if (isset($_POST['editId'])) {
	// 	$editId = $_POST['editId'];
	// 	$row = $shippingctrl->getRecordById($editId);
	// 	echo json_encode($row);
	// }

    // if (isset($_POST['action']) && $_POST['action'] == "update") {

	// 	$name = $_POST['name'];
	// 	$country = $_POST['country'];
    //     $id = $_POST['id'];
	// 	$shippingctrl->updateRecord($id, $name,  $country);
	// }

    // 	// Delete Record	
	// if (isset($_POST['deleteId'])) {
	// 	$deleteId = $_POST['deleteId'];
	// 	$row = $shippingctrl->delete($deleteId);
	// 	echo json_encode(array("msg"=>"Record Deleted Successfully"));
	// }

    

?>