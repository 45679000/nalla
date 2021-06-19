<?php

class Gl{
  
    // database connection and table name
	private $conn;
	public $tbpref;
       
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
	}

   
function add_gl_trans($type, $supplier_id, $person_type_id, $person_detail_id, $amount,
	$bank_account, $narrative, $cheque_no, $trans_no, $ref, $pay_items)
{

	try{
		$sql = "INSERT INTO  ".$this->tbpref."add_approval_workflow (`type`, `supplier_id`, `person_type_id`, `person_detail_id`, `amount`, 
         `bank_account`, `narrative`,  `cheque_no`,  `trans_no`, `ref`, `pay_items`) 
		VALUES (?,?,?,?,?,?,?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1, $type);
			$stmt->bindParam(2, $supplier_id);
			$stmt->bindParam(3, $person_type_id);
			$stmt->bindParam(4, $person_detail_id);	
			$stmt->bindParam(5, $amount);
			$stmt->bindParam(6, $bank_account);
			$stmt->bindParam(7, $narrative);
			$stmt->bindParam(8, $cheque_no);
			$stmt->bindParam(9, $trans_no);
			$stmt->bindParam(10, $ref);
			$stmt->bindParam(11, $pay_items);
			$stmt->execute();
			$insertedRId = $this->conn->lastInsertId();
            $response = array(' Payroll Posted', 'RefId'=>$insertedRId);
			return $response;

	}catch(Exception $ex){
		var_dump($ex);
	}
	
}


}
