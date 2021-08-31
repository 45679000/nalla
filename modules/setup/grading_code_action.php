<?php
	// Include config.php file
    include_once('../../models/Model.php');
    include_once('../../database/page_init.php');

	include_once('GradingCodes.php');

	$codes = new GradingCodes($conn);

	// Insert Record	
	if (isset($_POST['action']) && $_POST['action'] == "insert") {

		$description = $_POST['description'];
		$code = $_POST['code'];
		$order_id = $_POST['order_id'];
		$codes->insertRecord($description,$code, $order_id);
	}

	// View record
	if (isset($_POST['action']) && $_POST['action'] == "view") {
		$output = "";

		$codess = $codes->displayRecord();

		if ($codes->totalRowCount() > 0) {
			$output .="<table class='table table-striped table-bordered table-hover'>
			        <thead>
			          <tr>
			            <th>Id</th>
                        <th>Code</th>
			            <th>Description</th>
			            <th>Action</th>
			          </tr>
			        </thead>
			        <tbody>";
			foreach ($codess as $codes) {
			$output.="<tr>
			            <td>".$codes['order_id']."</td>
                        <td>".$codes['code']."</td>
			            <td>".$codes['description']."</td>
			            <td>
			              <a href='#editModal' style='color:green' data-toggle='modal' 
			              class='editBtn' id='".$codes['id']."'><i class='fa fa-pencil'></i></a>&nbsp;
			              <a href='' style='color:red' class='deleteBtn' id='".$codes['id']."'>
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
		$row = $codes->getRecordById($editId);
		echo json_encode($row);
	}

    if (isset($_POST['action']) && $_POST['action'] == "update") {

		$description = $_POST['description'];
		$code = $_POST['code'];
        $id = $_POST['id'];
		$order_id = $_POST['order_id'];
		$codes->updateRecord($id, $description,  $code, $order_id);
	}

    	// Delete Record	
	if (isset($_POST['deleteId'])) {
		$deleteId = $_POST['deleteId'];
		$row = $codes->delete($deleteId);
		echo json_encode(array("msg"=>"Record Deleted Successfully"));
	}

    

?>