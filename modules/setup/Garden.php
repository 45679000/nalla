<?php
	
	class Garden extends Model
	{
	
		public $tableName = "mark_country";

		// Insert customer data into customer table
		public function insertRecord($name, $country)
		{
			$this->query = "INSERT INTO $this->tableName (mark, country) VALUES('$name','$country')";
			echo $this->query;

			$query = $this->executeQuery();

			if ($query) {
				return true;
			}else{
				return false;
			}
		}

		// Update customer data into customer table
		public function updateRecord($id, $name, $country)
		{
			$this->query = "UPDATE $this->tableName SET 
			 mark = '$name',
			 country = '$country' 
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
		public function displayRecord()
		{
			$this->query = "SELECT * FROM $this->tableName WHERE deleted = 0 GROUP BY mark";
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
		public function getRecordById($id)
		{
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

	}
?>