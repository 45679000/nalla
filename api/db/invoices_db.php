<?php
class Invoice{
  
    // database connection and table name
	private $conn;
	public $customer_id;
	public $tbpref;
       
    // constructor with $db as database connection
    public function __construct($db){
		$this->conn = $db;
		$this->tbpref ='0_';
	}
	function add_sales_order($order_no, $type, $debtor_no, $trans_type, $branch_code, $customer_ref, $reference, $comments,
	 $order_type, $ship_via, $deliver_to, $delivery_address, $contact_phone,$freight_cost, $from_stk_loc, $payment_terms, 
	$total, $prep_amount){
		try{
			$sql = "INSERT INTO ".$this->tbpref."sales_orders (order_no, type, debtor_no, trans_type, branch_code, customer_ref, reference, comments,
			 order_type, ship_via, deliver_to, delivery_address, contact_phone,
			freight_cost, from_stk_loc,  payment_terms, total, prep_amount)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(1, $order_no);
				$stmt->bindParam(2, $type);
				$stmt->bindParam(3, $debtor_no);
				$stmt->bindParam(4, $trans_type);	
				$stmt->bindParam(5, $branch_code);
				$stmt->bindParam(6, $customer_ref);
				$stmt->bindParam(7, $reference);
				$stmt->bindParam(8, $comments);
				$stmt->bindParam(9, $order_type);
				$stmt->bindParam(10, $ship_via);
				$stmt->bindParam(11, $deliver_to);
				$stmt->bindParam(12, $delivery_address);
				$stmt->bindParam(13, $contact_phone);
				$stmt->bindParam(14, $freight_cost);
				$stmt->bindParam(15, $from_stk_loc);
				$stmt->bindParam(16, $payment_terms);
				$stmt->bindParam(17, $total);
				$stmt->bindParam(18, $prep_amount);

				$stmt->execute();
				$insertedRId = $this->conn->lastInsertId();
				return 1;
		}catch(Exception $ex){
			echo $ex;
			return 0;
			

	}
	}
	function add_items($order_no, $trans_type, $stk_code, $description, $unit_price, $quantity){
		try {
			$sql2 = "INSERT INTO ".$this->tbpref."sales_order_details (order_no, trans_type, stk_code, description,qty_sent, unit_price, quantity) 
			VALUES (?, ?,?,?,?,?,?)";
			$stmt2 = $this->conn->prepare($sql2);
			$stmt2->bindParam(1, $order_no);
			$stmt2->bindParam(2, $trans_type);
			$stmt2->bindParam(3, $stk_code);
			$stmt2->bindParam(4, $description);
			$stmt2->bindParam(5, $quantity);
			$stmt2->bindParam(6, $unit_price);
			$stmt2->bindParam(7, $quantity);
			$stmt2->execute();
                        $response = array('Response'=>'Invoice created');
                        return $this->conn->lastInsertId();
			
		} catch (Exception $ex) {
			var_dump($ex);
		}
	
	}	

	function add_bank_trans($type, $trans_no, $bank_act, $ref, $amount, $persontype, $personid){
		try {
			$sql2 = "INSERT INTO `0_bank_trans`(`type`, `trans_no`, `bank_act`, `ref`, `amount`,  `person_type_id`, `person_id`)
			 VALUES (?,?,?,?,?,?,?)";

			$stmt2 = $this->conn->prepare($sql2);
			$stmt2->bindParam(1, $type);
			$stmt2->bindParam(2, $trans_no);
			$stmt2->bindParam(3, $bank_act);
			$stmt2->bindParam(4, $ref);
			$stmt2->bindParam(5, $amount);
			$stmt2->bindParam(6, $persontype);
			$stmt2->bindParam(7, $personid);
			$stmt2->execute();

	        $response = array('Response'=>'created');
            return $this->conn->lastInsertId();
			
		} catch (Exception $ex) {
			var_dump($ex);
		}
	
	}	
	
function delete_sales_order($order_no){
	try{
			$sql = "DELETE FROM ".$this->tbpref."sales_orders WHERE order_no=?";

			$stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $order_no);
            $stmt->execute();
			

			$sql2 = $sql = "DELETE FROM ".$this->tbpref."sales_order_details WHERE order_no = ?";
			$stmt2 = $this->conn->prepare($sql2);
            $stmt2->bindParam(1, $order_no);
			$stmt2->execute();
			return "Deleted";

	}catch(Exception $ex){
		var_dump($ex);
	}
}
	
function update_sales_order($order_no, $type, $debtor_no, $trans_type, $branch_code, $customer_ref, $reference, $comments,
$ord_date, $order_type, $ship_via, $deliver_to, $delivery_address, $contact_phone,$freight_cost, $from_stk_loc, $delivery_date, $payment_terms, 
$total, $prep_amount){
try {
	$sql = "UPDATE ".$this->tbpref."sales_orders SET type = ?,
		debtor_no =?, trans_type=?, branch_code = ?, customer_ref = ?, reference = ?, comments = ?,
		ord_date = ?, order_type = ?, ship_via = ?, deliver_to = ?, delivery_address = ?,
		contact_phone = ?, freight_cost = ?, from_stk_loc = ?, delivery_date = ?,
		payment_terms = ?, total = ?, prep_amount = ?
	 WHERE order_no=?";
		$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(1, $type);
				$stmt->bindParam(2, $debtor_no);
				$stmt->bindParam(3, $trans_type);	
				$stmt->bindParam(4, $branch_code);
				$stmt->bindParam(5, $customer_ref);
				$stmt->bindParam(6, $reference);
				$stmt->bindParam(7, $comments);
				$stmt->bindParam(8, $ord_date);
				$stmt->bindParam(9, $order_type);
				$stmt->bindParam(10, $ship_via);
				$stmt->bindParam(11, $deliver_to);
				$stmt->bindParam(12, $delivery_address);
				$stmt->bindParam(13, $contact_phone);
				$stmt->bindParam(14, $freight_cost);
				$stmt->bindParam(15, $from_stk_loc);
				$stmt->bindParam(16, $delivery_date);
				$stmt->bindParam(17, $payment_terms);
				$stmt->bindParam(18, $total);
				$stmt->bindParam(19, $prep_amount);
				$stmt->bindParam(20, $order_no);
				$stmt->execute();
		$stmt->execute();
	} catch (Exception $ex) {
		echo $ex;
	}

}


	function get_sales_order($order_no){
		
		try {
			$sql = "SELECT `order_no`, `trans_type`, 
		`type`, `debtor_no`, `branch_code`, `reference`, `customer_ref`, `comments`,
		 `ord_date`, `order_type`, `ship_via`, `delivery_address`, `contact_phone`, 
		 `contact_email`, `deliver_to`, `freight_cost`, `from_stk_loc`, `delivery_date`, 
		 `payment_terms`, `total`, `prep_amount`, `alloc` 
		 FROM `".$this->tbpref."sales_orders` 
		 WHERE order_no = ?";
		$stmt = $this->conn->prepare($sql);
		$invoice=array();	
		$stmt->bindParam(1, $order_no);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row); 
				$invoice[]=array(                              
				'id'=>$row['order_no'],
				'TransType'=>$row['trans_type'],
				'Type'=>$row['type'],
				'CustomerId'=>$row['debtor_no'],
				'BranchCode'=>$row['branch_code'],
				'Reference'=>$row['reference'],
				'CustomerRef'=>$row['customer_ref'],
				'Comments'=>$row['comments'],
				'OrderDate'=>$row['ord_date'],
				'OrderType'=>$row['order_type'],
				'DeliveryAddress'=>$row['delivery_address'],
				'ContactPhone'=>$row['contact_phone'],
				'ContactEmail'=>$row['contact_email'],
				'DeliverTo'=>$row['deliver_to'],
				'FleightCost'=>$row['freight_cost'],
				'DeliveryDate'=>$row['delivery_date'],
				'Total'=>$row['total'],
				'PrepAmount'=>$row['prep_amount']
				);
				// var_dump($invoice);
				return $invoice;
			}
			
		
		} catch (Exception $ex) {
			var_dump($ex);
		}
		
	}
	function add_gl_trans($type,  $typeno, $account, $memo, $amount,  $person_type_id, $person_id){
		try {
			$sql2 = "SELECT max(type_no) AS type_no FROM ".$this->tbpref."gl_trans";
			$stmt2 = $this->conn->prepare($sql2);
			$stmt2->execute();
			while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
				$typeNo = $row['type_no'];
			}
			$typeNo=$typeNo+1;
			$sql="INSERT INTO ".$this->tbpref."gl_trans(`type`, `type_no`, `account`, `memo_`, `amount`,  `person_type_id`, `person_id`) 
			VALUES (?,?,?,?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1, $type);
			$stmt->bindParam(2, $typeno);	
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
	function add_debtor_trans($trans_no,$type,$version,$debtor_no,$branch_code,$reference,$tpe,$order,$ov_amount,$ov_gst,$ov_freight,
	$ov_freight_tax,$ov_discount,$alloc,$prep_amount,$rate,$ship_via,$dimension_id,$dimension2_id,$payment_terms,$tax_included){
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$sql = "INSERT INTO 0_debtor_trans(`trans_no`, `type`, `version`, `debtor_no`, `branch_code`, `reference`, `tpe`, `order_`, `ov_amount`, `ov_gst`, `ov_freight`, `ov_freight_tax`, `ov_discount`, `alloc`, `prep_amount`, `rate`, `ship_via`, `dimension_id`, `dimension2_id`, `payment_terms`, `tax_included`) 
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1,$trans_no);
			$stmt->bindParam(2,$type);
			$stmt->bindParam(3,$version);
			$stmt->bindParam(4,$debtor_no);
            $stmt->bindParam(5,$branch_code);
			$stmt->bindParam(6,$reference);
			$stmt->bindParam(7,$tpe);
			$stmt->bindParam(8,$order);
			$stmt->bindParam(9,$ov_amount);
			$stmt->bindParam(10,$ov_gst);
			$stmt->bindParam(11,$ov_freight);
			$stmt->bindParam(12,$ov_freight_tax);
			$stmt->bindParam(13,$ov_discount);
			$stmt->bindParam(14,$alloc);
			$stmt->bindParam(15,$prep_amount);
			$stmt->bindParam(16,$rate);
			$stmt->bindParam(17,$ship_via);
			$stmt->bindParam(18,$dimension_id);
			$stmt->bindParam(19,$dimension2_id);
			$stmt->bindParam(20,$payment_terms);
			$stmt->bindParam(21,$tax_included);
                        
			
			$stmt->execute();
            return $this->conn->lastInsertId();
	     
		} catch (Exception $ex) {
			var_dump($ex);
		
		
		}
	}
	function add_memo($type, $id, $memo){
		try {
			$sql = "INSERT INTO ".$this->tbpref."comments(`type`, `id`, `date_`, `memo_`)
			VALUES (?,?,current_date,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1,$type);
			$stmt->bindParam(2,$id);
			$stmt->bindParam(3,$memo);
			$stmt->execute();
	     return $this->conn->lastInsertId();
			
		} catch (Exception $ex) {
			var_dump($ex);
			return 0;
			
		}
	}


	function add_ref($type, $id, $ref){
		try {
			$sql = "INSERT INTO ".$this->tbpref."refs(`type`, `id`,  `reference`)
			VALUES (?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1,$type);
			$stmt->bindParam(2,$id);
			$stmt->bindParam(3,$ref);
			$stmt->execute();
	     return $this->conn->lastInsertId();
			
		} catch (Exception $ex) {
			var_dump($ex);
			return 0;
			
		}
	}

	function add_payment_type($type, $type_no, $mode_, $cheque_no, $paybillref)
	{
		$sql = "INSERT INTO ".$this->tbpref."payment_types(type, id, mode_, cheque_no, paybill_ref)
			VALUES (?,?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1,$type);
			$stmt->bindParam(2,$type_no);
			$stmt->bindParam(3,$mode_);
			$stmt->bindParam(4,$cheque_no);
			$stmt->bindParam(5,$paybillref);

			$stmt->execute();
	     return $this->conn->lastInsertId();

	}


	function add_audit_trail($type, $trans_no, $user,  $fiscal_year,  $gl_seq){
		try {
			$sql = "INSERT INTO ".$this->tbpref."audit_trail(`type`, `trans_no`, `user`,  `fiscal_year`,  `gl_seq`)
			VALUES (?,?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1,$type);
			$stmt->bindParam(2,$trans_no);
			$stmt->bindParam(3,$user);
			$stmt->bindParam(4,$fiscal_year);
			$stmt->bindParam(5,$gl_seq);
			$stmt->execute();
	     return $this->conn->lastInsertId();
			
		} catch (Exception $ex) {
			var_dump($ex);
			return 0;
			
		}
	}

	function add_customer_alloc($person_id, $amt, $trans_no_from,  $trans_type_from,  $trans_no_to, $trans_type_to){
		try {
			$sql = "INSERT INTO ".$this->tbpref."cust_allocations(`person_id`, `amt`, `trans_no_from`, `trans_type_from`, `trans_no_to`, `trans_type_to`)
			VALUES (?,?,?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1,$person_id);
			$stmt->bindParam(2,$amt);
			$stmt->bindParam(3,$trans_no_from);
			$stmt->bindParam(4,$trans_type_from);
			$stmt->bindParam(5,$trans_no_to);
			$stmt->bindParam(6,$trans_type_to);

			$stmt->execute();
	     return $this->conn->lastInsertId();
			
		} catch (Exception $ex) {
			var_dump($ex);
			return 0;
			
		}
	}


	function add_debtor_trans_details($debtor_trans_no, $debtor_trans_type, $stock_id, $description, $unit_price, $unit_tax, $quantity, $discount_percent, $standard_cost, $qty_done, $src_id){
		try {
			$sql = "INSERT INTO ".$this->tbpref."debtor_trans_details(`debtor_trans_no`, `debtor_trans_type`, `stock_id`, `description`, `unit_price`, `unit_tax`, `quantity`, `discount_percent`, `standard_cost`, `qty_done`, `src_id`)
			VALUES (?,?,?,?,?,?,?,?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1,$debtor_trans_no);
			$stmt->bindParam(2,$debtor_trans_type);
			$stmt->bindParam(3,$stock_id);
			$stmt->bindParam(4,$description);
			$stmt->bindParam(5,$unit_price);
			$stmt->bindParam(6,$unit_tax);
			$stmt->bindParam(7,$quantity);
			$stmt->bindParam(8,$discount_percent);
			$stmt->bindParam(9,$standard_cost);
			$stmt->bindParam(10,$qty_done);
			$stmt->bindParam(11,$src_id);
			$stmt->execute();
	     return $this->conn->lastInsertId();
			
		} catch (Exception $ex) {
			var_dump($ex);
			return 0;
			
		}
	}
	function get_next_trans_no(){
		$transNo=0;
		try {
			$sql2 = "SELECT max(trans_no) AS trans_no FROM ".$this->tbpref."debtor_trans";
			$stmt2 = $this->conn->prepare($sql2);
			$stmt2->execute();
			while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
				$transNo = $row['trans_no']+1;
			}
			return $transNo;
		} catch (Exception $ex) {
			 echo $ex;
		}
	
	}
	function get_invoice_id(){
		$transNo=0;
		try {
			$sql2 = "SELECT max(trans_no) AS trans_no FROM ".$this->tbpref."debtor_trans";
			$stmt2 = $this->conn->prepare($sql2);
			$stmt2->execute();
			while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
				$transNo = $row['trans_no']+1;
			}
			return $transNo;
		} catch (Exception $ex) {
			 echo $ex;
		}
	
	}
	function get_next_debtor_trans_no(){
		$transNo=0;
		try {
			$sql2 = "SELECT max(debtor_trans_no) AS debtor_trans_no FROM ".$this->tbpref."debtor_trans_details";
			$stmt2 = $this->conn->prepare($sql2);
			$stmt2->execute();
			while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
				$transNo = $row['debtor_trans_no']+1;
			}
			return $transNo;
		} catch (Exception $th) {
			echo $th;
		}
		
	}
	
	function get_next_order_id(){
		$transNo=0;
	try {
		$sql2 = "SELECT max(order_no) AS trans_no FROM ".$this->tbpref."sales_orders";
		$stmt2 = $this->conn->prepare($sql2);
		$stmt2->execute();
		while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
			$transNo = $row['trans_no']+1;
		}
		return $transNo;
	} catch (Exception $ex) {
			echo $ex;
	}
}

	function get_account_code($id){
			$item_code = 4080;
		try {
			$sql2 = "SELECT item_code FROM ".$this->tbpref."item_codes WHERE id = ?";
			$stmt2 = $this->conn->prepare($sql2);
			$stmt2->bindParam(1,$id);
			$stmt2->execute();
			while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
				$item_code = $row['item_code'];
			}
			return $item_code;
		} catch (Exception $ex) {
			 echo $ex;
		}
	}
		function get_bank_code($id){
			$acct_code = 1090;
		try {
			$sql2 = "SELECT account_code FROM ".$this->tbpref."bank_accounts WHERE id = ?";
			$stmt2 = $this->conn->prepare($sql2);
			$stmt2->bindParam(1,$id);
			$stmt2->execute();
			while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
				$acct_code = $row['account_code'];
			}
			return $acct_code;
		} catch (Exception $ex) {
			 echo $ex;
		}
	}
	function get_customer_branch($id){
		$cust_branch = "";
	try {
		$sql2 = "SELECT branch_code FROM ".$this->tbpref."cust_branch WHERE debtor_no = ?";
		$stmt2 = $this->conn->prepare($sql2);
		$stmt2->bindParam(1,$id);
		$stmt2->execute();
		while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
			$cust_branch = $row['branch_code'];
		}
		return $cust_branch;
	} catch (Exception $ex) {
		 echo $ex;
	}
}


	function get_account_description($id){
		$item_desc = "Family Day";
	try {
		$sql2 = "SELECT description FROM ".$this->tbpref."item_codes WHERE id =?";
		$stmt2 = $this->conn->prepare($sql2);
		$stmt2->bindParam(1,$id);
		$stmt2->execute();
		while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
			$item_desc = $row['description'];
		}
		return $item_desc;
	} catch (Exception $ex) {
			echo $ex;
	}
	
	}
	function get_next_sales_order_trans_no(){
		$sql2 = "SELECT max(id) AS debtor_trans_no FROM ".$this->tbpref."sales_order_details";
		$stmt2 = $this->conn->prepare($sql2);
		$stmt2->execute();
		while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
			$transNo = $row['debtor_trans_no']+1;
		}
		return $transNo;
	}
	
}
	

?>