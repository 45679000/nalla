<?php

Class WorkFlow extends Model{
    public function addApproval($clientId, $userid, $event, $approvePerson, $details, $status){
        $approvalId = (md5(time()));
        try {
            $this->query = "INSERT INTO `approval_workflow`(`approval_id`, `event_trigger`, `intiator`, `approve_person`, `details`, `status`) 
            VALUES ('$approvalId','$event','$userid','$approvePerson','$details','$status')";
            $this->executeQuery();
            $this->query = "UPDATE stock_allocation SET approval_id = '$approvalId' WHERE client_id = $clientId AND shipped = 0";
            $this->executeQuery();
        } catch (Exception $ex) {
            var_dump($ex);
        }
   
        
    }
}

