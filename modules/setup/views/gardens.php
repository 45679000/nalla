<div class="row">
        <button type="button" class="btn btn-success m-1 float-right" data-toggle="modal" data-target="#addModal">
            <i class="fa fa-plus"></i> Add New Garden</button>
</div><br>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="table-responsive" id="tableData">
                <h3 class="text-center text-success" style="margin-top: 150px;">Loading...</h3>
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
                <h4 class="modal-title">Garden</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="formData">
                    <div class="form-group">
                        <label for="name">Garden Name:</label>
                        <input type="text" class="form-control" name="name" placeholder="Garden Name" required="">
                    </div>
                    <div class="form-group">
                        <label for="country">Country:</label>
                        <input type="text" class="form-control" name="country" placeholder="Enter country" required="">
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
                <h4 class="modal-title">Edit Garden</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="EditformData">
                    <input type="hidden" name="id" id="edit-form-id">
                    <div class="form-group">
                        <label for="name">Garden Name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Garden Name" required="">
                    </div>
                    <div class="form-group">
                        <label for="country">Country:</label>
                        <input type="text" class="form-control" name="country" id="country" placeholder="Enter country" required="">
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


</body>

<script type="text/javascript">
    $(document).ready(function() {
        showAllGardens();
        //View Record
        function showAllGardens() {
            $.ajax({
                url: "action.php",
                type: "POST",
                data: {
                    action: "view"
                },
                success: function(response) {
                    $("#tableData").html(response);
                    $("table").DataTable({
                        order: [0, 'ASC']
                    });
                }

            });
        }

        $("#update").click(function(e) {
            if ($("#EditformData")[0].checkValidity()) {
                e.preventDefault();
                $.ajax({
                    url: "action.php",
                    type: "POST",
                    data: $("#EditformData").serialize() + "&action=update",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Customer Updated successfully',
                        });
                        $("#addModal").modal('hide');
                        $("#EditformData")[0].reset();
                        showAllGardens();
                    }
                });
            }
        });


        //insert ajax request data
        $("#submit").click(function(e) {
            if ($("#formData")[0].checkValidity()) {
                e.preventDefault();
                $.ajax({
                    url: "action.php",
                    type: "POST",
                    data: $("#formData").serialize() + "&action=insert",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Record added successfully',
                        });
                        $("#addModal").modal('hide');
                        $("#formData")[0].reset();
                        showAllGardens();
                    }
                });
            }
        });

        //Edit Record
        $("body").on("click", ".editBtn", function(e) {
            e.preventDefault();
            var editId = $(this).attr('id');
            $.ajax({
                url: "action.php",
                type: "POST",
                data: {
                    editId: editId
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $("#edit-form-id").val(data.id);
                    $("#name").val(data.mark);
                    $("#country").val(data.country);
                }
            });
        });

        //Delete Record
        $("body").on("click", ".deleteBtn", function(e) {
            e.preventDefault();
            var deleteId = $(this).attr('id');
            $.ajax({
                url: "action.php",
                type: "POST",
                data: {
                    deleteId: deleteId
                },
                success: function(response) {
                    showAllGardens();
                    Swal.fire({
                        icon: 'success',
                        title: 'Record deleted successfully',
                    });
                }
            });
        });



    });
</script>