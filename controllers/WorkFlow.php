<?php

Class WorkFlow extends Model{
    public function addApproval($approvalId, $userid, $event, $approvePerson, $details){
        try {
            $this->debugSql = true;
            $this->query = "SELECT approval_id FROM `approval_workflow` WHERE approval_id ='$approvalId'";
            $approval = $this->executeQuery();
            if(count($approval)>0){
                    $this->query = "UPDATE `approval_workflow` SET status = 'Approved'
                    WHERE approval_id = '$approvalId'";
                    $this->executeQuery();
                
            }else{
                $this->query = "INSERT INTO `approval_workflow`(`approval_id`, `event_trigger`, `intiator`, `approve_person`, `details`, `status`) 
                VALUES ('$approvalId','$event','$userid','$approvePerson','$details','unapproved')";
                $this->executeQuery();
            }

          
     
        } catch (Exception $ex) {
            var_dump($ex);
        }
   
        
    }
}

