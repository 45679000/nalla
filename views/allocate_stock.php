<style>
    .form-control-cstm {
        border: 1px solid !important;
        padding-bottom: 1px !important;
        color: black !important;
        height: 30px !important;
    }

    table {
        margin: 0 auto;
        width: 60%;
        clear: both;
        border-collapse: collapse;
        table-layout: fixed;
        word-wrap: break-word;
    }

    td,
    th {
        width: 20%;
    }

    .form-control-btn {
        height: 50px !important;
        background-color: green;
        color: white;
    }
</style>

<div class="col-md-8 col-lg-10">
    <div class="card">
        <div class="card-body p-6">
            <div class="col-md-12">
                <div class="expanel expanel-secondary">

                    <div class="expanel-heading">
                        <h3 class="expanel-title">Allocate Stock</h3>
                        <?php echo $msg ?>
                    </div>
                    <div class="expanel-body">
                        <form method="post" class="allocate">
                            <div class="form-group">
                                <div class="row justify-content-center">
                                    <div class="col-md-12 well">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Lot Details</label>
                                            <select id="stock_id" name="stock_id" class="form-control select2-show-search"><small>(required)</small>
                                                <option disabled="" value="..." selected="">select</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-2 well">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Client</label>
                                            <select id="clientwithcode" name="buyer_standard" class="form-control form-control-cstm select2-show-search well"><small>(required)</small>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 well">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Standard</label>
                                            <input id="std" name="pkgs" class=" standard form-control form-control-cstm well">
                                            </input>
                                            <select id="standard" name="standard" class="standard form-control form-control-cstm select2-show-search well"><small>(required)</small>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-2 well">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Pkgs To Allocate</label>
                                            <input id="pkgs" name="pkgs" class="form-control form-control-cstm well"></input>
                                        </div>
                                    </div>
                                    <div class="col-md-2 well">
                                        <div class="form-group label-floating">
                                            <label class="control-label">MRP value(USD)</label>
                                            <input id="mrpValue" name="mrpValue" class="form-control form-control-cstm well"></input>
                                        </div>
                                    </div>
                                    <div class="col-md-2 well">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Ware House</label>
                                            <select id="warehouseLocation" name="warehouseLocation" class="form-control form-control-cstm select2-show-search well"><small>(required)</small>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 well align-self-center">
                                        <div class="form-group label-floating ">
                                            <button id="allocate" name="allocate" class="form-control-btn">
                                                <i class="fa fa-plus"></i> allocate
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" id="pkg_stock" name="pkg_stock" value=""></input>
                                </div>
                        </form>

                    </div>

                    <div class="card-body">
                        <div id ="allocatedStock" class="table-responsive">
                          

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="centralModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <!--Content-->
                        <div class="modal-content">          
                            <!--Body-->
                            <div class="modal-body">
                                <h5>The Selected Lot does not have a selected standard</h5>
                            </div>
                            <!--Footer-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                            </div>
                        </div>
                        <!--/.Content-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>


    <!-- Dashboard js -->
    <script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
    <script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/vendors/jquery.sparkline.min.js"></script>
    <script src="../assets/js/vendors/selectize.min.js"></script>
    <script src="../assets/js/vendors/jquery.tablesorter.min.js"></script>
    <script src="../assets/js/vendors/circle-progress.min.js"></script>
    <script src="../assets/plugins/jquery-tabledit/jquery.tabledit.js"></script>
    <script src="../assets/js/common.js"></script>
    <script src="../assets/plugins/select2/select2.full.min.js"></script>
    <script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>

    <script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>


<script src="../assets/plugins/datatable/dataTables.buttons.min.js"></script>
<script src="../assets/plugins/datatable/jszip.min.js"></script>
<script src="../assets/plugins/datatable/pdfmake.min.js"></script>
<script src="../assets/plugins/datatable/vfs_fonts.js"></script>
<script src="../assets/plugins/datatable/buttons.html5.min.js"></script>
<script src="../assets/plugins/datatable/buttons.print.min.js"></script>

    <script>
        lotList();
        standardList();
        loadAllocated();


        $('.select2-show-search').select2({

            placeholder: 'Select an item',
        });
        $('#stock_id').change(function() {
            var stock_id = $('#stock_id').val();
            $.ajax({
                url: "../ajax/common.php",
                type: "POST",
                dataType: "json",
                data: {
                    action: "lot-list",
                    id: stock_id
                },
                success: function(data) {
                    var standard = data[0].standard;
                    if (standard == null) {
                        $('#centralModal').modal('show');
                    }else{
                        $('#std').val(standard);
                    }
                    $("#pkgs").val(data[0].pkgs);
                    $('#pkg_stock').val(data[0].pkgs);
                }

            });
        })
        $('#standard').change(function() {
            $("#std").val($('#standard').val());

        });
        $('#allocate').click(function(e){
            e.preventDefault();
            var standard = $("#std").val();
            var client = $("#clientwithcode").val();
            var stock_id = $("#stock_id").val();
            var pkgs = $("#pkgs").val();
            var mrp = $("#mrpValue").val();
            var warehouseLocation = $("#warehouseLocation").val();

            $.ajax({
                url: "../modules/stock/stock-action.php",
                type: "POST",
                dataType: "html",
                data: {
                    action: "allocate-stock",
                    stock_id: stock_id,
                    pkgs:pkgs,
                    mrp:mrp,
                    warehouseLocation:warehouseLocation,
                    standard:standard,
                    client:client
                },
                success: function(data) {
                    loadAllocated();
                    swal('','Allocated', 'success');

                }

            });

        });
        $('#allocatedStockTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print',
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    },
                    
                ]
        });
    </script>

    </html>