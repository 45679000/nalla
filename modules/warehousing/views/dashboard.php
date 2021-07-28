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

			<div class="my-3 my-md-5">
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
											<p class="mb-0 text-left">Awaiting Shipments</p>
											<div class="">
												<h3 id="awaitingShipment" class="font-weight-semibold text-left mb-0">
													0 Kgs
												</h3>
											</div>
										</div>
									</div>
									<p class="text-muted mb-0">
										<i class="mdi mdi-arrow-up-drop-circle text-success mr-1" aria-hidden="true"></i>
										Kgs allocated to be shipped
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
											<p class="mb-0 text-left">Shipped</p>
											<div class="">
												<h3 id="shipped" class="font-weight-semibold text-left mb-0">
													0Kgs
												</h3>
											</div>
										</div>
									</div>
									<p class="text-muted mb-0">
										<i class="mdi mdi-arrow-down-drop-circle mr-1 text-danger" aria-hidden="true"></i> Total Kgs Shipped
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
											<p class="mb-0 text-left">Total Stock</p>
											<div class="">
												<h3 id="availableStock" class="font-weight-semibold text-left mb-0">
												0kgs
												</h3>
											</div>
										</div>
									</div>
									<p class="text-muted mb-0">
										<i class="mdi mdi-arrow-up-drop-circle mr-1 text-success" aria-hidden="true"></i>Total Kgs In stock
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
											<p class="mb-0 text-left">Unclosed Blends</p>
											<div class="">
												<h3 id="unclosedBlend" class="font-weight-semibold text-left mb-0">0Kgs</h3>
											</div>
										</div>
									</div>
									<p class="text-muted  mb-0">
										<i class="mdi mdi-arrow-down-drop-circle mr-1 text-danger" aria-hidden="true"></i>Blends Waiting to be closed
									</p>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-lg-12">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">Shipment Status</h3>
								</div>
								<div class="text-center">
									<div class="">
										<div id="shippmentStatus" class="table-responsive">
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Add Record  Modal -->
<div class="modal" id="updateStatus">
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
                    <div class="form-group">
                        <label for="name">Status</label>
						<select id="statusChange" name="statusChange" class="form-control select2-show-search">
                            <option disabled="" value="..." selected="">select</option>
							<option  value="Received" >Received To Warehouse</option>
							<option  value="Blended">blended</option>
							<option  value="Shipped">Shipped</option>
                        </select>                    
					</div>
                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-success" id="submit">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
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
	dashboardSummaryTotals();
	shipmentStatus();
	$("#submit").click(function(e) {
            if ($("#formData")[0].checkValidity()) {
                e.preventDefault();
				var sino = localStorage.getItem("si_no");
                $.ajax({
                    url: "warehousing_action.php",
                    type: "POST",
                    data: $("#formData").serialize() + "&action=update-status&sino="+sino,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Record added successfully',
                        });
                        $("#updateStatus").modal('hide');
                        $("#formData")[0].reset();
						shipmentStatus();

                    }
                });
            }
        });

</script>
</html>