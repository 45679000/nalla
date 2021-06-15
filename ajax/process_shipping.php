<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include '../database/connection.php';
include '../models/Model.php';
include '../controllers/ShippingController.php';


$db = new Database();
$conn = $db->getConnection();
$action = isset($_POST['action']) ? $_POST['action'] : '';
$shippingCtrl = new ShippingController($conn);
if($action=='add-si'){
    unset($_POST['action']);
    $resp = $shippingCtrl->saveSI($_POST, 1);
   
    if($resp !=null){
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
    $stockList = $shippingCtrl->loadUnallocated();
    echo json_encode($stockList);
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
}
else{
    echo json_encode(array("error_code"=>404, "message"=>"Action not found"));

}
?>
