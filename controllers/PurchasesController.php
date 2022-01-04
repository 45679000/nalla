<?php
class Purchases extends Model
{
    public $cart;
    public $tbpref = "0_";
    public $rollBack = 0;

    //insert into bank trans//
    public function post_purchase(){
        // $this->clean();
        //insert into bank trans//
        $cart = $this->cart;
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->beginTransaction();

        $this->add_audit_trail(18, $cart->trans_no, $cart->user, $cart->description, $cart->fiscal_year,  $cart->trans_date, 0);
        $this->add_audit_trail(25, $cart->trans_no, $cart->user,  $cart->description, $cart->fiscal_year,  $cart->trans_date, 0);
        $this->add_audit_trail(20, $cart->trans_no, $cart->user,  $cart->description, $cart->fiscal_year,  $cart->trans_date, 0);

        $this->add_gl_trans(20,  $cart->trans_no, $cart->stock_id, $cart->description, $cart->total_amount-$cart->withholdingTax,  NULL, NULL);
        $this->add_gl_trans(20,  $cart->trans_no, $cart->payable_account, $cart->memo, -$cart->total_amount,  2, 0x37);
        $this->add_gl_trans(20,  $cart->trans_no, 1080, $cart->memo, $cart->withholdingTax,  2, 0x37);

        $this->add_ref(20, $cart->trans_no, $cart->reference);

        $order_no = $this->purch_orders($cart->supplier_id, $cart->description, $cart->trans_date, "auto", $cart->reference, "DEF", "N/A", $cart->total_amount, 0, 0, 0 );

        $po_detail_item = $this->purch_order_details($order_no, $cart->stock_id, $cart->description, $cart->trans_date, $cart->kgs,  $cart->unit_price, $cart->unit_price, 0, $cart->kgs, $cart->kgs);
        $po_detail_item1 = $this->purch_order_details($order_no, 1062, $cart->description, $cart->trans_date, 1,  $cart->withholdingTax, $cart->withholdingTax, 0, 1, 1);

        $grn_batch_id = $this->grn_batch($cart->supplier_id, $order_no, "auto", $cart->trans_date, "DEF", $cart->rate);

        $grn_item_id = $this->grn_items($grn_batch_id, $po_detail_item, $cart->stock_id, $cart->description, $cart->kgs, $cart->kgs);
		$grn_item_id1 = $this->grn_items($grn_batch_id, $po_detail_item1, 1062, $cart->description, 1, 1);

		$this->supp_trans($cart->trans_no, 20, $cart->supplier_id, $cart->reference, $cart->reference, $cart->trans_date,  $cart->trans_date, $cart->total_amount, $ov_discount=0, $ov_gst=0, $cart->rate, $alloc=0, $tax_included=0);
        $this->supp_invoice_items($cart->trans_no, 20,  $grn_item_id, $po_detail_item, $cart->stock_id, $cart->description,  $cart->kgs, $cart->unit_price, $cart->unit_tax, $cart->memo);
        $this->supp_invoice_items($cart->trans_no, 20,  $grn_item_id1, $po_detail_item1, 1062, "Witholding-Tea Brokerage Fees",  1, $cart->withholdingTax, $cart->unit_tax, $cart->memo);


        $this->add_memo(20, $cart->trans_no, "TEA Purchase");
		
       if($this->rollBack >8){
            $this->conn->commit();

			return $cart->trans_no;

       }else{
           $this->conn->rollBack();
       }
    }

	public function process_facility(){
        // $this->clean();
        //insert into bank trans//
        $cart = $this->cart;
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->beginTransaction();

        $this->add_audit_trail(0, $cart->trans_no, $cart->user, $cart->description, $cart->fiscal_year,  $cart->trans_date, 0);
       
		$this->add_to_journal(0,  $cart->trans_no, $cart->trans_date, $cart->reference, $cart->source_ref,  $cart->trans_date, $cart->trans_date, "USD", $cart->amount, $cart->rate);

        $this->add_gl_trans(0,  $cart->trans_no, $cart->account1, $cart->description, $cart->amount,  NULL, NULL);
        $this->add_gl_trans(0,  $cart->trans_no, $cart->account2, $cart->memo, -$cart->amount,  NULL, NULL);

		
        $this->add_ref(0, $cart->trans_no, $cart->reference);
       
        $this->add_memo(0, $cart->trans_no, "Deal Transfer");
		
       if($this->rollBack >0){
            $this->conn->commit();

			return $cart->trans_no;

       }else{
           $this->conn->rollBack();
       }
    }
	public function add_to_journal($type,  $trans_no, $trans_date, $reference, $source_ref,  $eventdate, $doc_date, $currency, $amount, $rate){
		try {
			$sql="INSERT INTO `0_journal`(`type`, `trans_no`, `tran_date`, `reference`, `source_ref`, `event_date`, `doc_date`, `currency`, `amount`, `rate`) 
			VALUES (?,?,current_date,?,?,current_date,current_date,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(1, 0);
			$stmt->bindParam(2, $trans_no);	
			$stmt->bindParam(3, $reference);
			$stmt->bindParam(4, $source_ref);
			$stmt->bindParam(5, $currency);
			$stmt->bindParam(6, $amount);
			$stmt->bindParam(7, $rate);
			$stmt->execute();

			return $this->conn->lastInsertId();
            $this->rollBack =+ 1;
		} catch (Exception $ex) {
			var_dump($ex);
		}
	}
    public function add_bank_trans($type, $trans_no, $bank_act, $ref, $trans_date, $amount, $persontype, $personid){
        try {
           

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

            $this->rollBack ++;

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
            $this->rollBack ++;
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
            $this->rollBack ++;

            return $this->conn->lastInsertId();
        } catch (Exception $ex) {
            var_dump($ex);
            return -1;
        }
	}
	public function supp_trans($trans_no, $type, $supplier_id, $reference, $supp_reference, $tran_date,  $due_date, $ov_amount, $ov_discount=0, $ov_gst=0, $rate, $alloc=0, $tax_included=0){
		try {
            
			$sql = "INSERT INTO ".$this->tbpref."supp_trans(`trans_no`, `type`,`supplier_id`, `reference`, `supp_reference`, `tran_date`, `due_date`,  `ov_amount`, `ov_discount`, `ov_gst`, `rate`, `alloc`, `tax_included`)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1,$trans_no);
			$stmt->bindParam(2,$type);
			$stmt->bindParam(3,$supplier_id);
			$stmt->bindParam(4,$reference);
			$stmt->bindParam(5,$supp_reference);
			$stmt->bindParam(6,$tran_date);
			$stmt->bindParam(7,$due_date);
			$stmt->bindParam(8,$ov_amount);
			$stmt->bindParam(9,$ov_discount);
			$stmt->bindParam(10,$ov_gst);
			$stmt->bindParam(11,$rate);
			$stmt->bindParam(12,$alloc);
			$stmt->bindParam(13,$tax_included);

            $stmt->execute();
            $this->rollBack ++;

            return $this->conn->lastInsertId();
        } catch (Exception $ex) {
			
            var_dump($ex);
            return -1;
        }
	}
    public function supp_invoice_items($supp_trans_no, $supp_trans_type, $grn_item_id, $po_detail_item_id, $stock_id, $description,  $quantity, $unit_price, $unit_tax, $memo){
		try {
            
			$sql = "INSERT INTO ".$this->tbpref."supp_invoice_items(`supp_trans_no`, `gl_code`,`supp_trans_type`, `grn_item_id`, `po_detail_item_id`, `stock_id`, `description`,  `quantity`, 
            `unit_price`, `unit_tax`, `memo_`, `dimension_id`, `dimension2_id`)
			VALUES (?,0,?,?,?,?,?,?,?,?,?,0,0)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1,$supp_trans_no);
			$stmt->bindParam(2,$supp_trans_type);
			$stmt->bindParam(3,$grn_item_id);
			$stmt->bindParam(4,$po_detail_item_id);
			$stmt->bindParam(5,$stock_id);
			$stmt->bindParam(6,$description);
			$stmt->bindParam(7,$quantity);
			$stmt->bindParam(8,$unit_price);
			$stmt->bindParam(9,$unit_tax);
			$stmt->bindParam(10,$memo);
            $stmt->execute();
            $this->rollBack ++;

            return $this->conn->lastInsertId();
        } catch (Exception $ex) {
			
            var_dump($ex);
            return -1;
        }
	}
    public function add_gl_trans($type, $typeno, $account, $memo, $amount,  $person_type_id, $person_id){
		try {
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
            $this->rollBack ++;

			$stmt->execute();
            
            return $this->conn->lastInsertId();
	     
		} catch (Exception $ex) {
			return -1;
		}
	}
    public function grn_items($grn_batch_id, $po_detail_item, $item_code, $description, $qty_recd, $quantity_inv){
		try{
			$sql = "INSERT INTO ".$this->tbpref."grn_items (grn_batch_id, po_detail_item, item_code, description, qty_recd, quantity_inv)
			VALUES (?,?,?,?,?,?)";
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(1, $grn_batch_id);
				$stmt->bindParam(2, $po_detail_item);
                $stmt->bindParam(3, $item_code);
				$stmt->bindParam(4, $description);	
				$stmt->bindParam(5, $qty_recd);
				$stmt->bindParam(6, $quantity_inv);
				
				$stmt->execute();
				$insertedRId = $this->conn->lastInsertId();
                $this->rollBack ++;

				return $insertedRId;
		}catch(Exception $ex){
			$this->conn->rollBack();
			echo $ex;
			return -1;

		}
	}
    public function grn_batch($supplier_id, $purch_order_no, $reference, $delivery_date, $loc_code, $rate){
		try{
			$sql = "INSERT INTO ".$this->tbpref."grn_batch (supplier_id, purch_order_no, reference, delivery_date, loc_code, rate)
			VALUES (?,?,?,?,?,?)";
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(1, $supplier_id);
				$stmt->bindParam(2, $purch_order_no);
                $stmt->bindParam(3, $reference);
				$stmt->bindParam(4, $delivery_date);	
				$stmt->bindParam(5, $loc_code);
				$stmt->bindParam(6, $rate);
				
				$stmt->execute();
				$insertedRId = $this->conn->lastInsertId();
                $this->rollBack ++;

				return $insertedRId;
		}catch(Exception $ex){
			$this->conn->rollBack();
			echo $ex;
			return -1;

		}
	}
    public function purch_data($supplier_id, $stock_id, $price, $suppliers_uom, $conversion_factor, $supplier_description){
		try{
			$sql = "INSERT INTO ".$this->tbpref."purch_data (`supplier_id`, `stock_id`, `price`, `suppliers_uom`, `conversion_factor`, `supplier_description`)
			VALUES (?,?,?,?,?,?)";
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam(1, $supplier_id);
				$stmt->bindParam(2, $stock_id);
                $stmt->bindParam(3, $price);
				$stmt->bindParam(4, $suppliers_uom);	
				$stmt->bindParam(5, $conversion_factor);
				$stmt->bindParam(6, $supplier_description);
				
				$stmt->execute();
				$insertedRId = $this->conn->lastInsertId();
                $this->rollBack ++;

				return $insertedRId;
		}catch(Exception $ex){
			$this->conn->rollBack();
			echo $ex;
			return -1;

		}
	}
    public function purch_orders($supplier_id, $comments, $ord_date, $reference, $requisition_no, $into_stock_location, $delivery_address, $total, $prep_amount, $alloc, $tax_included ){
		try {
			$sql2 = "INSERT INTO ".$this->tbpref."purch_orders (`supplier_id`, `comments`, `ord_date`, `reference`, `requisition_no`, `into_stock_location`, `delivery_address`, `total`, `prep_amount`, `alloc`, `tax_included`) 
			VALUES (?,?,?,?,?,?,?,?,?,?,?)";
			$stmt2 = $this->conn->prepare($sql2);
			$stmt2->bindParam(1, $supplier_id);
			$stmt2->bindParam(2, $comments);
			$stmt2->bindParam(3, $ord_date);
			$stmt2->bindParam(4, $reference);
			$stmt2->bindParam(5, $requisition_no);
			$stmt2->bindParam(6, $into_stock_location);
            $stmt2->bindParam(7, $delivery_address);
            $stmt2->bindParam(8, $total);
            $stmt2->bindParam(9, $prep_amount);
            $stmt2->bindParam(10, $alloc);
            $stmt2->bindParam(11, $tax_included);

			$stmt2->execute();
            $this->rollBack ++;

			return $this->conn->lastInsertId();
			
		} catch (Exception $ex) {
			$this->conn->rollBack();
			echo $ex;
			return -1;
		}
	
	}
    public function purch_order_details($order_no, $item_code, $description, $delivery_date, $qty_invoiced,  $unit_price, $act_price, $std_cost_unit, $quantity_ordered, $quantity_received){
		try {
			$sql2 = "INSERT INTO ".$this->tbpref."purch_order_details (`order_no`, `item_code`, `description`, `delivery_date`, `qty_invoiced`, `unit_price`, `act_price`, `std_cost_unit`, `quantity_ordered`, `quantity_received`) 
			VALUES (?,?,?,?,?,?,?,?,?,?)";
			$stmt2 = $this->conn->prepare($sql2);
			$stmt2->bindParam(1, $order_no);
			$stmt2->bindParam(2, $item_code);
			$stmt2->bindParam(3, $description);
			$stmt2->bindParam(4, $delivery_date);
			$stmt2->bindParam(5, $qty_invoiced);
			$stmt2->bindParam(6, $unit_price);
            $stmt2->bindParam(7, $act_price);
            $stmt2->bindParam(8, $std_cost_unit);
            $stmt2->bindParam(9, $quantity_ordered);
            $stmt2->bindParam(10, $quantity_received);

			$stmt2->execute();
            $this->rollBack ++;

			return $this->conn->lastInsertId();
			
		} catch (Exception $ex) {
			$this->conn->rollBack();
			echo $ex;
			return -1;
		}
	
	}	
    public function trans_tax_details($trans_type, $trans_no, $tax_type_id, $rate, $net_amount, $amount, $memo, $reg_type="NULL"){
        try {
            $sql= "INSERT INTO ".$this->tbpref."trans_tax_details (`trans_type`, `trans_no`, `tran_date`, `tax_type_id`, `rate`, `ex_rate`, `included_in_price`, `net_amount`, `amount`, `memo`, `reg_type`)
             VALUES($trans_type, $trans_no, CURRENT_DATE, $tax_type_id, $rate, 1, 0, $net_amount, $amount, '$memo', $reg_type)";
             $stmt = $this->conn->prepare($sql);
             $stmt->execute();
             $this->rollBack ++;

             return $this->conn->lastInsertId();

        } catch (Exception $ex) {
			$this->conn->rollBack();
			echo $ex;
			return -1;
        }
            
    }
    public function add_memo($type, $id, $memo){
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
			$this->rollBack ++;
			echo $ex;
			return -1;
			
		}
	}
	public function add_ref($type, $id, $ref){
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
			$this->rollBack ++;
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
        // DELETE FROM 0_supp_allocations;
        // DELETE FROM 0_supp_invoice_items;
        // DELETE FROM 0_supp_trans;
        // DELETE FROM 0_grn_items;
        // DELETE FROM 0_grn_batch;
        // DELETE FROM 0_purch_data;
        // DELETE FROM 0_purch_orders;
        // DELETE FROM 0_purch_order_details;
		// DELETE FROM 0_journal;


        
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
			$this->conn->prepare("DELETE FROM ".$this->tbpref."supp_allocations")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."supp_invoice_items")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."supp_trans")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."grn_items")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."grn_batch")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."purch_data")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."purch_orders")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."purch_order_details")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."sup_trans")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."journal")->execute();
			$this->conn->prepare("DELETE FROM ".$this->tbpref."gl_trans")->execute();

            $this->conn->commit();
			$this->rollBack ++;

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
					"stock_id"=>1068,
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