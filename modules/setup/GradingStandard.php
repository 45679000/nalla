<?php
	
	class GradingStandard extends Model
	{
	
		public $tableName = "grading_standard";

		// Insert customer data into customer table
		public function insertRecord($description, $standard)
		{
			$this->query = "INSERT INTO $this->tableName (description, standard) VALUES('$description','$standard')";
			echo $this->query;

			$query = $this->executeQuery();

			if ($query) {
				return true;
			}else{
				return false;
			}
		}
		public function insertGradeCode($code, $percentage, $standardId, $type){
			if($type=="update"){
				$this->debugSql = false;
				$this->query = "UPDATE `standard_composition` SET  `grade`  = $code,  `percentage` = $percentage 
				WHERE id = $standardId";
				$this->executeQuery();
			}else{
				$this->debugSql = false;
				$this->query = "SELECT SUM(percentage) AS total_percentage FROM standard_composition WHERE standard_id = $standardId";
				$total = $this->executeQuery();
				if(($total[0]['total_percentage'] + $percentage)<=100){
					$this->query = "INSERT INTO `standard_composition`(`standard_id`, `grade`, `percentage`)
					VALUES('$standardId','$code', '$percentage')";
					$query = $this->executeQuery();
					echo json_encode(array("type"=>"success", "message" => "Saved Successfully"));

				}else{
					echo json_encode(array("type"=>"error", "message" => "Percentage Must add up to 100%"));
				}
				
			}
		
		}

		// Update customer data into customer table
		public function updateRecord($id, $description, $standard){
			$this->query = "UPDATE $this->tableName SET 
			 description = '$description',
			 standard = '$standard' 
			 WHERE id = $id";
			echo $this->query;

			$query = $this->execute();
			if ($query) {
				return true;
			}else{
				return false;
			}
		}

		// Fetch customer records for show listing
		public function displayRecord(){
			$this->query = "SELECT * FROM $this->tableName WHERE deleted = 0";
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
			$this->query = "SELECT * FROM $this->tableName WHERE id = '$id'";
			$result = $this->execute();

			$this->query= "SELECT * FROM $this->tableName"; 
			$stmt = $this->execute(); 
			$row_count = $stmt->rowCount();

			if ($row_count > 0) {
				$row = $result->fetch(PDO::FETCH_ASSOC);
				return $row;
			}else{
				return false;
			}
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
		public function deleteComposition($id){
			$this->query = "UPDATE standard_composition SET active = 0 WHERE id= $id";
			$this->executeQuery();
		}

	}
?>