<style>
   .table {
        background-color: white !important;
    }
    .toolbar-button{
        padding: 0.5px !important;
    }
 
</style>
<div class="col-md-8 col-lg-10">

    <div class="row">
        <button type="button" class="btn btn-success m-1 float-right toolbar-button" data-toggle="modal" data-target="#addModal">
            <i class="fa fa-plus"></i> Create Blend</button>
    </div>
    <br>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="table-responsive" id="tableData">
                    <h3 class="text-center text-success" style="margin-top: 150px;">Loading...</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="straightTable"></div>
            </div>
        </div>
    </div>
</div>

<!-- Add Record  Modal -->
<div class="modal" id="addModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create Blend</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="formData">
                    <div class="row">
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Standard</label>
                                </input>
                                <select id="standard" name="standard" class="standard form-control form-control-cstm select2-show-search well"><small>(required)</small>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="control-label">Blend No:</label>
                            <input type="text" class="form-control" name="blendid" placeholder="Blend No" required="">
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="control-label">Contract No:</label>
                            <input type="text" class="form-control" name="contractno" placeholder="Contract No" required="">
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="control-label">Client Name:</label>
                                <select id="clientwithcode" name="clientid" class="form-control form-control-cstm select2-show-search well"><small>(required)</small>
                              </select>
                        </div>   
                    </div>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label class="control-label" for="blendno">Grade:</label>
                            <select id="grade" name="grade" class="form-control form-control-cstm select2-show-search well"><small>(required)</small>
                              </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="control-label" for="name">Output Pkgs:</label>
                            <input type="text" class="form-control" name="pkgs" placeholder="pkgs" required="">
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="control-label" for="name">Net:</label>
                            <input type="text" class="form-control" name="nw" placeholder="Client" required="">
                        </div>   
                    </div>
         
                    <div class="row">
                        <div class="col-md-3 form-group float-right">
                            <button type="submit" class="btn btn-success" id="submit">Save</button>
                        </div>
                        <div class="col-md-3 form-group float-right">
                             <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </form>
            </div>

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
                <h4 class="modal-title">Edit Blend</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="EditformData">
                    <input type="hidden" name="id" id="edit-form-id">
                    <div class="form-group">
                        <label for="code">Code:</label>
                        <input type="text" class="form-control" name="code" id="code" placeholder="Enter code" required="">
                    </div>
                    <div class="form-group">
                        <label for="name">Blend Name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Blend Name" required="">
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

<script src="../../assets/js/blending.js"></script>
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
        standardList();
        showAllBlends();
        gradeList();
        clientWithcodeList();
        //View Record
        function showAllBlends() {
            $.ajax({
                url: "blend_action.php",
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
                    url: "blend_action.php",
                    type: "POST",
                    data: $("#EditformData").serialize() + "&action=update",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Customer Updated successfully',
                        });
                        $("#addModal").modal('hide');
                        $("#EditformData")[0].reset();
                        showAllBlends();
                    }
                });
            }
        });


        //insert ajax request data
        $("#submit").click(function(e) {
            if ($("#formData")[0].checkValidity()) {
                e.preventDefault();
                $.ajax({
                    url: "blend_action.php",
                    type: "POST",
                    data: $("#formData").serialize() + "&action=insert",
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        if(response.code ==201){
                                Swal.fire({
                                icon: 'error',
                                title: response.error,
                            });
                            $("#addModal").modal('hide');
                            $("#formData")[0].reset();
                            showAllBlends();
                        }
                        if(response.code ==200){
                                Swal.fire({
                                icon: 'success',
                                title: response.success,
                            });
                            $("#addModal").modal('hide');
                            $("#formData")[0].reset();
                            showAllBlends();
                        }if(response.code == 500){
                            Swal.fire({
                                icon: 'error',
                                title: response.error,
                            }); 
                        }
                   
                      
                    }
                });
            }
        });

        //Edit Record
        $("body").on("click", ".editBtn", function(e) {
            e.preventDefault();
            var editId = $(this).attr('id');
            $.ajax({
                url: "blend_action.php",
                type: "POST",
                data: {
                    editId: editId
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $("#edit-form-id").val(data.id);
                    $("#name").val(data.mark);
                    $("#code").val(data.code);
                }
            });
        });

        //Delete Record
        $("body").on("click", ".deleteBtn", function(e) {
            e.preventDefault();
            var deleteId = $(this).attr('id');
            $.ajax({
                url: "blend_action.php",
                type: "POST",
                data: {
                    deleteId: deleteId
                },
                success: function(response) {
                    showAllBlends();
                    Swal.fire({
                        icon: 'success',
                        title: 'Record deleted successfully',
                    });
                }
            });
        });

    });
 
    // $('#lotEdit').click(function(e){
    // e.preventDefault();
    // alert('clicked');
    // var clientid = localStorage.getItem("clientId");
    // showClientAllocation(clientid);
    // });
    function loadAllocationSummaryForBlends(){
        loadUnallocated();
    }
    
</script>