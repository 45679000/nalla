<?php
session_start();
Class WarehouseController extends Model{
    
    public $stock;
    public function addWarehouse($post){
        $this->data = $post;
        $this->tablename = "warehouses";
        $id = $this->insertQuery();
        return $this->selectOne($id, "id");
    }
    public function addPackagingMaterials($post){
        $this->data = $post;
        $this->tablename = "packaging_materials";
        $this->debugSql=true;
        $id = $this->insertQuery();
        return $this->selectOne($id, "id");
    }
    public function addMaterialTypes($post){
        $post["created_by"] = $_SESSION["user_id"];
        $this->data = $post;
        $this->tablename = "material_types";
        $this->debugSql=true;
        $id = $this->insertQuery();
        return $this->selectOne($id, "id");
    }
    public function createMaterialTypes($post){
        $this->data = $post;
        $this->tablename = "material_types";
        $id = $this->insertQuery();
        return $this->selectOne($id, "id");
    }
    public function getMaterialTypes(){
        $this->query = "SELECT *FROM material_types WHERE is_deleted = 0";
        return $this->executeQuery();
    }
    public function getWarehouses($id=""){
        $query = "SELECT *FROM warehouses 
        WHERE is_deleted = false";
        if($id !=""){
           $query .= " AND id= $id";
        }
        $this->query = $query;
        return $this->executeQuery();
    }
    public function getPackingMaterials($id=""){
        $this->debugSql = false;
        $query = "SELECT packaging_materials.`id`, `type_id`, ABS(allocated) AS allocated, is_bonded, unit_cost, warehouses.code, warehouses.name AS warehouse,  warehouses.location, material_types.name, material_types.uom, material_types.unit_cost, 
        packaging_materials.`description`, (`in_stock`+`allocated`) AS available, unit_cost * (`in_stock`+`allocated`) AS total_value_ksh, unit_cost * (`in_stock`+`allocated`)*100 AS total_value_usd
        FROM `packaging_materials`
        INNER JOIN warehouses ON warehouses.id = packaging_materials.warehouse
        INNER JOIN material_types ON material_types.id = packaging_materials.type_id
        WHERE packaging_materials.is_deleted = 0";
        if($id !=""){
            $query .= " AND packaging_materials.id= $id";
            $this->query = $query;

            return $this->fetchOne();
        }else{
            $this->query = $query;

            return $this->executeQuery();

        }
    }
    public function shipmentUpdateStatus($newStatus, $sino){
        if($newStatus=="Shipped"){
            $this->query = "UPDATE shippments SET is_shipped = 1 WHERE instruction_id = $sino"; 
            $this->executeQuery();
 
            $this->query = "UPDATE shipping_instructions SET status = '$newStatus' WHERE instruction_id = $sino";
            $this->executeQuery();

        }else{
            $this->query = "UPDATE shipping_instructions SET status = '$newStatus' WHERE instruction_id = $sino";
            $this->executeQuery();
        }
       

    }
    public function materialAllocation($sino){
        $query = "SELECT contract_no, material_allocation.id,  `in_stock`, material_allocation.details,  
        material_allocation.si_no, 
        material_allocation.allocated_total,
        material_allocation.details
       FROM material_allocation
       INNER JOIN packaging_materials ON packaging_materials.id = material_allocation.material
       INNER JOIN shipping_instructions ON shipping_instructions.instruction_id = material_allocation.si_no";
        if($sino !=""){
          $query .=" WHERE material_allocation.si_no = $sino";
        }
        $this->query = $query;
        return $this->executeQuery();
    }
    public function upadateAllocation($post){
        $this->conn->beginTransaction();
        try {
            $this->data = $post;
            $this->tablename = "material_allocation";
            $id = $this->insertQuery();
            $material_id = $post["material_id"];
            $type_id = $post["type_id"];

            $total = $post["total"];
            if($post["event"] == 0){
                $total = -$post["total"];
                $this->query = "UPDATE packaging_materials SET allocated = $total WHERE id = $material_id";
                $this->executeQuery();
            }else if($post["event"] == 1){
                $this->query = "UPDATE packaging_materials SET in_stock = in_stock+$total WHERE id = $material_id";
                $this->executeQuery();
            }else if($post["event"] == 2){
                $this->query = "UPDATE packaging_materials SET in_stock = in_stock+$total WHERE id = $material_id";
                $this->executeQuery();

                $total = -$post["total"];
                $this->query = "UPDATE packaging_materials
                INNER JOIN warehouses ON packaging_materials.warehouse = warehouses.id
                SET allocated = $total 
                WHERE type_id = $type_id AND is_bonded = 1";
                $this->executeQuery();

            }
            
            $this->conn->commit();
        } catch (Exception $ex) {
            $this->conn->rollBack();
        }
       
    }
    public function deleteAllocation($id){
        $this->debugSql = true;

        $this->query = "DELETE FROM `material_allocation` WHERE id = $id";
        $this->executeQuery();
    }
    public function computeTotals($status){
        if($status == "shipped"){
            $status = 1;
        }else{
            $status = 0;
        }
        $this->query = "
        SELECT  
            (CASE WHEN siType = 'blend' 
            THEN
                SUM(blend_teas.blend_kgs)
            ELSE
                SUM(shippments.pkgs_shipped * closing_stock.net)   
            END
            ) AS totalKgs
        FROM shippments
        INNER JOIN stock_allocation ON stock_allocation.allocation_id = shippments.allocation_id
        INNER JOIN closing_stock ON shippments.allocation_id = stock_allocation.allocation_id
        LEFT JOIN blend_teas ON blend_teas.allocation_id = shippments.allocation_id
        WHERE shipped = $status";
        $totalKgs = $this->executeQuery();

        return $totalKgs;
    } 
    public function closeBlend($id, $output, $sweeping, $cyclone, $dust, $fiber, $remnant, $gain_loss, $polucon){
        try {
            $user = $_SESSION['user_id'];
            $this->conn->beginTransaction();
            $this->query = "UPDATE `blend_master` SET
            `output_kgs`='$output',
            `sweeping`='$sweeping',
            `cyclone`='$cyclone',
            `dust`='$dust',
            `fiber`='$fiber',
            `blend_remnant`='$remnant',
            `gain_loss`='$gain_loss',
            `polucon`='$polucon',
            `closed`=1,
            `closed_by` = $user,
            `closed_on` = CURRENT_TIMESTAMP WHERE id = $id";
            $this->executeQuery();

            
            $this->query = "INSERT INTO `closing_stock`(`line_no`,`sale_no`, `broker`, `lot`,  `mark`, `grade`,  `pkgs`,  `net`, `kgs`, `standard`, `is_blend_balance`, `invoice`, `sale_price`, `import_date`) 
            SELECT line_no, sale_no,'x', lot_no,mark, grade, pkgs, net, pkgs*net, standard, true, lot_no, sale_price,date_posted 
            FROM blend_lines
            WHERE blend_no = $id AND is_deleted = 0 AND added_to_stock = 0";
            $this->executeQuery();

            $this->query = "UPDATE blend_lines SET added_to_stock = 1
            WHERE blend_no = $id AND is_deleted = 0";
            $this->executeQuery();

            $this->query ="SELECT blend_no FROM blend_master WHERE id = $id";
            $rows=$this->executeQuery();

            $blendno = $rows[0]["blend_no"];

            $this->conn->commit();
            echo json_encode(array("status"=>"Blend ".$blendno." Has been Successfully Closed Redirecting ..."));
        } catch (Exception $th) {
            echo $th;
            $this->conn->rollBack();

        }
        
    } 
    public function addjustLevels($materialid, $newlevel, $details){
        $this->debugSql = true;

        $this->query = "INSERT INTO `material_allocation`(`material`, `si_no`, `allocated_total`, `details`, `allocation_date`)
        VALUES ('$materialid','00',$newlevel,'$details', CURRENT_TIMESTAMP)";
        $this->executeQuery();

    }
    public function genLineNo($blend_id){
        $this->debugSql = false;
        $this->query = "SELECT MAX(SUBSTRING(line_no, -7)) AS line_no FROM closing_stock";
        $rows = $this->executeQuery();
        $id = ((int)$rows[0]['line_no'])+1;

        $this->query = "SELECT DATE_FORMAT(CURRENT_DATE, '%y') AS date_part, WEEK(CURRENT_DATE) AS week_part, 'B', LPAD($id, 10, '0') AS id_part
        FROM blend_master WHERE id = $blend_id";
        $row = $this->executeQuery();
        if(sizeOf($row)>0){
            if(($row[0]['date_part'] != null) && ($row[0]['week_part'] != null)  && ($row[0]['id_part'] != null)){
                $lineno = $row[0]['date_part'].$row[0]['week_part'].'B'.$row[0]['id_part']; 
            }
        }else{
            $lineno = -1;
        }
        return $lineno;

    }
    public function addBlendLine($blendno){
        $blend_price = $this->getBlendPrice($blendno);
        $blend_origin = $this->getBlendOrigin($blendno);
        $user = $_SESSION['user_id'];
        $currentyear = date("Y");
        $lineno = $this->genLineNo($blendno);

        $sql = "INSERT INTO `blend_lines`(`line_no`,`blend_no`, `lot_no`, `standard`, `grade`, `sale_price`, `origin`, `mark`, `sale_no`, `posted_by`)
        SELECT '$lineno', id, blend_no, std_name, Grade, '$blend_price', '$blend_origin', 'BLENDED TEA', CONCAT($currentyear,'TB-',id), $user
        FROM blend_master
        WHERE id = $blendno";
         $this->query = $sql;
         $this->executeQuery();
    }
    public function updateBlendLine($id, $fieldName, $fieldValue){
        $sql = "UPDATE `blend_lines` SET $fieldName='$fieldValue'  WHERE id= $id";
         $this->query = $sql;
         $this->executeQuery();
    }
    public function loadBlendLines($blendno){
        $this->debugSql = false;
        $this->query = "SELECT *FROM `blend_lines` WHERE blend_no = ".$blendno." AND is_deleted = 0";
        $rows = $this->executeQuery();

        return $rows;
    }
    public function blendShippment($blendno){
        $this->query = "SELECT nw*Pkgs AS kgs  FROM `blend_master` WHERE id = ".$blendno;
        $rows = $this->executeQuery();
        return $rows[0]['kgs'];
    }
    public function getBlendOrigin($blendno){
        
        $this->query = "SELECT blend_no, shipping_instructions.destination_total_place_of_delivery 
        FROM `shippments`
        INNER JOIN shipping_instructions ON shipping_instructions.instruction_id = shippments.instruction_id  
        WHERE shippments.blend_no = $blendno
        GROUP BY shippments.blend_no";

        $rows = $this->executeQuery();
        return $rows[0]['destination_total_place_of_delivery'];

    }
    public function getBlendPrice($blendno){
        $this->query = "SELECT ROUND(SUM(sale_price)/Count(shippments.id),2) AS avg 
        FROM `shippments`
        INNER JOIN closing_stock ON closing_stock.stock_id = shippments.stock_id
        WHERE shippments.blend_no = $blendno
        GROUP BY shippments.blend_no";

        $rows = $this->executeQuery();
        return $rows[0]['avg'];

    }
    public function getBondedWarehouseStock($type_id){
        $this->debugSql = false;
        $this->query = "SELECT packaging_materials.`id`, `material_types`.`name`, `uom`, `type_id`,  (`in_stock`+`allocated`) AS available
        FROM `packaging_materials`
        INNER JOIN warehouses ON warehouses.id = packaging_materials.warehouse
        INNER JOIN material_types ON material_types.id = packaging_materials.type_id
        WHERE packaging_materials.is_deleted = 0 AND warehouses.is_bonded = 1 AND type_id = $type_id";
        return $this->executeQuery();

        
    }
    public function getMaterialAllocation($id, $event){
        $query = "SELECT material_allocation.`id`,  `total`, `details`,  users.full_name, `allocated_on` 
        FROM `material_allocation`
        INNER JOIN packaging_materials ON packaging_materials.id = material_allocation.material_id
        LEFT JOIN shipping_instructions ON shipping_instructions.instruction_id = material_allocation.si_no
        LEFT JOIN material_types ON material_types.id = packaging_materials.type_id
        LEFT JOIN users ON users.user_id = material_allocation.allocated_by
        WHERE material_id = $id ";
        if($event == "add"){
            $query.= " AND event IN (1,2)";
        }

        $this->query = $query;

        return $this->executeQuery();
    }

}


?>

