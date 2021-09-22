<?php
session_start();
header("Access-Control-Allow-Origin: *");
include '../../database/connection.php';
include '../../models/Model.php';
include '../../controllers/ShippingController.php';



$db = new Database();
$conn = $db->getConnection();
$action = isset($_POST['action']) ? $_POST['action'] : '';
$shippingCtrl = new ShippingController($conn);
if($action=='add-si'){
    unset($_POST['action']);
    unset($_POST['buyerid']);
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
                <th class="wd-15p">Lots No</th>
                <th class="wd-15p">Ware Hse.</th>
                <th class="wd-20p">Company</th>
                <th class="wd-15p">Mark</th>
                <th class="wd-10p">Grade</th>
                <th class="wd-25p">Invoice</th>
                <th class="wd-25p">Type</th>
                <th class="wd-25p">Kgs</th>
                <th class="wd-25p">Pkgs IN Stock</th>
                <th class="wd-25p">SI Allocation</th>
                <th class="wd-25p">Net</th>
                <th class="wd-25p">Gross</th>
                <th class="wd-25p">Value</th>
                <th class="wd-25p">Comment</th>
                <th class="wd-25p">Standard</th>
                <th class="wd-25p">Select</th>

            </tr>
        </thead>
        <tbody>';
        foreach ($stockList as $stock) {
            $output.='<tr>';
            $currentAllocation = $stock["pkgs"];
            if($stock["current_allocation"] > 0){
                $currentAllocation = $stock["current_allocation"];
            }
            $blendBalance = $stock["pkgs"];
            $gross = $stock["gross"];
            $net = $stock["net"];
            if($type =="blend"){
                $blendBalance = $stock["pkgs"]-$stock["current_allocation"];
                $gross = $blendBalance*$stock["kgs"];
                $net = $gross-$stock["tare"];
                $gross = $blendBalance*$stock["kgs"];
                $net = $gross-$stock["tare"];
            }
                $output.='<td>'.$stock["lot"].'</td>';
                $output.='<td>'.$stock["ware_hse"].'</td>';
                $output.='<td>'.$stock["company"].'</td>';
                $output.='<td>'.$stock["mark"].'</td>';
                $output.='<td>'.$stock["grade"].'</td>';
                $output.='<td>'.$stock["invoice"].'</td>';
                $output.='<td>'.$stock["type"].'</td>';
                $output.='<td>'.$stock["kgs"].'</td>';
                $output.='<td>'.$blendBalance.'</td>';
                if($type =="blend"){
          
                    $output.='<td><input id="'.$stock["stock_id"].'" onclick="splitLot(this.id)" class="packages" value="'.$currentAllocation.'"></input></td>';
                }else{
                    $output.='<td>'.$blendBalance.'</td>';
                }
                $output.='<td>'.$net.'</td>';
                $output.='<td>'.$gross.'</td>';
                $output.='<td>'.$stock["value"].'</td>';
                $output.='<td>'.$stock["comment"].'</td>';
                $output.='<td>'.$stock["standard"].'</td>';
                if($stock["selected_for_shipment"]==0){
                    $output.='
                    <td>
                        <button id="'.$stock["stock_id"].'" style="background:green; width:50px; color:white;" type="button"  onclick="allocateForShippment(this.id)" name="allocated"><i class="fa fa-plus"></i></button>
                    </td>';
                }else{
                    $output.='
                    <td>
                        <button id="'.$stock["stock_id"].'" style="background:red; width:50px; color:white;" type="button"  onclick="deAllocateForShippment(this.id)" name="allocated"><i class="fa fa-minus"></i></button>
                    </td>';                }                
            $output.='</tr>';
                }

        $output.='</tbody>
    </table>';
            }
   echo $output;
}else if($action=='blend'){
    $_SESSION['blend_details'] = $_POST;
    echo json_encode(array("success"=>200, "message"=>"Blend Saved"));
}else if($action=="si-template"){
    $output = "";
    $siTemp = $shippingCtrl->loadSItemplates(0);
            $output = '<option disabled="" value="..." selected="">select</option>';
    if (sizeOf($siTemp) > 0) {

         foreach($siTemp as $sitemp){
            $output .= '<option value="'.$sitemp['instruction_id'].'">'.$sitemp['contract_no'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
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
}else if($_POST['action']=="session-data"){
    echo json_encode($_SESSION);

}else if($action=="send-to-warehouse"){
    $sino = isset($_POST['sino']) ? $_POST['sino'] :'';
    $notification = isset($_POST['notification']) ? $_POST['notification'] :'';
    $shippingCtrl->completeShipment($sino, $notification);
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

else if($action=="attach-blend-si"){
    $sino = isset($_POST['sino']) ? $_POST['sino'] : '';
    $blendno = isset($_POST['blendno']) ? $_POST['blendno'] : '';
    $shippingCtrl->attachSi($sino, $blendno);
    echo json_encode(array("message"=>"success"));

    
}else if($action == "attach-straight-si"){
    $sino = isset($_POST['sino']) ? $_POST['sino'] : '';
    $contractNo = isset($_POST['contractNo']) ? $_POST['contractNo'] : '';
    $shippingCtrl->attachSiStraight($sino, $contractNo);
    echo json_encode(array("message"=>"success"));

}else if($action =="blendlist"){
    $output = "";
        $blends= $shippingCtrl->blendList();
        $output = '<option disabled="" value="..." selected="">select</option>';
        if (sizeOf($blends) > 0) {
             foreach($blends as $blend){
                $output .= '<option value="
                 '.$blend['id'].'">'.$blend['blend_no'].'</option>';
             }
              echo $output;	
        }else{
            echo '<option disabled="" value="..." selected="">select</option>';
        }
    
}else if($action =="contractnoList"){
    $output = "";
        $contracts= $shippingCtrl->contractList();
        $output = '<option disabled="" value="..." selected="">select</option>';
        if (sizeOf($contracts) > 0) {
             foreach($contracts as $contract){
                $output .= '<option value="
                 '.$contract['si_no'].'">'.$contract['si_no'].'</option>';
             }
              echo $output;	
        }else{
            echo '<option disabled="" value="..." selected="">select</option>';
        }
    

}else if ($action == "clients") {
    $output = "";
    $clients= $shippingCtrl->fetchErpClients();
    $output = '<option disabled="" value="..." selected="">select</option>';
    if (sizeOf($clients) > 0) {
         foreach($clients as $clients){
            $output .= '<option value="'.$clients['address'].'">'.$clients['name'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    } 
}else if ($action == "load-sis") {
    $output = "";
    $contracts= $shippingCtrl->getShippingInstructions();
    // var_dump($contracts);
    $output ='
        <table id="contracts" class="table table-responsive table-sm table-striped table-bordered">
        <thead>
            <tr>
                <th class="wd-15p">Shipping Instruction</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($contracts as $contract) {
            $output.='<tr>';
                $output.='<td id="'.$contract["shippment_type"].'"><a><i id="'.$contract["instruction_id"].'" class="contractno fa fa-folder-o">'.$contract["contract_no"].'</i></a></td>';            
            $output.='</tr>';
        }
        $output.='</tbody>
    </table>';
    echo $output;
    
}else if ($action == "get-blend-no") {
    $contractNo = isset($_POST['contractno']) ? $_POST['contractno'] : '';
    $blendno = $shippingCtrl->getBlendno($contractNo);
    echo json_encode(array("blend_no"=>$blendno));
}else if($action=="edit-si"){
    if(isset($_POST['id'])){
        $siRecord = $shippingCtrl->loadSItemplates($_POST['id']);
        echo json_encode($siRecord);
    }else{
        echo json_encode(array("error_code"=>404, "message"=>"Si Not Found"));

    }       
}else{
    echo json_encode(array("error_code"=>404, "message"=>"Action not found"));
}

?>
