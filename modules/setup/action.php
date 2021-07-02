<?php
	// Include config.php file
    include_once('../../models/Model.php');
    include_once('../../database/page_init.php');

	include_once('Garden.php');

	$garden = new Garden($conn);

	// Insert Record	
	if (isset($_POST['action']) && $_POST['action'] == "insert") {

		$name = $_POST['name'];
		$country = $_POST['country'];
		$garden->insertRecord($name,$country);
	}

	// View record
	if (isset($_POST['action']) && $_POST['action'] == "view") {
		$output = "";

		$customers = $garden->displayRecord();

		if ($garden->totalRowCount() > 0) {
			$output .="<table class='table table-striped table-bordered table-hover'>
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