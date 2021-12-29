<?php
	
	class Auction extends Model
	{
	
		public $tablename = "auctions";

		// Insert customer data into customer table
		public function insertRecord()
		{	
			for($i = 1; $i<53; $i++){
                // $year = date("Y");
                $year = 2022;
                $this->query = "INSERT INTO auctions(sale_no, active, auction_details)
                VALUES(CONCAT($year, '-',  lpad($i,2,'0')), 1, 'WEEK- $i ')";
                $this->executeQuery();

            }
		}


		// Fetch customer records for show listing
		public function displayRecord()
		{
			$this->debugSql = false;
			// $this->query = "SELECT * FROM $this->tablename WHERE active = 1";
			$this->query = "SELECT * FROM $this->tablename";
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
		
		
	}
?>