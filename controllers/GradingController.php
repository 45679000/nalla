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
}


?>

