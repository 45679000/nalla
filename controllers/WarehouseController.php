<?php
Class WarehouseController extends Model{
    public function create($post){
        $this->data = $post;
        $this->tablename = "warehouses";
        $id = $this->insertQuery();
        return $this->selectOne($id, "id");
    }
    public function addPackagingMaterials($post){
        $this->data = $post;
        $this->tablename = "packaging_materials";
        $id = $this->insertQuery();
        return $this->selectOne($id, "id");
    }
    public function getWarehouses(){
        $this->query = "SELECT *FROM warehouses WHERE is_deleted = false";
        return $this->executeQuery();
    }
    public function getPackingMaterials(){
        $this->query = "SELECT *FROM packaging_materials WHERE is_deleted = false";
        return $this->executeQuery();
    }
    public function getWarehouseLocation(){
        $this->query = "SELECT warehouse_location.id, location_name, name, code
        FROM `warehouse_location` 
        INNER JOIN warehouses ON warehouses.id = warehouse_location.whse_id
        WHERE active = 1";
        return $this->executeQuery();
    }
        
}


?>

