<?php
	// Include config.php file
    include_once('../../models/Model.php');
    include_once('../../database/page_init.php');

	include_once('GradingStandard.php');

	$standards = new GradingStandard($conn);

	// Insert Record	
	if (isset($_POST['action']) && $_POST['action'] == "insert") {

		$description = $_POST['description'];
		$standard = $_POST['standard'];
		$standards->insertRecord($description,$standard);
	}
	// Insert Record	
	if (isset($_POST['action']) && $_POST['action'] == "save-composition") {
		if(isset($_POST['type']) && $_POST['type'] == 'update'){
			$code = $_POST['code'];
			$percentage = $_POST['percentage'];
			$id = $_POST['id'];

			$standards->insertGradeCode($code, $percentage, $id, "update");
		}else{
			$code = $_POST['code'];
			$percentage = $_POST['percentage'];
			$standardId = $_POST['standardId'];
			$standards->insertGradeCode($code, $percentage, $standardId, "insert");

		}
		

	}


	// View record
	if (isset($_POST['action']) && $_POST['action'] == "view") {
		$output = "";

		$standardss = $standards->displayRecord();

		if ($standards->totalRowCount() > 0) {
			$output .="<table class='table table-striped table-bordered table-hover'>
			        <thead>
			          <tr>
			            <th>Id</th>
                        <th>Standard</th>
			            <th>Description</th>
			            <th>Action</th>
			          </tr>
			        </thead>
			        <tbody>";
					$id = 1;

			foreach ($standardss as $standards) {
			$output.="<tr>
						<td>".$id."</td>
						<td>".$standards['standard']."</td>
			            <td>".$standards['description']."</td>
			            <td>
						  <a data-toggle='tooltip' data-placement='bottom' title='Set Composition'  class='databaseBtn text-warning' id='".$standards['id']."'>
			              <i class='fa fa-database' ></i></a>&nbsp&nbsp&nbsp;

			              <a data-toggle='tooltip' data-placement='bottom' title='Edit'  href='#editModal' style='color:green' data-toggle='modal' 
			              class='editBtn' id='".$standards['id']."'><i class='fa fa-pencil'></i></a>&nbsp&nbsp&nbsp;

			              <a data-toggle='tooltip' data-placement='bottom' title='Delete' href='' style='color:red' class='deleteBtn' id='".$standards['id']."'>
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
		$row = $standards->getRecordById($editId);
		echo json_encode($row);
	}

    if (isset($_POST['action']) && $_POST['action'] == "update") {

		$description = $_POST['description'];
		$standard = $_POST['standard'];
        $id = $_POST['id'];
		$standards->updateRecord($id, $description,  $standard);
	}

    	// Delete Record	
	if (isset($_POST['deleteId'])) {
		$deleteId = $_POST['deleteId'];
		$row = $standards->delete($deleteId);
		echo json_encode(array("msg"=>"Record Deleted Successfully"));
	}

	if (isset($_POST['action']) && $_POST['action'] == "standard-composition") {

		$standard = $standards->getStandard($_POST['standardId'])[0]['standard'];

		$output = "
			<div class='text-center'>
				<span style='width:80px;' class='label label-info'>".$standard."</span>
			</div>";
		$compositions = $standards->getStandardComposition($_POST['standardId']);

		if (count($compositions)> 0) {
			$output .="<table class='table table-striped table-bordered table-hover'>
			        <thead>
			          <tr>
			            <th>Id</th>
                        <th>Code</th>
			            <th>Percentage</th>
			            <th>Action</th>
			          </tr>
			        </thead>
			        <tbody>";
					$id = 1;

			foreach ($compositions as $composition) {
			$output.="<tr>
						<td>".$composition['id']."</td>
						<td>".$composition['code']."</td>
			            <td>".$composition['percentage']."%</td>
			            <td>
			              <a data-toggle='tooltip' data-placement='bottom' title='Edit'  href='#editCompositionModal' style='color:green' data-toggle='modal' 
			              class='editCBtn' id='".$composition['id']."'><i class='fa fa-pencil'></i></a>&nbsp&nbsp&nbsp;

			              <a data-toggle='tooltip' data-placement='bottom' title='Delete' href='' style='color:red' class='deleteCBtn' id='".$composition['id']."'>
			              <i class='fa fa-trash' ></i></a>
			            </td>
			        </tr>";
					$id++;

				}
			$output .= "</tbody>
      		</table>";
      		echo $output;	
		}else{
			echo $output;	

			echo '<h3 class="text-center mt-5">Composition Not Set</h3>';
		}
	}
	if (isset($_POST['action']) && $_POST['action'] == "update-composition") {
		$id = $_POST['id'];
		$row = $standards->getComposition($id);
		echo json_encode($row);
	}
	if (isset($_POST['action']) && $_POST['action'] == "deleteComposition") {
		$id = $_POST['id'];
		$standards->deleteComposition($id);
	}

	
    

?>