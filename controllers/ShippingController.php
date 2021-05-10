<?php
Class ShippingController extends Model{
    public function saveSI($post, $step){
        $this->data = $post;
        $this->tablename = "shipping_instructions";
        $id = $this->insertQuery();
        return $this->selectOne($id, "instruction_id");
    }

    public function getShippingInstructions(){
        $this->query = "SELECT *FROM shipping_instructions LIMIT 1";
        return $this->executeQuery();
    }
        
}


?>

