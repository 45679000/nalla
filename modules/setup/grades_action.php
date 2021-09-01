<?php
	// Include config.php file
    include_once('../../models/Model.php');
    include_once('../../database/page_init.php');

	include_once('Grades.php');

	$grade = new Grade($conn);

	// Insert Record	
	if (isset($_POST['action']) && $_POST['action'] == "insert") {

		$name = $_POST['name'];
		$description = $_POST['description'];
		$grade->insertRecord($name,$description);
	}

	// View record
	if (isset($_POST['action']) && $_POST['action'] == "view") {
		$output = "";

		$grades = $grade->displayRecord();

		if ($grade->totalRowCount() > 0) {
			$output .="<table class='table table-striped table-bordered table-hover'>
			        <thead>
			          <tr>
			            <th>Id</th>
                        <th>Name</th>
			            <th>Description</th>
			            <th>Action</th>
			          </tr>
			        </thead>
			        <tbody>";
			$id = 1;
			foreach ($grades as $grade) {
			$output.="<tr>
						<td>".$id."</td>
						<td>".$grade['name']."</td>
                        <td>".$grade['description']."</td>
			            <td>
						
			              <a href='#editModal' style='color:green' data-toggle='modal' 
			              class='editBtn' id='".$grade['id']."'><i class='fa fa-pencil'></i></a>&nbsp;
			              <a href='' style='color:red' class='deleteBtn' id='".$grade['id']."'>
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
		$row = $grade->getRecordById($editId);
		echo json_encode($row);
	}

    if (isset($_POST['action']) && $_POST['action'] == "update") {

		$name = $_POST['name'];
		$description = $_POST['description'];
        $id = $_POST['id'];
		$grade->updateRecord($id, $name,  $description);
	}

    	// Delete Record	
	if (isset($_POST['deleteId'])) {
		$deleteId = $_POST['deleteId'];
		$row = $grade->delete($deleteId);
		echo json_encode(array("msg"=>"Record Deleted Successfully"));
	}

    

?>