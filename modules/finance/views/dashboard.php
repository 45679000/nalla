<?php
$path_to_root = "../../";
require_once $path_to_root . 'templates/header.php';
?>


<div class="row row-cards">

    <div class="col-sm-12 col-lg-2">
        <div id="cpurchaseList" class="card dashboardlink">
            <div class="card-body">
                <div class="card-box tilebox-one">
                    <i class="icon-layers float-left text-muted"><i class="fa fa-list text-primary"
                            aria-hidden="true"></i></i>
                    <h6 class="text-drak text-uppercase mt-0">Confirm Purchase List</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-2">
        <div id="cmdpurchaseList" class="card dashboardlink">
            <div class="card-body">
                <div class="card-box tilebox-one">
                    <i class="icon-layers float-left text-muted"><i class="fa fa-check text-primary"
                            aria-hidden="true"></i></i>
                    <h6 class="text-drak text-uppercase mt-0">Confirmed Purchase List</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-2">
        <div id="profomaInvoice" class="card dashboardlink">
            <div class="card-body">
                <div class="card-box tilebox-one">
                    <i class="icon-layers float-left text-muted"><i class="fa fa-file text-primary"
                            aria-hidden="true"></i></i>
                    <h6 class="text-drak text-uppercase mt-0">Profoma Invoices</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-2">
        <div id="commercialInvoice" class="card dashboardlink">
            <div class="card-body">
                <div class="card-box tilebox-one">
                    <i class="icon-layers float-left text-muted"><i class="fa fa-file text-info"
                            aria-hidden="true"></i></i>
                    <h6 class="text-drak text-uppercase mt-0">Commercial Invoices</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-2">
        <div id="missingLots" class="card dashboardlink">
            <div class="card-body">
                <div class="card-box tilebox-one">
                    <i class="icon-layers float-left text-muted"><i class="fa fa-search text-info"
                            aria-hidden="true"></i></i>
                    <h6 class="text-drak text-uppercase mt-0">Find Missing Lots</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-2">
        <div id="prvtPurchases" class="card dashboardlink">
            <div class="card-body">
                <div class="card-box tilebox-one">
                    <i class="icon-layers float-left text-muted"><i class="fa fa-balance-scale text-warning"
                            aria-hidden="true"></i></i>
                    <h6 class="text-drak text-uppercase mt-0">Private Purchases</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-2">
        <div id="paidLots" class="card dashboardlink">
            <div class="card-body">
                <div class="card-box tilebox-one">
                    <i class="icon-layers float-left text-muted"><i class="fa fa-credit-card-alt text-danger"
                            aria-hidden="true"></i></i>
                    <h6 class="text-drak text-uppercase mt-0">Mark Lots Paid</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-2">
        <div id="banking_gl" class="card dashboardlink">
            <div class="card-body">
                <div class="card-box tilebox-one">
                    <i class="icon-layers float-left text-muted"><i class="fa fa-balance-scale text-warning"
                            aria-hidden="true"></i></i>
                    <h6 class="text-drak text-uppercase mt-0">Banking and General Ledger</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-2">
        <div id="purchasesOthers" class="card dashboardlink">
            <div class="card-body">
                <div class="card-box tilebox-one">
                    <i class="icon-layers float-left text-muted"><i class="fa fa-balance-scale text-warning"
                            aria-hidden="true"></i></i>
                    <h6 class="text-drak text-uppercase mt-0">Other Purchases</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-2">
        <div id="customers" class="card dashboardlink">
            <div class="card-body">
                <div class="card-box tilebox-one">
                    <i class="icon-layers float-left text-muted"><i class="fa fa-users text-info"
                            aria-hidden="true"></i></i>
                    <h6 class="text-drak text-uppercase mt-0">Customers</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-2">
        <div id="suppliers" class="card dashboardlink">
            <div class="card-body">
                <div class="card-box tilebox-one">
                    <i class="icon-layers float-left text-muted"><i class="fa fa-users text-warning"
                            aria-hidden="true"></i></i>
                    <h6 class="text-drak text-uppercase mt-0">Suppliers</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-2">
        <div id="paymentSchedule" class="card dashboardlink">
            <div class="card-body">
                <div class="card-box tilebox-one">
                    <i class="icon-layers float-left text-muted"><i class="fa fa-calendar text-danger"
                            aria-hidden="true"></i></i>
                    <h6 class="text-drak text-uppercase mt-0">Payment Schedule</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="card cardclickable">
    <div class="card-body">
        <div id="cpurchaseList" class="clearfix dashboardlink">
            <div class="float-right">
                <i class="mdi mdi-calendar-clock text-warning icon-size"></i>
            </div>
            <div class="float-left">
                <p class="mb-0 text-left">Confirm Purchase List</p>
            </div>
        </div>
        <p class="text-muted mb-0">
            <i class="mdi mdi-arrow-up-drop-circle text-success mr-1" aria-hidden="true"></i>
            Click to Open
        </p>
    </div>
</div>
</div>
</div> -->


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
<script>
shipmentStatus();
$("#submit").click(function(e) {
    if ($("#formData")[0].checkValidity()) {
        e.preventDefault();
        var sino = localStorage.getItem("si_no");
        $.ajax({
            url: "warehousing_action.php",
            type: "POST",
            data: $("#formData").serialize() + "&action=update-status&sino=" + sino,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Record added successfully',
                });
                $("#updateStatus").modal('hide');
                $("#formData")[0].reset();
                shipmentStatus();

            }
        });
    }
});
$("#cpurchaseList").click(function(e) {
    window.location.href = "./index.php?view=confirmpplist";
});
$("#cmdpurchaseList").click(function(e) {
    window.location.href = "./index.php?view=confirmedpplist";
});
$("#profomaInvoice").click(function(e) {
    window.location.href = "./index.php?view=profoma";
});
$("#commercialInvoice").click(function(e) {
    window.location.href = "./index.php?view=commercial";
});
$("#prvtPurchases").click(function(e) {
    window.location.href = "/chamu/modules/stock/index.php?view=ppurchases";
});

$("#missingLots").click(function(e) {
    window.location.href = "/chamu/views/view_valuations.php";

});
$("#banking_gl").click(function(e) {
    window.location.href = "/chamu/views/view_valuations.php";
});
$("#purchasesOthers").click(function(e) {
    window.location.href = "/chamu/views/view_valuations.php";
});
$("#customers").click(function(e) {
    window.location.href = "/chamu/views/view_valuations.php";
});
$("#suppliers").click(function(e) {
    window.location.href = "/chamu/views/view_valuations.php";
});
$("#paymentSchedule").click(function(e) {
    Swal.fire({
        icon: 'notice',
        title: 'Development in progress',
    });
});
$("#paidLots").click(function(e) {
    Swal.fire({
        icon: 'notice',
        title: 'Development in progress',
    });
});



</script>

</html>