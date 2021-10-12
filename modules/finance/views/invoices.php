<style>
.table {
    background-color: white !important;
}

.toolbar-button {
    padding: 0.5px !important;
}
</style>
<?php 
    $invoicetype = isset($_GET["view"]) ? $_GET["view"] : 'profoma';
?>

<div class="col-md-12 col-lg-12">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Invoicing</h3>
                    </div>
                    <div class="card-body p-6">
                        <div class="panel panel-primary">
                            <div class="tab-menu-heading">
                                <div class="tabs-menu ">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs">
                                        <li id="create-profoma" class=""><a href="#tab1" class="active" data-toggle="tab">Create Profoma Invoice</a></li>
                                        <li id="allocate-teas"><a href="#tab2" data-toggle="tab">View Profoma Invoices</a></li>
                                        <li><a href="#tab3" data-toggle="tab">Create Commercial Invoice</a></li>
                                        <li><a href="#tab4" data-toggle="tab">Paid Invoices</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body">
                                <div class="tab-content">
                                    <div class="tab-pane active " id="tab1">
                                        <div class="card">
                                            <div class="card-body">
                                                <form id="formData">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="control-label">Load From a Template</label>
                                                            <select id="proforma_template" name="proforma_template"
                                                                class="form-control form-control-cstm select2"><small>(required)</small>
                                                                <option value="straight">Straight Line</option>
                                                                <option value="blend">Blend</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 well">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Category</label>
                                                                </input>
                                                                <select id="invoice_category" name="invoice_category"
                                                                    class="form-control form-control-cstm select2-show-search well"><small>(required)</small>
                                                                    <option value="straight">Straight Line</option>
                                                                    <option value="blend">Blend</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Invoice No:</label>
                                                            <input type="text" class="form-control" id="invoice_no"
                                                                name="invoice_no" placeholder="Invoice No" required="">

                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Container no:</label>
                                                            <input id="container_no" type="text" class="form-control"
                                                                name="container_no" placeholder="Container No"
                                                                required="">
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Buyer's Contract No:</label>
                                                            <input type="text" class="form-control"
                                                                id="buyer_contract_no" name="buyer_contract_no"
                                                                placeholder="Buyer's Contract No" required="">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="payment_terms">Payment
                                                                Terms:</label>
                                                            <select id="payment_terms" name="payment_terms"
                                                                class="form-control form-control-cstm select2-show-search well"><small>(required)</small></select>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Date:</label>
                                                            <input type="text" class="form-control" name="date"
                                                                placeholder="Date" required="">
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Buyer:</label>
                                                            <select id="buyer" name="buyer"
                                                                class="form-control form-control-cstm select2"><small>(required)</small>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Shipping Marks:</label>
                                                            <input type="text" class="form-control"
                                                                name="shipping_marks" id="shipping_marks"
                                                                placeholder="shipping marks" required="">
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="port_of_delivery">Port Of
                                                                Discharge:</label>
                                                            <textarea class="form-control" name="port_of_delivery"
                                                                id="port_of_delivery" cols="20" rows="3"></textarea>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="final_destination">Final
                                                                Destination:</label>
                                                            <textarea class="form-control" name="final_destination"
                                                                id="final_destination" cols="20" rows="3"></textarea>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label"
                                                                for="consignee">Consignee:</label>
                                                            <textarea class="form-control" name="consignee"
                                                                id="consignee" cols="20" rows="3"></textarea>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="pay_bank">Payment
                                                                Bank:</label>
                                                            <textarea class="form-control" name="pay_bank" id="pay_bank"
                                                                cols="20" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="name">Payment
                                                                Details:</label>
                                                            <textarea class="form-control" name="pay_details"
                                                                id="pay_details" cols="20" rows="3"></textarea>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label"
                                                                for="description_of_goods">Description of Goods:</label>
                                                            <textarea class="form-control" name="description_of_goods"
                                                                id="description_of_goods" cols="20" rows="3"></textarea>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="other_reference">Other
                                                                reference Bank:</label>
                                                            <textarea class="form-control" name="other_reference"
                                                                id="other_reference" cols="20" rows="3"></textarea>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="buyer_bank">Buyer
                                                                Bank:</label>
                                                            <textarea class="form-control" name="buyer_bank"
                                                                id="buyer_bank" cols="20" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 form-group float-right">
                                                            <button type="submit" class="btn btn-success btn-sm"
                                                                id="submit">Save</button>
                                                        </div>
                                                    </div>

                                                </form>
                                                <div id="invoicediv" style="display:none">
                                                    <a href="#"><span id="invoicenocreated"></span></a>
                                                </div>
                                                <div id="stocklist" style="display: none;">

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div id="invoices"></div>
                                                    </div>
                                                    <div class="col-md-8" >
                                                        <div id="profoma_invoice_print">

                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane " id="tab3">
                                    <div class="card">
                                            <div class="card-body">
                                                <form id="formData">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="control-label">Load From a Template</label>
                                                            <select id="proforma_template" name="proforma_template" class="form-control form-control-cstm select2"><small>(required)</small>
                                                               
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 well">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Category</label>
                                                                </input>
                                                                <select id="invoice_category" name="invoice_category"
                                                                    class="form-control form-control-cstm select2-show-search well"><small>(required)</small>
                                                                    <option value="straight">Straight Line</option>
                                                                    <option value="blend">Blend</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Invoice No:</label>
                                                            <input type="text" class="form-control" id="invoice_no"
                                                                name="invoice_no" placeholder="Invoice No" required="">

                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Container no:</label>
                                                            <input id="container_no" type="text" class="form-control"
                                                                name="container_no" placeholder="Container No"
                                                                required="">
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Buyer's Contract No:</label>
                                                            <input type="text" class="form-control"
                                                                id="buyer_contract_no" name="buyer_contract_no"
                                                                placeholder="Buyer's Contract No" required="">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="payment_terms">Payment
                                                                Terms:</label>
                                                            <select id="payment_terms" name="payment_terms"
                                                                class="form-control form-control-cstm select2-show-search well"><small>(required)</small></select>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Date:</label>
                                                            <input type="text" class="form-control" name="date"
                                                                placeholder="Date" required="">
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Buyer:</label>
                                                            <select id="buyer" name="buyer"
                                                                class="form-control form-control-cstm select2"><small>(required)</small>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Shipping Marks:</label>
                                                            <input type="text" class="form-control"
                                                                name="shipping_marks" id="shipping_marks"
                                                                placeholder="shipping marks" required="">
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="port_of_delivery">Port Of
                                                                Discharge:</label>
                                                            <textarea class="form-control" name="port_of_delivery"
                                                                id="port_of_delivery" cols="20" rows="3"></textarea>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="final_destination">Final
                                                                Destination:</label>
                                                            <textarea class="form-control" name="final_destination"
                                                                id="final_destination" cols="20" rows="3"></textarea>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label"
                                                                for="consignee">Consignee:</label>
                                                            <textarea class="form-control" name="consignee"
                                                                id="consignee" cols="20" rows="3"></textarea>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="pay_bank">Payment
                                                                Bank:</label>
                                                            <textarea class="form-control" name="pay_bank" id="pay_bank"
                                                                cols="20" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="name">Payment
                                                                Details:</label>
                                                            <textarea class="form-control" name="pay_details"
                                                                id="pay_details" cols="20" rows="3"></textarea>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label"
                                                                for="description_of_goods">Description of Goods:</label>
                                                            <textarea class="form-control" name="description_of_goods"
                                                                id="description_of_goods" cols="20" rows="3"></textarea>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="other_reference">Other
                                                                reference Bank:</label>
                                                            <textarea class="form-control" name="other_reference"
                                                                id="other_reference" cols="20" rows="3"></textarea>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="buyer_bank">Buyer
                                                                Bank:</label>
                                                            <textarea class="form-control" name="buyer_bank"
                                                                id="buyer_bank" cols="20" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 form-group float-right">
                                                            <button type="submit" class="btn btn-success btn-sm"
                                                                id="submit">Save</button>
                                                        </div>
                                                    </div>

                                                </form>
                                                <div id="invoicediv" style="display:none">
                                                    <a href="#"><span id="invoicenocreated"></span></a>
                                                </div>
                                                <div id="stocklist" style="display: none;">

                                                </div>

                                            </div>
                                        </div>
                                    <div class="tab-pane  " id="tab4">
                                       
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

<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<!-- Custom Js-->
<script src="../../assets/js/custom.js"></script>
<script id="url" data-name="../../ajax/common.php" src="../../assets/js/common.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- forn-wizard js-->
<script src="../../assets/plugins/forn-wizard/js/material-bootstrap-wizard.js"></script>
<script src="../../assets/plugins/forn-wizard/js/jquery.validate.min.js"></script>
<script src="../../assets/plugins/forn-wizard/js/jquery.bootstrap.js"></script>
</body>
<script type="text/javascript">
$(document).ready(function() {
    var invoiceType = '<?php echo $invoicetype ?>';
    $("#invoice_type").val(invoiceType);
    clientWithcodeList();
    loadInvoices();
    loadTemplate();
    //insert ajax request data
    $("#submit").click(function(e) {
        if ($("#formData")[0].checkValidity()) {
            e.preventDefault();
            localStorage.setItem("invoiceno", $("#invoice_no").val());
            $.ajax({
                url: "finance_action.php",
                type: "POST",
                data: $("#formData").serialize() + "&action=save-invoice",
                dataType: "json",
                success: function(response) {
                    if (response.code == 201) {
                        Swal.fire({
                            icon: 'error',
                            title: response.error,
                        });
                    }
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: response.success,
                        });
                        $("#formData").hide();
                        $("#invoicediv").show();
                        $("#invoicenocreated").html(localStorage.getItem("invoiceno"));

                    }
                    if (response.code == 500) {
                        Swal.fire({
                            icon: 'error',
                            title: response.error,
                        });
                    }
                },
                error: function(response) {
                    console.log(response);
                    // alert("response= "+response.code);
                }
            });
        }
    });

    $("#submitUpdate").click(function(e) {
        if ($("#EditformData")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: "finance_action.php",
                type: "POST",
                data: $("#EditformData").serialize() + "&action=update",
                dataType: "html",
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Record Updated',
                    });
                    $("#editModal").modal('hide');
                    $("#EditformData")[0].reset();
                }



            });
        }
    });
    //Edit Record
    $("body").on("click", ".profoma_print", function(e) {
        e.preventDefault();
        $("#profoma_invoice_print").html('<iframe class="frame" frameBorder="0" src="../../reports/invoice_profoma_straight.php?invoiceno=CSL/TXP 21523" width="1000px" height="800px"></iframe>');

    });
   
    $("body").on("click", ".removeTea", function(e) {
        e.preventDefault();
        var stockid = $(this).attr('id');
        $.ajax({
            url: "finance_action.php",
            type: "POST",
            data: {
                action: " select-invoice",
                stockid: stockid,
                invoiceid :localStorage.getItem("invoiceno")
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Tea Added',
                });
            }
        });
    });
    $("body").on("click", ".addTea", function(e) {
        e.preventDefault();
        var stockid = $(this).attr('id');
        $(this).parent().text(localStorage.getItem("invoiceno"));

        $.ajax({
            url: "finance_action.php",
            type: "POST",
            data: {
                action: "select-invoice",
                stockid: stockid,
                invoiceid :localStorage.getItem("invoiceno")
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Tea Added',
                });
            }
        });
    });


    //Delete Record
    $("body").on("click", ".deleteBtn", function(e) {
        e.preventDefault();
        var deleteId = $(this).attr('id');
        $.ajax({
            url: "finance_action.php",
            type: "POST",
            data: {
                deleteId: deleteId
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Record deleted successfully',
                });
            }
        });
    });

    $("#invoicenocreated").click(function(e){
        e.preventDefault();
        loadUnallocated("", "", "", "");
    })

});

function loadUnallocated(mark, lot, grade, saleno) {
    $.ajax({
        type: "POST",
        data: {
            action: "load-unallocated",
            type: "straight",
            mark:mark,
            lot:lot,
            grade:grade,
            saleno:saleno
        },
        cache: true,
        url: "finance_action.php",
        success: function (data) {
            $("#stocklist").show();
            $('#stocklist').html(data);
            $('#direct_lot').DataTable({
                "pageLength": 50,
                dom: 'Bfrtip'
            });

        }
    });
}
function loadInvoices() {
    $.ajax({
        type: "POST",
        data: {
            action: "view-invoices"
        },
        cache: true,
        url: "finance_action.php",
        success: function (data) {
            
            $('#invoices').html(data);
            $('#invoicetable').DataTable({
                "pageLength": 50,
                dom: 'Bfrtip'
            });

        }
    });
}

function loadTemplate(){
    $.ajax({
            url: "finance_action.php",
            type: "POST",
            dataType:"html",
            data: {
                action: "profoma-templates"
            },
            success: function(data) {
                $("#proforma_template").html(data);
            }
        });
}
function contractChangeUpdate(){
    $('#proforma_template').change(function(){
        var id = $('#proforma_template').val();
        $.ajax({
            url: "finance_action.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "edit-si-profoma",
                id: id
            },
            success: function(data) {
                for (const [key, value] of Object.entries(data[0])) {
                    $('#'+key).val(value);
                }

               
            }
    
        });
    });
}
$('#helpBlend').click(function(e) {
    $("#help").toggle();
});
</script>