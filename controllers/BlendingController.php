<?php
Class BlendingController extends Model{

    public function loadUnallocated(){
        $this->query = "SELECT stock_allocation.allocation_id, closing_stock.`stock_id`, `sale_no`, `broker`, 
        `comment`, `ware_hse`,  `value`, `lot`,  mark_country.`mark`, `grade`, `invoice`, 
        (CASE WHEN stock_allocation.allocated_pkgs IS NULL THEN stock_allocation.allocated_pkgs ELSE closing_stock.pkgs END) AS pkgs, closing_stock.allocated_whse AS warehouse,
        `type`, `net`,  (stock_allocation.allocated_pkgs * net) AS `kgs`,  `sale_price`, stock_allocation.`standard`, 
        DATE_FORMAT(`import_date`,'%d/%m/%y') AS import_date, `imported`,  `allocated`, `selected_for_shipment`, `current_allocation`, `is_blend_balance`,
         stock_allocation.blend_no, stock_allocation.si_id, stock_allocation.shipped,
        stock_allocation.approval_id, 0_debtors_master.debtor_ref, blend_teas.id AS selected_for_shipment, 
        blend_teas.packages AS blended_packages, CONCAT(stock_allocation.`standard`,'',0_debtors_master.short_name) AS allocation,
        mark_country.country, blend_teas.packages AS blended_packages
        FROM `stock_allocation` 
        LEFT JOIN closing_stock ON closing_stock.stock_id = stock_allocation.stock_id
        LEFT JOIN 0_debtors_master ON stock_allocation.client_id = 0_debtors_master.debtor_no
        LEFT JOIN blend_teas ON blend_teas.allocation_id = stock_allocation.allocation_id 
        LEFT JOIN mark_country ON  mark_country.mark = closing_stock.mark";
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
            $this->query = "SELECT * FROM blend_master WHERE id = '$blendno'";
            return $this->executeQuery();
        }else{
            $this->query = "SELECT * FROM blend_master";
            return $this->executeQuery(); 
        }
 
    }
    public function removeLotAllocationFromBlend($allocationId){
        $this->query = "DELETE FROM blend_teas WHERE allocation_id = ".$allocationId; 
        return $this->executeQuery();
    }
   
}        



?>



