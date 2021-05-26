<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$path_to_root = "";
include($path_to_root . "../db/add_gl_trans.php");

$action = isset($_GET['action']) ? $_GET['action']: die();
$db = new Database();

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
  
    $invoice = new Invoice($conn);
    $invoice->tbpref = $tbpref;

    if($action=='process-payroll'){
        $totalAmount = isset($_GET['total_amount']) ? $_GET['total_amount']: die();
        $BankAccount = isset($_GET['bank_account']) ? $_GET['bank_account']: die();
        $payItems = isset($_GET['items']) ? $_GET['items']: die();
        $totalAmount = isset($_GET['total_amount']) ? $_GET['total_amount']: die();

    }
    if($action=='add-invoice'){
        $customer = new Customer($conn);
        $customer->tbpref = $tbpref;
        $json = file_get_contents('php://input');
        $data = json_decode($json);  
        foreach($data as $invoiceObj){
            $invoicedCustomer =  $customer->get_customer_by_ref($invoiceObj->CustId);
			$nextorder=$invoice->get_next_order_id();
            if($invoicedCustomer){
                $orderId = $invoice->add_sales_order(
                    $nextorder, 
                    0,
                    $invoicedCustomer,
                    30,
                    3,
                    $invoiceObj->RefNo, 
                    '',
                    $invoiceObj->comments,
                    $invoiceObj->OrderDate, 
                    1,
                    1,
                    $invoiceObj->DeliverTo, 
                    $invoiceObj->DeliveryAddress,
                    $invoiceObj->ContactPhoneNo,
                    $invoiceObj->DeliveryCost,
                    'HQ',
                    $invoiceObj->DeliveryDate, 
                    1, 
                    $invoiceObj->InvoiceTotal, 
                    0
                );
              
                if($orderId !=0){
                    $transNo = $invoice->get_next_trans_no();
                    $debtTransRes = $invoice->add_debtor_trans($transNo,
                    10,0,$invoicedCustomer,$invoicedCustomer,$invoiceObj->OrderDate,$invoiceObj->DueDate,$invoiceObj->RefNo,1,$nextorder,$invoiceObj->InvoiceTotal,0,0,
                    0,0,$invoiceObj->InvoiceTotal,0,1,1,0,0,7,1);
                    
                  $transNo1 = $invoice->get_next_trans_no();
                   
                  $invoice->add_debtor_trans($transNo1,
                    13,1,$invoicedCustomer,$invoicedCustomer,$invoiceObj->OrderDate,$invoiceObj->DueDate,'auto',1,$nextorder,$invoiceObj->InvoiceTotal,0,0,
                    0,0,$invoiceObj->InvoiceTotal,0,1,1,0,0,7,1);

                    $debtorTransNno = $invoice->get_next_debtor_trans_no();
                    

                    $invoice->add_gl_trans(10, 	10001, 'admin', -$invoiceObj->InvoiceTotal, null ,$invoicedCustomer,$invoiceObj->OrderDate);
                    $invoice->add_gl_trans(10, 	2000, 'admin', $invoiceObj->InvoiceTotal, 2 ,$invoicedCustomer,$invoiceObj->OrderDate);

                    $itemsArray = $invoiceObj->items;
                        foreach ($itemsArray as $item) {
                            $srcId = $invoice->add_items($nextorder, 30, $item->Item, $item->Description, $item->UnitPrice, $item->Quantity);
                            $rid=  $invoice->add_debtor_trans_details($transNo1, 13, $item->Item, $item->Description, $item->UnitPrice, 0, $item->Quantity, 0, 0, $item->Quantity, $srcId);
                                                $invoice->add_debtor_trans_details($transNo, 10, $item->Item, $item->Description, $item->UnitPrice, 0, $item->Quantity, 0, 0, $item->Quantity, $rid);
                              }
                }
                echo json_encode(array("Success"=>"Invoice added","Invoice"=>$nextorder));
            
            }else{
                echo(json_encode(array("Error"=>"Customer does not exist")));
                die(); 

            }
            
            }
            
    }
    if($action=='update-invoice'){
        // $id = isset($_GET['order-id']) ? $_GET['order-id']: die();
        $json = file_get_contents('php://input');
        $data = json_decode($json);   
        foreach($data as $invoiceObj){
            $response = $invoice->update_sales_order(
            $invoiceObj->order_no, 
            $invoiceObj->type,
            $invoiceObj->debtor_no,
            $invoiceObj->trans_type,
            $invoiceObj->branch_code, 
            $invoiceObj->customer_ref,
            $invoiceObj->reference, 
            $invoiceObj->comments,
            $invoiceObj->ord_date, 
            $invoiceObj->order_type,
            $invoiceObj->ship_via, 
            $invoiceObj->deliver_to, 
            $invoiceObj->delivery_address,
            $invoiceObj->contact_phone,
            $invoiceObj->freight_cost,
            $invoiceObj->from_stk_loc,
            $invoiceObj->delivery_date, 
            $invoiceObj->payment_terms, 
            $invoiceObj->total, 
            $invoiceObj->prep_amount
            ); 
            
        }
        echo json_encode($response);
    }
    if($action=='delete-invoice'){
        $id = isset($_GET['order-id']) ? $_GET['order-id']: die();
        $response = $invoice->delete_sales_order($id);
        echo json_encode($response);
    }
}else{
    echo(json_encode(array("Error"=>"Wrong Username Or password supplied")));
    die(); 
 }

?>
