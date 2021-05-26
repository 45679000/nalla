
<?php 
	include $path_to_root.'database/page_init.php';
?>
<!doctype html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<meta name="msapplication-TileColor" content="#0061da">
		<meta name="theme-color" content="#1643a3">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<link rel="icon" href="favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

		<!-- Title -->
		<title>Chamu TIFMS</title>
		<link rel="stylesheet" href="<?=$path_to_root ?>assets/fonts/fonts/font-awesome.min.css">

		<!-- Font family -->
		<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">


		<!-- Dashboard Css -->
		<link href="<?=$path_to_root ?>assets/css/dashboard.css" rel="stylesheet" />


		<!-- c3.js Charts Plugin -->
		<link href="<?=$path_to_root ?>assets/plugins/charts-c3/c3-chart.css" rel="stylesheet" />

		<!-- Custom scroll bar css-->
		<link href="<?=$path_to_root ?>assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />

		<!---Font icons-->
        <link href="<?=$path_to_root ?>assets/plugins/iconfonts/plugin.css" rel="stylesheet" />
        
        	<!-- forn-wizard css-->
		<link href="<?=$path_to_root ?>assets/plugins/forn-wizard/css/material-bootstrap-wizard.css" rel="stylesheet" />
        <link href="<?=$path_to_root ?>assets/plugins/forn-wizard/css/demo.css" rel="stylesheet" />
        
        <!-- file upload css -->
        <link href="<?=$path_to_root ?>assets/plugins/fileuploads/css/dropify.min.css" rel="stylesheet" type="text/css" />

		<!-- Data table css -->
		<link href="<?=$path_to_root ?>assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />

		<!-- select2 Plugin -->
		<link href="<?=$path_to_root ?>assets/plugins/select2/select2.min.css" rel="stylesheet" />
			<!-- Tabs Style -->
		<link href="<?=$path_to_root ?>assets/plugins/tabs/style.css" rel="stylesheet" />
		<link href="<?=$path_to_root ?>assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet" />
		<style>
* {
  box-sizing: border-box;
}

body {
  margin: 0;
}

.navbar {
  overflow: hidden;
  background-color: #333;
  font-family: Arial, Helvetica, sans-serif;
}

.navbar a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  font: inherit;
  margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: red;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  width: 100%;
  left: 0;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content .header {
  background: red;
  padding: 16px;
  color: white;
}

.dropdown:hover .dropdown-content {
  display: block;
}

/* Create three equal columns that floats next to each other */
.column {
  float: left;
  width: 33.33%;
  padding: 10px;
  background-color: #ccc;
  height: 250px;
}

.column a {
  float: none;
  color: black;
  padding: 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.column a:hover {
  background-color: #ddd;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    height: auto;
  }
}
		</style>

    </head>
    <div class="header py-1">
					<div class="container-fluid">
						<div class="d-flex">
							<a class="header-brand" href="index.html">
								<img style="background-color:white;" src="<?=$path_to_root ?>images/logo.png" class="header-brand-img" alt="CHAMU">
							</a>
							<div class="container-fluid">
								<form class="input-icon mt-2 ">
									<div class="input-icon-addon">
										<i class="fe fe-search"></i>
									</div>
									<input type="search" class="form-control header-search" placeholder="Search&hellip;" tabindex="1">
								</form>
							</div>
							<div class="d-flex order-lg-2 ml-auto">
						
								<div class="dropdown d-none d-md-flex mt-1">
									<a class="nav-link icon" data-toggle="dropdown">
										<i class="fe fe-bell floating"></i>
										<span class="nav-unread bg-danger"></span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a href="#" class="dropdown-item d-flex pb-3">
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item text-center">View all Notification</a>
									</div>
								</div>
								<div class="dropdown d-none d-md-flex mt-1">
									<a class="nav-link icon" data-toggle="dropdown">
										<i class="fe fe-mail floating"></i>
										<span class=" nav-unread badge badge-warning  badge-pill">2</span>
									</a>
									
								</div>
								<div class="dropdown d-none d-md-flex mt-1">
									<a class="nav-link icon" data-toggle="dropdown">
										<i class="fe fe-grid floating"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<ul class="drop-icon-wrap p-1">
											<li>
												<a href="email.html" class="drop-icon-item">
													<i class="fe fe-mail text-dark"></i>
													<span class="block"> E-mail</span>
												</a>
											</li>
							
										</ul>
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item text-center">View all</a>
									</div>
								</div>
								<div class="dropdown d-none d-md-flex mt-1">
									<a href="<? echo $path_to_root?>views/logout.php" class="nav-link icon" >
										<i class="fa fa-sign-out floating"></i>
									</a>
								</div>
								<div class="dropdown mt-1">
									<a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
										<span class="avatar avatar-md brround" style="background-image: url(assets/images/faces/female/25.jpg)"></span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
										<div class="text-center">
											<a href="#" class="dropdown-item text-center font-weight-sembold user">Francis Chege</a>
											<span class="text-center user-semi-title text-dark">web designer</span>
											<div class="dropdown-divider"></div>
										</div>
										<a class="dropdown-item" href="#">
											<i class="dropdown-icon mdi mdi-account-outline "></i> Profile
										</a>
										<a class="dropdown-item" href="login.html">
											<i class="dropdown-icon mdi  mdi-logout-variant"></i> Sign out
											<a href="<?=$path_to_root ?>views/logout.php" class="nav-link pr-0 leading-none" data-toggle="dropdown">
										<span>Log Out</span>
										Log Out
									</a>
										</a>
									</div>
								</div>
							</div>
							<a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
							<span class="header-toggler-icon"></span>
							</a>
						</div>
					</div>
				</div>
				<div class="admin-navbar container-fluid" id="headerMenuCollapse">
					<div class="container-fluid">
						<ul class="nav">
							<li class="nav-item">
								<a class="nav-link active" href="dashboard.php">
									<i class="fa fa-home"></i>
									<span> DASHBOARD</span>
								</a>
							</li>
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
															<a href="#"><i style="font-size:65px; color: Dodgerblue;" class="fa fa-book"></i></a>
															<a href="<? echo $path_to_root?>views/auction_order.php">Auction Order</a>
														</div>
													</ul>
												</div>
												<div class="col">
													<ul>
														<div class="text-center">
															<a href="#"><i style="font-size:65px; color: Dodgerblue;" class="fa fa-address-card"></i></a>
															<a href="<? echo $path_to_root?>views/closing_import.php">Import Closing Catalogue</a>
														</div>
													</ul>
												</div>
												<div class="col">
													<ul>
														<div class="text-center">
															<a href="#"><i style="font-size:65px; color: Dodgerblue;" class="fa fa-credit-card-alt"></i></a>
															<a href="<? echo $path_to_root?>views/catalogue_correction.php">Catalogue Corrections</a>
														</div>
											
													</ul>
												</div>
												<div class="col">
													<ul>
														<div class="text-center">
															<a href="#"><i style="font-size:65px; color: red;" class="fa fa-book"></i></a>
															<a href="<? echo $path_to_root?>views/post_import.php">Post Catalogue Import</a>
														</div>										
													</ul>
												</div>
												<div class="col">
													<ul>
														<div class="text-center">
															<a href="#"><i style="font-size:65px; color: red;" class="fa fa-plus"></i></a>
															<a href="<? echo $path_to_root?>views/add_lot.php">Add New Lots</a>
														</div>		
													</ul>
												</div>
												<div class="col">
													<ul>
													   <div class="text-center">
															<a href="#"><i style="font-size:65px; color: red;" class="fa fa-cloud-upload"></i></a>
															<a href="<? echo $path_to_root?>views/valuation.php">Import Valuations</a>
														</div>
													</ul>
												</div>
												<div class="col">
													<ul>
														<div class="text-center">
															<a href="#"><i style="font-size:65px; color: red;" class="fa fa-list"></i></a>
															<a href="<? echo $path_to_root?>views/view_valuations.php">View Valuations</a>
														</div>	
													</ul>
												</div>
												<div class="col-lg">
													<ul>
													   <div class="text-center">
															<a href="#"><i style="font-size:65px; color: red;" class="fa fa-columns"></i></a>
															<a href="<? echo $path_to_root?>views/closing_import.php">Valuation Corrections</a>
														</div>
													</ul>
												</div><!-- col -->
												<div class="col-lg mg-t-30 mg-lg-t-0">
													<ul>
														<div class="text-center">
															<a href="#"><i style="font-size:65px; color: red;" class="fa fa-times"></i></a>
															<a href="<? echo $path_to_root?>views/remove_catalogue.php">Remove Catalogue</a>
														</div>
													
													</ul>
												</div><!-- col -->
												<div class="col-lg mg-t-30 mg-lg-t-0">
													<ul>
													    <div class="text-center">
															<a href="#"><i style="font-size:65px; color: red;" class="fa fa-book"></i></a>
															<a href="<? echo $path_to_root?>reports/broker_catalogue.php">Broker Catalogue</a>
														</div>
													</ul>
												</div><!-- col -->
												<div class="col-lg mg-t-30 mg-lg-t-0">
													<ul>
														<div class="text-center">
															<a href="#"><i style="font-size:65px; color: red;" class="fa fa-book"></i></a>
															<a href="<? echo $path_to_root?>views/closing_import.php">Fresh Brokers</a>
														</div>
													</ul>
												</div><!-- col -->

											</div><!-- row -->
										</div><!-- col -->
									</div><!-- row -->
								</div>
								<!-- dropdown-menu -->
							</li>


							<li class="nav-item">
								<a class="nav-link" href="<? echo $path_to_root?>views/tasting_grading.php"><i class="fa fa-bar-chart"></i> <span>Tasting Grading</span></a>
								<!-- dropdown-menu -->
							</li>

							<li class="nav-item">
								<a class="nav-link" href="<? echo $path_to_root?>views/stock_index.php?view=purchase-list"><i class="fa fa-database"></i> <span>Stocks</span></a>	
							<!-- dropdown-menu -->
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<? echo $path_to_root?>modules/shipping/index.php"><i class="fa fa-ship"></i> <span>Shipping</span></a>	
							<!-- dropdown-menu -->
							</li>

							<li class="nav-item">
								<a class="nav-link" href="<? echo $path_to_root?>views/stock.php"><i class="fa fa-trademark"></i> <span>Tea Board</span></a>	
							<!-- dropdown-menu -->
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<? echo $path_to_root?>views/finance.php"><i class="fa fa-money"></i><span>Finance</span></a>
								<!-- dropdown-menu -->
							</li>
							<!-- <li class="nav-item">
								<a class="nav-link" href="#"><i class="fa fa-money"></i><span>Trading</span></a>
							</li> -->
							<!-- <li class="nav-item">
								<a class="nav-link" href="#"><i class="fa fa-wrench"></i><span>Logistics</span></a>
							</li> -->
							<li class="nav-item">
								<a class="nav-link" href="<? echo $path_to_root?>views/warehousing.php?view=warehouses"><i class="fa fa-wrench"></i><span>Ware Housing</span></a>
							</li>
							<!-- <li class="nav-item">
								<a class="nav-link" href="#"><i class="fa fa-cogs"></i><span>Setup</span></a>
							</li> -->
							<li class="nav-item">
								<a class="nav-link"  href="<? echo $path_to_root?>reports/index.php"><i class="fa fa-file-text-o"></i> <span>Reports</span></a>
								<!-- dropdown-menu -->
							</li>
							<li class="nav-item">
								<a class="nav-link " data-toggle="dropdown" href="#"><i class="fa fa-users"></i> <span>User Management</span></a>
								<!-- dropdown-menu -->
							</li>
						</ul>
					</div>
				</div>