<?php
class Voucher{
  
    // database connection and table name
	private $conn;
	public $customer_id;
	public $tbpref;
       
    // constructor with $db as database connection
    public function __construct($db){
		$this->conn = $db;
		$this->tbpref ='0_';
	}
	

    function check_if_can_approve($userid, $approvaltype){
        $can_approve = 0;

        $sql = "SELECT * FROM  ".$this->tbpref."users WHERE id = ".$userid;
        $stmt2 = $this->conn->prepare($sql);
			$stmt2->execute();
			while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
                if($row['role_id']==2 && $approvaltype == 'admin'){
                    $can_approve = 1;
                }else if($row['role_id']==10 && $approvaltype =='subadmin'){
                    $can_approve = 1;
                }else{
                    $can_approve = 0; 
                }                

            }
            return $can_approve;

    }
    function check_role($userid){
        $sql = "SELECT * FROM  ".$this->tbpref."users u
                INNER JOIN ".$this->tbpref."security_roles sr
                ON u.role_id = sr.id
                WHERE u.id = ".$userid;
            $stmt2 = $this->conn->prepare($sql);
			$stmt2->execute();
			$row = $stmt2->fetch(PDO::FETCH_ASSOC);
                    
            return $row;

    }
    function fetch_pending_approvals($roleid){
        $sql = "
        SELECT wkl.id, wkl.type, trans_date, person_type_id, wkl.ref, 
        (CASE
            WHEN person_type_id = 2 THEN deb.name
            WHEN person_type_id = 3 THEN supp_name
            ELSE 'Quick Entry'
        END) AS person_name,
        supp_name, bank_account_name, amount, narrative, aproved_by_admin, aproved_by_sub_admin, voucher_url,
         real_name, cheque_no, trans_no
        FROM  ".$this->tbpref."add_approval_workflow wkl
        LEFT JOIN ".$this->tbpref."suppliers sup ON sup.supplier_id = wkl.supplier_id
        LEFT JOIN ".$this->tbpref."debtors_master deb ON deb.debtor_no = wkl.supplier_id
        INNER JOIN ".$this->tbpref."bank_accounts bka ON bka.id = wkl.bank_account
        INNER JOIN ".$this->tbpref."users u ON u.id = wkl.user_id";
        if($roleid==2){
            $sql .= " WHERE aproved_by_sub_admin = 1";
        }
        $stmt2 = $this->conn->prepare($sql);
        $stmt2->execute();
        return $row = $stmt2->fetchAll(PDO::FETCH_ASSOC);
		
    }

    function fetch_approved($id){
        $sql = "
        SELECT wkl.id, wkl.type, trans_date, person_type_id, wkl.bank_account, wkl.approval_date, wkl.ref,
        (CASE
            WHEN person_type_id = 2 THEN deb.name
            WHEN person_type_id = 3 THEN supp_name
            ELSE 'Quick Entry'
        END) AS person_name, wkl.supplier_id,
        supp_name, bank_account_name, amount, narrative, aproved_by_admin, aproved_by_sub_admin, voucher_url,
         real_name, cheque_no, trans_no, pay_items, wkl.person_detail_id
        FROM  ".$this->tbpref."add_approval_workflow wkl
        LEFT JOIN ".$this->tbpref."suppliers sup ON sup.supplier_id = wkl.supplier_id
        LEFT JOIN ".$this->tbpref."debtors_master deb ON deb.debtor_no = wkl.supplier_id
        INNER JOIN ".$this->tbpref."bank_accounts bka ON bka.id = wkl.bank_account
        INNER JOIN ".$this->tbpref."users u ON u.id = wkl.user_id
        WHERE wkl.id = ".$id;
        $stmt2 = $this->conn->prepare($sql);
        $stmt2->execute();
        return $row = $stmt2->fetch(PDO::FETCH_ASSOC);
		
    } 

    function check_if_approved($id){
        $sql = "SELECT wkl.id, type
                FROM  ".$this->tbpref."add_approval_workflow wkl
                WHERE aproved_by_admin = 1 AND aproved_by_sub_admin = 1 AND  wkl.id = ".$id;
        $stmt2 = $this->conn->prepare($sql);
        $stmt2->execute();
        return $row = $stmt2->fetch(PDO::FETCH_ASSOC);
        
		
    }

    function update_approval($paymentid, $type_no, $cheque_no, $mode_, $id){
        try {
            $sql = "UPDATE ".$this->tbpref."add_approval_workflow SET trans_no =".$paymentid."  WHERE id = '".$id."'";
            $stmt2 = $this->conn->prepare($sql);
            $stmt2->execute();
        } catch (Exception $ex) {
            var_dump($ex);
        }
       

            $sql = "INSERT INTO ".$this->tbpref."payment_types(type, id, mode_, cheque_no)
			VALUES (?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(1,$paymentid);
			$stmt->bindParam(2,$type_no);
			$stmt->bindParam(3,$mode_);
			$stmt->bindParam(4,$cheque_no);
		
			$stmt->execute();
	     return $this->conn->lastInsertId();
            
    }

    function approve_voucher($type, $id, $action){
        $completed = 0;
        if($type=='2' && $action==1){
            $sql = "UPDATE ".$this->tbpref."add_approval_workflow SET aproved_by_admin = 1, approval_date=current_date() WHERE id = ".$id;
            $stmt2 = $this->conn->prepare($sql);
            $stmt2->execute();
            $completed = 1;
        }elseif($type=='2' && $action==0){
            $sql = "UPDATE ".$this->tbpref."add_approval_workflow SET aproved_by_admin = 0, approval_date=current_date() WHERE id = ".$id;
            $stmt2 = $this->conn->prepare($sql);
            $stmt2->execute();
            $completed = 1;
        }elseif($type=='10' && $action==1){
            $sql = "UPDATE ".$this->tbpref."add_approval_workflow SET aproved_by_sub_admin = 1, approval_date=current_date() WHERE id = ".$id;
            $stmt2 = $this->conn->prepare($sql);
            $stmt2->execute();
            $completed = 1;
        }elseif($type=='10' && $action==0){
            $sql = "UPDATE ".$this->tbpref."add_approval_workflow SET aproved_by_sub_admin = 0, approval_date=current_date() WHERE id = ".$id;
            $stmt2 = $this->conn->prepare($sql);
            $stmt2->execute();
            $completed = 1;
        }else{
            $completed = 0;
        }
        return $completed;
    }
	
}


?>