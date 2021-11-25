<div class="card table-responsive p-2">
    <div class="card-header bg-teal">
        <h3 class="card-title">Stock Of Materials</h3>
        <div class="card-options">
        <button  id="add" type="button" class="btn btn-success m-1 float-right btn-sm" data-toggle="modal" data-target="#addModal">
        Add To stock <i class="fa fa-plus"></i>
        </button>
</div>
    </div>
    <div class="card-body p-6">
        <div class="panel panel-primary">
            <div class="card-body">
                <div class="table-responsive" id="packingMaterial">
                    <h3 class="text-center text-success" style="margin-top: 150px;">Loading...</h3>
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
            <div class="modal-header">
                <h4 class="modal-title">Packing Materials</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="formData">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="type_id" class="select2" id="material_type">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="warehouse">warehouse</label>
                        <select name="warehouse" class="select2" id="warehouse">
                        </select>
                    </div>

                    
                    <div class="form-group">
                        <label for="location">Total:</label>
                        <input type="text" class="form-control" name="in_stock" placeholder="Total" required="">
                    </div>
                    <div class="form-group">
                        <label for="details">Details:</label>
                        <textarea type="text" class="form-control" name="description" placeholder="Enter details">
                        </textarea>
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Adjust Stock Levels</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group" id="addorLess">
                    <div class="form-check-inline">
                        <label class="custom-control custom-radio">
                            <button id="addstock" class="btn btn-sm btn-success">Add to Stock</button>
                        </label>
                        <label class="custom-control custom-radio">
                            <button id="lessstock" class="btn btn-sm btn-danger">Deduct from Stock</button>
                        </label>
                        <label class="custom-control custom-radio">
                            <button id="transfer" class="btn btn-sm btn-primary">Transfer From Bonded Warehouse</button>
                        </label>
                    </div>
                </div>
                <form style="display:none" id="EditformData">
                    <div class="row">
                        <input type="hidden" name="id" id="id"></input>
                        <input type="hidden" name="type_id" id="type_id"></input>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="value">Material Type</label>
                                <input disabled="false" type="text" class="form-control" name="type" value="" id="mtype" placeholder="type" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="value">Warehouse</label>
                                <input disabled="false" type="text" class="form-control" name="warehouse" id="ewarehouse" placeholder="" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="value">Current Stock</label>
                                <input disabled="false" type="text" class="form-control" name="in_stock" id="in_stock" placeholder="" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="source">Source:</label>
                                <select class="select2" name="source" id="source">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label id="actionLabel" for="source">How Many Pieces Do you Wish to add?:</label>
                                <input  type="text" class="form-control" name="new_stock" id="new_stock" placeholder="" required="">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="source">Comment:</label>
                                <textarea  type="text" class="form-control" name="comment" id="comment" placeholder="" required=""></textarea>

                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group float-right">
                        <button  class="btn btn-primary btn-sm" id="post">Adjust</button>
                        <button type="submit" class="btn btn-danger btn-sm" id="close">Close</button>
                    </div>
                    <input type="hidden" name="event" id="event" value=''>
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

<script id="url" data-name="../../ajax/common.php" src="../../assets/js/common.js"></script>
<script src="../../assets/plugins/select2/select2.full.min.js"></script>


</body>
<script type="text/javascript">
$(document).ready(function() {
    loadPackingMaterials();
    $("body").on("click", ".adjust", function(e) {
        e.preventDefault();
        $("#editModal").modal('show');
        var id = $(this).attr("id");
        $.ajax({
            url: "warehousing_action.php",
            type: "POST",
            dataType: "json",
            data: {
                id: id,
                action: "get_packing_material_by_id"
            },
            success: function(data) {
                $("#mtype").val(data.name);
                $("#ewarehouse").val(data.warehouse);
                $("#in_stock").val(data.available);
                $("#id").val(data.id);
                $("#type_id").val(data.type_id);
            },
            error: function(data){
        console.log(data);
            }
        });
       

    });

    $("#addstock").click(function(e) {
        $("#EditformData").show();
        $("#lessstock").hide();
        $("#event").val("1");
        $("#addorLess").hide();
        $("#source").html(
            '<option value="">Select</option><option value="Material Bought">Material Bought</option><option value="Material Borrowed">Material Borrowed</option>'
        );

    });
    $("#lessstock").click(function(e) {
        $("#EditformData").show();
        $("#addstock").hide();
        $("#addorLess").hide();
        $("#event").val("0");
        $("#actionLabel").html("How Many Pieces Do you Wish to Deduct?");

        $("#source").html(
            '<option value="">Select</option><option value="Material Loaned">Material Loaned</option><option value="Material Sold">Material Sold</option>'
        );
    });

    $("#transfer").click(function(e) {
        $("#EditformData").show();
        $("#addstock").hide();
        $("#addorLess").hide();
        $("#event").val("2");
        $("#actionLabel").html("How Many Pieces Do you Wish to Transfer?");
        $("#source").html(
            '<option value="">Select</option><option value="Material Loaned">Material Loaned</option><option value="Material Sold">Material Sold</option>'
        );

    });


    $("#close").click(function(e) {
        e.preventDefault();
        location.reload();


    });

    $("#post").click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "warehousing_action.php",
            type: "POST",
            data: {
                action: "adjust_material_stock",
                material_id: $("#id").val(),
                total: $("#new_stock").val(),
                details: $("#comment").val(),
                source: $("#source").val(),
                event: $("#event").val()

            },
            success: function(data) {
                Swal.fire({
                    icon: 'success',
                    title: 'Stock Adjusted successfully',
                });
                loadPackingMaterials();
                $("#EditformData")[0].reset();
                $("#editModal").hide();

            }
        });
    });
    //insert ajax request data
    $("#submit").click(function(e) {
        if ($("#formData")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: "warehousing_action.php",
                type: "POST",
                data: $("#formData").serialize() + "&action=add-packing materials",
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Record added successfully',
                    });
                    // $("#addModal").modal('hide');
                    $("#formData")[0].reset();
                    loadPackingMaterials()
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
            url: "warehousing_action.php",
            type: "POST",
            data: {
                deleteId: deleteId
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Record deleted successfully',
                });
            }
        });
    });



});
</script>