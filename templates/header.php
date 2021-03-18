<?php
$path_to_root = "../"
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
								<div class="dropdown mt-1">
									<a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
										<span class="avatar avatar-md brround" style="background-image: url(assets/images/faces/female/25.jpg)"></span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
										<div class="text-center">
											<a href="#" class="dropdown-item text-center font-weight-sembold user">Jessica Allan</a>
											<span class="text-center user-semi-title text-dark">web designer</span>
											<div class="dropdown-divider"></div>
										</div>
								
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
							<li class="nav-item with-sub">
								<a class="nav-link" href="#"><i class="fa fa-bar-chart"></i> <span>Import Catalogues</span></a>
								<div class="sub-item">
									<ul>

										<li>
											<a href="<? echo $path_to_root?>layouts/closing_import.php">Import Closing Catalogue</a>
										</li>
										<li>
											<a href="closing_catalog_import.php">Import ITTS Catalogue</a>
										</li>
                                        <li>
											<a href="closing_catalog_import.php">Import Valuation Catalogue</a>
										</li>
										
										
									</ul>
								</div>
								<!-- dropdown-menu -->
							</li>

							<li class="nav-item">
								<a class="nav-link" href="#"><i class="fa fa-database"></i> <span>STOCK</span></a>	
							<!-- dropdown-menu -->
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#"><i class="fa fa-pencil-square-o"></i><span>FINANCE</span></a>
								
								<!-- dropdown-menu -->
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#"><i class="fa fa-cogs"></i><span>Sytem Configurations</span></a>
							
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="dropdown" href="#"><i class="fa fa-file-text-o"></i> <span>Reports</span></a>
								<!-- dropdown-menu -->
							</li>
							<li class="nav-item">
								<a class="nav-link " data-toggle="dropdown" href="#"><i class="fa fa-users"></i> <span>User Management</span></a>
								<!-- dropdown-menu -->
							</li>
						</ul>
					</div>
				</div>