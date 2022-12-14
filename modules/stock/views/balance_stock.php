<div class="col-md-12 col-lg-12">
    <div class="my-3 my-md-5">
        <div class="container-fluid">
            <div id="global-loader"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <span>Stock Reconciliation</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="success" id="message"></p>
                        </div>
                        <div class="card-body">
                            <div id="reconTable" class="table-responsive">
                                <div class="card-body">
                                    <div class="dimmer active">
                                        <div class="spinner2">
                                            <div class="cube1"></div>
                                            <div class="cube2"></div>
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

<!-- Dashboard js -->
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../../assets/js/vendors/selectize.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>
<!-- forn-wizard js-->
<script src="../../assets/plugins/forn-wizard/js/material-bootstrap-wizard.js"></script>
<script src="../../assets/plugins/forn-wizard/js/jquery.validate.min.js"></script>
<script src="../../assets/plugins/forn-wizard/js/jquery.bootstrap.js"></script>
<!-- file import -->
<script src="../../assets/plugins/fileuploads/js/dropify.min.js"></script>
<!-- Custom scroll bar Js-->
<script src=../../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- counter  -->
<script src="../../assets/plugins/counters/counterup.min.js"></script>
<script src="../../assets/plugins/counters/waypoints.min.js"></script>
<!-- Custom Js-->
<script src="../../assets/js/custom.js"></script>
<script id="url" data-name="../../ajax/common.php" src="../../assets/js/common.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/plugins/select2/select2.full.min.js"></script>
<script src="../../assets/plugins/notify/js/rainbow.js"></script>
<script src="../../assets/plugins/notify/js/jquery.growl.js"></script>



<script>
$(".dimmer").hide();
loadStock();

function loadStock(){
    $(".dimmer").show();
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "stock-action.php",
            data: {
                action: "recon-stock"
            },
            success: function(data) {
                $("#reconTable").html(data);
                $('.select2').select2({});
                $('.table').DataTable();
                $(".dimmer").hide();
            }
        });
    });
}
$("body").on("click", ".reverse", function(e) {
    var contractNo = $(this).attr("id");
    console.log(contractNo)
});
$("body").on("click", ".shipp", function(e) {
    var stock_id = $(this).attr("id");
    markAsShipped(stock_id)
});
function markAsShipped(stock_id){
    $.ajax({
        type: "POST",
            url: "stock-action.php",
            data: {
                action: "mark-as-shipped",
                stock_id: stock_id
            },
            success: function(data) {
                loadStock();
            }
    })
}

</script>