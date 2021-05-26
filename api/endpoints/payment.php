<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$path_to_root = "";
include($path_to_root . "../db/payments_db.php");
include($path_to_root . "../db/customers_db.php");
include($path_to_root . "../db/invoices_db.php");


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
    echo json_encode("Missing username or password");
    exit;
}

if($authenticated!= -1){
    $payment = new Payment($conn);
    $payment->tbpref = $tbpref;

    if($action=='make-payment'){
        $customer = new Customer($conn);
        $customer->tbpref = $tbpref;

        $invoice = new Invoice($conn);
        $invoice->tbpref = $tbpref;

        $json = file_get_contents('php://input');
        $data = json_decode($json);  
		$transNo = $invoice->get_next_trans_no();
        foreach($data as $payObj){
			
				
			 $Inv =  $payment->get_invoice($payObj->Invoice);
				 
			  if($payObj->Invoice && !$Inv){
				 
                echo(json_encode(array("Error"=>"Invoice does not exist")));
                die(); 
			}
           
		    $invoicedCustomer =  $customer->get_customer_by_ref($payObj->CustId);
            if($invoicedCustomer){
              //  $nextorder=$invoice->get_next_order_id();
				if ($payObj->Invoice==''){
					$Inv=0;
				}

                $response= $payment->make_payment(
                    12, 
                    $transNo, 
                    $payObj->BankAcct, 
                    $payObj->TransactionRef, 
                    $payObj->TransactionRef, 
                    $payObj->Amount,
                        $payObj->TransDate 
                        );
              echo $response;  
            
                    
                    $debtTransRes = $invoice->add_debtor_trans($transNo,
                    12,0,$invoicedCustomer,$invoicedCustomer,$payObj->TransDate ,$payObj->TransDate, $payObj->TransactionRef,1, $Inv,$payObj->Amount,0,0,
                    0,0,$payObj->Amount,0,1,1,0,0,7,1);
                   

                    $debtorTransNno = $invoice->get_next_debtor_trans_no();
            $payment->add_gl_trans(12, 	1020, 'admin', $payObj->Amount, null ,$invoicedCustomer);
            $payment->add_gl_trans(12, 	2000, 'admin', -$payObj->Amount, 2 ,$invoicedCustomer);

            

            }else{
                echo(json_encode(array("Error"=>"Customer does not exist")));
                die(); 

            }
            }
			
		}
       
           
    
}else{
    echo(json_encode(array("Error"=>"Wrong Username Or password supplied")));
    die(); 
 }

?>
