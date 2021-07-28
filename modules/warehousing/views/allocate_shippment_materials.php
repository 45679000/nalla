<?php
$path_to_root = "../../";
require_once $path_to_root . 'templates/header.php';
?>
<style>
    table{
        width:100%;
    }td, th, tr{
        border:1px solid;
    }

</style>

<body class="container-fluid">
    <div id="global-loader"></div>
    <div class="page">
        <div class="page-main">

            <div class="my-3 my-md-5">
                <div class="container-fluid">
                    <div class="row row-cards">
                        <div class="col-xs-12 col-sm-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Shipment Status</h3>
                                </div>
                                <div class="text-center">
                                    <div class="">
                                        <div id="shippments" class="table-responsive">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">In stock</h3>
                    </div>
                    <div class="text-center">
                        <div class="">
                            <div id="packingMaterial">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">This Shipment Allocation</h3>
                    </div>
                    <div class="text-center">
                        <div class="">
                            <div id="thisAllocation">
                            </div>
                        </div>
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
        var sino = '<?php echo $sino ?>'
        loadOneShipment(sino);
        loadPackingMaterialsToAlloacate();
        loadSiAllocation(sino);
        function allocateMaterial(element){
            var pk = $(element).attr("id");
            $.ajax({
            type: "POST",
            dataType: "html",
            data: {

                action: "allocate-material",
                materialid:pk,
                totalAllocation:$("#"+pk+"selected").text(),
                sino:sino

            },
            cache: true,
            url: "warehousing_action.php",
            success: function (data) {
                loadSiAllocation(sino);
                loadPackingMaterialsToAlloacate();

            }
        });
        }
    </script>

    </html>