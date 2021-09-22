<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addModal">
                <i class="fa fa-plus"></i> Add Packing Materials</button>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="packingMaterial">
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
                        <textarea type="text" class="form-control" name="description" placeholder="Enter details" required="">
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
                    </div>custom
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
<script src="../../assets/js/warehousing.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</body>
<script type="text/javascript">
    $(document).ready(function() {
        loadPackingMaterials();
        $("body").on("click", ".adjust", function(e) {
            e.preventDefault();
            $("#addModal").modal('show');

            var id = $(this).attr("id");
                    $.ajax({
                    url: "action.php",
                    type: "POST",
                    data: $("#EditformData").serialize() + "&action=update",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Customer Updated successfully',
                        });
                        $("#addModal").modal('show');
                        $("#EditformData")[0].reset();
                    }
                });
        });

        // $("#adjust").click(function(e) {
        //     if ($("#EditformData")[0].checkValidity()) {
        //         e.preventDefault();
        //         $.ajax({
        //             url: "action.php",
        //             type: "POST",
        //             data: $("#EditformData").serialize() + "&action=update",
        //             success: function(response) {
        //                 Swal.fire({
        //                     icon: 'success',
        //                     title: 'Customer Updated successfully',
        //                 });
        //                 $("#addModal").modal('hide');
        //                 $("#EditformData")[0].reset();
        //             }
        //         });
        //     }
        // });


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