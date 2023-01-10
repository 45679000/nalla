<div class="row">
       
</div>
<style>
    body {
        position: relative;
        /* background-color: black; */
    }
    .lds-roller {
        position: absolute;
        left: 45%;
        top: 100px;
        z-index: 1;
    }
</style>

<div class="container-fluid">
    <div class="lds-roller" id="loader">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                    <div class="card-header bg-primary">
                    <i id="helpBlend" style="float:left; font-size:large" class="fa fa-question-circle">help</i>
                        <div id="help" style="display:none; margin-left:30px; text-align:center">
                        <span class="label label-info">Click Add Broker Button to add new Broker,  
                            <i class="fa fa-pencil btn-success"></i> 
                            to edit a Broker and <i class="fa fa-trash btn-danger"></i>  to delete a Broker</span>
                        </div>
                        <div class="card-options">
                        <button style="display: none;" id="refresh" type="button" class="btn btn-success m-1 float-right btn-sm">
                         <i class="fa fa-reply"></i>
                        </button>

                        <button id="create" type="button" class="btn btn-success m-1 float-right btn-sm" data-toggle="modal" data-target="#addModal">
                        <i class="fa fa-plus"></i>Generate Auction List</button>
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
                <h4 class="modal-title">Generate an auction list</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="formData">
                    <div class="form-control">
                        <label for="year">Enter the year</label>
                        <input class="form-control" type="text" placeholder="Example - 2000" name="year" id="year" required>
                    </div>
                    <!-- <p class="danger">Note that when you can generate one auction list for othis list you will not be able to generate it until next year</p> -->
       
                    <!-- <hr> -->
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
                <h4 class="modal-title">Edit Broker</h4>
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
                        <label for="name">Broker Name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Broker Name" required="">
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
        $('#loader').hide()
        showAllBrokers();
        // generateOrNot();
        //View Record
        function showAllBrokers() {
            $.ajax({
                url: "auction_action.php",
                type: "POST",
                data: {
                    action: "view"
                },
                success: function(response) {
                    // console.log(response);
                    $("#tableData").html(response);
                    $("table").DataTable({});
                }

            });
        }
        function generateOrNot() {
            $.ajax({
                url: "auction_action.php",
                type: "POST",
                data: {
                    action: "gOrNot"
                },
                success: function(response) {
                    if(response>0){
                        $("#create").prop('disabled', true);
                        console.log(response);
                    }
                }

            });
        }
        $("#update").click(function(e) {
            if ($("#EditformData")[0].checkValidity()) {
                e.preventDefault();
                $.ajax({
                    url: "auction_action.php",
                    type: "POST",
                    data: $("#EditformData").serialize() + "&action=update",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Customer Updated successfully',
                        });
                        $("#addModal").modal('hide');
                        $("#EditformData")[0].reset();
                        showAllBrokers();
                    }
                });
            }
        });


        //insert ajax request data
        $("#submit").click(function(e) {
            e.preventDefault();
            let year_field = $("#year").val().length
            if (year_field == 4) {
                $('#loader').show()
                $("#addModal").modal('hide');
                $.ajax({
                    url: "auction_action.php",
                    type: "POST",
                    data: $("#formData").serialize() + "&action=insert",
                    success: function(response) {
                        $('#loader').hide()
                        console.log(response)
                        if(response == 0){
                            Swal.fire({
                                icon: 'error',
                                title: 'Auction list of the inputed year already exist',
                            });
                        }else if(response == 1){
                            Swal.fire({
                                icon: 'success',
                                title: 'List generated successfully',
                            });
                            
                            $("#formData")[0].reset();
                            showAllBrokers();
                        }else {
                            Swal.fire({
                                icon: 'error',
                                title: 'There was a problem. Try again',
                                footer: 'If problems persist contact the admin'
                            })
                        }
                        
                    }
                });
            }else if(year_field == 0) {
                alert("Make sure to indicate the year")
            }else {
                alert("Make sure to enter the correct length of a year eg 2023")
            }
        });

        //Edit Record
        $("body").on("click", ".editBtn", function(e) {
            e.preventDefault();
            var editId = $(this).attr('id');
            $.ajax({
                url: "auction_action.php",
                type: "POST",
                data: {
                    editId: editId
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $("#edit-form-id").val(data.id);
                    $("#name").val(data.name);
                    $("#code").val(data.code);
                }
            });
        });

        //Delete Record
        $("body").on("click", ".deleteBtn", function(e) {
            e.preventDefault();
            var deleteId = $(this).attr('id');
            $.ajax({
                url: "auction_action.php",
                type: "POST",
                data: {
                    deleteId: deleteId
                },
                success: function(response) {
                    showAllBrokers();
                    Swal.fire({
                        icon: 'success',
                        title: 'Record deleted successfully',
                    });
                }
            });
        });



    });
</script>