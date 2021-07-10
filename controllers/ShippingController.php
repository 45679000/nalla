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
        $this->query = "SELECT stock_allocation.allocation_id, closing_stock.`stock_id`, `sale_no`, `broker`,
         `comment`, `ware_hse`, `value`, `lot`, mark_country.`mark`, `grade`, `invoice`, 
         stock_allocation.allocated_pkgs AS pkgs, closing_stock.allocated_whse AS warehouse, 
         `type`, `net`, (stock_allocation.allocated_pkgs * net) AS `kgs`, 
         `sale_price`, stock_allocation.`standard`, DATE_FORMAT(`import_date`,'%d/%m/%y') AS import_date,
          `imported`, `allocated`, `selected_for_shipment`, 
          `current_allocation`, `is_blend_balance`, stock_allocation.blend_no_contract_no, 
          stock_allocation.si_id, stock_allocation.shipped, stock_allocation.approval_id, shippments.si_no,
          0_debtors_master.debtor_ref, shippments.id AS selected_for_shipment,  
          CONCAT(stock_allocation.`standard`,'',0_debtors_master.short_name) AS allocation,
           mark_country.country, shippments.pkgs_shipped AS shipped_packages 
           FROM `stock_allocation` 
           LEFT JOIN closing_stock ON closing_stock.stock_id = stock_allocation.stock_id 
           LEFT JOIN 0_debtors_master ON stock_allocation.client_id = 0_debtors_master.debtor_no 
           LEFT JOIN shippments ON shippments.allocation_id = stock_allocation.allocation_id 
           LEFT JOIN mark_country ON mark_country.mark = closing_stock.mark";
        return $this->executeQuery();
    }
 
    public function unAllocateForShippment($id){
        $this->query = "DELETE FROM blend_teas WHERE id = ".$id;
        return $this->executeQuery();
    }
    public function removeFromShipment($id){
        $this->query = "DELETE FROM shippments WHERE id = ".$id;
        return $this->executeQuery();
    }
    public function shipmentSummaries($siNo, $clientId="1"){
   
        $this->query = "SELECT COUNT(id) AS totalLots FROM shippments 
        LEFT JOIN stock_allocation ON stock_allocation.allocation_id = shippments.allocation_id
        WHERE  si_no = '$siNo'";
        $lots = $this->executeQuery();

        $this->query = "SELECT SUM(closing_stock.net*shippments.pkgs_shipped) AS totalkgs FROM shippments
        LEFT JOIN closing_stock ON closing_stock.stock_id = stock_allocation.stock_id
        LEFT JOIN stock_allocation ON stock_allocation.allocation_id = shippments.allocation_id
        WHERE  shippments.si_no = '$siNo'";
        $kgs = $this->executeQuery();

        $this->query = "SELECT SUM((pkgs_shipped)) AS totalpkgs FROM shippments
        WHERE  shippments.si_no = '$siNo'";
        $pkgs = $this->executeQuery();

        $this->query = "SELECT (SUM(closing_stock.net*shippments.pkgs_shipped)*sale_price) AS totalkgs FROM shippments
        LEFT JOIN closing_stock ON closing_stock.stock_id = stock_allocation.stock_id
        LEFT JOIN stock_allocation ON stock_allocation.allocation_id = shippments.allocation_id
        WHERE  shippments.si_no = '$siNo'";
        $totalAmount = $this->executeQuery();
 
        $this->query = "SELECT (CASE WHEN (approval_workflow.id IS NULL) THEN 'Unconfirmed' ELSE status END) AS status
        FROM stock_allocation  
        LEFT JOIN approval_workflow ON stock_allocation.approval_id = approval_workflow.approval_id
        WHERE  shippments.si_no = '$siNo' AND shipped = 0";
        $status = $this->executeQuery();

        $this->query = "SELECT name FROM 0_debtors_master WHERE debtor_no = '$clientId'";
        $clientName = $this->executeQuery();

        return array(
            "totalLots"=>$lots[0]['totalLots'],
            "totalkgs"=>$kgs[0]['totalkgs'],
            "totalpkgs"=>$pkgs[0]['totalpkgs'],
            "totalAmount"=>$totalAmount[0]['totalAmount'],
            "clientName"=>$clientName[0]['name'],
            "approvalStatus"=>$status[0]['status'],
            "lotDetailsView"=>"<a href='../../reports/lot_details?action=view&contact=".$siNo."'>Print</a>",
            "lotDetailsEdit"=>"<a href='./index?action=edit&clientid=".$siNo."'>view</a>",

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
        $this->query = "SELECT *FROM blend_master WHERE approved = 1";
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
    public function saveBlend($blendno, $clientid, $stdname,$grade, $pkgs,$nw){
        $this->query = "INSERT INTO `blend_master`(`blend_no`,  `client_name`, `std_name`, `Grade`, `Pkgs`, `nw`)
         VALUES ('$blendno', '$clientid', '$stdname', '$grade', '$pkgs', '$nw')";
        $this->executeQuery();

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
        $this->query = "SELECT debtor_no, name, debtor_ref FROM 0_debtors_master WHERE inactive = 0 AND tea_buyer = 1";
        return $this->executeQuery();
    }
    public function loadAllocated($clientid){
        $this->query = "SELECT *FROM closing_stock
        LEFT JOIN stock_allocation ON closing_stock.stock_id = stock_allocation.stock_id
         WHERE client_id = '$clientid'";
        return $this->executeQuery();
    }
    public function fetchStandards(){
        $this->query = "SELECT standard FROM grading_standard WHERE deleted = 0";
        return $this->executeQuery();
    }
    public function fetchGrades(){
        $this->query = "SELECT name FROM grades WHERE deleted = 0";
        return $this->executeQuery();
    }
 
    
    public function allocateForShippment($allocationid, $siNo, $packages, $type){
        $this->query = "REPLACE INTO shippments(allocation_id, si_no, pkgs_shipped, siType)
        VALUES ('$allocationid', '$siNo', $packages, 'straight')"; 
    
        return $this->executeQuery();
    }
    public function unAllocateForShippmentBlend($id, $blendno){
        $this->query = "UPDATE closing_stock SET selected_for_shipment = 0 WHERE stock_id = ".$id;
        $this->query = "DELETE FROM stock_allocation WHERE stock_id = ".$id. " AND blend_no = ".$blendno;
        return $this->executeQuery();
    }
    public function attachSi($sino, $blendno){
        $this->query = "UPDATE blend_master SET si_no = '$sino' WHERE blend_no = '$blendno'";
        return $this->executeQuery();
    }
    public function deletBlend($id){
        $this->query = "DELETE FROM blend_master WHERE id= '$id'";
        return $this->executeQuery();
    }
}        



?>



