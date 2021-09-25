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
</style>

<body class="container-fluid">
    <div id="global-loader"></div>
    <div class="page">
        <div class="page-main">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Shippments</h3>
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
                                        <div class="card-header">
                                            <button id="addMaterial" class="btn btn-sucess btn-sm pl-20">Add Material</button>
                                            <span id="si_no" class="pl-20"></span>
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
                <div class="modal-header">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        shippment();
        $("body").on("click", ".allocatem", function(e) {
            var sino = $(this).attr("id");
            localStorage.setItem("sino", sino);
            var contractno = $(this).parent().attr("id");
            $("#si_no").html(contractno);
            $("#shippments").hide();
            $("#allocations").show();
            $("#addMaterial").click(function(e) {
                $("#addModal").show();
                loadPackingMaterialsToAlloacate();
            });
            $(".close").click(function() {
                $("#addModal").hide();

            });
            loadSiAllocation(localStorage.getItem("sino"));
        });
        $("body").on("click", ".deleteBtn", function(e) {
            var id = $(this).attr("id");

            $.ajax({
                type: "POST",
                dataType: "html",
                data: {
                    action: "unallocate",
                    id: id
                },
                cache: true,
                url: "warehousing_action.php",
                success: function(data) {
                    loadSiAllocation(localStorage.getItem("sino"));
                }
            });
        });

        $("body").on("click", ".allocate", function(e) {
            var pk = $(this).attr("id");
            var value = $("#" + pk + "selected").text();
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {
                    action: "allocate-material",
                    pk: localStorage.getItem("sino"),
                    value: value,
                    material: pk
                },
                cache: true,
                url: "warehousing_action.php",
                success: function(data) {
                    loadSiAllocation(localStorage.getItem("sino"));

                }
            });

        });

        showPackingMaterialAlloacated();    
        </script>

    </html>