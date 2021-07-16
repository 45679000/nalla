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
        mark_country.country, blend_teas.packages AS blended_packages, 
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
        GROUP BY stock_id, allocation_id";
        return $this->executeQuery();
    }

    public function addLotAllocationToBlend($allocationId, $blendNo, $allocatedPackages){
        $this->query = "INSERT INTO blend_teas(allocation_id, blend_no, packages) 
        VALUES('$allocationId', '$blendNo','$allocatedPackages')";
        return $this->executeQuery();
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
        if($blendno !=''){
            $this->query = "SELECT `id`,`contractno`, `blend_no`, `date_`, 0_debtors_master.short_name AS client_name, 
            `std_name`, `Grade`, `Pkgs`, `nw`, `sale_no`, `output_pkgs`, `output_kgs`, `comments`, `approved`, 
            `si_no`, `closed`, `blendid` 
            FROM `blend_master`
            INNER JOIN 0_debtors_master ON 0_debtors_master.debtor_no = blend_master.client_name WHERE id = '$blendno'";
            return $this->executeQuery();
        }else{
            $this->query = "SELECT `id`, `blend_no`, `contractno`, `date_`, 0_debtors_master.short_name AS client_name, `std_name`, `Grade`, 
            `Pkgs`, `nw`, `sale_no`, `output_pkgs`, `output_kgs`, `comments`, `approved`, `si_no`, `closed`, `blendid` 
            FROM `blend_master`
            INNER JOIN 0_debtors_master ON 0_debtors_master.debtor_no = blend_master.client_name";
            return $this->executeQuery(); 
        }
 
    }
    public function removeLotAllocationFromBlend($allocationId){
        $this->query = "DELETE FROM blend_teas WHERE allocation_id = ".$allocationId; 
        $this->executeQuery();
        return $this->query;
    }
    public function saveBlend($blendno, $clientid, $stdname,$grade, $pkgs,$nw, $blendid,$contractno){
        $this->query = "SELECT blend_no FROM blend_master WHERE blend_no = '$blendno'";
        $results = $this->executeQuery();
        if(count($results)==0){
            $response = array();
            $this->query = "INSERT INTO `blend_master`(`blend_no`,  `client_name`, `std_name`, `Grade`, `Pkgs`, `nw`, `blendid`, `contractno`)
            VALUES ('$blendno', '$clientid', '$stdname', '$grade', '$pkgs', '$nw','$blendid', '$contractno')";
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
        $this->query = "SELECT SUM(closing_stock.kgs) AS totalKgs
        FROM blend_teas
        INNER JOIN stock_allocation ON stock_allocation.allocation_id = blend_teas.allocation_id
        INNER JOIN closing_stock ON closing_stock.stock_id = stock_allocation.stock_id
        WHERE blend_no = ".$blendno;
        $result = $this->executeQuery();
        return $result[0]['totalKgs'];
    }
    public function expectedComposition($blendno){
        $this->query = "
            SELECT a.id, a.percentage, g.code AS name,  s.standard
            FROM blend_composition a
            INNER JOIN grading_comments g ON g.id = a.id
            INNER JOIN grading_standard s ON s.id = a.standard_id
            LEFT JOIN blend_master bm ON bm.std_name = s.standard
            WHERE bm.id = '$blendno'";
            $result = $this->executeQuery();
            return $result;

    }
    public function currentComposition($blendno){
        $this->query = "
        SELECT blend_teas.id, closing_stock.comment AS grade, COUNT(*)*100 / (SELECT COUNT(id) AS s FROM blend_teas) AS `percentage` 
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
        $this->query = "UPDATE blend_master SET approved =1 WHERE id = ".$blendno;
        $this->executeQuery();

        $this->query = "INSERT INTO `shippments`(`allocation_id`, `si_no`, `pkgs_shipped`, `siType`, `blend_no`) 
        SELECT allocation_id, blend_no, packages, 'blend', blend_no
        FROM blend_teas
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
        $this->query = "SELECT stock_allocation.allocation_id, closing_stock.`stock_id`, closing_stock.`sale_no`, `broker`, 
        `comment`, `ware_hse`,  `value`, `lot`,  mark_country.`mark`, closing_stock.`grade`, `invoice`, 
        (CASE WHEN stock_allocation.allocated_pkgs IS NULL THEN stock_allocation.allocated_pkgs ELSE closing_stock.pkgs END) AS pkgs, closing_stock.allocated_whse AS warehouse,
        `type`, `net`,   closing_stock.`kgs`,  `sale_price`, stock_allocation.`standard`, 
        DATE_FORMAT(`import_date`,'%d/%m/%y') AS import_date, `imported`,  `allocated`, `selected_for_shipment`, `current_allocation`, `is_blend_balance`,
          stock_allocation.si_id, stock_allocation.shipped,
        stock_allocation.approval_id, 0_debtors_master.debtor_ref, blend_teas.id AS selected_for_shipment, 
        blend_teas.packages AS blended_packages,  
        mark_country.country, blend_teas.packages AS blended_packages, blend_master.blend_no AS allocation
        FROM `blend_teas`
        LEFT JOIN stock_allocation ON blend_teas.allocation_id = stock_allocation.allocation_id  
        LEFT JOIN closing_stock ON closing_stock.stock_id = stock_allocation.stock_id
        LEFT JOIN 0_debtors_master ON stock_allocation.client_id = 0_debtors_master.debtor_no
        LEFT JOIN blend_master ON blend_master.id = blend_teas.blend_no 
        LEFT JOIN mark_country ON  mark_country.mark = closing_stock.mark
        WHERE blend_teas.blend_no = $blendno
        GROUP BY stock_id";
        return $this->executeQuery();
    }
    
}        



?>



