<?php
$path_to_root = "../../";
require_once $path_to_root . 'templates/header.php';
?>
<style>
    .modal-dialog{
        background-color: rgba(217, 245, 255,0.5);
        border: 1px solid;
    }
   .table {
        background-color: white !important;
        width:100% !important;
    }
    .toolbar-button{
        padding: 0.5px !important;
    }
    .modal {
        text-align: center;
    width:100% !important;
    }

@media screen and (min-width: 768px) { 
  .modal:before {
    display: inline-block;
    vertical-align: middle;
    content: " ";
    height: 100%;
  }
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
  width:1000%;
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
		<div class="card table-responsive p-2">
			<div class="card-header">
				<h3 class="card-title">Update Shippment Status</h3>
			</div>
			<div class="card-body p-6">
				<div class="panel panel-primary">
					<div class=" tab-menu-heading">
						<div class="tabs-menu1 ">
							<!-- Tabs -->
							<ul class="nav panel-tabs">
								<li class=""><a href="#tab5" class="active" data-toggle="tab">Pending</a></li>
								<li><a href="#tab6" data-toggle="tab">Received To warehouse</a></li>
								<li><a href="#tab7" data-toggle="tab">Blended</a></li>
								<li><a href="#tab8" data-toggle="tab">Shipped</a></li>
							</ul>
						</div>
					</div>
					<div class="panel-body tabs-menu-body">
						<div class="tab-content">
							<div class="tab-pane active " id="tab5">
								<div id="unupdatedi"></div>
							</div>
							<div class="tab-pane" id="tab6">
								<div id="receivedi"></div>
							</div>
							<div class="tab-pane" id="tab7">
								<div id="blendedi"></div>
							</div>
							<div class="tab-pane" id="tab8">
								<div id="shippedi"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- modal start-->
			<div class="modal fade" id="updateStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Modal Title</h4>
				</div>
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
				<div class="modal-footer">
					<button class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				</div>
			</div>
			</div>
		<!-- modal end -->
		<!-- Add Record  Modal -->
		<div class="modal modal-md" id="updateStatus1">
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
							<input type="checkbox" class="status" id="ReceivedSi" name="status" value="Received">
							<label for="Received">Received to The Warehouse</label><br>
							<input type="checkbox" class="status" id="BlendedSi" name="status" value="Blended">
							<label for="Blended"> Blended </label><br>
							<input type="checkbox" class="status" id="ShippedSi" name="status" value="Shipped">
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
						shipmentStatus("null", "unupdatedi");
						shipmentStatus("Shipped", "shippedi")
						shipmentStatus("Blended","blendedi");
						shipmentStatus("Received","receivedi");
				
					var sino = localStorage.getItem("clickedSi");

					$(".status").click(function(e){
						$('#formData').trigger('reset');

						var value = $(this).val();
						updateShippmentStatus(value, sino);
					
					});
				
				$("body").on("change", ".shipment-status", function(e) {
					var value = $(this).val();
					var id = $(this).attr("id");
					updateShippmentStatus(value, id);
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
							shipmentStatus("null", "unupdatedi");
							shipmentStatus("Shipped", "shippedi")
							shipmentStatus("Blended","blendedi");
							shipmentStatus("Received","receivedi");
						}
					});
				}

				});

				
				
				$('.table').DataTable({});

		</script>

		</html>