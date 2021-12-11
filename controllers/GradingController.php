<?php
Class GradingController extends Model{
    public function loadCodes(){
        $this->query = "SELECT *FROM grading_comments WHERE deleted = 0";
        return $this->executeQuery();
    }
    public function loadStandards(){
        $this->query = "SELECT *FROM grading_standard WHERE deleted = 0";
        return $this->executeQuery();
    }
    public function loadPrivatePurchases($saleno, $broker, $category){
        if($saleno != ''&& $broker!=''&& $category !=''){
            $this->query = "SELECT *FROM closing_cat WHERE sale_no LIKE '%PRVT%' AND sale_no = '$saleno' AND broker = '$broker' AND category = '$category'";
            return $this->executeQuery();
        }else{
            $this->query = "SELECT *FROM closing_cat WHERE sale_no LIKE '%PRVT%'";
            return $this->executeQuery();
        }
      
    }
    public function addPrivatePurchase($post){
        unset($post['action']);
        unset($post['closing_cat_import_id']);
        $this->debugSql = false;
        $this->data = $post;
        $this->tablename = "closing_cat";
        $id = $this->insertQuery();
        return $id;
    
    }
    public function updatePrivatePurchase($post){
        unset($post['action']);
        $this->debugSql = true;
        $this->data = $post;
        $this->tablename = "closing_cat";
        $id = $this->insertQuery();
        return $id;
    
    }
    public function deletePrivatePurchase($id){
        $this->debugSql = true;
        $this->tablename = "closing_cat";
        $this->tableFieldName = "closing_cat_import_id";
        $this->id = $id;
        return $this->deleteRow();
    
    }
    
    public function getPrivatePurchase($id){
        $this->query = "SELECT *FROM closing_cat WHERE closing_cat_import_id = $id";
        return $this->executeQuery();
        
    
    }
    public function loadRemarks(){
        try{
            $this->query = "SELECT DISTINCT remark FROM grading_remarks";
            $remarks = $this->executeQuery();
            return $remarks;
            
        }catch(Exception $ex){
            return $ex;
        }

    }

}


?>

