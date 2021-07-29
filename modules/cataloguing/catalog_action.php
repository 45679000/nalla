<?php
	$path_to_root = '../../';
    include_once($path_to_root.'/models/Model.php');
    include_once($path_to_root.'/database/page_init.php');

	include ($path_to_root.'controllers/CatalogController.php');

	$CatalogController = new Catalogue($conn);

	if(isset($_POST['action']) && $_POST['action'] == "list-buying"){
		$catalogs= $CatalogController->buyingSummary($sale_no);
		$output = "";
		if(count($catalogs)>0){
			$output .= '
			<table id="dashboard" class="table">
			<thead>
				<tr>
					<th>Broker</th>
                    <th>Lots</th>
					<th>Kgs</th>
					<th>Pkgs</th>
				</tr>
			</thead>
			<tbody>';
			foreach($catalogs as $catalog){
				$output .= '<tr>';
					$output .= '<td>'.$catalog['broker'].'</td>';
					$output .= '<td>'.$catalog['totalLots'].'</td>';
					$output .= '<td>'.$catalog['totalKgs'].'</td>';
					$output .= '<td>'.$catalog['totalPkgs'].'</td>';
					'</tr>';
			}
			$output .= '</tbody>
					</table>';

		}else{
			$output.= "<p>You don't have any Buying For this Sale</p>";
		}
		echo $output;

	}
?>

