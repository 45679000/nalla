<?php 
    $path_to_root = '../../';

    Class Grading extends Model{
        public function grade($id, $fieldValue, $fieldName){
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            try {
                if($fieldValue !== null){
                    $this->query = "UPDATE closing_cat SET
                    ".$fieldName." ='".$fieldValue."'
                      WHERE lot = ".$id;

                    $this->executeQuery();
                }
            } catch (Exception $ex) {
                var_dump($ex);
            }
            
        }

        public function addComment($comment, $description){
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            try {
                    $this->query = "INSERT INTO grading_comments(`comment`, `description`)
                    VALUES("."'".$comment."', '".$description."')";
                    $this->executeQuery();
            } catch (Exception $ex) {
                var_dump($ex);
            }
            
        }
        public function readComments(){
            $this->query="SELECT *FROM grading_comments WHERE deleted = false";
            return($this->executeQuery());

        }
        public function readOffers(){
            $this->query="SELECT *FROM closing_cat WHERE allocated = true";
            return($this->executeQuery());

        }

    
    }

?>