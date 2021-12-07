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
                <form id="formData" method="post">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="name">Garden Name:</label>
								<input type="text" class="form-control" name="name" placeholder="Garden Name" required="">
                    		</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="country">Country:</label>
								<input type="text" class="form-control" name="country" placeholder="Enter country" required="">
							</div>
						</div>
					</div>
                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-success" id="saveGarden">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Record  Modal -->
<div class="modal" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Garden</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="EditformData">
                    <input type="hidden" name="id" id="edit-form-id">
                    <div class="form-group">
                        <label for="name">Garden Name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Garden Name"
                            required="">
                    </div>
                    <div class="form-group">
                        <label for="country">Country:</label>
                        <input type="text" class="form-control" name="country" id="country" placeholder="Enter country"
                            required="">
                    </div>
                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-primary" id="update">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
			$("#addModal").show();
		})
    });
</script>