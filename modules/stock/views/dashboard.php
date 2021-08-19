<?php
$path_to_root = "../../";
require_once $path_to_root . 'templates/header.php';
error_reporting(1);

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
					<div id="dashboardCards" class="row row-cards">	
						<div id="totalP" class="col-lg-3 col-md-6 col-sm-12">
						</div>	
						<div id="totalStck" class="col-lg-3 col-md-6 col-sm-12">
						</div>
						<div id="totalShpd" class="col-lg-3 col-md-6 col-sm-12">
						</div>
						<div id="totalStckO" class="col-lg-3 col-md-6 col-sm-12">
						</div>
						<div id="totalStckB" class="col-lg-3 col-md-6 col-sm-12">
						</div>
						<div id="totalStckAllc" class="col-lg-3 col-md-6 col-sm-12">
						</div>
						<div id="totalStckUnAllc" class="col-lg-3 col-md-6 col-sm-12">
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

<script type="text/javascript">
    $(document).ready(function() {
		appendCard("totalP", "../../modules/dashboard/dashboard_action.php");
		appendCard("totalStck", "../../modules/dashboard/dashboard_action.php");
		appendCard("totalShpd", "../../modules/dashboard/dashboard_action.php");
		appendCard("totalStckO", "../../modules/dashboard/dashboard_action.php");
		appendCard("totalStckB", "../../modules/dashboard/dashboard_action.php");
		appendCard("totalStckAllc", "../../modules/dashboard/dashboard_action.php");
		appendCard("totalStckUnAllc", "../../modules/dashboard/dashboard_action.php");

		
		
		
		function appendCard(id, url){
			$.ajax({
				type: "POST",
				data: {
					tag: id
				},
				cache: true,
				url: url,
				success: function (data) {
					$("#"+id).html(data);
				}
			});
		}
        
    });
</script>
</html>