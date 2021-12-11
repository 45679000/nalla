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
							<div class="card-header">
								<button type="button" id="addUser" class="btn btn-sm btn-success"><i class="fa fa-plus">Add User</i></button>
							</div>
							<div id="userList" class="">

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Add Record  Modal -->
<div class="modal" id="addModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-teal">
                <h4 class="modal-title">Add User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="formData" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="name">Full Name:</label>
								<input type="text" class="form-control" name="full_name" placeholder="Full Name" required="">
                    		</div>
						</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label for="name">Email:</label>
								<input type="text" class="form-control" name="email" placeholder="Email" required="">
                    		</div>
						</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label for="name">Department:</label>
                                <select name="department_id" class="form-control custom-select">
                                    <option value="0">--Select--</option>
                                    <option value="1">Tea Room</option>
                                    <option value="2">Finance</option>
                                    <option value="4">Shipping</option>
                                    <option value="5">Warehousing</option>

                                </select>
                    		</div>
						</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label for="name">Role:</label>
                                <select name="role_id" class="form-control custom-select">
                                    <option value="0">--Select--</option>
                                    <option value="1">User</option>
                                    <option value="2">Support</option>
                                    <option value="3">Admin</option>
                                </select>
                    		</div>
						</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label for="name">Profile Picture:</label>
								<input type="file"  class="dropify" name="image"/>
                    		</div>
						</div>
                        <input type="hidden" class="form-control"  name="action" value="create-user">

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
                <h4 class="modal-title">Add User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="editForm" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="name">Full Name:</label>
								<input type="text" id="full_name" class="form-control" name="full_name" placeholder="Full Name" required="">
                    		</div>
						</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label for="name">Email:</label>
								<input type="text" id="email" class="form-control" name="email" placeholder="Email" required="">
                    		</div>
						</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label for="name">Department:</label>
                                <select id="department_id" name="department_id" class="form-control custom-select">
                                    <option value="0">--Select--</option>
                                    <option value="1">Tea Room</option>
                                    <option value="2">Finance</option>
                                    <option value="4">Shipping</option>
                                    <option value="5">Warehousing</option>

                                </select>
                    		</div>
						</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label for="name">Role:</label>
                                <select id="role_id" name="role_id" class="form-control custom-select">
                                    <option value="0">--Select--</option>
                                    <option value="1">User</option>
                                    <option value="2">Support</option>
                                    <option value="3">Admin</option>
                                </select>
                    		</div>
						</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label for="name">Profile Picture:</label>
								<input type="file" id="image"   name="image"/>
                    		</div>
						</div>
                        <input type="hidden" class="form-control"  name="action" value="create-user">
                        <input type="hidden" class="form-control"  id="user_id" name="user_id">

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
		loadUsers();
		function loadUsers(){
			$.ajax({
				type: "POST",
				data: {
					action: "list-user",
				},
				cache: true,
				url: "user_action.php",
				success: function (data) {
					$("#userList").html(data);
					$(".table").dataTable();
				}
			});
		}

		$("#addUser").click(function(e){
            $('#formData').trigger("reset");
			$("#addModal").show();
		});

        $(".close").click(function(e){
            $(".modal").hide();
        });
        $("#formData, #editForm").on('submit', (function(e){
            e.preventDefault();
            $.ajax({
				type: "POST",
                data: new FormData(this),
                contentType: false, cache: false, processData:false,
				url: "user_action.php",
				success: function (data) {
                    loadUsers();

				}
			});
     
        }));
        $("body").on("click", ".editBtn", function(e) {
            e.preventDefault();
            var editId = $(this).parent().parent().attr('id');
            $.ajax({
                url: "user_action.php",
                type: "POST",
                dataType: "json",
                data: {
                    id: editId,
                    action: "get-user"
                },
                success: function(response) {
                    $("#editModal").show();
                    var data = response[0];
                   
                    $("#full_name").val(data['full_name']);
                    $("#email").val(data['email']);
                    $("#department_id").val(data['department_id']);
                    $("#role_id").val(data['role_id']);
                    $("#user_id").val(data['user_id']);

                    $("#image").addClass('dropify');
                    $("#image").attr("data-height", 300);
                    $("#image").attr("data-default-file", data['image']);
                    $('.dropify').dropify();

                    loadUsers();

                    
                }
            });
        });

        
    });
</script>