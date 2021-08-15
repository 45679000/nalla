<?php
$path_to_root = "../../";
require_once $path_to_root . 'templates/header.php';
?>

<div class="row row-cards">
    <div class="col-lg-2 col-md-2 col-sm-4">
        <div class="card cardclickable">
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
    $("#cpurchaseList").click(function(e){
        window.location.href="./index.php?view=confirmpplist";
    })
    </script>

    </html>