<?php
	
	class GardenCluster extends Model
	{
	
		public $tableName = "garden_grade_cluster";

		// Insert customer data into customer table

		public function insertRecord($garden,  $code_id)
		{
			$this->query = "INSERT INTO $this->tableName (garden, code_id)
             VALUES('$garden', '$code_id')";

			 $this->executeQuery();

	
		}

		// Update customer data into customer table
		public function updateRecord($cluster_id, $garden, $code_id){
			$this->query = "UPDATE $this->tableName SET 
			 garden = '$garden',
             code_id = '$code_id'
			 WHERE id = $cluster_id";
			echo $this->query;

			$query = $this->execute();
			if ($query) {
				return true;
			}else{
				return false;
			}
		}

		public function displayRecord($id){
			$this->query = "SELECT * FROM garden_grade_cluster 
            INNER JOIN grading_comments ON grading_comments.id = garden_grade_cluster.code_id
            WHERE garden_grade_cluster.deleted = 0 AND code_id = $id
            GROUP BY garden_grade_cluster.code_id, garden_grade_cluster.garden";
			$query = $this->execute();

			$this->query= "SELECT * FROM $this->tableName"; 
			$stmt = $this->execute(); 
			$row_count = $stmt->rowCount();

			$data = array();
			if ($row_count > 0) {
				while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
					$data[] = $row;
				}
				return $data;
			}else{
				return false;
			}
		}

		// Fetch single data for edit from customer table
		public function getRecordById($id){
			$this->query = "SELECT * FROM $this->tableName WHERE cluster_id = '$id'";
           $this->debugSql = true;
			return $this->executeQuery();

		}
		public function totalRowCount(){
			$this->query= "SELECT * FROM $this->tableName"; 
			$stmt = $this->execute(); 
			$row_count = $stmt->rowCount();
			return $row_count;
		}
		public function delete($id){
			$this->query = "UPDATE $this->tableName SET deleted = 1  WHERE id = $id";
		   	$query = $this->executeQuery();
		}
		public function getStandard($id=0){
			if($id==0){
				$this->query= "SELECT * FROM grading_standard WHERE 1"; 
				return $this->executeQuery();
			}else{
				$this->query= "SELECT * FROM grading_standard WHERE id = $id"; 
			    return $this->executeQuery();
			}
			
		}
		public function getStandardComposition($id){
			$this->query= "SELECT a.id, a.standard_id, a.percentage, b.code, c.standard
			FROM standard_composition a
			INNER JOIN grading_comments b ON b.id = a.grade
			INNER JOIN grading_standard c ON c.id = a.standard_id
			WHERE standard_id = $id AND active=1"; 
			return $this->executeQuery();
			
		}
		public function getComposition($id){
			$this->query="SELECT * FROM standard_composition WHERE id = $id"; 
			return $this->executeQuery();
			
		}
		public function deleteCluster($id){
			$this->query = "UPDATE garden_grade_cluster SET deleted = 1 WHERE cluster_id= $id";
			$this->executeQuery();
		}
        public function updateCluster($formid, $gardenId,$code, $grade){
           $this->debugSql = true;
            $this->query = "UPDATE garden_grade_cluster SET code_id = '$code', grade_id = '$grade' WHERE cluster_id= $formid";
			return $this->executeQuery();
        }


	}
?>