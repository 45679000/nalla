<div class="card table-responsive p-2">
    <div class="card-header bg-teal">
        <h3 class="card-title">Materials Types</h3>
        <div class="card-options">
        <button  id="add" type="button" class="btn btn-success m-1 float-right btn-sm" data-toggle="modal" data-target="#addModal">
        Define Material Types <i class="fa fa-plus"></i>
        </button>
</div>
    </div>
    <div class="card-body p-6">
        <div class="panel panel-primary">
            <div class="card-body">
                <div class="table-responsive" id="materialtypes">
                    <h3 class="text-center text-success" style="margin-top: 150px;">Loading...</h3>
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
                <h4 class="modal-title">Define Materials Types</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="formData">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Name" required="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="uom">UOM:</label>
                                <input type="text" class="form-control" name="uom" placeholder="UOM" required="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="unit_cost">Unit Cost:</label>
                                <input type="text" class="form-control" name="unit_cost" placeholder="unit cost" required="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="details">Description:</label>
                                <textarea type="text" class="form-control" name="description" placeholder="Enter details" required=""></textarea>
                        </div>
                    </div>

                    </div>
                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-success btn-sm" id="submit">Submit</button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
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
                <h4 class="modal-title">Update Materials Types</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="editform">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id = "name" name="name" placeholder="Name" required="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="uom">UOM:</label>
                                <input type="text" class="form-control" id = "uom" name="uom" placeholder="UOM" required="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="unit_cost">Unit Cost:</label>
                                <input type="text" class="form-control" id="unit_cost" name="unit_cost" placeholder="unit cost" required="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="details">Description:</label>
                                <textarea type="text" class="form-control" id = "description" name="description" placeholder="Enter details" required=""></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="id">
                    </div>
                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-success btn-sm" id="update">Update</button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
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
<script src="../../assets/js/sweet_alert2.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->


</body>
<script type="text/javascript">
$(document).ready(function() {
    loadPackingMaterialsTypes();

    $("#close").click(function(e) {
        e.preventDefault();
        location.reload();


    });    
    $("#submit").click(function(e) {
        if ($("#formData")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: "warehousing_action.php",
                type: "POST",
                data: $("#formData").serialize() + "&action=add-material-types",
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Record added successfully',
                    });
                    $("#formData")[0].reset();
                    loadPackingMaterialsTypes();
                    $("#addModal").modal('hide');

                }
            });
        }
    });

    $("#update").click(function(e) {
        if ($("#editform")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: "warehousing_action.php",
                type: "POST",
                data: $("#editform").serialize() + "&action=add-material-types",
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Record Updated successfully',
                    });
                    $("#editform")[0].reset();
                    loadPackingMaterialsTypes();
                    $("#editModal").modal('hide');

                }
            });
        }
    });
//Edit Record
$("body").on("click", ".editBtn", function(e) {
    e.preventDefault();
    var editId = $(this).attr('id');
    $.ajax({
        url: "warehousing_action.php",
        type: "POST",
        dataType: "json",
        data: {
            editId: editId,
            action: "edit-material-type"
        },
        success: function(data) {
            $("#id").val(data.id);
            $("#name").val(data.name);
            $("#uom").val(data.uom);
            $("#unit_cost").val(data.unit_cost);
            $("#description").val(data.description);

        }
    });
});
//Delete Record
$("body").on("click", ".delete", function(e) {
    e.preventDefault();
    var deleteId = $(this).attr('id');
    $.ajax({
        url: "warehousing_action.php",
        type: "POST",
        data: {
            id: deleteId,
            action: "delete-material-type"
        },
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Record deleted successfully',
            });
            loadPackingMaterialsTypes();

        }
    });
});

});
</script>