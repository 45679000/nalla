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
                                        <li class=""><a href="#tab1" class="active" data-toggle="tab">Create Profoma
                                                Invoice</a></li>
                                        <li><a href="#tab2" data-toggle="tab">Allocate Lots</a></li>
                                        <li><a href="#tab3" data-toggle="tab">View Profoma Invoices</a></li>
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
                                                        <div class="col-md-6" >
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
                                                            <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Invoice No" required="">
                                                                
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Container no:</label>
                                                            <input id="container_no" type="text" class="form-control"  name="container_no" placeholder="Container No" required="">                                                                                                                            
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Buyer's Contract No:</label>
                                                            <input type="text" class="form-control" id="buyer_contract_no" name="buyer_contract_no"  placeholder="Buyer's Contract No" required="">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="payment_terms">Payment Terms:</label>                                                               
                                                            <select id="payment_terms" name="payment_terms" class="form-control form-control-cstm select2-show-search well"><small>(required)</small></select>                                                                                                                   
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Date:</label>
                                                            <input type="text" class="form-control" name="date"  placeholder="Date" required="">
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Buyer:</label>
                                                            <select id="buyer" name="buyer"
                                                                class="form-control form-control-cstm select2"><small>(required)</small>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label">Shipping Marks:</label>
                                                            <input type="text" class="form-control" name="shipping_marks" id="shipping_marks" placeholder="shipping marks" required="">
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="port_of_delivery">Port Of Discharge:</label> 
                                                            <textarea class="form-control" name="port_of_delivery" id="port_of_delivery" cols="20" rows="3"></textarea>                                                               
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="final_destination">Final Destination:</label> 
                                                            <textarea class="form-control" name="final_destination" id="final_destination" cols="20" rows="3"></textarea>                                                               
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label"  for="consignee">Consignee:</label>
                                                           <textarea class="form-control" name="consignee" id="consignee" cols="20" rows="3"></textarea>                                                               
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="pay_bank">Payment  Bank:</label>                                                               
                                                            <textarea class="form-control" name="pay_bank" id="pay_bank" cols="20" rows="3"></textarea>  
                                                        </div>           
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="name">Payment Details:</label>
                                                            <textarea class="form-control" name="pay_details" id="pay_details" cols="20" rows="3"></textarea> 
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="description_of_goods">Description of Goods:</label>
                                                            <textarea class="form-control" name="description_of_goods" id="description_of_goods" cols="20" rows="3"></textarea>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="other_reference">Other reference Bank:</label>
                                                            <textarea class="form-control" name="other_reference" id="other_reference" cols="20" rows="3"></textarea>  
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="control-label" for="buyer_bank">Buyer Bank:</label>
                                                            <textarea class="form-control" name="buyer_bank" id="buyer_bank" cols="20" rows="3"></textarea>  
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 form-group float-right">
                                                            <button type="submit" class="btn btn-success btn-sm" id="submit">Save</button>
                                                        </div>
                                                    </div>
                                               
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane  " id="tab2">
                                        <p> default model text, and a search for 'lorem ipsum' will uncover many web
                                            sites still in their infancy. Various versions have evolved over the years,
                                            sometimes by accident, sometimes on purpose (injected humour and the like
                                        </p>
                                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
                                            eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
                                            voluptua. At vero eos et</p>
                                    </div>
                                    <div class="tab-pane " id="tab3">
                                        <p>over the years, sometimes by accident, sometimes on purpose (injected humour
                                            and the like</p>
                                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
                                            eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
                                            voluptua. At vero eos et</p>
                                    </div>
                                    <div class="tab-pane  " id="tab4">
                                        <p>page editors now use Lorem Ipsum as their default model text, and a search
                                            for 'lorem ipsum' will uncover many web sites still in their infancy.
                                            Various versions have evolved over the years, sometimes by accident,
                                            sometimes on purpose (injected humour and the like</p>
                                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
                                            eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
                                            voluptua. At vero eos et</p>
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
</body>
<script type="text/javascript">
$(document).ready(function() {
    var invoiceType = '<?php echo $invoicetype ?>';
    $("#invoice_type").val(invoiceType);
    showAllBlends(invoiceType);
    clientWithcodeList();
    //View Record
    function showAllBlends(type) {
        $.ajax({
            url: "finance_action.php",
            type: "POST",
            data: {
                action: "view-invoices",
                type: type
            },
            success: function(response) {
                $("#tableData").html(response);
                $("table").DataTable({
                    order: [0, 'ASC']
                });
            }

        });
    }

    $("#update").click(function(e) {
        if ($("#EditformData")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: "finance_action.php",
                type: "POST",
                data: $("#EditformData").serialize() + "&action=update",
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Customer Updated successfully',
                    });
                    $("#addModal").modal('hide');
                    $("#EditformData")[0].reset();
                    showAllBlends();
                }
            });
        }
    });


    //insert ajax request data
    $("#submit").click(function(e) {
        if ($("#formData")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: "finance_action.php",
                type: "POST",
                data: $("#formData").serialize() + "&action=save-invoice",
                dataType: "json",
                success: function(response) {
                    console.log(response)
                    if (response.code == 201) {
                        Swal.fire({
                            icon: 'error',
                            title: response.error,
                        });
                        $("#addModal").modal('hide');
                        $("#formData")[0].reset();
                        showAllBlends();
                    }
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: response.success,
                        });
                       
                    }
                    if (response.code == 500) {
                        Swal.fire({
                            icon: 'error',
                            title: response.error,
                        });
                    }


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
                    showAllBlends();
                }



            });
        }
    });
    //Edit Record
    $("body").on("click", ".editBtn", function(e) {
        e.preventDefault();

        var editId = $(this).attr('id');
        $.ajax({
            url: "finance_action.php",
            type: "POST",
            dataType: "json",
            data: {
                editId: editId
            },
            success: function(data) {
                $("#edit-form-id").val(data[0].id);
                $("#standardUpdate").val(data[0].std_name);
                $("#blendid").val(data[0].blendid);
                $("#contractno").val(data[0].contractno);
                $("#clientwithcodeUpdate").val(data[0].client_id);
                $("#updateGrade").val(data[0].Grade);
                $("#pkgs").val(data[0].Pkgs);
                $("#nw").val(data[0].nw);
                $("#sale_no").val(data[0].sale_no);

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
                showAllBlends();
                Swal.fire({
                    icon: 'success',
                    title: 'Record deleted successfully',
                });
            }
        });
    });

});

function loadAllocationSummaryForBlends() {
    loadUnallocated();
}

$('#helpBlend').click(function(e) {
    $("#help").toggle();
});
</script>