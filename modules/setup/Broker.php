<?php
	
	class Broker extends Model
	{
	
		public $tablename = "brokers";

		// Insert customer data into customer table
		public function insertRecord($code, $name)
		{
			$this->query = "INSERT INTO $this->tablename (code, name) VALUES('$code','$name')";

			$query = $this->executeQuery();

			if ($query) {
				return true;
			}else{
				return false;
			}
		}

		// Update customer data into customer table
		public function updateRecord($id, $code, $name)
		{
			$this->query = "UPDATE $this->tablename SET 
			 mark = '$code',
			 name = '$name' 
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
			$this->query = "SELECT * FROM $this->tablename WHERE deleted = 0";
			$this->executeQuery();
            $this->debugSql = true;
			$this->query= "SELECT * FROM $this->tablename"; 
			return $this->executeQuery();
		}

		// Fetch single data for edit from customer table
		public function getRecordById($id)
		{
			$this->query = "SELECT * FROM $this->tablename WHERE id = '$id'";
			$result = $this->execute();

			$this->query= "SELECT * FROM $this->tablename"; 
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
			$this->query= "SELECT * FROM $this->tablename"; 
			$stmt = $this->execute(); 
			$row_count = $stmt->rowCount();
			return $row_count;
		}
		
		public function delete($id){
			$this->query = "UPDATE $this->tablename SET deleted = 1  WHERE id = $id";
		   	$query = $this->executeQuery();
		}

	}
?>