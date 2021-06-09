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





?>