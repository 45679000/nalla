<style>
    .form-control {
        border: 1px solid !important;
        padding-bottom: 5px !important;
        color: black !important;
    }
    table{
        margin: 0 auto;
        width: 60%;
        clear: both;
        border-collapse: collapse;
        table-layout: fixed; 
        word-wrap:break-word;
}td,th{
    width:20%;
}
</style>

<div class="col-md-8 col-lg-10">
    <div class="card">
        <div class="card-body p-6">
            <div class="col-md-12">
                <div class="expanel expanel-secondary">

                    <div class="expanel-heading">
                        <h3 class="expanel-title">Allocate Stock</h3>
                        <?php  echo $msg ?>
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
                                    <div class="col-md-3 well">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Client/Standard</label>
                                            <select id="buyer_standard" name="buyer_standard" class="form-control select2-show-search well"><small>(required)</small>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 well">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Pkgs To Allocate</label>
                                            <input id="pkgs" name="pkgs" class="form-control well"></input>
                                        </div>
                                    </div>
                                    <div class="col-md-3 well">
                                        <div class="form-group label-floating">
                                            <label class="control-label">MRP value(USD)</label>
                                            <input id="mrpValue" name="mrpValue" class="form-control well"></input>
                                        </div>
                                    </div>
                                    <div class="col-md-3 well">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Offer Price Max(USD)</label>
                                            <input id="offerPrice" name="offerPrice" class="form-control well"></input>
                                        </div>
                                    </div>
                                    <div class="col-md-3 well">
                                        <div class="form-group label-floating">
                                            <button id="allocate" name="allocate" class="btn btn-success">Allocate</button>
                                        </div>
                                    </div>
                                    <input type="hidden" id="pkg_stock" name="pkg_stock" value=""></input>
                                </div>
                        </form>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="allocatedStock" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <td>#Id</td>
                                        <td>Lot</td>
                                        <td>Sale No</td>
                                        <td>Broker</td>
                                        <td>Mark</td>
                                        <td>Grade</td>
                                        <td>Invoice</td>
                                        <td>Allocated Pkgs</td>
                                        <td>Kgs</td>
                                        <td>Net</td>
                                        <td>Hammer.P(USD)</td>
                                        <td>MRP Value</td>
                                        <td>Buyer/STD</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $html = "";
                                    foreach ($allocated as $allocated) {
                                        $html .= '<td>' . $allocated['allocation_id'] . '</td>';
                                        $html .= '<td>' . $allocated['lot'] . '</td>';
                                        $html .= '<td><div>' . $allocated['sale_no'] . '</div></td>';
                                        $html .= '<td>' . $allocated['broker'] . '</td>';
                                        $html .= '<td>' . $allocated['mark'] . '</td>';
                                        $html .= '<td>' . $allocated['grade'] . '</td>';
                                        $html .= '<td>' . $allocated['invoice'] . '</td>';
                                        $html .= '<td>' . $allocated['allocated_pkgs'] . '</td>'; 
                                        $html .= '<td>' . $allocated['kgs'] . '</td>'; 
                                        $html .= '<td>' . $allocated['net_allocation'] . '</td>'; 
                                        $html .= '<td>' . $allocated['sale_price'] . '</td>'; 
                                        $html .= '<td>' . $allocated['mrp_value'] . '</td>'; //auction hammer
                                        $html .= '<td>' . $allocated['buyerstandard'] . '</td>'; //auction hammer

                                        $html .= '</tr>';
                                    }

                                    $html .= '</tbody>
                                    </table>
                                </div>
                            </div>';
                                    echo $html;

                                    ?>

                        </div>
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


    <script>
        lotList();
        standardList();
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
                    $("#pkgs").val(data[0].pkgs);
                    $('#pkg_stock').val(data[0].pkgs);
                }

            });
        })
    </script>

    </html>