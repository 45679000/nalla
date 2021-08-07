<?php
$path_to_root = "../../";
require_once $path_to_root . 'templates/header.php';
?>
<style>
	table, th, td {
  		border: 1px solid black;
	}
	th{
		background-color: burlywood;
	}
</style>
<body class="container-fluid">
	<div id="global-loader"></div>
	<div class="page">
		<div class="page-main">

			<div class="my-6 my-md-6">
				<div class="container-fluid">
					<div class="row row-cards">
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="clearfix">
										<div class="float-right">
											<i class="mdi mdi-calendar-clock text-warning icon-size"></i>
										</div>
										<div class="float-left">
											<p class="mb-0 text-left">Total Purchases</p>
											<div class="">
												<h3 id="purchases" class="font-weight-semibold text-left mb-0">
													0 Kgs
												</h3>
											</div>
										</div>
									</div>
									<p class="text-muted mb-0">
										<i class="mdi mdi-arrow-up-drop-circle text-success mr-1" aria-hidden="true"></i>
										Kgs Purchased
									</p>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="clearfix">
										<div class="float-right">
											<i class="mdi mdi-ferry text-secondary icon-size"></i>
										</div>
										<div class="float-left">
											<p class="mb-0 text-left">Total Stock Available</p>
											<div class="">
												<h3 id="stock" class="font-weight-semibold text-left mb-0">
													0Kgs
												</h3>
											</div>
										</div>
									</div>
									<p class="text-muted mb-0">
										<i class="mdi mdi-arrow-down-drop-circle mr-1 text-danger" aria-hidden="true"></i> Total Kgs Stock
									</p>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="clearfix">
										<div class="float-right">
											<i class="mdi mdi-scale-balance text-danger icon-size"></i>
										</div>
										<div class="float-left">
											<p class="mb-0 text-left">Total Shipped</p>
											<div class="">
												<h3 id="shipped" class="font-weight-semibold text-left mb-0">
												0kgs
												</h3>
											</div>
										</div>
									</div>
									<p class="text-muted mb-0">
										<i class="mdi mdi-arrow-up-drop-circle mr-1 text-success" aria-hidden="true"></i>Total Kgs In Shipped
									</p>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="clearfix">
										<div class="float-right">
											<i class="mdi mdi-link-variant-off text-success icon-size"></i>
										</div>
										<div class="float-left">
											<p class="mb-0 text-left">Total Stock Original Teas</p>
											<div class="">
												<h3 id="original" class="font-weight-semibold text-left mb-0">0Kgs</h3>
											</div>
										</div>
									</div>
									<p class="text-muted  mb-0">
										<i class="mdi mdi-arrow-down-drop-circle mr-1 text-danger" aria-hidden="true"></i>Total Stock Original Teas
									</p>
								</div>
							</div>
						</div>
						
					</div>
					<div class="row row-cards">
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="clearfix">
										<div class="float-right">
											<i class="mdi mdi-calendar-clock text-warning icon-size"></i>
										</div>
										<div class="float-left">
											<p class="mb-0 text-left">Total Blended Teas</p>
											<div class="">
												<h3 id="blended" class="font-weight-semibold text-left mb-0">
													0 Kgs
												</h3>
											</div>
										</div>
									</div>
									<p class="text-muted mb-0">
										<i class="mdi mdi-arrow-up-drop-circle text-success mr-1" aria-hidden="true"></i>
										Kgs Blended
									</p>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="clearfix">
										<div class="float-right">
											<i class="mdi mdi-ferry text-secondary icon-size"></i>
										</div>
										<div class="float-left">
											<p class="mb-0 text-left">Total Stock Allocated</p>
											<div class="">
												<h3 id="stock" class="font-weight-semibold text-left mb-0">
													0Kgs
												</h3>
											</div>
										</div>
									</div>
									<p class="text-muted mb-0">
										<i class="mdi mdi-arrow-down-drop-circle mr-1 text-danger" aria-hidden="true"></i> Total Kgs Allocated
									</p>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="clearfix">
										<div class="float-right">
											<i class="mdi mdi-scale-balance text-danger icon-size"></i>
										</div>
										<div class="float-left">
											<p class="mb-0 text-left">Total Stock Unallocated</p>
											<div class="">
												<h3 id="unallocated" class="font-weight-semibold text-left mb-0">
												0kgs
												</h3>
											</div>
										</div>
									</div>
									<p class="text-muted mb-0">
										<i class="mdi mdi-arrow-up-drop-circle mr-1 text-success" aria-hidden="true"></i>Total Stock Unallocated
									</p>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="clearfix">
										<div class="float-right">
											<i class="mdi mdi-link-variant-off text-success icon-size"></i>
										</div>
										<div class="float-left">
											<p class="mb-0 text-left">Total Stock Paid and Allocated</p>
											<div class="">
												<h3 id="paidallocated" class="font-weight-semibold text-left mb-0">0Kgs</h3>
											</div>
										</div>
									</div>
									<p class="text-muted  mb-0">
										<i class="mdi mdi-arrow-down-drop-circle mr-1 text-danger" aria-hidden="true"></i>Total Stock Paid and Allocated
									</p>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<!-- Add Record  Modal -->


<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<!-- Custom Js-->
<script src="../../assets/js/custom.js"></script>
<script src="../../assets/js/warehousing.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
	dashboardSummaryTotals();
	

</script>
</html>