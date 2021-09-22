<style>
    .select2-container {
        width: 100% !important;
    }

    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
        background-color: white !important;

    }

    #compositionTable tbody tr td {
        padding-bottom: 0px !important;
    }

    .allocate {
        background: green;
        width: 50px;
        color: white;
    }

    .pdfViewer {
    padding-bottom: var(--pdfViewer-padding-bottom);
    background-color: white !important;
    }

    .deallocate {
        background: red;
        width: 50px;
        color: white;
    }

    .frame {
        background-color: white;
    }

    .my-custom-scrollbar {
        position: relative;
        height: 60vH;
        overflow: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
    }

    .horizontal-scrollable>.row {
        overflow-x: auto;
        white-space: nowrap;
    }

    .horizontal-scrollable>.row>.col-xs-4 {
        display: inline-block;
        float: none;
    }

    .clickable:hover {
        background-color: green;
        opacity: 0.3;
        color: white;
    }

    @media screen and (max-width:450) {
        .counter {
            margin-bottom: 10px;
        }
    }
</style>

<div class="col-md-12 col-lg-12">
    <div class="row">
        <div class="col-md-1 card p-2">
            <div class="table-responsive">
                <div class="card ">
                    <span id="addNewBtn"><i class="fa fa-plus card-header">ADD NEW</i></span>
                </div>
                <div id="menuTable" style="height:85vH;" class="p-3">

                </div>
            </div>
        </div>
        <div id="formContainer" class="col-md-6">
            <div id="createForm" class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <form id="formData">
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label class="control-label">Contract No:</label>
                                <input type="text" class="form-control" id="contractno" name="contractno" placeholder="Contract No" required="">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="control-label">Client Name:</label>
                                <select id="buyer" name="buyer" class="buyer form-control form-control-cstm select2-show-search well"><small>(required)</small>
                                </select>
                            </div>
                            <div class="col-md-5 form-group">
                                <label class="control-label">Details:</label>
                                <textarea col="10" class="form-control" id="details" name="details" placeholder="Details" required=""></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 form-group float-right">
                                <button type="submit" class="btn btn-success" id="submit">Save</button>
                            </div>
                            <div class="col-md-3 form-group float-right">
                                <button type="button" class="btn btn-danger" id="close">Close</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div id="allocationContainer" class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <span class="label" id="allocationLabel"></span>
                </div>
                <div class="card-body">
                    <div class="col-md-12 col-lg-12">
                        <div id="contentwrapper">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="card widgets-cards">
                                                <div class="card-body d-flex justify-content-center align-items-center">
                                                    <div class="col-6 p-0">
                                                        <div class="wrp icon-circle bg-success">
                                                            <i class="si si-basket-loaded icons"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 p-0">
                                                        <div class="wrp text-wrapper">
                                                            <p id="totalPkgs"></p>
                                                            <p class="text-dark mt-1 mb-0">Pkgs Added</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="card widgets-cards">
                                                <div class="card-body d-flex justify-content-center align-items-center">
                                                    <div class="col-6 p-0">
                                                        <div class="wrp icon-circle bg-success">
                                                            <i class="si si-basket-loaded icons"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 p-0">
                                                        <div class="wrp text-wrapper">
                                                            <p id="totalkgs"></p>
                                                            <p class="text-dark mt-1 mb-0">kgs Added</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="card widgets-cards">
                                                <div class="card-body d-flex justify-content-center align-items-center">
                                                    <div class="col-6 p-0">
                                                        <div class="wrp icon-circle bg-success">
                                                            <i class="si si-basket-loaded icons"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 p-0">
                                                        <div class="wrp text-wrapper">
                                                            <p id="price"></p>
                                                            <p class="text-dark mt-1 mb-0">Avg Sale Price</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="printLotDetail" class="card widgets-cards clickable">
                                                <div class="card-body d-flex justify-content-center align-items-center">
                                                    <div class="col-6 p-0">
                                                        <div class="wrp icon-circle bg-secondary">
                                                            <i class="si si-bag icons"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 p-0">
                                                        <div class="wrp text-wrapper">
                                                            <p id="price"></p>
                                                            <p class="text-dark mt-1 mb-0">Print Lot Details</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="approveShippment" class="card widgets-cards clickable">
                                                <div class="card-body d-flex justify-content-center align-items-center">
                                                    <div class="col-6 p-0">
                                                        <div class="wrp icon-circle bg-secondary">
                                                            <i class="si si-check icons"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 p-0">
                                                        <div class="wrp text-wrapper">
                                                            <p id="price"></p>
                                                            <p class="text-dark mt-1 mb-0">Approve For Shippment</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="approveEdit" class="card widgets-cards clickable">
                                                <div class="card-body d-flex justify-content-center align-items-center">
                                                    <div class="col-6 p-0">
                                                        <div class="wrp icon-circle bg-danger">
                                                            <i class="si si-pencil icons"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 p-0">
                                                        <div class="wrp text-wrapper">
                                                            <p id="price"></p>
                                                            <p class="text-dark mt-1 mb-0">Edit</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                  <div class="card">
                                  <div class="card-status card-status-left bg-red br-bl-7 br-tl-7"></div>

                                    <div class="card-header">
                                        <span>Lot Details</span>
                                    </div>
                                    <div class="card-body table-wrapper-scroll-y my-custom-scrollbar">
                                        <div id="blendSheetWrapper"></div>
                                    </div>
                                    </div>

                                </div>

                            </div>
                            <div id="blendEditForm" class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-status card-status-left bg-red br-bl-7 br-tl-7"></div>

                                        <div style="width:100% !important;">
                                            <div style="width:100% !important;  padding:1.6rem !important;" class="card-header">
                                                <span>Lot's In stock</span>
                                                <div class="card-options">
                                                    <a href="#" class="card-options-remove refresh" data-toggle="card-remove">Refresh <i class="fe fe-refresh-cw"></i></a>
                                                </div>
                                            </div>
                                            <div class="card-body table-wrapper-scroll-y my-custom-scrollbar">
                                                <div style="width:100%; height:50vH" id="blendTable">
                                                    <div class="dimmer active text-center">
                                                        <div class="spinner2">
                                                            <div class="cube1"></div>
                                                            <div class="cube2"></div>
                                                        </div>
                                                        <span>Loading....</span>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<!-- split Record  Modal -->
<div class="modal" id="splitModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Split Lot</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="splitLot">
                    <div class="row">
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Lot</label>
                                <input disabled id="elot"></input>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Mark</label>
                                <input disabled id="emark"></input>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Invoice</label>
                                <input disabled id="invoice"></input>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Current Allocation==></label>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Pkgs</label>
                                <input id="pkgs"></input>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Net</label>
                                <input id="net" disabled></input>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Kgs</label>
                                <input id="kgs"></input>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Enter Packages to split==></label>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Pkgs</label>
                                <input type="number" step="5" min="5" id="newpkgs"></input>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Net</label>
                                <input id="newnet" disabled></input>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Kgs</label>
                                <input type="number" min="5" id="newkgs"></input>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-3 form-group float-right">
                    <button type="submit" class="btn btn-success btn-sm" id="saveSplit">Save</button>
                </div>
                <div class="col-md-3 form-group float-right">
                    <button type="button" class="btn btn-danger btn-sm" id="closeModal">Close</button>
                </div>
                <input hidden id="stock_id"></input>

            </div>
            </form>
        </div>

    </div>
</div>



<script src="../../assets/js/blending.js"></script>
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../../assets/js/vendors/selectize.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>
<script src="../../assets/plugins/select2/select2.full.min.js"></script>
<script id="url" data-name="../../ajax/common.php" src="../../assets/js/common.js"></script>
<!-- counter  -->
<script src="../../assets/plugins/counters/counterup.min.js"></script>
<script src="../../assets/plugins/counters/waypoints.min.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<script>
    $("#issueTeaMenu").hide();
    $("#allocationContainer").hide();


    $(document).ready(function() {
        menu();
        print_lotdetails();
        summaries();
        $("#addNewBtn").click(function(e) {
            e.preventDefault();
            $("#createForm").toggle();
        });

        $("#submit").click(function(e) {
            e.preventDefault();
            var contractno = $("#contractno").val();
            var buyer = $("#buyer").val();
            var detail = $("#details").val();

            $.ajax({
                url: "straightline_action.php",
                type: "POST",
                dataType: "html",
                data: {
                    action: "create-contract",
                    contract_no: contractno,
                    client_id: buyer,
                    details: detail

                },
                success: function(response) {
                    menu();
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved Successfully',
                    });

                }

            });
        });

        $("#close").click(function(e) {
            $("#createForm").toggle();
        });

        $("body").on("click", ".contractBtn", function(e) {
            e.preventDefault();
            var id = $(this).attr("id");
            localStorage.setItem("contractno", id);
            $("#formContainer").hide();
            $("#allocationContainer").show();
            $("#allocationLabel").text("Allocations for Contract :- " + id);
            loadUnallocatedStraightLine("", "", "", "");
            summaries();


        });
        $("body").on("click", ".addTea", function(e) {
            e.preventDefault();
            $this = $(this);
            var id = $(this).attr('id');
            $.ajax({
                url: "straightline_action.php",
                type: "POST",
                dataType: "html",
                data: {
                    action: "add-tea",
                    id: id,
                    contract_no: localStorage.getItem("contractno")
                },
                success: function(response) {
                    var removeBtn = '<a class="removeAlloc" id="'+id+'" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Remove" ><i class="fa fa-close" ></i></a>';
                    $this.parent().html(localStorage.getItem("contractno")+removeBtn);
                    print_lotdetails();
                    summaries();

                }

            });


        });
        $("body").on("click", ".removeAlloc", function(e) {
            e.preventDefault();
            $this = $(this);
            var id = $(this).attr('id');
            var element = document.getElementById(id);

            $.ajax({
                url: "straightline_action.php",
                type: "POST",
                dataType: "html",
                data: {
                    action: "remove-tea",
                    id: id,
                    contract_no: localStorage.getItem("contractno")
                },
                success: function(response) {
                    summaries();
                    var addBtn = '<a class="addTea" id="'+id+'" style="color:green" data-toggle="tooltip" data-placement="bottom" title="Use Tea" >';
                    addBtn += '<i class="fa fa-arrow-right" ></i></a>&nbsp&nbsp&nbsp';
                    addBtn += '<a class="splitLot" id="'+id+'" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Split Lot">';
                    addBtn +=  '<i class="fa fa-scissors"></i></a>&nbsp&nbsp&nbsp';
                    $this.parent().html(addBtn);
                    print_lotdetails();
                }

            });



        });
        $(".refresh").click(function(e) {
            loadUnallocated("", "", "", "");
        });
     
        $("#approveShippment").click(function(e) {
            Swal.fire({
                icon: 'warning',
                title: 'Are You Sure You Want to confirm',
            });
            $(".swal2-confirm").click(function(e) {
                confirmLots();
            });
        })
    });

    function menu() {
        $.ajax({
            url: "straightline_action.php",
            type: "POST",
            dataType: "html",
            data: {
                action: "show-all",
            },
            success: function(response) {
                $("#menuTable").html(response);
                $("#menuStraight").DataTable({
                    "paging": false,
                    "bInfo": false,
                    "oLanguage": {
                        "sSearch": ""
                    }
                });
            }

        });

    }
    function print_lotdetails(){
            var siNo = localStorage.getItem("contractno");
            $('#blendSheetWrapper').html('<iframe class="frame" frameBorder="0" src="../../reports/straightline_lots.php?sino=' + siNo + '" width="100%" height="500px"></iframe>');
    }
    function viewAllocations() {
        $.ajax({
            url: "straightline_action.php",
            type: "POST",
            dataType: "html",
            data: {
                action: "allocated",
                contract_no: localStorage.getItem("contractno")

            },
            success: function(response) {
                $("#selected").html(response);
                $("#alloc").DataTable({

                })
            }

        });
    }

    function confirmLots() {
        $.ajax({
            url: "straightline_action.php",
            type: "POST",
            dataType: "html",
            data: {
                action: "approve",
                contract_no: localStorage.getItem("contractno")

            },
            success: function(response) {
                loadUnallocated("", "", "", "");

            }

        });
    }
    function summaries(){
        $.ajax({
            url: "straightline_action.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "summaries",
                contract_no: localStorage.getItem("contractno")

            },
            success: function(response) {
                $("#totalPkgs").html(response.pkgs);
                $("#totalkgs").html(response.kgs);
                $("#price").html(response.avg_price);
            }

        });
    }
	function update_mrp(element){
		var id = $(element).attr("id");
		var mrpvalue =  $(element).text();
		$.ajax({
            url: "straightline_action.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "post-mrp",
				stock_id: id,
				value: mrpvalue

            },
            success: function(response) {
            }

        });
		
	}
</script>