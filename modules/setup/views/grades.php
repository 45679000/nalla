<div class="row">

</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <i id="helpBlend" style="float:left; font-size:large" class="fa fa-question-circle">help</i>
                    <div id="help" style="display:none; margin-left:30px; text-align:center">
                        <span class="label label-info">Click Add Standard Button to add new standard,
                            <i class="fa fa-database btn-success"></i> to add set standard composition <i
                                class="fa fa-pencil btn-success"></i>
                            to edit a standard and <i class="fa fa-trash btn-danger"></i> to delete a standard</span>
                    </div>
                    <div class="card-options">
                        <button style="display: none;" id="refresh" type="button"
                            class="btn btn-success m-1 float-right btn-sm">
                            <i class="fa fa-reply"></i>
                        </button>

                        <button id="create" type="button" class="btn btn-success m-1 float-right btn-sm"
                            data-toggle="modal" data-target="#addModal">
                            <i class="fa fa-plus"></i> Add Grade</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="tableData">
                        <h3 class="text-center text-success" style="margin-top: 150px;">Loading...</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Add Record  Modal -->
<div class="modal" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Grade</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="formData">
                    <div class="form-group">
                        <label for="name">Grade Name:</label>
                        <input type="text" class="form-control" name="name" placeholder="Grade Name" required="">
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control" name="description" placeholder="Enter Description"
                            required="">
                    </div>
                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-success" id="submit">Submit</button>
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
                <h4 class="modal-title">Edit Grade</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="EditformData">
                    <input type="hidden" name="id" id="edit-form-id">
                    <div class="form-group">
                        <label for="name">Grade Name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Grade Name"
                            required="">
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control" name="description" id="description"
                            placeholder="Enter Description" required="">
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

<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<!-- Custom Js-->
<script src="../../assets/js/custom.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</body>

<script type="text/javascript">
$(document).ready(function() {
    showAllGrades();
    //View Record
    function showAllGrades() {
        $.ajax({
            url: "grades_action.php",
            type: "POST",
            data: {
                action: "view"
            },
            success: function(response) {
                $("#tableData").html(response);
                $("table").DataTable({});
            }

        });
    }

    $("#update").click(function(e) {
        if ($("#EditformData")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: "grades_action.php",
                type: "POST",
                data: $("#EditformData").serialize() + "&action=update",
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Customer Updated successfully',
                    });
                    $("#addModal").modal('hide');
                    $("#EditformData")[0].reset();
                    showAllGrades();
                }
            });
        }
    });


    //insert ajax request data
    $("#submit").click(function(e) {
        if ($("#formData")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: "grades_action.php",
                type: "POST",
                data: $("#formData").serialize() + "&action=insert",
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Record added successfully',
                    });
                    $("#addModal").modal('hide');
                    $("#formData")[0].reset();
                    showAllGrades();
                }
            });
        }
    });

    //Edit Record
    $("body").on("click", ".editBtn", function(e) {
        e.preventDefault();
        var editId = $(this).attr('id');
        $.ajax({
            url: "grades_action.php",
            type: "POST",
            data: {
                editId: editId
            },
            success: function(response) {
                var data = JSON.parse(response);
                $("#edit-form-id").val(data.id);
                $("#name").val(data.name);
                $("#description").val(data.description);
            }
        });
    });

    //Delete Record
    $("body").on("click", ".deleteBtn", function(e) {
        e.preventDefault();
        var deleteId = $(this).attr('id');
        $.ajax({
            url: "grades_action.php",
            type: "POST",
            data: {
                deleteId: deleteId
            },
            success: function(response) {
                showAllGrades();
                Swal.fire({
                    icon: 'success',
                    title: 'Record deleted successfully',
                });
            }
        });
    });



});
</script>