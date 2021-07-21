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
        // $this->debugSql = true;
        $this->query = "SELECT stock_allocation.allocation_id, closing_stock.`stock_id`, `sale_no`, `broker`,
         `comment`, `ware_hse`, `value`, `lot`, mark_country.`mark`, `grade`, `invoice`, 
         stock_allocation.allocated_pkgs AS pkgs, closing_stock.allocated_whse AS warehouse, 
         `type`, `net`, 
                (CASE 
                WHEN stock_allocation.allocated_pkgs != pkgs_shipped THEN
                pkgs_shipped * net
                ELSE
                    closing_stock.kgs 
                    
                END ) AS `kgs`, 

         `sale_price`, stock_allocation.`standard`, DATE_FORMAT(`import_date`,'%d/%m/%y') AS import_date,
          `imported`, `allocated`, `selected_for_shipment`, 
          `current_allocation`, `is_blend_balance`, stock_allocation.blend_no_contract_no, 
          stock_allocation.si_id, stock_allocation.shipped, stock_allocation.approval_id, shippments.si_no,
          0_debtors_master.debtor_ref, shippments.id AS selected_for_shipment,  mrp_value, 
          CONCAT(stock_allocation.`standard`,'',0_debtors_master.short_name) AS allocation,
           mark_country.country, shippments.pkgs_shipped AS shipped_packages 
           FROM `stock_allocation` 
           LEFT JOIN closing_stock ON closing_stock.stock_id = stock_allocation.stock_id 
           LEFT JOIN 0_debtors_master ON stock_allocation.client_id = 0_debtors_master.debtor_no 
           LEFT JOIN shippments ON shippments.allocation_id = stock_allocation.allocation_id 
           LEFT JOIN mark_country ON mark_country.mark = closing_stock.mark
           GROUP BY stock_id, allocation_id";
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
        $this->debugSql = false;
        $this->query = "SELECT (CASE WHEN COUNT(id) IS NULL THEN 0 ELSE COUNT(id) END) AS totalLots FROM shippments 
        LEFT JOIN stock_allocation ON stock_allocation.allocation_id = shippments.allocation_id
        WHERE  si_no = '$siNo'";
        $lots = $this->executeQuery();

        $this->query = "SELECT 
            (CASE 
                WHEN stock_allocation.allocated_pkgs != pkgs_shipped THEN
                pkgs_shipped * net
                 ELSE
                closing_stock.kgs 
                
                END )  AS totalkgs 
        FROM shippments
        LEFT JOIN stock_allocation ON stock_allocation.allocation_id = shippments.allocation_id
        LEFT JOIN closing_stock ON closing_stock.stock_id = stock_allocation.stock_id
        WHERE  shippments.si_no = '$siNo'";
        $kgs = $this->executeQuery();

        $this->query = "SELECT (CASE WHEN SUM(pkgs_shipped) IS NULL THEN 0 
        ELSE SUM(pkgs_shipped) END) AS totalpkgs FROM shippments
        WHERE  shippments.si_no = '$siNo'";
        $pkgs = $this->executeQuery();

 
        $this->query = "SELECT name FROM 0_debtors_master WHERE debtor_no = '$clientId'";
        $clientName = $this->executeQuery();
        
        $this->query = "SELECT (CASE WHEN status IS NULL THEN 'unconfirmed' ELSE status END) AS status
        FROM approval_workflow WHERE approval_id = '$siNo'";
        $approvalStatus = $this->executeQuery();


        $totalKgs = 0;
        if(count($kgs)>0){
            $totalKgs = $kgs[0]['totalkgs'];

        }

        return array(
            "siNo"=>$siNo,
            "clientName"=>$clientName[0]['name'],
            "totalLots"=>$lots[0]['totalLots'],
            "totalkgs"=>$totalKgs,
            "totalpkgs"=>$pkgs[0]['totalpkgs'],
            "approvalStatus"=>$approvalStatus[0]['status'],
            "lotDetailsView"=>"
            <a onclick='printLotDetails()' id='lotView' href='#'><i class='fa fa-eye' aria-hidden='true'></i>
            </a>",
            "lotDetailsEdit"=>"
            <a onclick='printLotDetails()' id='lotView' href='#'><i class='fa fa-print' aria-hidden='true'></i>
            </a>",
         
         

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
    public function loadSelectedForshipment($contactNo){
        $this->query = "
        SELECT stock_allocation.allocation_id, closing_stock.`stock_id`, `sale_no`, `broker`,
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
           FROM shippments 
           INNER JOIN stock_allocation ON shippments.allocation_id = stock_allocation.allocation_id 
           INNER JOIN closing_stock ON closing_stock.stock_id = stock_allocation.stock_id 
           INNER JOIN 0_debtors_master ON stock_allocation.client_id = 0_debtors_master.debtor_no 
           LEFT JOIN mark_country ON mark_country.mark = closing_stock.mark WHERE si_no = '".$contactNo."'";
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

    public function viewPackingMaterials(){
        $this->query = "SELECT *FROM packaging_materials WHERE in_stock>0";
        return $this->executeQuery();
    }
    public function completeShipment($sino, $notification){

        $this->query = "UPDATE shipping_instructions SET sent_to_warehouse = 1 WHERE instruction_id = $sino";
        return $this->executeQuery();

        if($notification=="notify"){
               echo 'email sent';    
        }else{
            echo 'SI forwarded';    

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
        $this->query = "SELECT debtor_no, address, name, debtor_ref FROM 0_debtors_master WHERE inactive = 0 AND tea_buyer = 1";
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
 
    
    public function allocateForShippment($allocationid, $siNo, $packages, $type, $shipKgs){
        $this->debugSql = true;

        $this->query = "REPLACE INTO shippments(allocation_id, si_no, pkgs_shipped, siType, shipped_kgs)
        VALUES ('$allocationid', '$siNo', $packages, 'straight', $shipKgs)"; 
    
        return $this->executeQuery();
    }
    public function unAllocateForShippmentBlend($id, $blendno){
        $this->query = "UPDATE closing_stock SET selected_for_shipment = 0 WHERE stock_id = ".$id;
        $this->query = "DELETE FROM stock_allocation WHERE stock_id = ".$id. " AND blend_no = ".$blendno;
        return $this->executeQuery();
    }
    public function attachSi($sino, $blendno){
        $this->debugSql = true;
        $this->query = "UPDATE blend_master SET si_no = '$sino' WHERE blend_no = '$blendno'";
        $this->executeQuery();
        $this->query = "UPDATE shippments
        SET instruction_id = '$sino' 
        WHERE shippments.blend_no = '$blendno'";
         $this->executeQuery();
         echo $this->query;
      
    }
    public function attachSiStraight($sino, $contractNo){
        $this->debugSql = true;
        $this->query = "UPDATE shippments
        SET instruction_id = '$sino' 
        WHERE shippments.si_no = '$contractNo'";
         $this->executeQuery();
         echo $this->query;
      
    }

    public function deletBlend($id){
        $this->query = "DELETE FROM blend_master WHERE id= '$id'";
        return $this->executeQuery();
    }
    public function getContractNo($id){
        $this->query = "SELECT contract_no FROM shipping_instructions WHERE instruction_id= '$id' LIMIT 1";
        return $this->executeQuery();
    }
    public function blendList(){
        $this->query = "SELECT blend_no, id FROM blend_master WHERE closed = 0 AND approved = 1";
        return($this->executeQuery());
    }
    public function contractList(){
        $this->query = "SELECT si_no FROM shippments WHERE `siType` = 'straight' GROUP BY si_no";
        return($this->executeQuery());
    }
    public function fetchSiDetails($sino){
        $this->query = "SELECT * FROM shipping_instructions WHERE instruction_id = $sino";
        return($this->executeQuery());
    }
    public function unshippedSi($id=0){
        if($id==0){
            $this->query = "SELECT * FROM shipping_instructions WHERE  sent_to_warehouse = 1";
            return($this->executeQuery());
        }else{
            $this->query = "SELECT * FROM shipping_instructions WHERE  sent_to_warehouse = 1 AND instruction_id = $id";
            return($this->executeQuery());
        }
     
    }
    public function updateMrp($id, $mrp){
        $this->query = "UPDATE stock_allocation SET mrp_value = '$mrp' WHERE allocation_id = $id";
        $this->executeQuery();
    }
}        



?>



