<?php
    $role = $_SESSION['role_id'];
	if($role==1){
      //show all menu for admin
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
		echo menu_catalogue($path_to_root);
		echo menu_tasting_grading($path_to_root);
		echo menu_stock($path_to_root);
		echo menu_setup($path_to_root);

	}else if($role==3){
		//shipping 
		echo menu_stock($path_to_root);
		echo menu_shipping($path_to_root);
		echo menu_setup($path_to_root);

	}else if($role==4){
		echo menu_user_management($path_to_root);
		echo menu_setup($path_to_root);
	}

	function menu_catalogue($path_to_root){
		return '
		<li class="nav-item with-sub mega-dropdown">
		<a class="nav-link" href="#"><i class="fa fa-pencil-square-o"></i><span>CATALOGUES</span></a>
		<div class="sub-item">
			<div class="row">
				<div class="col-lg-12">
					<label class="section-label">Catalogues</label>
					<div class="row">
						<div class="col">
							<ul>
								<div class="text-center">
									<a href="#"><i style="font-size:65px; color: Dodgerblue;" class="fa fa-file-text-o"></i></a>
									<a href='.$path_to_root.'views/auction_order.php>Auction Order</a>
								</div>
							</ul>
						</div>
						<div class="col">
							<ul>
								<div class="text-center">
									<a href="#"><i style="font-size:65px; color: Dodgerblue;" class="fa fa-address-card"></i></a>
									<a href='.$path_to_root.'views/closing_import.php>Import Closing Catalogue</a>
								</div>
							</ul>
						</div>
						<div class="col">
							<ul>
								<div class="text-center">
									<a href="#"><i style="font-size:65px; color: Dodgerblue;" class="fa fa-credit-card-alt"></i></a>
									<a href='.$path_to_root.'views/catalogue_correction.php>Catalogue Corrections</a>
								</div>
	
							</ul>
						</div>
						<div class="col">
							<ul>
								<div class="text-center">
									<a href="#"><i style="font-size:65px; color: red;" class="fa fa-file-text-o"></i></a>
									<a href='.$path_to_root.'views/post_import.php>Post Catalogue Import</a>
								</div>
							</ul>
						</div>
						<div class="col">
						<ul>
							<div class="text-center">
								<a href='.$path_to_root.'modules/cataloguing/imports/itts_import.php><i style="font-size:65px; color: brown;" class="fa fa-file-text-o"></i></a>
								<a href='.$path_to_root.'modules/cataloguing/imports/itts_import.php>ITTS Import</a>
							</div>
						</ul>
					</div>
						<div class="col">
							<ul>
								<div class="text-center">
									<a href="#"><i style="font-size:65px; color: red;" class="fa fa-cloud-upload"></i></a>
									<a href='.$path_to_root.'views/valuation.php>Import Valuations</a>
								</div>
							</ul>
						</div>
						<div class="col">
							<ul>
								<div class="text-center">
									<a href="#"><i style="font-size:65px; color: red;" class="fa fa-list"></i></a>
									<a href='.$path_to_root.'views/view_valuations.php>View Valuations</a>
								</div>
							</ul>
						</div>
						<div class="col-lg mg-t-30 mg-lg-t-0">
							<ul>
								<div class="text-center">
									<a href="#"><i style="font-size:65px; color: red;" class="fa fa-times"></i></a>
									<a href='.$path_to_root.'views/remove_catalogue.php>Remove Catalogue</a>
								</div>
	
							</ul>
						</div><!-- col -->
						<div class="col-lg mg-t-30 mg-lg-t-0">
							<ul>
								<div class="text-center">
									<a href="#"><i style="font-size:65px; color: red;" class="fa fa-file"></i></a>
									<a href='.$path_to_root.'reports/broker_catalogue.php>Broker Catalogue</a>
								</div>
							</ul>
						</div><!-- col -->
						<div class="col-lg mg-t-30 mg-lg-t-0">
							<ul>
								<div class="text-center">
									<a href="#"><i style="font-size:65px; color: red;" class="fa fa-book"></i></a>
									<a href='.$path_to_root.'views/closing_import.php>Fresh Brokers</a>
								</div>
							</ul>
						</div><!-- col -->
	
					</div><!-- row -->
				</div><!-- col -->
			</div><!-- row -->
		</div>
		<!-- dropdown-menu -->
	</li>';
	}
	function menu_tasting_grading($path_to_root){
		return '
		<li class="nav-item">
			<a class="nav-link" href='.$path_to_root.'views/tasting_grading.php?view=grading><i class="fa fa-bar-chart"></i> <span>Tasting Grading</span></a>
		</li>';
	}
	function menu_stock($path_to_root){
		return '
		<li class="nav-item">
			<a class="nav-link" href='.$path_to_root.'views/stock_index.php?view=purchase-list><i class="fa fa-database"></i> <span>Stocks</span></a>
		</li>';
	}
	function menu_shipping($path_to_root){
		return '
		<li class="nav-item">
			<a class="nav-link" href='.$path_to_root.'modules/shipping/index.php><i class="fa fa-ship"></i> <span>Shipping</span></a>
		</li>';
	}
	function menu_finance($path_to_root){
		return '
		<li class="nav-item">
			<a class="nav-link" href='.$path_to_root.'views/finance.php><i class="fa fa-money"></i><span>Finance</span></a>
		</li>';
	}
	function menu_ware_housing($path_to_root){
		return '
		<li class="nav-item">
			<a class="nav-link" href='.$path_to_root.'views/warehousing.php?view=warehouses><i class="fa fa-wrench"></i><span>Ware Housing</span></a>
		</li>';
	}
	function menu_reports($path_to_root){
		return '
			<li class="nav-item">
				<a class="nav-link" href='.$path_to_root.'reports/index.php?rep=broker-catalog><i class="fa fa-file-text-o"></i> <span>Reports</span></a>
			</li>';
	}
	function menu_user_management($path_to_root){
		return '
		<li class="nav-item">
			<a class="nav-link" href='.$path_to_root.'admin/admin/index.php><i class="fa fa-users"></i><span>User Management</span></a>
		</li>';
	}
	function menu_setup($path_to_root){
		return '
		<li class="nav-item">
			<a class="nav-link" href='.$path_to_root.'modules/setup/index.php?view=standards><i class="fa fa-cogs"></i><span>Setup</span></a>
		</li>';
	}
	
?>






