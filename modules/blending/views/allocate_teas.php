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

@media screen and (max-width:450) {
    .counter {
        margin-bottom: 10px;
    }
}
</style>
<?php
$blendno = isset($_GET['blendno']) ? $_GET['blendno'] : '';

?>
<div class="col-md-12 col-lg-12">
    <div id="contentwrapper">
        <div class="row">
            <div class="card col-md-9 p-2">
                <div id="tableData">
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-6">
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
                    <div class="col-md-6">
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
                </div>
            </div>
        </div>
        <div id="blendEditForm" class="row">
            <div class="col-md-7">
                <div class="card">
                    <div style="width:100% !important;">
                        <div style="width:100% !important;  padding:2.6rem !important;" class="card-header">
                            <div  class="row">
                                <div class="col-md-4 input-group">
                                    <label for="saleno">Sale No</label>
                                    <select class="select2" data-placeholder="Select" name="saleno"
                                        id="saleno"></select>
                                </div>
                                <div class="col-md-4 input-group">
                                    <label for="mark">Mark</label>
                                    <select class="select2" data-placeholder="Select" name="mark" id="mark"></select>
                                </div>
                                <div class="col-md-4 input-group">
                                    <label for="grade">Grade</label>
                                    <select class="select2" data-placeholder="Select" name="grade" id="grade"></select>
                                </div>
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
            <div class="col-md-5">
                <div class="card  horizontal-scrollable">
                    <div style="width:100% !important; height:150px;padding-bottom:0px;margin-bottom:0px;"
                        class="card-header">
                        <div class="row" style="padding-top:30px;">
                            <div>
                                <label>Grade code composition</label>
                            </div>
                            <div style="width:75vH; height:150px !important;padding-bottom:0px;" id="composition"
                                class="col-md-12">
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-wrapper-scroll-y my-custom-scrollbar">
                        <div id="selected"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="blendSheetWrapper">

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
$(document).ready(function() {
    var blendno = '<?php echo $blendno ?>'

    $('.select2').select2();
    $('#saleno').change(function(e) {
        var mark = $('#mark').val();
        var grade = $('#grade').val();
        var lot = $('#lot').val();
        var saleno = $('#saleno').val();
        loadUnallocated(mark, lot, grade, saleno);
    });
    $('#mark').change(function(e) {
        var mark = $('#mark').val();
        var grade = $('#grade').val();
        var lot = $('#lot').val();
        var saleno = $('#saleno').val();
        loadUnallocated(mark, lot, grade, saleno);
    });
    $('#grade').change(function(e) {
        var mark = $('#mark').val();
        var grade = $('#grade').val();
        var lot = $('#lot').val();
        var saleno = $('#saleno').val();
        loadUnallocated(mark, lot, grade, saleno);
    });
    $('#lot').focusout(function(e) {
        var mark = $('#mark').val();
        var grade = $('#grade').val();
        var lot = $('#lot').val();
        var saleno = $('#saleno').val();
        loadUnallocated(mark, lot, grade, saleno);
    });
    $('#closeModal').click(function(e) {
        $('#splitModal').hide();
    });
        
    $('#newpkgs').change(function(e) {
        var lotPkgs = localStorage.getItem("lotPkgs");
        var newPkgs = $('#newpkgs').val();
        var previousPkgs = lotPkgs;
        var previousKgs = $('#kgs').val();
        var net = $('#net').val();
        if(previousPkgs>=0){
            $('#pkgs').val(previousPkgs - newPkgs);
            $('#kgs').val((previousPkgs - newPkgs) * net);
            $('#newkgs').val(previousKgs - ((previousPkgs - newPkgs) * net));
        }else{
            alert("Lot cannot be splitted to zero");
        }     
    })
    $('#saveSplit').click(function(e) {
        e.preventDefault();
        var stockId = $('#stock_id').val();
        var Pkgs = $('#pkgs').val();
        var Kgs = $('#kgs').val();
        var NewKgs = $('#newkgs').val();
        var NewPkgs = $('#newpkgs').val();
        if ((stockId != null) && (Pkgs != null) && (Kgs != null) && (NewKgs != null) && (NewPkgs !=
                null)) {
            insertSplit(stockId, Pkgs, Kgs, NewKgs, NewPkgs);
        } else {
            alert("You Must Enter packages to split");
        }
    });
    loadUnallocated("", "", "", "");
    viewAllocations();
    loadComposition(blendno)
    showBlend(blendno);
    BlendAllocationSummary(blendno);


});
$("body").on("click", ".splitLot", function(e) {
    e.preventDefault();
    var id = $(this).attr('id');
    splitLot(id);
});
$("body").on("click", ".addTea", function(e) {
    e.preventDefault();
    var blendno = '<?php echo $blendno ?>'

    var id = $(this).attr('id');
    addLotToBlend(id, "add-blend-teas", blendno);
    BlendAllocationSummary(blendno);
    viewAllocations();
    loadUnallocated("", "", "", "");
    loadComposition(blendno)
});
$("body").on("click", ".removeAlloc", function(e) {
    e.preventDefault();
    var blendno = '<?php echo $blendno ?>'

    var id = $(this).attr('id');
    removeLotFromBlend(id, blendno, "remove-blend-teas");
    BlendAllocationSummary(blendno);
    viewAllocations();
    loadUnallocated("", "", "", "");
    loadComposition(blendno)


});
$("body").on("click", ".editWindow", function(e) {
    e.preventDefault();
    $('#blendEditForm').show();
    $('#blendSheetWrapper').hide();
});
$("body").on("click", ".blendSheet", function(e) {
    e.preventDefault();
    var blendno = '<?php echo $blendno ?>'
    $('#blendEditForm').hide();
    $('#blendSheetWrapper').show();
    $('#blendSheetWrapper').html(
        '<iframe class="frame" frameBorder="0" src="../../reports/blend_sheet.php?blendno=' + blendno +
        '" width="100%" height="800px"></iframe>');

});
$("body").on("click", ".confirm", function(e) {
    e.preventDefault();
    approveBlend();
});
$("#issueTeaMenu").hide();

function viewAllocations() {
    var blendno = '<?php echo $blendno ?>'
    currentAllocation(blendno);
}

function approveBlend() {
    var blendno = '<?php echo $blendno ?>'
    $.ajax({
        url: "blend_action.php",
        type: "POST",
        dataType: "html",
        data: {
            action: "approve-blend",
            blendno: blendno
        },
        success: function(response) {
            showBlend(blendno);
            viewAllocations();
            Swal.fire({
                icon: 'success',
                title: 'Blend Confirmed Successfully',
            });
        }

    });

}

function editBlend() {
    var blendno = '<?php echo $blendno ?>'
    $.ajax({
        url: "blend_action.php",
        type: "POST",
        dataType: "html",
        data: {
            action: "edit-blend",
            blendno: blendno
        },
        success: function(response) {
            showBlend(blendno);
            location.reload()
        }

    });

}

function splitLot(id) {
    $('#splitModal').show();
    $('#newpkgs').val(0);
    $('#newkgs').val(0);

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "../stock/stock-action.php",
        data: {
            action: "getlot",
            id: id
        },
        success: function(data) {
            var lots = data[0];
            $('#pkgs').val(lots.pkgs);
            $('#kgs').val(lots.kgs);
            $('#elot').val(lots.lot);
            $('#net').val(lots.net);
            $('#emark').val(lots.mark);
            $('#invoice').val(lots.invoice);
            $('#newnet').val(lots.net);
            $('#stock_id').val(lots.stock_id);
            $("#newpkgs").attr({"max" : lots.pkgs});
            localStorage.setItem("lotPkgs", lots.pkgs);

        },
        error: function(data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}

function insertSplit(stockId, Pkgs, Kgs, NewKgs, NewPkgs) {
    $.ajax({
        type: "POST",
        dataType: "html",
        url: '../stock/stock-action.php',
        data: {
            action: 'split',
            stockId: stockId,
            Pkgs: Pkgs,
            Kgs: Kgs,
            NewKgs: NewKgs,
            NewPkgs: NewPkgs
        },
        success: function(data) {
            Swal.fire({
                icon: 'success',
                title: 'Lot Splitted Successfully',
            });
            $('#splitModal').trigger("reset");
            $("#splitModal").hide();
            loadUnallocated("", "", "", "");

        }
    });
}
</script>