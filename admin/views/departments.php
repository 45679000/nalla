<?php
session_start();
error_reporting(1);
$path_to_root = "../../";
include('../../database/page_init.php');
?>
<style>
	.editBtn:hover, .deleteBtn:hover {
		cursor: pointer !important;
	}
	select {
		display: block;
		width: 100%;
		padding: 0.375rem 0.75rem;
		font-size: 0.9375rem;
		line-height: 1.6;
		color: black;
		background-color: #fff;
		background-clip: padding-box;
		border: 1px solid #eaeaea !important;
		border-radius: 3px !important;
		transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
	}
</style>
<body class="">
	<div class="page">
		<div class="page-main">
			<div class="my-1 my-md-3">
				<div class="container-fluid">
					
					<div class="col-lg-12">
						<div class="card p-4">
							<div class="col-12">	
								<button type="button" id="addDepartment" class="btn btn-sm btn-success"><i class="fa fa-plus">Add Department</i></button>
							</div>	
							<div id="departmentList" class="">

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="addModal">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header bg-teal">
					<h4 class="modal-title">Add Department</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<form id="formData" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="name">Department name:</label>
									<input type="text" id="full_name" class="form-control" name="name" placeholder="" required="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="name">Head of department:</label>
									<select name="head" id="head" class="form-control">

									</select>
								</div>
							</div>
							<input type="hidden" class="form-control"  name="action" value="add_department">
							<input type="hidden" class="form-control"  id="department_id" name="department_id">

						</div>
						<hr>
						<div class="form-group float-right">
							<button type="submit" class="btn btn-success btn-sm" id="saveUser">Submit</button>
							<button type="button" class="btn btn-danger btn-sm close"  data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Edit Record  Modal -->
	<div class="modal" id="editModal">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header bg-teal">
					<h4 class="modal-title">Edit department</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<form id="editForm" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="name">Department name:</label>
									<input type="text" id="full_name" class="form-control" name="name" placeholder="" required="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="name">Head of department:</label>
									<select name="head" id="head" class="form-control">

									</select>
								</div>
							</div>
							<input type="hidden" class="form-control"  name="action" value="update_department">
							<input type="hidden" class="form-control"  id="department_id" name="department_id">

						</div>
						<hr>
						<div class="form-group float-right">
							<button type="submit" class="btn btn-success btn-sm" >Update</button>
							<button type="button" class="btn btn-danger btn-sm close"  data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>





	<script type="text/javascript">
    $(document).ready(function() {
		loadDepartments();
		getUsers();
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
		$(".close").click(function(e){
            $(".modal").hide();
        });
		$("#addDepartment").click(function(e){
            $('#formData').trigger("reset");
			$("#addModal").show();
		});
		$("body").on("click", ".editBtn", function(e){
			// e.preventDefault()
			var editId = $(this).parent().parent().attr('id');
            // $('#formData').trigger("reset");
			// $("#editModal").show();
			getDepartment(editId)
		});
		$("#editForm").on('submit', (function(e){
            e.preventDefault();
            $.ajax({
				type: "POST",
                data: new FormData(this),
                contentType: false, cache: false, processData:false,
				url: "user_action.php",
				success: function (data) {
                    $("#editModal").hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Department details updated successfully',
                    });
                    loadDepartments();

				}
			});
     
        }));
		function getDepartment(id){
			console.log(id)
			$.ajax({
                url: "user_action.php",
                type: "POST",
                dataType: "json",
                data: {
                    id: id,
                    action: "get-department"
                },
                success: function(response) {
                    $("#editModal").show();
                    var data = response[0];
					console.log(data.department_id)
                    $("#full_name").val(data.department_name);
                    // $("#head").val(data.department_leader).change()
					$('option[value='+data.department_leader+']').attr('selected','selected');
                    $("#department_id").val(data.department_id);


                    
                }
            });
		}
		function getUsers(){
			$.ajax({
                url: "user_action.php",
                type: "POST",
                dataType: "json",
                data: {
                    action: "get-users"
                },
                success: function(response) {
					let ht = ''
					response.forEach((item) => {
						ht += "<option value='"+item.user_id+"'>"+item.full_name+"</option>"
					})
					$('#head').html(ht)
                }
            });
		}
		$("#formData").on('submit', (function(e){
            e.preventDefault();
            $.ajax({
				type: "POST",
                data: new FormData(this),
                contentType: false, cache: false, processData:false,
				url: "user_action.php",
				success: function (data) {
                    $("#addModal").hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Department created successfully',
                    });
                    loadDepartments();

				}
			});
     
        }));
	});
		

</script>