<?php
	// Include config.php file
    include_once('../../models/Model.php');
    include_once('../../database/page_init.php');
	include '../database/connection.php';


	include_once('Auction.php');

	$auction = new Auction($conn);

	// Insert Record	
	if (isset($_POST['action']) && $_POST['action'] == "insert") {
		$auction->insertRecord();
	}

	// View record
	if (isset($_POST['action']) && $_POST['action'] == "view") {
		$output = "";
		$tablecount = $auction->totalRowCount();
		$auctions = $auction->displayRecord();

		if ($auction->totalRowCount() > 0) {
			$output .="<table class='table table-striped table-bordered table-hover'>
			        <thead>
			          <tr>
			            <th>Id</th>
                        <th>Sale Number</th>
			            <th>Auction detail</th>
			            <th>Active</th>
			          </tr>
			        </thead>
			        <tbody>";
				$id = 1;
			foreach ($auctions as $auction) {
			$output.="<tr>
						<td>".$id."</td>
						<td>".$auction['sale_no']."</td>
			            <td>".$auction['auction_details']."</td>
						<td>".($auction['active'] == 1 ? 'Yes' : 'No')."</td>
			        </tr>";
					$id++;

				}
			$output .= "</tbody>
      		</table>";
      		echo $output;
			// echo $tablecount;	
		}else{
			echo '<h3 class="text-center mt-5">No records found</h3>';
		}
	}
	if (isset($_POST['action']) && $_POST['action'] == "gOrNot") {
		$tablecount = $auction->totalRowCount();
		echo $tablecount;
	}


	// Edit Record	
	if (isset($_POST['editId'])) {
		$editId = $_POST['editId'];
		$row = $auction->getRecordById($editId);
		echo json_encode($row);
	}

    if (isset($_POST['action']) && $_POST['action'] == "update") {

		$name = $_POST['name'];
		$code = $_POST['code'];
        $id = $_POST['id'];
		$auction->updateRecord($id, $code, $name);
	}

    	// Delete Record	
	if (isset($_POST['deleteId'])) {
		$deleteId = $_POST['deleteId'];
		$row = $auction->delete($deleteId);
		echo json_encode(array("msg"=>"Record Deleted Successfully"));
	}

    

?>