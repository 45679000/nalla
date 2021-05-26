<?php

class Payment{
  
    // database connection and table name
	private $conn;
    public $id;
	public $tbpref;
       
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
	}
    function make_payment($type, $trans_no, $bank_act, $ref, $trans_ref,  $amount,$date){

	try{
		$this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		$sql = "INSERT INTO ".$this->tbpref."bank_trans(type, trans_no, bank_act, ref, trans_ref, trans_date, amount)
		 VALUES (?,?,?,?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $type);
            $stmt->bindParam(2, $trans_no);
			$stmt->bindParam(3, $bank_act);
			$stmt->bindParam(4, $ref);
            $stmt->bindParam(5, $trans_ref);	
			$stmt->bindParam(6, $date);
                        $stmt->bindParam(7, $amount);
			$stmt->execute();
			$insertedRId = $this->conn->lastInsertId();
			if($insertedRId!=0){
				$response = json_encode(array("Success"=>" Payment added"));
			}else{
				$response = json_encode(array("Failed"=>" Payment could not be completed"));

			}
            
			return $response;

	}catch(Exception $ex){
		var_dump($ex);
	}
	
}	function add_gl_trans($type,  $account, $memo, $amount,  $person_type_id, $person_id){
	try {
		$sql2 = "SELECT max(type_no) AS type_no FROM ".$this->tbpref."gl_trans";
		$stmt2 = $this->conn->prepare($sql2);
		$stmt2->execute();
		while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
			$typeNo = $row['type_no']+1;
		}
		$sql="INSERT INTO ".$this->tbpref."gl_trans(`type`, `type_no`, `tran_date`, `account`, `memo_`, `amount`,  `person_type_id`, `person_id`) 
		VALUES (?,?,current_date,?,?,?,?,?)";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1, $type);
		$stmt->bindParam(2, $typeNo);	
		$stmt->bindParam(3, $account);
		$stmt->bindParam(4, $memo);
		$stmt->bindParam(5, $amount);
		$stmt->bindParam(6, $person_type_id);
		$stmt->bindParam(7, $person_id);
		
		$stmt->execute();
	 
	} catch (Exception $ex) {
		var_dump($ex);
	}
}

function add_debtor_trans($trans_no,$type,$version,$debtor_no,$branch_code,$tran_date,$due_date,$reference,$tpe,$order,$ov_amount,$ov_gst,$ov_freight,
	$ov_freight_tax,$ov_discount,$alloc,$prep_amount,$rate,$ship_via,$dimension_id,$dimension2_id,$payment_terms,$tax_included){
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$sql = "INSERT INTO 0_debtor_trans(`trans_no`, `type`, `version`, `debtor_no`, `branch_code`, `tran_date`, `due_date`, `reference`, `tpe`, `order_`, `ov_amount`, `ov_gst`, `ov_freight`, `ov_freight_tax`, `ov_discount`, `alloc`, `prep_amount`, `rate`, `ship_via`, `dimension_id`, `dimension2_id`, `payment_terms`, `tax_included`) 
			VALUES (?,?,?,?,?,current_date,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1,$trans_no);
			$stmt->bindParam(2,$type);
			$stmt->bindParam(3,$version);
			$stmt->bindParam(4,$debtor_no);
			$stmt->bindParam(5,$branch_code);
			$stmt->bindParam(6,$due_date);
			$stmt->bindParam(7,$reference);
			$stmt->bindParam(8,$tpe);
			$stmt->bindParam(9,$order);
			$stmt->bindParam(10,$ov_amount);
			$stmt->bindParam(11,$ov_gst);
			$stmt->bindParam(12,$ov_freight);
			$stmt->bindParam(13,$ov_freight_tax);
			$stmt->bindParam(14,$ov_discount);
			$stmt->bindParam(15,$alloc);
			$stmt->bindParam(16,$prep_amount);
			$stmt->bindParam(17,$rate);
			$stmt->bindParam(18,$ship_via);
			$stmt->bindParam(19,$dimension_id);
			$stmt->bindParam(20,$dimension2_id);
			$stmt->bindParam(21,$payment_terms);
			$stmt->bindParam(22,$tax_included);
			
			$stmt->execute();
	     return 1;
		} catch (Exception $ex) {
			var_dump($ex);
		
		
		}
	}
	function get_invoice($ref){
	try {
		$sql = "SELECT * FROM  ".$this->tbpref."sales_orders WHERE order_no= ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1, $ref);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		   extract($row); 
			   return $row['order_no'];
		   }
	} catch (Exception $ex) {
		var_dump($ex);
	}	
	}


}
