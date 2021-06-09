<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
    include_once('../../models/Model.php');
    include_once('../../database/page_init.php');
    include 'Stock.php';
    
    $db = new Database();
    $conn = $db->getConnection();
    $stock = new Stock($conn);

	// Insert Record	
	if (isset($_POST['action']) && $_POST['action'] == "insert") {
		$insertRecord = $stock->addPrivatePurchase($_POST);
		echo json_encode(array("message"=>"Saved Successfully"));
	}

	// View record
	if (isset($_POST['action']) && $_POST['action'] == "view") {
		$output = "";

		$customers = $garden->displayRecord();

		if ($garden->totalRowCount() > 0) {
			$output .="<table class='table table-striped table-hover'>
			        <thead>
			          <tr>
			            <th>Id</th>
			            <th>Garden Name</th>
			            <th>Country</th>
			            <th>Action</th>
			          </tr>
			        </thead>
			        <tbody>";
			foreach ($customers as $customer) {
			$output.="<tr>
			            <td>".$customer['id']."</td>
			            <td>".$customer['mark']."</td>
			            <td>".$customer['country']."</td>
			            <td>
			              <a href='#editModal' style='color:green' data-toggle='modal' 
			              class='editBtn' id='".$customer['id']."'><i class='fa fa-pencil'></i></a>&nbsp;
			              <a href='' style='color:red' class='deleteBtn' id='".$customer['id']."'>
			              <i class='fa fa-trash' ></i></a>
			            </td>
			        </tr>";
				}
			$output .= "</tbody>
      		</table>";
      		echo $output;	
		}else{
			echo '<h3 class="text-center mt-5">No records found</h3>';
		}
	}

	// Edit Record	
	if (isset($_POST['editId'])) {
		$editId = $_POST['editId'];
		$row = $garden->getRecordById($editId);
		echo json_encode($row);
	}

    if (isset($_POST['action']) && $_POST['action'] == "update") {

		$name = $_POST['name'];
		$country = $_POST['country'];
        $id = $_POST['id'];
		$garden->updateRecord($id, $name,  $country);
	}

    	// Delete Record	
	if (isset($_POST['deleteId'])) {
		$deleteId = $_POST['deleteId'];
		$row = $garden->delete($deleteId);
		echo json_encode(array("msg"=>"Record Deleted Successfully"));
	}

    

?>