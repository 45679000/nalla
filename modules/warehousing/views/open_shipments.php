<?php
$path_to_root = "../../";
require_once $path_to_root . 'templates/header.php';
?>
<style>
    .modal {
        text-align: center;
    }

    @media screen and (min-width: 768px) {
        .modal:before {
            display: inline-block;
            vertical-align: middle;
            content: " ";
            height: 100%;
        }
    }

    .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
    }
    .open-shipment {
        cursor: pointer;
    }
</style>

<body class="container-fluid">
    <div id="global-loader"></div>
    <div class="page">
        <div class="page-main">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-light">Shippments</h3>
                </div>
                <div class="card-body p-6">
                    <div class="panel panel-primary">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu ">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs">
                                    <li class=""><a href="#tab1" class="active" data-toggle="tab">Allocate Materials</a></li>
                                    <li><a href="#tab2" data-toggle="tab">View Material Allocation</a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body">
                            <div class="tab-content">
                                <div class="tab-pane active " id="tab1">
                                    <div id="shippments" class="table-responsive"></div>
                                    <div style="display:none" class="card" id="allocations">
                                        <div class="card-header bg-teal">
                                            <button id="addMaterial" class="btn btn-success btn-sm pl-20">Add Material Used In 
                                                 <span id="si_no" class="pl-20"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="thisAllocation" class="table-responsive"></div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab2">
                                <div id="materialAllocation" class="table-responsive"></div>

                                </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Add Record  Modal -->
    <div class="modal" id="addModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-teal">
                    <h4 class="modal-title">Packing Materials</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="stock">

                    </div>
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
        openShippment();
        $("body").on("click", ".open-shipment", function(e) {
            var sino = $(this).attr("id");
            localStorage.setItem("sino", sino);
            var contractno = $(this).parent().attr("id");
            $("#si_no").html(contractno);
            
            loadSiAllocation(localStorage.getItem("sino"));
        });

        showPackingMaterialAlloacated();    
        </script>

    </html>