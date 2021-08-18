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
$invoiceno = isset($_GET['invoice_no']) ? $_GET['invoice_no'] : '';
$category = isset($_GET['cat']) ? $_GET['cat'] : '';
$kind = isset($_GET['kind']) ? $_GET['kind'] : '';
?>

<div class="col-md-12 col-lg-12">
    <div id="contentwrapper">
        <div class="card">
            <div class="card-body p-12">
                <div class="col-md-12 text-center">
                    <div class="row mx-auto" id="invoiceTable" style="max-height:20%;">
                    </div>
                </div>
            </div>
        </div>
        <div id="blendEditForm" class="row">
            <div class="col-md-6">
                <div class="card">
                    <div style="width:100% !important;">
                        <div style="width:100% !important;" class="card-header">
                            <div class="row">
                                <div class="col-md-3 input-group">
                                    <label for="saleno">Sale No</label>
                                    <select class="select2" data-placeholder="Select" name="saleno"
                                        id="saleno"></select>
                                </div>
                                <div class="col-md-3 input-group">
                                    <label for="mark">Mark</label>
                                    <select class="select2" data-placeholder="Select" name="mark" id="mark"></select>
                                </div>
                                <div class="col-md-3 input-group">
                                    <label for="grade">Grade</label>
                                    <select class="select2" data-placeholder="Select" name="grade" id="grade"></select>
                                </div>
                                <div class="col-md-3 input-group">
                                    <label for="mark">Lot</label>
                                    <input id="lot" type="text" name="lot" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-wrapper-scroll-y my-custom-scrollbar">
                            <div style="width:100%; height:60vH" id="blendTable"></div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-body table-wrapper-scroll-y my-custom-scrollbar">
                    <div style="width:100% !important;" class="card-header">
                        <div class="row">
                            Teas selected for this Invoice
                        </div>
                    </div>
                    <div style="width:100%; height:60vH" id="selected"></div>

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
                                <input id="newpkgs"></input>
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
                                <input id="newkgs"></input>
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
    var invoiceno = '<?php echo $invoiceno ?>'
    showInvoice(invoiceno);

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
        var newPkgs = $('#newpkgs').val();
        var previousPkgs = $('#pkgs').val();
        var previousKgs = $('#kgs').val();
        var net = $('#net').val();
        $('#pkgs').val(previousPkgs - newPkgs);
        $('#kgs').val((previousPkgs - newPkgs) * net);
        $('#newkgs').val(previousKgs - ((previousPkgs - newPkgs) * net));
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
    loadInvoiced(invoiceno);

});
$("body").on("click", ".splitLot", function(e) {
    e.preventDefault();
    var id = $(this).attr('id');
    splitLot(id);
});
$("body").on("click", ".addTea", function(e) {
    e.preventDefault();
    var invoiceno = '<?php echo $invoiceno ?>';
    var id = $(this).attr('id');
    selectInvoiceTea(id, invoiceno);
    loadUnallocated("", "", "", "");
    loadInvoiced(invoiceno);
});
$("body").on("click", ".removeTea", function(e) {
    e.preventDefault();
    var id = $(this).attr('id');
    var invoiceno = '<?php echo $invoiceno ?>';

    removeInvoiceTea(id);
    loadInvoiced(invoiceno);
    loadUnallocated("", "", "", "");


});
$("body").on("click", ".editWindow", function(e) {
    e.preventDefault();
    $('#blendEditForm').show();
    $('#blendSheetWrapper').hide();
});

$("body").on("click", ".printInvoice", function(e) {
    e.preventDefault();
    var invoiceno = '<?php echo $invoiceno ?>';
    $('#blendEditForm').hide();
    $('#blendSheetWrapper').show();
    $('#blendSheetWrapper').html(
        '<iframe class="frame" frameBorder="0" src="../../reports/invoice_profoma_straight.php?invoiceno=' + invoiceno +
        '" width="100%" height="800px"></iframe>');

});
$("body").on("click", ".confirm", function(e) {
    e.preventDefault();
    approveBlend();
});

function splitLot(id) {
    $('#splitModal').show();

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
            $("#splitModal").hide();
            loadUnallocated("", "", "", "");

        }
    });
}

function showInvoice(invoiceno) {
    $.ajax({
        url: "finance_action.php",
        type: "POST",
        data: {
            action: "view-invoices",
            invoiceno: invoiceno
        },
        success: function(response) {
            $("#invoiceTable").html(response);
        }

    });
}

function loadUnallocated(mark, lot, grade, saleno) {
    $.ajax({
        type: "POST",
        data: {
            action: "load-unallocated",
            type: "straight",
            mark: mark,
            lot: lot,
            grade: grade,
            saleno: saleno
        },
        cache: true,
        url: "finance_action.php",
        success: function(data) {
            $('#blendTable').html(data);

        }
    });
}

function loadInvoiced(invoiceid) {
    $.ajax({
        type: "POST",
        data: {
            action: "load-allocated",
            type: "straight",
            invoiceid: invoiceid
        },
        cache: true,
        url: "finance_action.php",
        success: function(data) {
            $('#selected').html(data);

        }
    });
}
function selectInvoiceTea(stockid, invoiceid){
    $.ajax({
        type: "POST",
        data: {
            action: "select-invoice",
            stockid: stockid,
            invoiceid:invoiceid
        },
        cache: true,
        url: "finance_action.php",
        success: function (data) {
            loadInvoiced(invoiceid);
        }
    });
}
function removeInvoiceTea(stockid, invoiceid){
    $.ajax({
        type: "POST",
        data: {
            action: "remove-invoice",
            stockid: stockid,
            invoiceid:invoiceid
        },
        cache: true,
        url: "finance_action.php",
        success: function (data) {
            loadInvoiced(invoiceid);
        }
    });
}
function printReport(element){
    alert("clicked");
}
</script>