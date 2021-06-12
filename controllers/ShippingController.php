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
    public function allocateLot($id){
        $this->query = "UPDATE closing_cat SET allocated = 1 WHERE closing_cat_import_id = ".$id;
        return $this->executeQuery();
    }
    public function unAllocateLot($id){
        $this->query = "UPDATE closing_cat SET allocated = 0 WHERE closing_cat_import_id = ".$id;
        return $this->executeQuery();
    }
    public function summaries(){
        $this->query = "SELECT COUNT(lot) AS totalLots FROM closing_cat WHERE allocated = 1";
        $lots = $this->executeQuery();
        $this->query = "SELECT SUM(kgs) AS totalkgs FROM closing_cat WHERE allocated = 1";
        $kgs = $this->executeQuery();
        $this->query = "SELECT SUM(pkgs) AS totalpkgs FROM closing_cat WHERE allocated = 1";
        $pkgs = $this->executeQuery();
        $this->query = "SELECT SUM((net * value)) AS totalAmount FROM closing_cat WHERE allocated = 1";
        $totalAmount = $this->executeQuery();

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
}


?>

