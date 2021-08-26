<?php
    $role = $_SESSION['role_id'];
	if($role==1){
      echo dashboard($path_to_root);
	  echo menu_catalogue($path_to_root);
	  echo menu_tasting_grading($path_to_root);
	  echo menu_stock($path_to_root);
	  echo menu_shipping($path_to_root);
	  echo menu_finance($path_to_root);
	  echo menu_ware_housing($path_to_root);
	  echo menu_reports($path_to_root);
	  echo menu_user_management($path_to_root);
	  echo menu_setup($path_to_root);
	}else if($role==2){
		//cataloging and tasting and grading
		echo dashboard($path_to_root);
		echo menu_catalogue($path_to_root);
		echo menu_tasting_grading($path_to_root);
		echo menu_finance($path_to_root);
		echo menu_stock($path_to_root);
		echo menu_ware_housing($path_to_root);
		echo menu_setup($path_to_root);

	}else if($role==3){
		//shipping 
		echo dashboard($path_to_root);
		echo menu_stock($path_to_root);
		echo menu_shipping($path_to_root);
		echo menu_setup($path_to_root);

	}else if($role==4){
		echo dashboard($path_to_root);
		echo menu_user_management($path_to_root);
		echo menu_setup($path_to_root);
	}else if($role==5){
		echo menu_ware_housing($path_to_root);


	}else if($role==6){
		echo menu_catalogue($path_to_root);
		echo menu_tasting_grading($path_to_root);
	}

	function menu_catalogue($path_to_root){
		return '
		<li class="nav-item with-sub">
					<a class="nav-link" href='.$path_to_root.'modules/cataloguing/index.php?view=dashboard><i class="fa fa-snowflake-o text-success"></i> <span class="font-weight-bold">Catalogues</span></a>
					<div class="sub-item">
						<ul>
							<li>
								<a href='.$path_to_root.'modules/cataloguing/imports/closing_import.php>Import Pre-Auction Catalogs</a>
							</li>
							<li>
								<a href='.$path_to_root.'modules/cataloguing/imports/itts_import.php>Import Post-Auction Catalog</a>
							</li>
							<li>
								<a href='.$path_to_root.'views/view_valuations.php>View Catalogs</a>
							</li>
							<li>
								<a href='.$path_to_root.'reports/broker_catalogue.php>Print Catalogs</a>
							</li>
							
						</ul>
					</div>
					<!-- dropdown-menu -->
				</li>';
}

	function menu_tasting_grading($path_to_root){
		return '
		<li class="nav-item">
			<a class="nav-link" href='.$path_to_root.'views/tasting_grading.php?view=grading><i class="fa fa-bar-chart text-primary font-weight-bold"></i> <span class="font-weight-bold">Tasting Grading</span></a>
		</li>';
	}
	function menu_stock($path_to_root){
		return '
		<li class="nav-item">
			<a class="nav-link" href='.$path_to_root.'modules/stock/index.php?view=dashboard><i class="fa fa-database text-info font-weight-bold"></i> <span class="font-weight-bold">Stocks</span></a>
		</li>';
	}
	function menu_shipping($path_to_root){
		return '
		<li class="nav-item">
			<a class="nav-link" href='.$path_to_root.'modules/shipping/index.php><i class="fa fa-ship text-warning font-weight-bold"></i> <span class="font-weight-bold">Shipping</span></a>
		</li>';
	}
	function menu_finance($path_to_root){
		return '
		<li class="nav-item">
			<a class="nav-link" href='.$path_to_root.'modules/finance/index.php?view=dashboard><i class="fa fa-money text-danger font-weight-bold"></i><span class="font-weight-bold">Finance</span></a>
		</li>';
	}
	function menu_ware_housing($path_to_root){
		return '
		<li class="nav-item">
			<a class="nav-link" href='.$path_to_root.'modules/warehousing/index.php?view=dashboard><i class="fa fa-wrench text-danger font-weight-bold"></i><span class="font-weight-bold">Ware Housing</span></a>
		</li>';
	}
	function menu_reports($path_to_root){
		return '
			<li class="nav-item">
				<a class="nav-link" href='.$path_to_root.'reports/index.php?rep=broker-catalog><i class="fa fa-file-text-o text-danger font-weight-bold"></i> <span class="font-weight-bold">Reports</span></a>
			</li>';
	}
	function menu_user_management($path_to_root){
		return '
		<li class="nav-item">
			<a class="nav-link" href='.$path_to_root.'admin/admin/index.php><i class="fa fa-users text-danger font-weight-bold"></i><span class="font-weight-bold">User Management</span></a>
		</li>';
	}
	function menu_setup($path_to_root){
		return '
		<li class="nav-item">
			<a class="nav-link" href='.$path_to_root.'modules/setup/index.php?view=standards><i class="fa fa-cogs text-primary font-weight-bold"></i><span class="font-weight-bold">Setup</span></a>
		</li>';
	}
	function dashboard($path_to_root){
		return '
		<li class="nav-item">
			<a class="nav-link active" href='.$path_to_root.'views/dashboard.php>
				<i class="fa fa-home"></i>
				<span> DASHBOARD</span>
			</a>
		</li>
		';
	}
	
?>






