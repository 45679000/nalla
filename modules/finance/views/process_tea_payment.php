
	<body class="">
		<!-- <div id="global-loader" ></div> -->
		<div class="page" >
			<div class="page-main">
		
				<div class="my-3 my-md-5">
					<div class="container-fluid">
				
						<div class="row">
							<div class="col-md-2">
                                <div class="card">
									<div class="card-body">
										<div class="card-box tilebox-one">
											<i class="icon-layers float-right text-muted"><i class="fa fa-history text-success" aria-hidden="true"></i></i>
											<h6 class="text-drak text-uppercase mt-0">Pending Processing</h6>
											<h2 class="m-b-20">1</h2>
											<span class="badge badge-success"> +0% </span> <span class="text-muted">Current period</span>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-body">
										<div class="card-box tilebox-one">
											<i class="icon-layers float-right text-muted"><i class="fa fa-cubes text-success" aria-hidden="true"></i></i>
											<h6 class="text-drak text-uppercase mt-0">Facilities Pending Payment</h6>
											<h2 class="m-b-20">0</h2>
											<span class="badge badge-success"> +0% </span> <span class="text-muted">Current period</span>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-body">
										<div class="card-box tilebox-one">
											<i class="icon-layers float-right text-muted"><i class="fa fa-bar-chart text-secondary" aria-hidden="true"></i></i>
											<h6 class="text-drak text-uppercase mt-0">Facilities Paid</h6>
											<h2 class="m-b-20">0</h2>
											<span class="badge badge-secondary"> +0% </span> <span class="text-muted">Current period</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-8">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Facilities</h3>
									</div>
									<div id="facilities" class="table-responsive">
									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Back to top-->
		<a href="#top" id="back-to-top" style="display: inline;"><i class="fa fa-angle-up"></i></a>

        <script src="<?php echo $path_to_root ?>assets/js/vendors/jquery-3.2.1.min.js"></script>
        <script src="<?php echo $path_to_root ?>assets/plugins/select2/select2.full.min.js"></script>
        <script src="<?php echo $path_to_root ?>assets/plugins/datatable/jszip.min.js"></script>
        <script src="<?php echo $path_to_root ?>assets/plugins/datatable/pdfmake.min.js"></script>
        <script src="<?php echo $path_to_root ?>assets/plugins/datatable/vfs_fonts.js"></script>
        <script src="<?php echo $path_to_root ?>assets/plugins/datatable/buttons.html5.min.js"></script>
        <script src="<?php echo $path_to_root ?>assets/plugins/datatable/buttons.print.min.js"></script>


<script>

loadUnbookedLots();
$("body").on("click", ".process", function(e) {
    $.ajax({
            type: "POST",
            dataType: "html",
            url: 'finance_action.php',
            data: {
                action: 'process-facility',
                facility_no: $(this).attr("id")
            },
            success: function(data) {
                loadUnbookedLots();
            }
        });
 });


function loadUnbookedLots() {
        $.ajax({
            type: "POST",
            dataType: "html",
            url: 'finance_action.php',
            data: {
                action: 'view-facilities',
            },
            success: function(data) {
                $("#facilities").html(data);
                $("#table").DataTable({
                    scrollX: '50vh',
                    scrollCollapse: false,
                    paging: true,
                    scrollY: '50vh',

                });

            }
        });

    }

</script>

		<!-- <script src="./assets/js/vendors/jquery-3.2.1.min.js"></script>
		<script src="./assets/js/vendors/bootstrap.bundle.min.js"></script>
		<script src="./assets/js/vendors/jquery.sparkline.min.js"></script>
		<script src="./assets/js/vendors/selectize.min.js"></script>
		<script src="./assets/js/vendors/jquery.tablesorter.min.js"></script>
		<script src="./assets/js/vendors/circle-progress.min.js"></script>
		<script src="./assets/plugins/rating/jquery.rating-stars.js"></script> -->
		<!-- Custom scroll bar Js-->
		<!-- <script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script> -->

		<!-- Custom Js-->
		<!-- <script src="assets/js/custom.js"></script> -->
    </body>
</html>