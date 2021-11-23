<?php
	// Include config.php file
    include_once('../../models/Model.php');
    include_once('../../database/page_init.php');

	include_once('Broker.php');

	$broker = new Broker($conn);

	// Insert Record	
	if (isset($_POST['action']) && $_POST['action'] == "insert") {

		$name = $_POST['name'];
		$code = $_POST['code'];
		$broker->insertRecord($name,$code);
	}

	// View record
	if (isset($_POST['action']) && $_POST['action'] == "view") {
		$output = "";

		$brokers = $broker->displayRecord();

		if ($broker->totalRowCount() > 0) {
			$output .="<table class='table table-striped table-bordered table-hover'>
			        <thead>
			          <tr>
			            <th>Id</th>
                        <th>Code</th>
			            <th>Broker Name</th>
			            <th>Action</th>
			          </tr>
			        </thead>
			        <tbody>";
				$id = 1;
			foreach ($brokers as $broker) {
			$output.="<tr>
						<td>".$id."</td>
						<td>".$broker['code']."</td>
			            <td>".$broker['name']."</td>
			            <td>
			              <a href='#editModal' style='color:green' data-toggle='modal' 
			              class='editBtn' id='".$broker['id']."'><i class='fa fa-pencil'></i></a>&nbsp;
			              <a href='' style='color:red' class='deleteBtn' id='".$broker['id']."'>
			              <i class='fa fa-trash' ></i></a>
			            </td>
			        </tr>";
					$id++;

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
		$row = $broker->getRecordById($editId);
		echo json_encode($row);
	}

    if (isset($_POST['action']) && $_POST['action'] == "update") {

		$name = $_POST['name'];
		$code = $_POST['code'];
        $id = $_POST['id'];
		$broker->updateRecord($id, $code, $name);
	}

    	// Delete Record	
	if (isset($_POST['deleteId'])) {
		$deleteId = $_POST['deleteId'];
		$row = $broker->delete($deleteId);
		echo json_encode(array("msg"=>"Record Deleted Successfully"));
	}

    

?>