<?php
Class BlendingController extends Model{

    public function loadUnallocated(){
        $this->query = "SELECT stock_allocation.allocation_id, closing_stock.`stock_id`, closing_stock.`sale_no`, `broker`, 
        `comment`, `ware_hse`,  `value`, `lot`,  mark_country.`mark`, closing_stock.`grade`, `invoice`, 
        (CASE WHEN stock_allocation.allocated_pkgs IS NULL THEN stock_allocation.allocated_pkgs ELSE closing_stock.pkgs END) AS pkgs, closing_stock.allocated_whse AS warehouse,
        `type`, `net`,  kgs,  `sale_price`, stock_allocation.`standard`, 
        DATE_FORMAT(`import_date`,'%d/%m/%y') AS import_date, `imported`,  `allocated`, `selected_for_shipment`, `current_allocation`, `is_blend_balance`,
          stock_allocation.si_id, stock_allocation.shipped,
        stock_allocation.approval_id, 0_debtors_master.debtor_ref, blend_teas.id AS selected_for_shipment, 
        blend_teas.packages AS blended_packages,  
        mark_country.country, blend_teas.packages AS blended_packages, blend_teas.split,
            (CASE WHEN blend_teas.id IS NULL THEN
            ''
            ELSE 
                CONCAT(COALESCE(blend_master.contractno, ''),  '- STD', COALESCE(blend_master.std_name, ''),'/',blend_master.blendid)
            END) AS allocation
        FROM `stock_allocation` 
        LEFT JOIN closing_stock ON closing_stock.stock_id = stock_allocation.stock_id
        LEFT JOIN 0_debtors_master ON stock_allocation.client_id = 0_debtors_master.debtor_no
        LEFT JOIN blend_teas ON blend_teas.allocation_id = stock_allocation.allocation_id 
        LEFT JOIN blend_master ON blend_master.id = blend_teas.blend_no 
        LEFT JOIN mark_country ON  mark_country.mark = closing_stock.mark
        GROUP BY stock_id, allocation_id,blend_teas.id, split";
        return $this->executeQuery();
    }

    public function addLotAllocationToBlend($stock_id, $id){
        $this->debugSql = true;


        $this->query = "REPLACE INTO blend_teas(stock_id, blend_no, packages, blend_kgs) 
        SELECT stock_id, '$id', pkgs, kgs
        FROM closing_stock
        WHERE stock_id = $stock_id ";
        $this->executeQuery();

        $this->query = "UPDATE closing_stock SET allocation = 
        (
            SELECT contractno FROM blend_master WHERE id = $id
        )
        WHERE stock_id = $stock_id ";
        $this->executeQuery();
        
    }
    public function shipmentSummaryBlend($blendno){
   
        $this->query = "SELECT (CASE WHEN COUNT(lot) IS NULL THEN 0 ELSE COUNT(lot) END) AS totalLots 
        FROM closing_stock 
        INNER JOIN stock_allocation ON stock_allocation.stock_id = closing_stock.stock_id
        INNER JOIN blend_teas ON blend_teas.allocation_id = stock_allocation.allocation_id
        WHERE blend_teas.blend_no = '$blendno'";
        $lots = $this->executeQuery();
       
        $this->query = "SELECT  (CASE WHEN SUM(kgs) IS NULL THEN 0 ELSE SUM(kgs) END) AS totalkgs FROM closing_stock
        INNER JOIN stock_allocation ON stock_allocation.stock_id = closing_stock.stock_id
        INNER JOIN blend_teas ON blend_teas.allocation_id = stock_allocation.allocation_id
        WHERE blend_teas.blend_no = '$blendno'";
        $kgs = $this->executeQuery();
       
        $this->query = "SELECT (CASE WHEN SUM(pkgs) IS NULL THEN 0 ELSE SUM(pkgs) END) AS totalpkgs 
        FROM closing_stock
        INNER JOIN stock_allocation ON stock_allocation.stock_id = closing_stock.stock_id
        INNER JOIN blend_teas ON blend_teas.allocation_id = stock_allocation.allocation_id
        WHERE blend_teas.blend_no = '$blendno'";
        $pkgs = $this->executeQuery();
        
        $this->query = "SELECT  (CASE WHEN SUM((kgs * (sale_price/100))) IS NULL THEN 0 ELSE SUM((kgs * (sale_price/100))) END)  
        AS totalAmount 
        FROM closing_stock 
        INNER JOIN stock_allocation ON stock_allocation.stock_id = closing_stock.stock_id
        INNER JOIN blend_teas ON blend_teas.allocation_id = stock_allocation.allocation_id
        WHERE blend_teas.blend_no = '$blendno'";
        $totalAmount = $this->executeQuery();

        $this->query = "SELECT (CASE WHEN SUM(blend_teas.packages) IS NULL THEN 0 ELSE SUM(blend_teas.packages) END) AS totalpkgs 
        FROM closing_stock 
        INNER JOIN stock_allocation ON stock_allocation.stock_id = closing_stock.stock_id
        INNER JOIN blend_teas ON blend_teas.allocation_id = stock_allocation.allocation_id
        WHERE blend_teas.blend_no = '$blendno'";

        $this->query = "SELECT (CASE WHEN SUM(net) IS NULL THEN 0 ELSE SUM(net) END) AS totalNet 
        FROM closing_stock 
        INNER JOIN stock_allocation ON stock_allocation.stock_id = closing_stock.stock_id
        INNER JOIN blend_teas ON blend_teas.allocation_id = stock_allocation.allocation_id
        WHERE blend_teas.blend_no = '$blendno'";
        $net = $this->executeQuery();

        $this->query = "SELECT blend_no FROM blend_master WHERE id = '$blendno'";
        $blendNo = $this->executeQuery();

        $this->query = "SELECT (CASE WHEN (approved = 0) THEN 'Unconfirmed' ELSE 'Confirmed' END) AS status
        FROM blend_master  
        WHERE blend_no = '$blendno'";
        $status = $this->executeQuery();

        // $this->query = "SELECT name FROM 0_debtors_master WHERE debtor_no = '$blendno'";
        // $clientName = $this->executeQuery();
        return array(
            "totalLots"=>$lots[0]['totalLots'],
            "totalkgs"=>$kgs[0]['totalkgs'],
            "totalNet"=>$net[0]['totalNet'],
            "totalpkgs"=>$pkgs[0]['totalpkgs'],
            "totalAmount"=>$totalAmount[0]['totalAmount'],
            "blendNo"=>$blendNo[0]['blend_no'],
            "lotDetailsView"=>"<a href='../../reports/lot_details?action=view&blendno=".$blendno."'>Print</a>",
            "lotDetailsEdit"=>"<a href='./index?action=edit&blendno=".$blendno."'>view</a>",


        );
    }
    public function fetchBlends($blendno=''){
        $this->debugSql = false;

        if($blendno !=''){
            $this->query = "SELECT `id`,`contractno`, `blend_no`, `date_`, 0_debtors_master.short_name AS client_name, 
            `std_name`, `Grade`, `Pkgs`, `nw`, `sale_no`, `output_pkgs`, `output_kgs`, `comments`, `approved`, 
            `si_no`, `closed`, `blendid`, blend_remnant,  `sweeping`, `cyclone`, `dust`, `fiber`,  `gain_loss`,  client_id, 
            `shipping_instructions`.`destination_total_place_of_delivery` AS destination 
            
            FROM `blend_master`
            INNER JOIN 0_debtors_master ON 0_debtors_master.debtor_no = blend_master.client_id 
            LEFT JOIN shipping_instructions ON shipping_instructions.contract_no = blend_master.contractno            
            WHERE id = '$blendno'";
            return $this->executeQuery();
        }else{
            $this->query = "SELECT `id`, `blend_no`, `contractno`, `date_`, 0_debtors_master.short_name AS client_name, `std_name`, `Grade`, 
            `Pkgs`, `nw`, `sale_no`, `output_pkgs`, `output_kgs`, `comments`, `approved`, `si_no`, `closed`, `blendid`,  `sweeping`, `cyclone`, 
            `dust`, `fiber`,  `gain_loss`
            FROM `blend_master`
            INNER JOIN 0_debtors_master ON 0_debtors_master.debtor_no = blend_master.client_id";
            return $this->executeQuery(); 
        }
 
    }
    public function fetchBlendByStatus($status){
        $this->debugSql = false;
        $condition = " WHERE closed = 0 ";

        if($status == 1){
            $condition = " WHERE closed = 1 ";
        }
            $this->query = "SELECT `id`,`contractno`, `blend_no`, `date_`, 0_debtors_master.short_name AS client_name, 
            `std_name`, `Grade`, `Pkgs`, `nw`, `sale_no`, `output_pkgs`, `output_kgs`, `comments`, `approved`, 
            `si_no`, `closed`, `blendid`, blend_remnant,  `sweeping`, `cyclone`, `dust`, `fiber`,  `gain_loss`,  client_id, 
            `shipping_instructions`.`destination_total_place_of_delivery` AS destination 
            FROM `blend_master`
            INNER JOIN 0_debtors_master ON 0_debtors_master.debtor_no = blend_master.client_id 
            LEFT JOIN shipping_instructions ON shipping_instructions.contract_no = blend_master.contractno            
             ". $condition;
            return $this->executeQuery();
       
 
    }

    public function removeLotAllocationFromBlend($id, $blendno){
        $this->query = "UPDATE closing_stock 
        INNER JOIN blend_teas ON blend_teas.stock_id = closing_stock.stock_id
        SET allocation = NULL
        WHERE blend_teas.id = ".$id. " AND blend_teas.confirmed = 0"; 
        $this->executeQuery();

        $this->debugSql = true;
        $this->query = "DELETE FROM blend_teas WHERE id = ".$id. " AND confirmed = 0"; 
        $this->executeQuery();  
    }
    public function saveBlend($blendno, $clientid, $stdname,$grade, $pkgs,$nw, $blendid,$contractno, $sale_no){
        $this->debugSql = false;
        $this->query = "SELECT blend_no FROM blend_master WHERE blend_no = '$blendno'";
        $results = $this->executeQuery();
        if(count($results)==0){
            $response = array();
            $this->query = "INSERT INTO `blend_master`(`blend_no`,  `client_id`, `std_name`, `Grade`, `Pkgs`, `nw`, `blendid`, `contractno`, `sale_no`)
            VALUES ('$blendno', '$clientid', '$stdname', '$grade', '$pkgs', '$nw','$blendid', '$contractno', '$sale_no')";
            $this->executeQuery();
            $this->query = "SELECT blend_no FROM blend_master WHERE blend_no = '$blendno'";
            $results = $this->executeQuery();

            if(count($results)==0){
                $error = "Blend $blendno Failed to save successfully contact support";
                $response["error"] = $error;
                $response["code"] = 201;

            }else{
                $success = "Blend $blendno has been created succesfully, click the + button to add teas to this Blend";
                $response["success"] = $success;
                $response["code"] = 200;

            }
        }else{
            $error = "Blend $blendno already Exists Do you wish to update?";
            $response["error"] = $error;
            $response["code"] = 500;
        }
        return $response;
    }
    public function selectedKgs($blendno){
        $this->query = "SELECT SUM(blend_teas.blend_kgs) AS totalKgs
        FROM blend_teas
        WHERE blend_no = ".$blendno;
        $result = $this->executeQuery();
        return $result[0]['totalKgs'];
    }
    public function expectedComposition($blendno){
        $this->debugSql=false;

        $this->query = "
            SELECT a.id, a.percentage, g.code AS name,  s.standard
            FROM standard_composition a
            INNER JOIN grading_comments g ON g.id = a.id
            INNER JOIN grading_standard s ON s.id = a.standard_id
            LEFT JOIN blend_master bm ON bm.std_name = s.standard
            WHERE bm.id = '$blendno'";
            $result = $this->executeQuery();
            return $result;

    }
    public function currentComposition($blendno){
        $this->query = "
        SELECT blend_teas.id, closing_stock.comment AS grade, ROUND(COUNT(*)*100 / (SELECT COUNT(id) AS s FROM blend_teas), 1) AS `percentage` 
        FROM `blend_teas` 
        LEFT JOIN stock_allocation ON blend_teas.allocation_id = stock_allocation.allocation_id 
        LEFT JOIN closing_stock ON closing_stock.stock_id = stock_allocation.stock_id 
        LEFT JOIN blend_master bm ON bm.id = blend_teas.blend_no 
        WHERE bm.id = '$blendno'
        GROUP BY comment , bm.id ";
        $result = $this->executeQuery();
        return $result;

    }
    public function approveBlend($blendno){
        $this->debugSql = true;
        $this->query = "UPDATE blend_master SET approved =1 WHERE id = ".$blendno;
        $this->executeQuery();
        $this->debugSql = false;

        $this->query = "UPDATE blend_teas SET confirmed =1 WHERE blend_no = ".$blendno;
        $this->executeQuery();
        $this->debugSql = false;

        $this->query = "INSERT INTO `shippments`(`si_no`, `pkgs_shipped`, `shipped_kgs`, `siType`, `blend_no`, stock_id) 
        SELECT  allocation, packages, kgs, 'blend', blend_no, blend_teas.stock_id
        FROM blend_teas
        INNER JOIN closing_stock ON blend_teas.stock_id = closing_stock.stock_id
        WHERE blend_no = '$blendno'";
        $this->executeQuery();
    }
    public function clearFromShippment($blendno){
        $this->query = "UPDATE blend_master SET approved =0 WHERE id = ".$blendno;
        $this->executeQuery();

        $this->query = "DELETE FROM `shippments` WHERE blend_no = '$blendno'";
        $this->executeQuery();
    }
    public function showCurrentBlendAllocation($blendno){
        $this->debugSql=false;
        $this->query = "SELECT blend_teas.`id` , closing_stock.`stock_id`, closing_stock.`sale_no`, `broker`, `comment`,
        `ware_hse`, `value`, `lot`, mark_country.`mark`, closing_stock.`grade`, `invoice`, `allocated_whse` AS warehouse,
        `net`, blend_teas.`blend_kgs` AS kgs, `sale_price`, `standard`, DATE_FORMAT(`import_date`,'%d/%m/%Y') AS import_date,
        `imported`, `allocated`, `selected_for_shipment`, `current_allocation`, `is_blend_balance`, 0_debtors_master.debtor_ref,
         blend_teas.packages AS pkgs, COALESCE(blend_master.contractno, '') AS allocation, blend_teas.confirmed FROM `blend_teas` 
         LEFT JOIN closing_stock ON closing_stock.stock_id = blend_teas.stock_id 
         LEFT JOIN 0_debtors_master ON closing_stock.client_id = 0_debtors_master.debtor_no 
         LEFT JOIN blend_master ON blend_master.id = blend_teas.blend_no 
         LEFT JOIN mark_country ON mark_country.mark = closing_stock.mark 
         WHERE blend_teas.blend_no = $blendno GROUP BY stock_id";
        return $this->executeQuery();
    }
    public function totalBlendedTeas($status){
        if($status == "closed"){
            $status = 1;
        }else{
            $status = 0;
        }
        $this->query="SELECT COUNT(*) AS blended
        FROM blend_master 
        WHERE approved = 1 AND closed = $status";  
        $totalKgs = $this->executeQuery();

        return $totalKgs[0]['blended'];

    }
    public function totalBlendedPerBlend($blendno){
        $this->query="SELECT sum(blend_kgs) AS blended
        FROM blend_teas 
        WHERE  blend_no = '$blendno'";  
        $totalKgs = $this->executeQuery();

        return $totalKgs[0]['blended'];

    }
    public function updateBlendMaster($id, $standard,  $blendid, $contractno, $grade, $pkgs, $nw, $saleno, $clientid){
        $this->query = "UPDATE blend_master SET  std_name = '$standard', 
        blendid = '$blendid',
        contractno = '$contractno',
        grade = '$grade',
        pkgs = '$pkgs',
        nw = '$nw',
        sale_no = '$saleno',
        blend_no = CONCAT('STD ',$standard,'/',$blendid),
        client_id = '$clientid'

        WHERE id = $id
        ";
        $this->debugSql = false;            
        $this->executeQuery();
    }
        public function updateMrp($stock_id, $value){
        $this->query = "UPDATE shippments SET  mrp_value = '$value' WHERE stock_id = $stock_id";     
        $this->executeQuery();
    }
}        



?>



