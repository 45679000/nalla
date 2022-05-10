<?php
class Sales extends Model
{
    public $cart;
    public $tbpref = "0_";

    //insert into bank trans//
    public function post_pos_sale(){
        // $this->clean();
        //insert into bank trans//
        $cart = $this->cart;
        // $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // $this->conn->beginTransaction();


        $this->add_audit_trail(30, $cart->trans_no, $cart->user, $cart->description, $cart->fiscal_year,  $cart->trans_date, 0);
        $this->add_audit_trail(13, $cart->trans_no, $cart->user,  $cart->description, $cart->fiscal_year,  $cart->trans_date, 0);
        $this->add_audit_trail(10, $cart->trans_no, $cart->user,  $cart->description, $cart->fiscal_year,  $cart->trans_date, 0);

		// $cart->trans_no
        $this->add_debtor_trans($cart->trans_no,10,0,$cart->debtor_no,$cart->branch_code, $cart->due_date,  $cart->reference,2,9, $cart->total_amount, 0, 0,0,0,0, 0,1,1,0,0,4,0);
        $this->add_debtor_trans($cart->trans_no,13,1,$cart->debtor_no,$cart->branch_code, $cart->due_date, 'auto',2,1, $cart->total_amount, 0, 0,0,0,0, 0,1,1,0,0,4,0);

        $this->add_debtor_trans_details($cart->trans_no, 13, $cart->stock_id, $cart->description, $cart->total_amount, $cart->ov_gst, 1, 0, 0, 1, 1);
		$this->add_debtor_trans_details($cart->trans_no, 10, $cart->stock_id, $cart->description, $cart->total_amount, $cart->ov_gst, 1, 0, 0, 0, 1);
	

        $this->add_gl_trans(10,  $cart->trans_no, $cart->stock_id, $cart->description, -$cart->total_amount,  NULL, NULL);
        $this->add_gl_trans(10,  $cart->trans_no, $cart->receivables_account, $cart->memo, $cart->total_amount,  2, 0x37);

	
        $this->add_sales_order($cart->trans_no, 30, 0, $cart->debtor_no, 2, $cart->customer_ref, 'auto', $cart->description, 2, 1, 'CHAMU', 'CHAMU', NULL, 0,'HQ', 4, $cart->total_amount, 0, 0);
        $this->sales_order_details($cart->trans_no, 30, $cart->stock_id, $cart->description, $cart->total_amount, 1);
	
        // $this->trans_tax_details(13, $cart->trans_no,  0, 1, $cart->amount-$cart->ov_gst, $cart->vat,'auto');
        // $this->trans_tax_details(10, $cart->trans_no,  0, 1, $cart->amount-$cart->ov_gst, $cart->vat,$cart->reference,0);


        $this->add_ref(10, $cart->trans_no, $cart->reference);
		$this->add_ref(12, $cart->trans_no, $cart->reference);

        $this->add_memo(13, $cart->trans_no, "TEA Sales");
		$this->add_memo(10, $cart->trans_no, "TEA Sales");
        $this->add_memo(12, $cart->trans_no, "TEA Sales");


    //    if($this->rollBack >2){
    //         $this->conn->commit();
	// 		$this->markPosted();

	// 		return $cart->trans_no;

    //    }else{
    //        $this->conn->rollBack();
    //    }



    }
    public function add_bank_trans($type, $trans_no, $bank_act, $ref, $trans_date, $amount, $persontype, $personid)
    {
        try {
			$this->conn->beginTransaction();
            $sql2 = "INSERT INTO ".$this->tbpref."bank_trans(`type`, `trans_no`, `bank_act`, `ref`, `trans_date`, `amount`,  `person_type_id`, `person_id`)
            VALUES (?,?,?,?,?,?,?,?)";

            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->bindParam(1, $type);
            $stmt2->bindParam(2, $trans_no);
            $stmt2->bindParam(3, $bank_act);
            $stmt2->bindParam(4, $ref);
            $stmt2->bindParam(5, $trans_date);
            $stmt2->bindParam(6, $amount);
            $stmt2->bindParam(7, $persontype);
            $stmt2->bindParam(8, $personid);
            $stmt2->execute();
            return $this->conn->lastInsertId();
            $this->rollBack =+ 1;
        } catch (Exception $ex) {
            var_dump($ex);
            $this->rollBack  = 0;
            return -1;
        }
    }
    public function add_audit_trail($type, $trans_no, $user, $description, $fiscal_year,  $gl_date, $gl_seq){
        //insert into audit trail
        // INSERT INTO `0_audit_trail` (`type`, `trans_no`, `user`, `stamp`, `description`, `fiscal_year`, `gl_date`, `gl_seq`) VALUES
        // (30, 1, 1, '2021-10-08 13:54:57', '', 5, '2021-10-08', 0),
        // (13, 1, 1, '2021-10-08 13:54:57', '', 5, '2021-10-08', 0),
        // (10, 1, 1, '2021-10-08 13:54:57', '', 5, '2021-10-08', 0),
        // (12, 1, 1, '2021-10-08 13:54:58', '', 5, '2021-10-08', 0);
		try {
			$this->conn->beginTransaction();

			$sql = "INSERT INTO ".$this->tbpref."audit_trail(`type`, `trans_no`, `user`, `stamp`, `description`, `fiscal_year`, `gl_date`, `gl_seq`)
			VALUES (?,?,?,CURRENT_TIMESTAMP,?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1,$type);
			$stmt->bindParam(2,$trans_no);
			$stmt->bindParam(3,$user);
            $stmt->bindParam(4,$description);
			$stmt->bindParam(5,$fiscal_year);
            $stmt->bindParam(6,$gl_date);
			$stmt->bindParam(7,$gl_seq);
			$stmt->execute();
			// $this->executeQuery();

            // $this->conn->commit();
			$this->conn->commit();

            return $this->conn->lastInsertId();

        } catch (Exception $ex) {
            var_dump($ex);

            return -1;
        }
	}
    public function add_customer_alloc($person_id, $amt, $date_alloc, $trans_no_from,  $trans_type_from,  $trans_no_to, $trans_type_to){
        //INSERT INTO `0_cust_allocations` (`person_id`, `amt`, `date_alloc`, `trans_no_from`, `trans_type_from`, `trans_no_to`, `trans_type_to`) VALUES
        //(7, 5900, '2021-10-08', 1, 12, 1, 10);
		try {
            $this->conn->beginTransaction();
			$sql = "INSERT INTO ".$this->tbpref."cust_allocations(`person_id`, `amt`, `date_alloc`, `trans_no_from`, `trans_type_from`, `trans_no_to`, `trans_type_to`)
			VALUES (?,?,?,?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1,$person_id);
			$stmt->bindParam(2,$amt);
            $stmt->bindParam(3,$date_alloc);
			$stmt->bindParam(4,$trans_no_from);
			$stmt->bindParam(5,$trans_type_from);
			$stmt->bindParam(6,$trans_no_to);
			$stmt->bindParam(7,$trans_type_to);

			$stmt->execute();
            $this->conn->commit();
            return $this->conn->lastInsertId();
        } catch (Exception $ex) {
            var_dump($ex);
            return -1;
        }
	}
    public function add_debtor_trans($trans_no,$type,$version,$debtor_no,$branch_code,$due_date, $reference,$tpe,$order,$ov_amount,$ov_gst,$ov_freight,
	$ov_freight_tax=0,$ov_discount=0,$alloc,$prep_amount=0,$rate,$ship_via,$dimension_id,$dimension2_id,$payment_terms,$tax_included){
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$this->conn->beginTransaction();
			$sql = "INSERT INTO 0_debtor_trans(`trans_no`, `type`, `version`, `debtor_no`, `branch_code`, `reference`, `tpe`, `order_`, `ov_amount`, `ov_gst`, `ov_freight`, `ov_freight_tax`, `ov_discount`, `alloc`, `prep_amount`, `rate`, `ship_via`, `dimension_id`, `dimension2_id`, `payment_terms`, `tax_included`, `tran_date`, `due_date`) 
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, CURRENT_DATE, ?)";
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
            $stmt->bindParam(22,$due_date); 

            
            $stmt->execute();
            $this->conn->commit();

            return $this->conn->lastInsertId();
        } catch (Exception $ex) {
            var_dump($ex);
            return -1;
        }
	}
    public function add_debtor_trans_details($debtor_trans_no, $debtor_trans_type, $stock_id, $description, $unit_price, $unit_tax, $quantity, $discount_percent, $standard_cost, $qty_done, $src_id){
		try {
            $this->conn->beginTransaction();
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
            $this->conn->commit();

            return $this->conn->lastInsertId();
        } catch (Exception $ex) {
			
            var_dump($ex);
            return -1;
        }
	}
    public function add_gl_trans($type, $typeno, $account, $memo, $amount,  $person_type_id, $person_id){
		try {
			$this->conn->beginTransaction();
			$sql2 = "SELECT max(type_no) AS type_no FROM ".$this->tbpref."gl_trans";
			$stmt2 = $this->conn->prepare($sql2);
			$stmt2->execute();
			while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
				$typeNo = $row['type_no'];
			}
			$typeNo=$typeNo+1;
			$sql="INSERT INTO ".$this->tbpref."gl_trans(`type`, `type_no`, `tran_date`,`account`, `memo_`, `amount`,  `person_type_id`, `person_id`) 
			VALUES (?,?,CURRENT_DATE,?,?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1, $type);
			$stmt->bindParam(2, $typeno);	
            $stmt->bindParam(3, $account);
			$stmt->bindParam(4, $memo);
			$stmt->bindParam(5, $amount);
			$stmt->bindParam(6, $person_type_id);
			$stmt->bindParam(7, $person_id);
            $this->conn->commit();

			$stmt->execute();
            
            return $this->conn->lastInsertId();
	     
		} catch (Exception $ex) {
			return -1;
		}
	}
    public function add_sales_order($order_no, $trans_type, $type, $debtor_no,  $branch_code, $customer_ref, $reference, $comments,
	 $order_type, $ship_via, $deliver_to, $delivery_address, $contact_phone,$freight_cost, $from_stk_loc, $payment_terms, 
	$total, $prep_amount){
		try{
			$this->conn->beginTransaction();
			$sql = "INSERT INTO ".$this->tbpref."sales_orders (order_no, type, version, ord_date, debtor_no, trans_type, branch_code, customer_ref, reference, comments,
			 order_type, ship_via, deliver_to, delivery_address, contact_phone,
			freight_cost, from_stk_loc,  payment_terms, total, prep_amount, delivery_date)
			VALUES (?,?,1,CURRENT_DATE,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, CURRENT_DATE)";
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
                $this->conn->commit();

				return $insertedRId;
		}catch(Exception $ex){
			$this->conn->rollBack();
			echo $ex;
			return -1;

		}
	}
    public function sales_order_details($order_no, $trans_type, $stk_code, $description, $unit_price, $quantity){
		try {
			$this->conn->beginTransaction();
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
            $this->conn->commit();

			return $this->conn->lastInsertId();
			
		} catch (Exception $ex) {
			$this->conn->rollBack();
			echo $ex;
			return -1;
		}
	
	}	
    public function trans_tax_details($trans_type, $trans_no, $tax_type_id, $rate, $net_amount, $amount, $memo, $reg_type="NULL"){
        try {
			$this->conn->beginTransaction();
            $sql= "INSERT INTO ".$this->tbpref."trans_tax_details (`trans_type`, `trans_no`, `tran_date`, `tax_type_id`, `rate`, `ex_rate`, `included_in_price`, `net_amount`, `amount`, `memo`, `reg_type`)
             VALUES($trans_type, $trans_no, CURRENT_DATE, $tax_type_id, $rate, 1, 0, $net_amount, $amount, '$memo', $reg_type)";
             $stmt = $this->conn->prepare($sql);
             $stmt->execute();
             $this->conn->commit();

             return $this->conn->lastInsertId();

        } catch (Exception $ex) {
			$this->conn->rollBack();
			echo $ex;
			return -1;
        }
            
    }
    public function add_memo($type, $id, $memo){
		try {
			$this->conn->beginTransaction();
			$sql = "INSERT INTO ".$this->tbpref."comments(`type`, `id`, `date_`, `memo_`)
			VALUES (?,?,current_date,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1,$type);
			$stmt->bindParam(2,$id);
			$stmt->bindParam(3,$memo);
			$stmt->execute();
			$this->conn->commit();

	     return $this->conn->lastInsertId();
			
		} catch (Exception $ex) {
			$this->conn->commit();
			echo $ex;
			return -1;
			
		}
	}
	public function add_ref($type, $id, $ref){
		try {
			$this->conn->beginTransaction();
			$sql = "INSERT INTO ".$this->tbpref."refs(`type`, `id`,  `reference`)
			VALUES (?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1,$type);
			$stmt->bindParam(2,$id);
			$stmt->bindParam(3,$ref);
			$stmt->execute();
			$this->conn->commit();

	     return $this->conn->lastInsertId();
			
		} catch (Exception $ex) {
			$this->conn->commit();
			echo $ex;
			return -1;
			
		}
	}
    public function clean(){
        // DELETE FROM 0_bank_trans;
        // DELETE FROM 0_audit_trail;
        // DELETE FROM  0_cust_allocations;
        // DELETE FROM 0_debtor_trans;
        // DELETE FROM 0_debtor_trans_details;
        // DELETE FROM 0_gl_trans;
        // DELETE FROM 0_sales_orders;
        // DELETE FROM 0_sales_order_details;
        // DELETE FROM 0_trans_tax_details;
        // DELETE FROM 0_comments;
        // DELETE FROM 0_refs;
        try {
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->beginTransaction();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."bank_trans")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."audit_trail")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."cust_allocations")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."debtor_trans")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."debtor_trans_details")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."gl_trans")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."sales_orders")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."sales_order_details")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."trans_tax_details")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."comments")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."refs")->execute();

            $this->conn->commit();
			$this->conn->commit();

        } catch (\Throwable $th) {
            $this->conn->rollBack();

        }


    }
	public function Cart(){
		$stmt1 = $this->conn->prepare("SELECT  SUM(`amount`) AS total_amount, SUM(`vat`)+SUM(`levy`) AS ov_gst FROM `0_sale_invoice_temp` WHERE posted = 0");
		$stmt1->execute();
		$row = $stmt1->fetch(PDO::FETCH_ASSOC);
		$total_amount = $row['total_amount'];
		$ov_gst = $row['ov_gst'];

		$stmt2 = $this->conn->prepare("SELECT * FROM ".$this->tbpref."sale_invoice_temp WHERE posted = 0");
		$stmt2->execute();

		$stmt = $this->conn->prepare("SELECT (CASE WHEN (max(type_no)) IS NULL THEN 1 ELSE max(type_no)+1 END)  AS trans_no FROM  ".$this->tbpref."gl_trans");
		$stmt->execute();
		$row = $stmt->fetch();
		$this->trans_no = $row["trans_no"];

		

		$cart = new stdClass();
		$line_items = array();
		$id = 0;
		while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
			$id++;
			$items = array(
					"stock_id"=>$row2['code'],
					"description"=>$row2['item'],
					"vat"=>$row2['vat'],
					"levy"=>$row2['levy'],
					"amount"=>$row2['amount'],
					"ov_gst"=>$ov_gst,
			);
			$line_items[$id]=$items;

		}

		$cart = (Object) array(
			"total_amount"=>$total_amount, 
			"personid"=>0x37,
			"persontype"=>2,
			"person_id"=>7,
			"trans_no"=>$this->trans_no, 
			"bank_act"=>50,
			"trans_date"=>$this->trans_date,
			"trans_no_from"=>$this->trans_no,
			"trans_type_from"=>12,
			"trans_type_to"=>10,
			"trans_no_to"=>$this->trans_no,
			"ref"=>$this->reference,
			"user"=>$this->user_id,
			"fiscal_year"=>5,
			"reference"=>$this->reference,
			"memo"=>$this->user_name,
			"customer_ref"=>'',
			"ov_gst" => $ov_gst,
			"line_items"=>$line_items
			
		);

		return $cart;

	}
	public function markPosted(){
		$stmt = $this->conn->prepare("UPDATE ".$this->tbpref."sale_invoice_temp SET posted = 1");
		$stmt->execute();
	}

    
}
