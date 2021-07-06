<?php
Class ShippingController extends Model{
    public function saveSI($post, $step){
        $this->data = $post;
        $this->tablename = "shipping_instructions";
        $id = $this->insertQuery();
        return $id;
    }

    public function getShippingInstructions(){
        $this->query = "SELECT *FROM shipping_instructions LIMIT 1";
        return $this->executeQuery();
    }
    public function getAtciveShippingInstructions($id){
        $this->tablename ="shipping_instructions";
        return $this->selectOne($id, "instruction_id");
    }
        

    public function updateShippingInstructions(){
        $this->query = "SELECT *FROM shipping_instructions LIMIT 1";
        return $this->executeQuery();
    }
    public function loadUnallocated(){
        $this->query = "SELECT *FROM closing_stock WHERE pkgs>0";
        return $this->executeQuery();
    }
    public function allocateForShippment($id, $client_id){
        $this->query = "UPDATE closing_stock SET selected_for_shipment = 1 WHERE stock_id = ".$id;
        $this->executeQuery();
        $this->query = "REPLACE INTO stock_allocation(stock_id, client_id, allocated_pkgs) 
        SELECT stock_id, $client_id, pkgs
        FROM closing_stock WHERE stock_id= ".$id;
        return $this->executeQuery();
    }
    public function unAllocateForShippment($id, $client_id){
        $this->query = "UPDATE closing_stock SET selected_for_shipment = 0 WHERE stock_id = ".$id;
        $this->query = "DELETE FROM stock_allocation WHERE stock_id = ".$id. " AND client_id = ".$client_id;
        return $this->executeQuery();
    }
    public function shipmentSummaries($client_id){
   
        $this->query = "SELECT COUNT(lot) AS totalLots FROM closing_stock 
        LEFT JOIN stock_allocation ON stock_allocation.stock_id = closing_stock.stock_id
        WHERE allocation_id IS NOT NULL AND client_id = '$client_id'";
        $lots = $this->executeQuery();
        $this->query = "SELECT SUM(kgs) AS totalkgs FROM closing_stock
        LEFT JOIN stock_allocation ON stock_allocation.stock_id = closing_stock.stock_id
        WHERE allocation_id IS NOT NULL AND client_id = '$client_id'";
        $kgs = $this->executeQuery();
        $this->query = "SELECT SUM((pkgs)) AS totalpkgs FROM closing_stock
        LEFT JOIN stock_allocation ON stock_allocation.stock_id = closing_stock.stock_id
        WHERE allocation_id IS NOT NULL AND client_id = '$client_id'";
        $pkgs = $this->executeQuery();
        $this->query = "SELECT SUM((kgs * (sale_price/100))) AS totalAmount FROM closing_stock 
        LEFT JOIN stock_allocation ON stock_allocation.stock_id = closing_stock.stock_id
        WHERE allocation_id IS NOT NULL AND client_id = '$client_id'";
        $totalAmount = $this->executeQuery();
        $this->query = "SELECT SUM((allocated_pkgs)) AS totalpkgs FROM closing_stock 
        LEFT JOIN stock_allocation ON stock_allocation.stock_id = closing_stock.stock_id
        WHERE allocation_id IS NOT NULL AND client_id = '$client_id'";
        $this->query = "SELECT SUM((net)) AS totalNet FROM closing_stock 
        LEFT JOIN stock_allocation ON stock_allocation.stock_id = closing_stock.stock_id
        WHERE allocation_id IS NOT NULL AND client_id = '$client_id'";
        $net = $this->executeQuery();
        
        $this->query = "SELECT (CASE WHEN (approval_workflow.id IS NULL) THEN 'Unconfirmed' ELSE status END) AS status
        FROM stock_allocation  
        LEFT JOIN approval_workflow ON stock_allocation.approval_id = approval_workflow.approval_id
        WHERE client_id = '$client_id' AND shipped = 0";
        $status = $this->executeQuery();

        $this->query = "SELECT name FROM 0_debtors_master WHERE debtor_no = '$client_id'";
        $clientName = $this->executeQuery();
        return array(
            "totalLots"=>$lots[0]['totalLots'],
            "totalkgs"=>$kgs[0]['totalkgs'],
            "totalNet"=>$net[0]['totalNet'],
            "totalpkgs"=>$pkgs[0]['totalpkgs'],
            "totalAmount"=>$totalAmount[0]['totalAmount'],
            "clientName"=>$clientName[0]['name'],
            "approvalStatus"=>$status[0]['status'],
            "lotDetailsView"=>"<a href='../../reports/lot_details?action=view&clientid=".$client_id."'>Print</a>",
            "lotDetailsEdit"=>"<a href='./index?action=edit&clientid=".$client_id."'>view</a>",


        );
    }
    public function loadSItemplates($id=0){
        if($id==0){
            $this->query = "SELECT *FROM shipping_instructions";
            return $this->executeQuery();
        }else{
            $this->query = "SELECT *FROM shipping_instructions WHERE instruction_id = '$id'";
            return $this->executeQuery();
        }
      
    }
    public function loadSelectedForshipment(){
        $this->query = "SELECT *FROM closing_stock WHERE selected_for_shipment = 1";
        return $this->executeQuery();
    }
    public function loadActiveBlend(){
        $this->query = "SELECT *FROM blend_master LIMIT 1";
        return $this->executeQuery();
    }
    public function allocateBlend($id, $pkgs){
        $this->query = "UPDATE closing_stock SET  current_allocation= ".$pkgs." WHERE stock_id = ".$id;
        return $this->executeQuery();
    }
    public function confirmShipment(){
        $this->query = "SELECT *FROM closing_stock WHERE selected_for_shipment = 1";
        return $this->executeQuery();
    }
    public function saveBlend($post){
        $this->data = $post;
        $this->tablename = "blend_master";
        $id = $this->insertQuery();
        return $id;
    }
    public function viewPackingMaterials(){
        $this->query = "SELECT *FROM packaging_materials WHERE in_stock>0";
        return $this->executeQuery();
    }
    public function completeShipment($siType, $user){
        $this->query = "INSERT INTO `shippments`(`si_no`, `lot_no`, `pkgs_shipped`, `siType`, `shippedBy`, `shipped_on`, `details`) 
        SELECT instruction_id, lot, IF(`current_allocation` !=0, `current_allocation`, `pkgs`) AS allocated , '', 1, current_date, 'Shippment completed' 
        FROM closing_stock, shipping_instructions
        WHERE selected_for_shipment = 1 AND shipping_instructions.is_current = 1";
        echo $this->query;
        return $this->executeQuery();

        if($siType="blend"){
            $this->query = "UPDATE closing_stock SET pkgs = (pkgs-current_allocation), net=(pkgs-current_allocation)*kgs, gross=(pkgs-current_allocation)*kgs+(gross-net),
            is_blend_balance = 1, current_allocation=0, selected_for_shipment =0
             WHERE selected_for_shipment = 1";
             return $this->executeQuery();        
        }else{
            $this->query = "UPDATE closing_stock SET pkgs = 0, net=0, gross=0, is_blend_balance = 0, current_allocation=0, selected_for_shipment =0
             WHERE selected_for_shipment = 1";
             return $this->executeQuery();  
        }
      
    }
    public function fetchShippingInstruction($id){
        $this->query = "SELECT *FROM shipping_instructions WHERE instruction_id = ".$id;
        return $this->executeQuery();
    }
    public function updateInstructionFile($file, $id){
        $this->query = "UPDATE shipping_instructions SET file = '$file' WHERE instruction_id = ".$id;
        return $this->executeQuery();

    }
    public function fetchErpClients(){
        $this->query = "SELECT debtor_no, name FROM 0_debtors_master WHERE inactive = 0";
        return $this->executeQuery();
    }
    public function loadAllocated($clientid){
        $this->query = "SELECT *FROM closing_stock
        LEFT JOIN stock_allocation ON closing_stock.stock_id = stock_allocation.stock_id
         WHERE client_id = '$clientid'";
        return $this->executeQuery();
    }
}        



?>



