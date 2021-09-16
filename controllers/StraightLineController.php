<?php
Class StraightLineController extends Model{

    public function fetchStraightline(){

        $this->debugSql = false;

            $this->query = "SELECT *
            FROM `straightlineteas`";

            return $this->executeQuery();
        
 
    }
    public function addStraightline($contract_no, $client_id, $details){

            $this->debugSql = false;
        
            $this->query = "REPLACE INTO `straightlineteas`(`contract_no`, `client_id`,  `details`) 
            VALUES ('$contract_no', '$client_id', '$details')";

            return $this->executeQuery();
    }
    public function allocationStraightline($contract_no){

        $this->debugSql = false;
    
        $this->query = "SELECT lot, line_no, shippments.stock_id, shippments.id, pkgs_shipped AS pkgs, shipped_kgs AS kgs, closing_stock.net, 
        broker, mark, grade, confirmed, si_no
        FROM `shippments`
        INNER JOIN closing_stock ON closing_stock.stock_id = shippments.stock_id
        WHERE si_no = '$contract_no' AND siType = 'straight'";

        return $this->executeQuery();
    }
    public function addLotStraight($id, $contract_no){
        $this->debugSql = true;
    
        $this->query = "INSERT INTO `shippments`(`si_no`, `pkgs_shipped`, `shipped_kgs`, `siType`, `stock_id`) 
        SELECT '$contract_no', pkgs, kgs, 'straight', stock_id
        FROM closing_stock
        WHERE stock_id = $id";
        $this->executeQuery();

        $this->query ="UPDATE closing_stock SET allocation = '$contract_no' WHERE stock_id = $id";
        $this->executeQuery();

    }
    public function removeLotStraight($id, $contract_no){
        $this->debugSql = true;
    
        $this->query = "DELETE FROM `shippments`
        WHERE stock_id = $id";
        $this->executeQuery();

        $this->query ="UPDATE closing_stock SET allocation = NULL WHERE stock_id = $id";
        $this->executeQuery();

    }
    

}