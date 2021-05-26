<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$path_to_root = "";

include($path_to_root . "../db/customers_db.php");
include("../db/connect_db.php");
$action = isset($_GET['action']) ? $_GET['action']: die();
$db = new Database();
$companyid = isset($_GET['company-id']) ? $_GET['company-id'] : '';

if(($companyid=='KAMP')||($companyid=='KPM')||($companyid=='PRISK')){
    $db->companyid = $companyid;
    $conn = $db->getConnection()->conn;
    $tbpref = $db->getConnection()->tbpref;

}else{
    var_dump(json_encode(array("Error"=>"The company does not exist")));
    die();
}

$authenticated;
if(isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_PW']){
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
    $authenticated= $db->authenticate($username, $password);
}else{
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    var_dump(json_encode(array("Error"=>"Username or password missing")));
    exit;
}
if($authenticated!= -1){
$customer = new Customer($conn);
$customer->tbpref = $tbpref;
if($action=='get-customer'){
    $customerId = isset($_GET['customer-id']) ? $_GET['customer-id']: die();
    $results = $customer->get_customer($customerId);
    echo json_encode($results);
}
if($action=='add-customer'){
    $json = file_get_contents('php://input');
    $data = json_decode($json);   
    foreach($data as $customerObj){
        $response = $customer->add_customer(
            $customerObj->CustName,        
            $customerObj->CustId,
            $customerObj->Address,
            $customerObj->TaxId,
            $customerObj->CurrencyCode,
            0,
            0,         
            $customerObj->SalesType,
            $customerObj->CreditStatus,
            $customerObj->PaymentTerms,  
            $customerObj->Discount,
            $customerObj->paymentDiscount,  
            $customerObj->CreditLimit, 
            0,
            $customerObj->Notes  
        );        
    }
    echo json_encode($response);
}
if($action=='update-customer'){
    $customerId = isset($_GET['customer-id']) ? $_GET['customer-id']: die();
    $customer->customer_id=$customerId;
    $json = file_get_contents('php://input');
    $data = json_decode($json);   
    foreach($data as $customerObj){
        $response = $customer->update_customer(
            $customerObj->CustName,        
            $customerObj->Address,
            $customerObj->TaxId,
            $customerObj->CurrencyCode,       
            $customerObj->SalesType,
            $customerObj->CreditStatus,
            $customerObj->PaymentTerms,  
            $customerObj->Discount,
            $customerObj->paymentDiscount,  
            $customerObj->CreditLimit, 
            $customerObj->Notes  
        );        
    }
    echo json_encode($response);
}
if($action=='delete-customer'){
    $customerId = isset($_GET['customer-id']) ? $_GET['customer-id']: die();
    $customer->customer_id=$customerId;
    $response = $customer->delete_customer();
    echo json_encode($response);
}
}else{
    var_dump(json_encode(array("Error"=>"Wrong Username Or password supplied")));
    die(); 
 }

?>
