<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include '../database/connection.php';
include '../models/Model.php';
include '../modules/cataloguing/Catalogue.php';



$db = new Database();
$conn = $db->getConnection();
$catalogue = new Catalogue($conn);
if (isset($_POST['action']) && $_POST['action'] == "list-brokers") {
    $output = "";

    $brokers = $catalogue->PrintBrokers();
            $output = '<option disabled="" value="..." selected="">select</option>';
    if ($catalogue->totalRowCount("brokers") > 0) {

         foreach($brokers as $broker){
            $output .= '<option value="'.$broker['code'].'">'.$broker['code'].'||'.$broker['name'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
}

if (isset($_POST['action']) && $_POST['action'] == "garden-list") {
    $output = "";

    $gardens = $catalogue->PrintGardens();
            $output = '<option disabled="" value="..." selected="">select</option>';
    if ($catalogue->totalRowCount("brokers") > 0) {

         foreach($gardens as $garden){
            $output .= '<option value="'.$garden['mark'].'">'.$garden['mark'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
}

if (isset($_POST['action']) && $_POST['action'] == "grade-list") {
    $output = "";

    $grades= $catalogue->PrintGrades();
            $output = '<option disabled="" value="..." selected="">select</option>';
    if ($catalogue->totalRowCount("brokers") > 0) {

         foreach($grades as $grade){
            $output .= '<option value="'.$grade['name'].'">'.$grade['name'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
}
if (isset($_POST['action']) && $_POST['action'] == "standard-list") {
    $output = "";

    $standard= $catalogue->PrintStandard();
    $output = '<option disabled="" value="..." selected="">select</option>';
    if (sizeOf($standard) > 0) {
         foreach($standard as $standard){
            $output .= '<option value="'.$standard['id'].'">'.$standard['standard'].'</option>';

         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
    
}

if (isset($_POST['action']) && $_POST['action'] == "lot-list") {
    $output = "";

    if(isset($_POST['id'])){
        $lots= $catalogue->PrintLots($_POST['id']);
        echo json_encode($lots);
    }else{
        $lots= $catalogue->PrintLots(0);

        $output = '<option disabled="" value="..." selected="">select</option>';
        if (sizeOf($lots) > 0) {
             foreach($lots as $lots){
                $output .= '<option value="
                 '.$lots['stock_id'].'">'.$lots['lot']. 
                "<b> ||GARDEN  </b>||".$lots['mark']."  
                GRADE || ".$lots['grade']. " 
                || PACKAGES IN STOCK:".$lots['pkgs'].'</option>';
             }
              echo $output;	
        }else{
            echo '<option disabled="" value="..." selected="">select</option>';
        }
    }
    
}

if (isset($_POST['action']) && $_POST['action'] == "update") {
    $output = "Allocated successfully";
    $tableName = isset($_POST['tableName']) ? $_POST['tableName'] : ''; 
    $value = isset($_POST['value']) ? $_POST['value'] : ''; 
    $id = isset($_POST['id']) ? $_POST['id'] : ''; 
    $columnName = isset($_POST['columnName']) ? $_POST['columnName'] : ''; 

    $catalogue->update($tableName, $value, $id, $columnName);

}
if (isset($_POST['action']) && $_POST['action'] == "add-remark") {
     $remark = $_POST['remark'];
     $lot = $_POST['lot'];
    $catalogue->insertRemarks($remark, $lot);

}
if (isset($_POST['action']) && $_POST['action'] == "remark-opt") {
   echo json_encode($catalogue->loadRemarks());

}
if (isset($_POST['action']) && $_POST['action'] == "clear") {
    $catalogue->clearOffers();
    echo json_encode("offers cleared");
 
 }

?>