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
<!-- Add Record  Modal -->
<div class="modal" id="addComposition">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Set Composition</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="composition">
                    <div class="form-group">
                        <label for="code">Code:</label>
                        <select id="gradeCode" name="code"
                            class="code form-control form-control-cstm select2-show-search well"><small>(required)</small>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="percentage">Percentage:</label>
                        <input type="number" min="0" type="text" class="form-control" name="percentage"
                            placeholder="Percentage" required="">
                    </div>

                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-success" id="SaveComposition">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="editCompositionModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Composition</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="editCompositionForm">
                    <div class="form-group">
                        <label for="code">Code:</label>
                        <select id="code" name="code"
                            class="code form-control form-control-cstm select2-show-search well"><small>(required)</small>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="percentage">Percentage:</label>
                        <input id="percentageUpdate" type="number" min="0" type="text" class="form-control"
                            name="percentage" placeholder="Percentage" required="">
                    </div>
                    <input id="EditId" type="hidden" type="text">
                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-success" id="UpdateComposition">update</button>
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
                $("table").DataTable({});
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

    $("body").on("click", ".editCBtn", function(e) {
        e.preventDefault();
        var editId = $(this).attr('id');
        $.ajax({
            url: "grading_standard_action.php",
            type: "POST",
            dataType: "json",
            data: {
                id: editId,
                action: "update-composition"
            },
            success: function(response) {
                $('#editCompositionModal').modal('show');
                gradeCodes("code");
                var data = response[0];
                $("#EditId").val(data.id);
                $("#percentageUpdate").val(data.percentage);
                $("#code").val(data.grade);
            }
        });
    });

});

$("body").on("click", ".databaseBtn", function(e) {
    e.preventDefault();
    var standardId = $(this).attr('id');
    $('#create').html("Add Composition");
    $('#create').attr('data-target', '#addComposition');
    $('#refresh').css("display", "block")
    localStorage.setItem("standardId", standardId);
    displayCluster(standardId);
});

function displayCluster(id) {
    $.ajax({
        url: "action.php",
        type: "POST",
        data: {
            action: "garden-cluster",
            id: id
        },
        success: function(response) {
            $("#tableData").html(response);
            $("table").DataTable({});
        }
    });
}
</script>


<!-- $('#helpBlend').click(function(e){
        $("#help").toggle();
    });
    $('#create').click(function(e){
        gradeCodes("gradeCode");
    });
    $('#SaveComposition').click(function(e){
            e.preventDefault();
            $.ajax({
                url: "grading_standard_action.php",
                type: "POST",
                data: $("#composition").serialize() + "&action=save-composition&standardId="+localStorage.getItem("standardId"),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Record added successfully',
                    });
                    $("#addComposition").modal('hide');
                    displayComposition(localStorage.getItem("standardId"));
                }
            });
            
    });
    $('#UpdateComposition').click(function(e){
            var id= $("#EditId").val();
            e.preventDefault();
            $.ajax({
                url: "grading_standard_action.php",
                type: "POST",
                data: $("#editCompositionForm").serialize() + "&action=save-composition&type=update&&id="+id,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Record Updated successfully',
                    });
                    $("#editCompositionModal").modal('hide');
                    displayComposition(localStorage.getItem("standardId"));
                }
            });
            
    });
    $("body").on("click", ".deleteCBtn", function(e) {
            e.preventDefault();
            var deleteId = $(this).attr('id');
            $.ajax({
                url: "grading_standard_action.php",
                type: "POST",
                data: {
                    action:"deleteComposition",
                    id: deleteId
                },
                success: function(response) {
                    displayComposition(localStorage.getItem("standardId"));
                    Swal.fire({
                        icon: 'success',
                        title: 'Record deleted successfully',
                    });
                }
            });
    });
    $("#refresh").click(function(e){
        location.reload();
    }) -->