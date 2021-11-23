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
                            <i class="fa fa-database btn-success"></i>  to add set standard composition <i class="fa fa-pencil btn-success"></i> 
                            to edit a standard and <i class="fa fa-trash btn-danger"></i>  to delete a standard</span>
                        </div>
                        <div class="card-options">
                        <button style="display: none;" id="refresh" type="button" class="btn btn-success m-1 float-right btn-sm">
                         <i class="fa fa-reply"></i>
                        </button>

                        <button id="create" type="button" class="btn btn-success m-1 float-right btn-sm" data-toggle="modal" data-target="#addModal">
                        <i class="fa fa-plus"></i> Add Warehouse</button>
                        </div>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive" id="warehouseTable">
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
                <h4 class="modal-title">Add Warehouse</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="formData">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code">Code:</label>
                                <input type="text" class="form-control" name="code" placeholder="Enter code" required="">
                            </div>
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter name" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="location">location:</label>
                                <input type="text" class="form-control" name="location" placeholder="Location" required="">
                            </div>
                            <div class="form-group">
                                <label for="name">Details:</label>
                                <input type="text" class="form-control" name="details" placeholder="Enter details" required="">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-success" id="save">Save</button>
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
                <h4 class="modal-title">Edit Warehouse</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="EditformData">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code">Code:</label>
                                <input type="text" class="form-control" id="code" name="code" placeholder="Enter code" required="">
                            </div>
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="location">location:</label>
                                <input type="text" class="form-control" id="location" name="location" placeholder="Location" required="">
                            </div>
                            <div class="form-group">
                                <label for="name">Details:</label>
                                <input type="text" class="form-control" id="details" name="details" placeholder="Enter details" required="">
                            </div>
                            <input type="hidden" id="id" name="id" type="text">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group float-right">
                        <button  class="btn btn-success" id="edit">UPDATE</button>
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
<script src="../../assets/js/warehousing.js"></script>


<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</body>
<script type="text/javascript">
    $(document).ready(function() {
        loadWarehouses("../../modules/warehousing/warehousing_action.php");
        $("body").on("click", ".edit", function(e) {
            var editId = $(this).parent().parent().attr('id');
            $.ajax({
                url: "../../modules/warehousing/warehousing_action.php",
                type: "POST",
                dataType: "json",
                data: {
                    action: "get-warehouse",
                    id: editId

                },
                success: function(data) {
                    $('#editModal').modal('show');
                    $("#id").val(data.id);
                    $("#code").val(data.code);
                    $("#name").val(data.name);
                    $("#location").val(data.location);
                    $("#details").val(data.details);

                }
            });
        });

        $("body").on("click", ".deleteBtn", function(e) {
            var editId = $(this).parent().parent().attr('id');
            $.ajax({
                url: "../../modules/warehousing/warehousing_action.php",
                type: "POST",
                dataType: "json",
                data: {
                    action: "delete-warehouse",
                    id: editId

                },
                success: function(data) {
                    loadWarehouses("../../modules/warehousing/warehousing_action.php");
                    Swal.fire({
                            icon: 'success',
                            title: 'Record Delete successfully',
                        });

                }
            });
        });

        
        //insert ajax request data
        $("#save").click(function(e) {
            if ($("#formData")[0].checkValidity()) {
                e.preventDefault();
                $.ajax({
                    url: "../../modules/warehousing/warehousing_action.php",
                    type: "POST",
                    data: $("#formData").serialize() + "&action=add-warehouse",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Record added successfully',
                        });
                        $("#addModal").modal('hide');
                        $("#formData")[0].reset();
                        loadWarehouses("../../modules/warehousing/warehousing_action.php");

                    }
                });
            }
        });
        //Edit Record
        $("#edit").click(function(e) {
            if ($("#EditformData")[0].checkValidity()) {
                e.preventDefault();
                $.ajax({
                    url: "../../modules/warehousing/warehousing_action.php",
                    type: "POST",
                    data: $("#EditformData").serialize() + "&action=add-warehouse",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Record added successfully',
                        });
                        $("#addModal").modal('hide');
                        $("#EditformData")[0].reset();
                        loadWarehouses("../../modules/warehousing/warehousing_action.php");

                    }
                });
            }
        });
  

    });
    $('#helpBlend').click(function(e){
        $("#help").toggle();
    });
    $('#create').click(function(e){
        gradeCodes("gradeCode");
    });

    $("#refresh").click(function(e){
        location.reload();
    });

    
</script>
