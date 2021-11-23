<div class="card table-responsive p-2">
    <div class="card-header bg-teal">
        <h3 class="card-title">Materials Types</h3>
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
    <div class="modal-dialog">
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
                        <select name="category" id="category">
                            <option value="Gunny Bags">Gunny Bags(New)</option>
                            <option value="Gunny Bags">Gunny Bags (Used)</option>
                            <option value="poly Bags">Poly Bags</option>
                            <option value="Paper Sacks 3ply small size">Paper Sacks 3ply</option>
                            <option value="Paper Sacks 4ply big size">Paper Sacks 4ply</option>
                            <option value="Paper Sacks small size (25 Kgs)">Paper Sacks small size (25 Kgs)</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="location">Total:</label>
                        <input type="text" class="form-control" name="in_stock" placeholder="Total" required="">
                    </div>
                    <div class="form-group">
                        <label for="details">Details:</label>
                        <textarea type="text" class="form-control" name="description" placeholder="Enter details"
                            required="">
                        </textarea>
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
                <h4 class="modal-title">Adjust Stock Levels</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- $('input[name=radioName]:checked', '#myForm').val() -->
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group ">
                    <div class="form-check-inline">
                        <label class="custom-control custom-radio">
                            <button id="addstock" class="btn btn-sm btn-success">Add to Stock</button>
                        </label>
                        <label class="custom-control custom-radio">
                            <button id="lessstock" class="btn btn-sm btn-danger">Deduct from Stock</button>
                        </label>

                    </div>
                </div>
                <form style="display:none" id="EditformData">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="value">Type</label>
                                <input disabled="false" type="text" class="form-control" name="type" value="" id="mtype"
                                    placeholder="type" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="value">Number</label>
                                <input type="text" class="form-control" name="value" id="total" placeholder="Value"
                                    required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="source">Source:</label>
                                <select name="source" id="source">

                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-primary btn-sm" id="adjust">Adjust</button>
                        <button type="submit" class="btn btn-danger btn-sm" id="close">Close</button>
                    </div>
                    <input type="hidden" name="symbol" id="symbol" value=''>
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
<script src="../../assets/js/sweet-alert.js"></script>


<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->


</body>
<script type="text/javascript">
$(document).ready(function() {
    loadPackingMaterials();
    // loadPackingMaterialsTypes();
    // loadWarehouses();
    $("body").on("click", ".adjust", function(e) {
        e.preventDefault();
        $("#editModal").modal('show');
        var id = $(this).attr("id");
        localStorage.setItem("category", $(this).parent().attr("class"));
        localStorage.setItem("form_id", id);

        var category = $(this).parent().attr("class");

        $("#mtype").val(category);
    });

    $("#addstock").click(function(e) {
        $("#EditformData").show();
        $("#lessstock").hide();
        $("#symbol").val("-");

        $("#source").html(
            '<option value="">Select</option><option value="Material Bought">Material Bought</option><option value="Material Borrowed">Material Borrowed</option>'
        );

    });
    $("#lessstock").click(function(e) {
        $("#EditformData").show();
        $("#addstock").hide();
        $("#source").html(
            '<option value="">Select</option><option value="Material Loaned">Material Loaned</option><option value="Material Sold">Material Sold</option>'
        );
        $("#symbol").val("");

    });

    $("#close").click(function(e) {
        e.preventDefault();
        location.reload();


    })

    $("#adjust").click(function(e) {
        e.preventDefault();

        var total = $('#symbol').val() + $("#total").val();
        var details = $("#source").val();

        $.ajax({
            url: "warehousing_action.php",
            type: "POST",
            data: {
                material: localStorage.getItem("form_id"),
                action: "adjust_level",
                total: total,
                details: details
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Stock Updated successfully',
                });
                loadPackingMaterials();
                $("#EditformData")[0].reset();
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