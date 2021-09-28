<?php
Class WarehouseController extends Model{
    public $stock;
    public function create($post){
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
    public function getWarehouses(){
        $this->query = "SELECT *FROM warehouses WHERE is_deleted = false";
        return $this->executeQuery();
    }
    public function getPackingMaterials(){
        $this->query = "SELECT packaging_materials.id,  material_allocation.id AS material_id, 
        `category`,  material_allocation.details, packaging_materials.description,
        (CASE WHEN material_allocation.id IS NULL THEN  in_stock
            ELSE
             (in_stock - sum(allocated_total))
             END) AS in_stock,
             material_allocation.si_no
                 FROM packaging_materials
                 LEFT JOIN material_allocation ON packaging_materials.id = material_allocation.material
                WHERE is_deleted = 0
                GROUP BY packaging_materials.id, category";
        return $this->executeQuery();
    }
    public function getWarehouseLocation(){
        $this->query = "SELECT warehouse_location.id, location_name, name, code
        FROM `warehouse_location` 
        INNER JOIN warehouses ON warehouses.id = warehouse_location.whse_id
        WHERE active = 1";
        return $this->executeQuery();
    }

    public function shipmentUpdateStatus($newStatus, $sino){
        $this->query = "UPDATE shipping_instructions SET status = '$newStatus' WHERE instruction_id = $sino";
        $this->executeQuery();

    }
    public function materialAllocation($sino){
        $query = "SELECT contract_no, material_allocation.id, `category`, `in_stock`, material_allocation.details,  
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
    public function upadateAllocation($materialid, $sino,  $totalAllocation){
        $this->query = "INSERT INTO `material_allocation`(`material`, `si_no`, `allocated_total`) 
        VALUES ('$materialid','$sino','$totalAllocation')";
        $this->executeQuery();
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
        $this->query = "UPDATE `blend_master` SET
        `output_kgs`='$output',
        `sweeping`='$sweeping',
        `cyclone`='$cyclone',
        `dust`='$dust',
        `fiber`='$fiber',
        `blend_remnant`='$remnant',
        `gain_loss`='$gain_loss',
        `polucon`='$polucon',
        `closed`=1 WHERE id = $id";

        $this->executeQuery();

    } 
    public function addClosedBlendToStock( $id, $lineno, $sale_no, $lot, $grade, $pkgs, $net, $kgs, $standard){
        $this->query = "INSERT INTO `closing_stock`(`line_no`,`sale_no`, `broker`, `lot`,  `mark`, `grade`,  `pkgs`,  `net`, `kgs`, `standard`, `is_blend_balance`, `invoice`) 
        SELECT '$lineno', '$sale_no','x', '$lot','BLENDED TEA', '$grade', '$pkgs', '$net', '$kgs', '$standard', true, '$lot' ";
        $this->executeQuery();

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
}


?>

