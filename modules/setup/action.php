<?php
	// Include config.php file
    include_once('../../models/Model.php');
    include_once('../../database/page_init.php');

	include_once('Garden.php');
	include_once('GardenCluster.php');

	$garden = new Garden($conn);
	$cluster = new GardenCluster($conn);

	// Insert Record	
	if (isset($_POST['action']) && $_POST['action'] == "insert") {

		$name = $_POST['name'];
		$country = $_POST['country'];
		$garden->insertRecord($name,$country);
	}

	// View record
	if (isset($_POST['action']) && $_POST['action'] == "view") {
		$output = "";

		$gardens = $garden->displayRecord();

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
			$id = 1;
			foreach ($gardens as $garden) {
			$output.="<tr>
			            <td>".$id."</td>
			            <td>".$garden['mark']."</td>
			            <td>".$garden['country']."</td>
			            <td>
						<a data-toggle='tooltip' data-placement='bottom' title='Set Grade Clusters'  class='databaseBtn text-warning' id='".$garden['id']."'>
			              <i class='fa fa-database' ></i></a>&nbsp&nbsp&nbsp;

			              <a href='#editModal' style='color:green' data-toggle='modal' 
			              class='editBtn' id='".$garden['id']."'><i class='fa fa-pencil'></i></a>&nbsp;
			              <a href='' style='color:red' class='deleteBtn' id='".$garden['id']."'>
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
	if (isset($_POST['action']) && $_POST['action'] == "garden-cluster") {
		$output = "";
		$id = $_POST["id"];
		$clusters = $cluster->displayRecord($id);

		if ($cluster->totalRowCount() > 0) {
			$output .="<table class='table table-striped table-bordered table-hover'>
			        <thead>
			          <tr>
			            <th>Id</th>
			            <th>code</th>
			            <th>Grade</th>
			            <th>Action</th>
			          </tr>
			        </thead>
			        <tbody>";
			$id = 1;
			foreach ($clusters as $cluster) {
			$output.="<tr>
			            <td>".$id."</td>
			            <td>".$cluster['code']."</td>
			            <td>".$cluster['name']."</td>
			            <td>
			              <a href='#editCModal' style='color:green' data-toggle='modal' 
			              class='editCBtn' id='".$cluster['cluster_id']."'><i class='fa fa-pencil'></i></a>&nbsp;
			              <a href='' style='color:red' class='deleteCBtn' id='".$cluster['cluster_id']."'>
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
	if (isset($_POST['action']) && $_POST['action'] == "update-cluster") {
		$editId = $_POST['id'];
		$row = $cluster->getRecordById($editId);
		echo json_encode($row);
	}
    
	if (isset($_POST['action']) && $_POST['action'] == "save-composition") {

		$gardenId = $_POST['gardenId'];
		$code = $_POST['code'];
		$grade = $_POST['grade'];
		$formid = $_POST['formid'];

		if($formid>0){
			echo "Updating";
			$cluster->updateCluster($formid,$gardenId,$code, $grade);
		}else{
			echo "Inserting";

			$cluster->insertRecord($gardenId,$code, $grade);
		}


	}
	if (isset($_POST['action']) && $_POST['action'] == "delete-cluster") {
		$id = $_POST['id'];
		echo $cluster->deleteCluster($id);
	}

	
	
?>