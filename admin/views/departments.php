<?php
session_start();
error_reporting(1);
$path_to_root = "../../";
include('../../database/page_init.php');
?>

<body class="">
	<div class="page">
		<div class="page-main">
			<div class="my-1 my-md-3">
				<div class="container-fluid">
					<div class="col-lg-12">
						<div class="card p-4">
						
							<div id="departmentList" class="">

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>





	<script type="text/javascript">
    $(document).ready(function() {
		loadDepartments();
        function loadDepartments(){
			$.ajax({
				type: "POST",
				data: {
					action: "list-departments",
				},
				cache: true,
				url: "user_action.php",
				success: function (data) {
					$("#departmentList").html(data);
					$(".table").dataTable();
				}
			});
		}

	});

</script>