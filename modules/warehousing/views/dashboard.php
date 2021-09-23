<?php
$path_to_root = "../../";
require_once $path_to_root . 'templates/header.php';
?>
<style>
	table,
	th,
	td {
		border: 1px solid black;
	}

	th {
		background-color: burlywood;
	}
	.modal {
   position: absolute;
   top: 10px;
   right: 30px;
   bottom: 0;
   left: 3000;
   z-index: 10040;
   overflow: auto;
   overflow-y: auto;
}
</style>

<body class="container-fluid">
	<div id="global-loader"></div>
	<div class="page">
		<div class="page-main">
			<div class="my-6 my-md-6">
				<div class="container-fluid card">
					<div id="dashboardCards" class="row row-cards">
						<div id="totalP" class="col-lg-3 col-md-6 col-sm-12">
						</div>
						<div id="totalStck" class="col-lg-3 col-md-6 col-sm-12">
						</div>
						<div id="totalShpd" class="col-lg-3 col-md-6 col-sm-12">
						</div>

					</div>

				</div>
			</div>
		</div>
		<div class="table-responsive card p-2">
			<div class="card-header"></div>
			<div id="shippmentStatus"></div>
		</div>
		<!-- Add Record  Modal -->
		<div class="modal modal-md" id="updateStatus">
			<div class="modal-dialog">
				<div class="modal-content">
					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">Shippment Status</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<!-- Modal body -->
					<div class="modal-body">
						<form id="formData">
							<input type="checkbox" class="status" id="Received" name="status" value="Received">
							<label for="Received">Received to The Warehouse</label><br>
							<input type="checkbox" class="status" id="Blended" name="status" value="Blended">
							<label for="Blended"> Blended </label><br>
							<input type="checkbox" class="status" id="Shipped" name="status" value="Shipped">
							<label for="Shipped"> Shipped</label><br><br>
							<hr>
						</form>
					</div>
				</div>
			</div>
		</div>

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
		
			
			$(document).ready(function() {
					shipmentStatus();
					var sino = localStorage.getItem("si_no");

					$(".status").click(function(e){
						var value = $(this).val();
						updateShippmentStatus(value, sino);
					
					});
		
			
				
				appendCard("pvsvs", "../../modules/dashboard/dashboard_action.php");

				appendCard("totalP", "../../modules/dashboard/dashboard_action.php");
				appendCard("totalStck", "../../modules/dashboard/dashboard_action.php");
				appendCard("totalShpd", "../../modules/dashboard/dashboard_action.php");
				appendCard("totalStckO", "../../modules/dashboard/dashboard_action.php");
				appendCard("totalStckB", "../../modules/dashboard/dashboard_action.php");
				appendCard("totalStckAllc", "../../modules/dashboard/dashboard_action.php");
				appendCard("totalStckUnAllc", "../../modules/dashboard/dashboard_action.php");



				function appendCard(id, url) {
					$.ajax({
						type: "POST",
						data: {
							tag: id
						},
						cache: true,
						url: url,
						success: function(data) {
							$("#" + id).html(data);
						}
					});
				}

				function updateShippmentStatus(value, id){
					$.ajax({
						url: "warehousing_action.php",
						type: "POST",
						data: {
							action:"update-status",
							id:id,
							value: value
						},
						success: function(response) {
							Swal.fire({
								icon: 'success',
								title: 'Status Updated',
							});
							
							shipmentStatus();

						}
					});
				}

				});
		</script>

		</html>