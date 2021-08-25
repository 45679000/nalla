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
        public function addToBuyingList($id, $fieldValue, $fieldName){
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            try {
                if($fieldValue !== null){
                    $this->query = "UPDATE closing_cat SET
                    ".$fieldName." ='".$fieldValue."'
                      WHERE closing_cat_import_id = ".$id;
                    $this->executeQuery();
                }
                if($fieldValue == 1){
                    $this->query = "INSERT INTO `buying_list`(`sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, `auction_date`, `imported`, `imported_by`, `allocated`, `source`) 
                    SELECT `sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `standard`, 'CSS', `import_date`, `auction_date`, `imported`, `imported_by`, `allocated`, 'A' 
                    FROM `closing_cat` WHERE closing_cat_import_id = $id";
                    $this->executeQuery();

                }else{
                    $this->query = "DELETE  FROM `closing_cat` WHERE closing_cat_import_id = $id";
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