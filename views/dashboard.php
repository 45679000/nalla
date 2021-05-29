<?php
$path_to_root = "../";
require_once $path_to_root.'templates/header.php';
?>
	<body class="container-fluid">
		<div id="global-loader" ></div>
		<div class="page" >
			<div class="page-main">
			
				<div class="my-3 my-md-5">
					<div class="container-fluid">
						<div class="page-header">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
							</ol>
						</div>

						<div class="row row-cards">
							<div class="col-lg-3 col-md-6 col-sm-12">
								<div class="card">
									<div class="card-body">
										<div class="clearfix">
											<div class="float-right">
												<i class="mdi mdi-cube text-warning icon-size"></i>
											</div>
											<div class="float-left">
												<p class="mb-0 text-left">Company Revenue</p>
												<div class="">
													<h3 class="font-weight-semibold text-left mb-0"></h3>
												</div>
											</div>
										</div>
										<p class="text-muted mb-0">
											<i class="mdi mdi-arrow-up-drop-circle text-success mr-1" aria-hidden="true"></i> 
										</p>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12">
								<div class="card">
									<div class="card-body">
										<div class="clearfix">
											<div class="float-right">
												<i class="mdi mdi-receipt text-secondary icon-size"></i>
											</div>
											<div class="float-left">
												<p class="mb-0 text-left">Projects</p>
												<div class="">
													<h3 class="font-weight-semibold text-left mb-0"></h3>
												</div>
											</div>
										</div>
										<p class="text-muted mb-0">
											<i class="mdi mdi-arrow-down-drop-circle mr-1 text-danger" aria-hidden="true"></i>  Completed Projects
										</p>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12">
								<div class="card">
									<div class="card-body">
										<div class="clearfix">
											<div class="float-right">
												<i class="mdi mdi-poll-box text-danger icon-size"></i>
											</div>
											<div class="float-left">
												<p class="mb-0 text-left">Profits</p>
												<div class="">
													<h3 class="font-weight-semibold text-left mb-0"></h3>
												</div>
											</div>
										</div>
										<p class="text-muted mb-0">
											<i class="mdi mdi-arrow-up-drop-circle mr-1 text-success" aria-hidden="true"></i> Monthly Profits
										</p>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12">
								<div class="card">
									<div class="card-body">
										<div class="clearfix">
											<div class="float-right">
												<i class="mdi mdi-account-location text-success icon-size"></i>
											</div>
											<div class="float-left">
												<p class="mb-0 text-left">Employees</p>
												<div class="">
													<h3 class="font-weight-semibold text-left mb-0">0</h3>
												</div>
											</div>
										</div>
										<p class="text-muted  mb-0">
											<i class="mdi mdi-arrow-down-drop-circle mr-1 text-danger" aria-hidden="true"></i>Employees Growth
										</p>
									</div>
								</div>
							</div>
						</div>

						<div class="row row-cards">
							<div class="col-md-6" style="height:10% !important;">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Company profit</h3>
									</div>
									<div class="card-body">
										<div class="chart-container">
											<canvas  id="lineChart"></canvas>
										</div>

									</div>
								</div>
								
							</div>
							<div class="col-md-6">
								<div class="card">
									<div class="card-header">
									
										<h3 class="card-title">Sales By Grades</h3>
									</div>
									<div class="card-body">
										<div id="highchart3" style="height:10% !important"></div>
									</div>
								</div>
								
							</div>
							<div class="col-xs-12 col-sm-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Auction Statistcs</h3>
									</div>
									<div class="text-center">
										<div class="">
											<div class="table_style table-responsive">

												<table class="table mb-0 ">
													<thead>
														<tr>
															<th>Lot No</th>
															<th>Customers</th>
															<th >Popularity</th>
															<th>Sale Price</th>

														</tr>
													</thead>
													<tbody>
														<tr>
															<td>BPF</td>
															<td>
															<ul class="users-list m-0">
																<li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Josh Hazlewood" class="pull-up list_membler">
																	<div class="avatar-list avatar-list-stacked">
																	  <span class="avatar brround" style="background-image: url(assets/images/faces/female/12.jpg)"></span>
																	  <span class="avatar brround" style="background-image: url(assets/images/faces/female/21.jpg)"></span>
																	  <span class="avatar brround" style="background-image: url(assets/images/faces/female/29.jpg)"></span>
																	  <span class="avatar brround">+8</span>
																	</div>
																</li>
															</ul></td>
															<td>
															<div class="progress" style="height: 5px;">
																<div class="progress-bar bg-info" role="progressbar" style="width:95%;" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
															</div></td>
															<td>KSH150.00</td>
														</tr>
													</tbody>
												</table>

											</div>
										</div>
									</div>
								</div>
							</div>
							
						</div>
						<div class="row row-cards row-deck">
							
							<div class="col-sm-12 col-lg-6">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Sales</div>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col text-center">
												<label class="tx-12">Today</label>
												<p class="font-weight-semibold"></p>
											</div><!-- col -->
											<div class="col border-left text-center">
												<label class="tx-12">This Week</label>
												<p class="font-weight-semibold"></p>
											</div><!-- col -->
											<div class="col border-left text-center">
												<label class="tx-12">This Month</label>
												<p class="font-weight-semibold"></p>
											</div><!-- col -->
										</div><!-- row -->

									<div class="progress mt-4">
										<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 50%">50%</div>
									</div>

									</div>
								</div>
							</div>
							<div class="col-sm-12 col-lg-6">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Profit</div>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col text-center">
												<label class="tx-12">Today</label>
												<p class="font-weight-semibold"></p>
											</div><!-- col -->
											<div class="col border-left text-center ">
												<label class="tx-12">This Week</label>
												<p class="font-weight-semibold"></p>
											</div><!-- col -->
											<div class="col border-left text-center">
												<label class="tx-12">This Month</label>
												<p class="font-weight-semibold"></p>
											</div><!-- col -->
										</div><!-- row -->

									<div class="progress mt-4">
										<div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" style="width: 35%">35%</div>
									</div>

									</div>
								</div>
							</div>
						</div>
				
					</div>
				</div>
			</div>

<?php
     include $path_to_root.'templates/footer.php';
?>
</html>