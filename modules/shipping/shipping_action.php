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
    $resp = $shippingCtrl->saveSI($_POST, 1);
    $_SESSION['shipment-type'] = $_POST['shippment_type'];
    $_SESSION['blend_details'] = '';

    $_SESSION['current-si-id'] = $resp;
    if($resp !=null){
        echo json_encode(array("success"=>"true", "message"=>"Saved Successfully", "shipment-type"=>$_SESSION['shipment-type']));
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
                <th class="wd-25p">Pkgs</th>
                <th class="wd-25p">Type</th>
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
                $output.='<td>'.$stock["lot"].'</td>';
                $output.='<td>'.$stock["ware_hse"].'</td>';
                $output.='<td>'.$stock["company"].'</td>';
                $output.='<td>'.$stock["mark"].'</td>';
                $output.='<td>'.$stock["grade"].'</td>';
                $output.='<td>'.$stock["invoice"].'</td>';
                $output.='<td>'.$stock["pkgs"].'</td>';
                $output.='<td>'.$stock["type"].'</td>';
                $output.='<td>'.$stock["net"].'</td>';
                $output.='<td>'.$stock["gross"].'</td>';
                $output.='<td>'.$stock["value"].'</td>';
                $output.='<td>'.$stock["comment"].'</td>';
                $output.='<td>'.$stock["standard"].'</td>';
                if($stock["selected_for_shipment"]==0){
                    $output.='<td>
                        <button style="background:green; width:50px; color:white;" type="button"  onclick="myFunction()" name="allocated"><i class="fa fa-plus"></i></button>
                    </td>';
                }else{
                    $output.='<td><input type="button"  name="allocated"><i class="fa fa-minus"></i></button></td>';
                }                
            $output.='</tr>';
                }

        $output.='</tbody>
    </table>';
            }
   echo $output;
}else if(($action=='allocate')){
    $id = isset($_POST['id']) ? $_POST['id'] : die();
    $shippingCtrl->allocateLot($id);
    echo json_encode(array("status"=>"Lot allocated successfully"));
    
}else if(($action=='unallocate')){
    $id = isset($_POST['id']) ? $_POST['id'] : die();
    $shippingCtrl->unAllocateLot($id);
    echo json_encode(array("status"=>"Lot allocated successfully"));
}else if($action=='shippment-summary'){
    echo json_encode($shippingCtrl->summaries());
}else if($action=='blend'){
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
}else if($action=="edit-si"){
    if(isset($_POST['id'])){
        $siRecord = $shippingCtrl->loadSItemplates($_POST['id']);
        echo json_encode($siRecord);
    }else{
        echo json_encode(array("error_code"=>404, "message"=>"Si Not Found"));

    }       
}
else{
    echo json_encode(array("error_code"=>404, "message"=>"Action not found"));
}

?>
