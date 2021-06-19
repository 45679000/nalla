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
    public function allocateForShippment($id){
        $this->query = "UPDATE closing_stock SET selected_for_shipment = 1 WHERE stock_id = ".$id;
        return $this->executeQuery();
    }
    public function unAllocateForShippment($id){
        $this->query = "UPDATE closing_stock SET selected_for_shipment = 0 WHERE stock_id = ".$id;
        return $this->executeQuery();
    }
    public function summaries($siType="straight"){
   
        $this->query = "SELECT COUNT(lot) AS totalLots FROM closing_stock WHERE selected_for_shipment = 1";
        $lots = $this->executeQuery();
        $this->query = "SELECT SUM(kgs) AS totalkgs FROM closing_stock WHERE selected_for_shipment = 1";
        $kgs = $this->executeQuery();
        $this->query = "SELECT SUM((pkgs)) AS totalpkgs FROM closing_stock WHERE selected_for_shipment = 1";
        $pkgs = $this->executeQuery();
        $this->query = "SELECT SUM((net * sale_price/100)) AS totalAmount FROM closing_stock WHERE selected_for_shipment = 1";
        $totalAmount = $this->executeQuery();
        if($siType!=="straight"){
            $this->query = "SELECT SUM((current_allocation)) AS totalpkgs FROM closing_stock WHERE selected_for_shipment = 1";
            $pkgs = $this->executeQuery();
        }
        $this->query = "SELECT contract_no, target_vessel, buyer, consignee FROM shipping_instructions ORDER BY instruction_id DESC LIMIT 1";
        $shippingDetails = $this->executeQuery();

        return array(
            "totalLots"=>$lots[0]['totalLots'],
            "totalkgs"=>$kgs[0]['totalkgs'],
            "totalpkgs"=>$pkgs[0]['totalpkgs'],
            "totalAmount"=>$totalAmount[0]['totalAmount'],
            "shippingDetails"=>$shippingDetails[0]
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
}        



?>



