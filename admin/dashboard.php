<?php
$path_to_root = "../";
require_once $path_to_root . 'templates/header.php';
?>

<body class="container-fluid">
	<div id="global-loader"></div>
	<div class="page">
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
							<div id="totalP"></div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div id="totalStck"></div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div id="totalShpd"></div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="card widgets-cards" id="totalusers"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">Year 2021 Buying</h3>
								</div>
								<div class="card-body text-center">
									<div id="highchart7"></div>
								</div>
							</div>
						</div>
					</div>



				</div>
			</div>
		</div>

		<?php
		include $path_to_root . 'templates/footer.php';
		?>
		<script type="text/javascript">
			$(document).ready(function() {
				// appendCard("pvsvs", "../modules/dashboard/dashboard_action.php");

				appendCard("totalP", "../modules/dashboard/dashboard_action.php");
				appendCard("totalStck", "../modules/dashboard/dashboard_action.php");
				appendCard("totalShpd", "../modules/dashboard/dashboard_action.php");
				appendCard("totalusers", "../modules/dashboard/user_dashboard_action.php");

				$.ajax({
						type: "POST",
						dataType: "json",
						data: {
							tag: "barChart0"
						},
						cache: true,
						url: "../modules/dashboard/dashboard_action.php",
						success: function(data) {
							var categories = [];
							var colors = ['#17B794', '#172f71', '#ecb403', '#24CBE5', '#64E572', '#FF9655', '#f1c40f', '#6AF9C4'];
							var points = [];
							for(let i=0; i<data.length; i++){
								console.log(data[i].sale_no);
								categories[i] = data[i].sale_no;
								points[i] = data[i].pkgs;

							}
							drawChart('highchart7',
									  'Packages Bought By Sale No',
						  			  categories,
						  			  colors,
						  			  points
						   );
						}
					});



			

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


			});


			function drawChart(id, text, xAxisArray, colorsArray, dataPointsArray, url){
	
			var chart = Highcharts.chart(id, {

				title: {
					text: ''
				},

				subtitle: {
					text: text
				},
				exporting: {
					enabled: true
				},
				credits: {
					enabled: false
				},
				xAxis: {
					categories: xAxisArray 
				},
				colors: colorsArray,
				series: [{
					type: 'column',
					colorByPoint: true,
					data: dataPointsArray,
					showInLegend: false
				}]

			});
		}

			
		</script>

		</html>