<head>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css"> -->



</head>

<style>
    * {
        margin: 0;
        padding: 0
    }

    html {
        height: 100%
    }

    p {
        color: grey
    }

    #heading {
        text-transform: uppercase;
        color: #673AB7;
        font-weight: normal
    }

    #msform {
        text-align: center;
        position: relative;
        margin-top: 20px
    }

    #msform fieldset {
        background: white;
        border: 0 none;
        border-radius: 0.5rem;
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding-bottom: 20px;
        position: relative
    }

    .form-card {
        text-align: left
    }

    #msform fieldset:not(:first-of-type) {
        display: none
    }

    #msform input,
    #msform textarea {
        padding: 8px 15px 8px 15px;
        border: 1px solid #ccc;
        border-radius: 0px;
        margin-bottom: 25px;
        margin-top: 2px;
        width: 100%;
        box-sizing: border-box;
        font-family: montserrat;
        color: #2C3E50;
        background-color: #ECEFF1;
        font-size: 16px;
        letter-spacing: 1px
    }

    #msform input:focus,
    #msform textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: 1px solid #673AB7;
        outline-width: 0
    }

    #msform .action-button {
        width: 100px;
        background: #673AB7;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 0px 10px 5px;
        float: right
    }

    #msform .action-button:hover,
    #msform .action-button:focus {
        background-color: #311B92
    }

    #msform .action-button-previous {
        width: 100px;
        background: #616161;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px 10px 0px;
        float: right
    }

    #msform .action-button-previous:hover,
    #msform .action-button-previous:focus {
        background-color: #000000
    }

    .card {
        z-index: 0;
        border: none;
        position: relative
    }

    .fs-title {
        font-size: 25px;
        color: #673AB7;
        margin-bottom: 15px;
        font-weight: normal;
        text-align: left
    }

    .purple-text {
        color: #673AB7;
        font-weight: normal
    }

    .steps {
        font-size: 25px;
        color: gray;
        margin-bottom: 10px;
        font-weight: normal;
        text-align: right
    }

    .fieldlabels {
        color: gray;
        text-align: left
    }

    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey
    }

    #progressbar .active {
        color: #673AB7
    }

    #progressbar li {
        list-style-type: none;
        font-size: 15px;
        width: 25%;
        float: left;
        position: relative;
        font-weight: 400
    }

    #progressbar #account:before {
        font-family: FontAwesome;
        content: "\f2bb"
    }

    #progressbar #personal:before {
        font-family: FontAwesome;
        content: "\f073"
    }
    
    #progressbar #submitInvoice:before {
        font-family: FontAwesome;
        content: "\f00c"
    }
    #progressbar #payment:before {
        font-family: FontAwesome;
        content: "\f030"
    }
    #progressbar #selected:before {
        font-family: FontAwesome;
        content: "\f00e"
    }
    #progressbar #confirm:before {
        font-family: FontAwesome;
        content: "\f02f"
    }

    #progressbar li:before {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 20px;
        color: #ffffff;
        background: lightgray;
        border-radius: 50%;
        margin: 0 auto 10px auto;
        padding: 2px
    }

    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1
    }

    #progressbar li.active:before,
    #progressbar li.active:after {
        background: #673AB7
    }

    .progress {
        height: 20px
    }

    .progress-bar {
        background-color: #673AB7
    }

    .fit-image {
        width: 100%;
        object-fit: cover
    }
    .updateable:hover {
        -webkit-appearance: textfield;
        padding: 1px;
        background-color: rgba(217, 245, 255,0.5);
        border: 2px inset;
    }
</style>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-12 text-center">
            <div class="card px-4 pt-4 pb-0 mt-3 mb-3 p-4 mt-3 mb-2">
                <h2 id="heading">Create Profoma Invoice Blend</h2>
                <p>Fill all form field to go to next step</p>
                <form id="msform" class="p-1">
                    <!-- progressbar -->
                    <ul id="progressbar">
                        <li class="active" id="account"><strong>Invoice Details</strong></li>
                        <li id="personal"><strong>Add Blend Line</strong></li>
                        <li id="confirm"><strong>Print</strong></li>
                        <li id="submitInvoice"><strong>Submit Invoice</strong></li>

                    </ul>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> 
                    <br> <!-- fieldsets -->
                    <fieldset id="formData">
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Invoice Details:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 1 - 3</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Load From a Template</label>
                                    <select id="proforma_template" name="proforma_template"><small>(required)</small>
                                        
                                    </select>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label class="control-label">Buyer:</label>
                                    <select id="buyer" name="buyer" class="select2"><small>(required)</small>
                                    </select>
                                    <textarea class="form-control" name="buyer_address" id="buyer_address" cols="20" rows="3"></textarea>
                                    <label class="control-label">HS CODE:</label>
                                    <input type="text" class="form-control" name="hs_code" id="hs_code" placeholder="HS CODE" required="">
                                </div>
                          
                                <div class="col-md-3 form-group">
                                    <label class="control-label">Invoice No:</label>
                                    <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Invoice No" required="">
                                    <label class="control-label">Date:</label>
                                    <input type="text" class="form-control" name="date_captured" id="date_captured" placeholder="Date" required="">
                                    <label class="control-label">Buyer's Contract No:</label>
                                    <input type="text" class="form-control" name="buyer_contract_no" id="buyer_contract_no" placeholder="Buyer's Contract No" required="">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="control-label">Container no:</label>
                                    <input id="container_no" type="text" class="form-control" name="container_no" placeholder="Container No" required="">
                                    <label class="control-label">Shipping Marks:</label>
                                    <input type="text" class="form-control" name="shipping_marks" id="shipping_marks" placeholder="shipping marks" required="">
                                    <label class="control-label">BL No:</label>
                                    <input type="text" class="form-control" name="bl_no" id="bl_no" placeholder="BL NO" required="">
                               
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="control-label">Bank:</label>
                                    <select id="bank_id" name="bank_id" class="select2"><small>(required)</small>
                                    </select>
                                    <label class="control-label" for="pay_bank">Our Bank Detail:</label>
                                    <textarea class="form-control" name="pay_bank" id="pay_bank" cols="20" rows="6"></textarea>
                                </div>
                       
                            </div>
                  
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="port_of_delivery">Port Of
                                        Discharge:</label>
                                    <textarea class="form-control" name="port_of_delivery" id="port_of_delivery" cols="20" rows="3"></textarea>
                                    <label class="control-label" for="description_of_goods">Description of Goods:</label>
                                    <textarea class="form-control" name="good_description" id="good_description" cols="20" rows="3"></textarea>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="final_destination">Final
                                        Destination:</label>
                                    <textarea class="form-control" name="final_destination" id="final_destination" cols="20" rows="3"></textarea>
                                    <label class="control-label" for="other_reference">Other
                                        reference:</label>
                                    <textarea class="form-control" name="other_references" id="other_references" cols="20" rows="3"></textarea>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="consignee">Consignee:</label>
                                    <textarea class="form-control" name="consignee" id="consignee" cols="20" rows="3"></textarea>
                                    <label class="control-label" for="buyer_bank">Buyer
                                        Bank:</label>
                                    <textarea class="form-control" name="buyer_bank" id="buyer_bank" cols="20" rows="3"></textarea>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="pay_details">
                                        Terms of Delivery and Payment:</label>
                                    <textarea class="form-control" name="pay_details" id="pay_details" cols="20" rows="3"></textarea>
                                    <input type="hidden" class="form-control" id="invoice_category" name="invoice_category" placeholder="Invoice No" value="straight">

                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-3 form-group float-right">
                                    <button id="saveBtn" type="submit" class="btn btn-success btn-sm" id="submit">Save</button>
                                </div>
                            </div>
                            
                        </div>
                        <input type="button" id="page1Btn" name="next" class="next action-button" value="Next" />

                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Add Blend Lines For this Proforma:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 2 - 3</h2>
                                </div>
                            </div>
                            <div class ="col-md-12 p-3">
                                <div id="invoiceTeaList">
                                    <span>Loading....</span>
                                </div>
                            </div>

                        </div>
                        <input type="button" id="Preview" name="next" class="next action-button" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-6">
                                    <h2 class="fs-title">Print:</h2>
                                </div>
                                <div class="col-6">
                                    <h2 class="steps">Step 3 - 3</h2>
                                </div>
                            </div> <br><br>
                            <h2 class="purple-text text-center"><strong>Preview And Print Invoice</strong></h2> <br>
                            <div class="row justify-content-center text-center">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fa fa-print" id="viewInvoice">Print</i>
                                    </div>
                                    <div class="card-body">
                                        <div id="invoicePreview"></div>
                                    </div>
                                    <div class="card-header">

                                    </div>
                                    
                                </div>
                            </div> 
                            <br><br>
                            <div class="row justify-content-center">
                                <div id="finalSubmit" class="col-7 text-center">
                                </div>
                            </div>
                        </div>
                        <input type="button"  name="next" class="next action-button" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />

                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-6">
                                    <h2 class="fs-title">Finish:</h2>
                                </div>
                                <div class="col-6">
                                    <h2 class="steps">Step 4 - 4</h2>
                                </div>
                            </div> <br><br>
                            <h2 class="purple-text text-center"><strong>Submit Invoice</strong></h2> <br>
                            <div class="row justify-content-center text-center">
                                <div class="card">
                                    <div class="card-header">
                                    </div>
                                    <div class="card-body text-center">
                                        <button class="btn btn-secondary" id="invoiceSubmit">Submit Invoice</button>
                                    </div>
                                    <div class="card-header">

                                    </div>
                                    
                                </div>
                            </div> 
                            <br><br>
                            <div class="row justify-content-center">
                                <div id="finalSubmit" class="col-7 text-center">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $path_to_root ?>assets/js/vendors/jquery-3.2.1.min.js"></script>
<script id="url" data-name="../../../ajax/common.php" src="../../../assets/js/common.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="<?php echo $path_to_root ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo $path_to_root ?>assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo $path_to_root ?>assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>


<script src="<?php echo $path_to_root ?>assets/plugins/datatable/dataTables.buttons.min.js"></script>
<script src="<?php echo $path_to_root ?>assets/plugins/datatable/jszip.min.js"></script>
<script src="<?php echo $path_to_root ?>assets/plugins/datatable/pdfmake.min.js"></script>
<script src="<?php echo $path_to_root ?>assets/plugins/datatable/vfs_fonts.js"></script>
<script src="<?php echo $path_to_root ?>assets/plugins/datatable/buttons.html5.min.js"></script>
<script src="<?php echo $path_to_root ?>assets/plugins/datatable/buttons.print.min.js"></script>

<script>
    $("#invoiceSubmit").click(function(e){
        e.preventDefault();
        $.ajax({
                type: "POST",
                data: {
                    action: "submit-invoice",
                    invoice:localStorage.getItem("invoiceno")
                    
                },
                cache: true,
                url: "../finance_action.php",
                success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: "Invoice Submitted Successfully",
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
            });
    });
    $("body").on("blur",".updateableText", function(e){
            var value = $(this).val();
            var name =  $(this).attr("name");
                $.ajax({
                type: "POST",
                data: {
                    action: "update-blend-value",
                    value:value,
                    id:$(this).parent().parent().attr("id"),
                    name: name
                },
                cache: true,
                url: "../finance_action.php",
                success: function (data) {

                }
            });
        });
    $(document).ready(function() {
        $('.select2').select2();

        $("#page1Btn").hide();

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        var current = 1;
        var steps = $("fieldset").length;

        setProgressBar(current);
        loadTemplates();

        $("body").on("blur",".updateableText", function(e){
            alert("changed");
        });


        $("#loadTeas").click(function(e){
            loadInvoiceTeas();
        })

        $(".next").click(function() {

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(++current);
        });
        $(".previous").click(function() {

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(--current);
        });
        $("body").on("blur",".updateable", function(e){
            if((name=="total_net") || name=="p_cif_rate"){
                $(this).attr("p_amount").text(Number($(this).attr("total_net")) * Number($(this).attr("p_cif_rate")));
            }

            var value = $(this).text();
            var name =  $(this).attr("name");
            $.ajax({
            type: "POST",
            data: {
                action: "update-blend-value",
                value:value,
                id:$(this).parent().attr("id"),
                name: name
            },
            cache: true,
            url: "../finance_action.php",
            success: function (data) {

            }
        });    
        function setProgressBar(curStep) {
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
                .css("width", percent + "%")
        }
        $("#saveBtn").click(function(e) {
            if ($("#formData")[0].checkValidity()) {
                e.preventDefault();
                localStorage.setItem("invoiceno", $("#invoice_no").val());
                $.ajax({
                    url: "../finance_action.php",
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
                            $("#saveBtn").hide();
                            $("#page1Btn").show();
        
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
        $("#buyer").change(function(e){
            var address = $(this).children(":selected").attr("name");
            $("#buyer_address").val(address);
        });
        $("#bank_id").change(function(e){
            var bank_address = $(this).children(":selected").attr("name");
            $("#pay_bank").val(bank_address);
        });
        $("#submitUpdate").click(function(e) {
            if ($("#EditformData")[0].checkValidity()) {
                e.preventDefault();
                $.ajax({
                    url: "../finance_action.php",
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
        $("body").on("click", ".removeTea", function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
                url: "../finance_action.php",
                type: "POST",
                data: {
                    action: "remove-invoice-tea",
                    id: id,
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Tea Removed',
                    });
                    loadInvoiceTeas();
                }
            });
        });
        $("#submitPI").click(function(e){
            $("#finalSubmit").html('<h5 class="purple-text text-center">You Have Successfully Created Invoice</h5>'+localStorage.getItem("invoiceno"));
            setTimeout(function() {
                location.reload();
                }, 3000);
            })

        });
        $('#proforma_template').change(function(e) {
            var id = $('#proforma_template').val();
            $.ajax({
                url: "../finance_action.php",
                type: "POST",
                dataType: "json",
                data: {
                    action: "edit-si-invoice",
                    id: id
                },
                success: function(data) {
                    for (const [key, value] of Object.entries(data[0])) {
                        $('#' + key).val(value);
                    }


                }

            });
        });
        $("body").on("click", ".deleteBtn", function(e) {
            e.preventDefault();
            var deleteId = $(this).attr('id');
            $.ajax({
                url: "../finance_action.php",
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
        $("body").on("blur", ".profoma_amount", function(e){
            var id = $(this).attr('id');
            var value = $(this).text();
            $.ajax({
            type: "POST",
            data: {
                action: "update-invoice-value",
                value:value,
                id:id
            },
            cache: true,
            url: "finance_action.php",
            success: function (data) {

            }
        });
        });
        $("body").on("click", "#add", function(e) {
            e.preventDefault();
            $.ajax({
            type: "POST",
            data: {
                action: "add-line",
                id: localStorage.getItem("invoiceno")

            },
            dataType:"html",
            url: "../finance_action.php",
            success: function (data) {
                loadInvoiceTeas();
            }
        })
        });
        $("body").on("click", ".remove", function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                $.ajax({
                type: "POST",
                data: {
                    action: "remove-line",
                    id: id  
                },
                dataType:"html",
                url: "../finance_action.php",
                success: function (data) {
                    loadInvoiceTeas();
                }
            });
        });
        $("#submitPI").click(function(e){
            $("#finalSubmit").html('<h5 class="purple-text text-center">You Have Successfully Created Invoice</h5>'+localStorage.getItem("invoiceno"));
            setTimeout(function() {
                location.reload();
                }, 3000);
        });
        function loadInvoiceTeas(){
            $.ajax({
                type: "POST",
                dataType:"html",
                data: {
                    action: "load-invoice-teas-blend",
                    invoice: localStorage.getItem("invoiceno")
                },
                cache: true,
                url: "../finance_action.php",
                success: function (data) {
                    $("#invoiceTeaList").show();
                    $('#invoiceTeaList').html(data);
                    $('#added_lots').DataTable({
                        "pageLength": 10,
                        dom: 'Bfrtip'
                    });

                }
            });

         }

    });

</script>

<script>
    $(document).ready(function() {
        $("#page1Btn").hide();
        $("#invoicePreview").html('<iframe class="frame" frameBorder="0" src="../../../reports/invoice_proforma_blend.php?invoiceno='+localStorage.getItem("invoiceno")+'" width="1000px" height="800px"></iframe>');

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        var current = 1;
        var steps = $("fieldset").length;

        setProgressBar(current);
        loadTemplates();
        loadInvoiceTeas();
        $("#Preview").click(function(e){ 
            $("#invoicePreview").html('<iframe class="frame" frameBorder="0" src="../../../reports/invoice_proforma_blend.php?invoiceno='+localStorage.getItem("invoiceno")+'" width="1000px" height="800px"></iframe>');
        });
        $(".next").click(function() {

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(++current);
        });

        $(".previous").click(function() {

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(--current);
        });
        function setProgressBar(curStep) {
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
                .css("width", percent + "%")
        }
        $("#saveBtn").click(function(e) {
        if ($("#formData")[0].checkValidity()) {
            e.preventDefault();
            localStorage.setItem("invoiceno", $("#invoice_no").val());
            $.ajax({
                url: "../finance_action.php",
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
                        $("#saveBtn").hide();
                        $("#page1Btn").show();
       
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
    $("body").on("blur",".updateable", function(e){
        if((name=="total_net") || name=="p_cif_rate"){
            $(this).attr("p_amount").text(Number($(this).attr("total_net")) * Number($(this).attr("p_cif_rate")));
        }

        var value = $(this).text();
        var name =  $(this).attr("name");
        $.ajax({
        type: "POST",
        data: {
            action: "update-blend-value",
            value:value,
            id:$(this).parent().attr("id"),
            name: name
        },
        cache: true,
        url: "../finance_action.php",
        success: function (data) {

        }
    })

    });
    $("#submitUpdate").click(function(e) {
        if ($("#EditformData")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: "../finance_action.php",
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
    $("body").on("click", ".removeTea", function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        $.ajax({
            url: "../finance_action.php",
            type: "POST",
            data: {
                action: "remove-invoice-tea",
                id: id,
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Tea Removed',
                });
                loadInvoiceTeas();
            }
        });
    });
    $("body").on("click", ".addTea", function(e) {
        e.preventDefault();
        var stockid = $(this).attr('id');
        $(this).parent().text(localStorage.getItem("invoiceno"));

        $.ajax({
            url: "../finance_action.php",
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
            url: "../finance_action.php",
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
    $("body").on("blur", ".profoma_amount", function(e){
        var id = $(this).attr('id');
        var value = $(this).text();
        $.ajax({
        type: "POST",
        data: {
            action: "update-invoice-value",
            value:value,
            id:id
        },
        cache: true,
        url: "finance_action.php",
        success: function (data) {

        }
    });
    });
    $("body").on("click", "#add", function(e) {
        e.preventDefault();
        $.ajax({
        type: "POST",
        data: {
            action: "add-line",
            id: localStorage.getItem("invoiceno")

        },
        dataType:"html",
        url: "../finance_action.php",
        success: function (data) {
            loadInvoiceTeas();
        }
    })
    });
    $("body").on("click", ".remove", function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
            type: "POST",
            data: {
                action: "remove-line",
                id: id  
            },
            dataType:"html",
            url: "../finance_action.php",
            success: function (data) {
                loadInvoiceTeas();
            }
        });
    });
    $("#submitPI").click(function(e){
        $("#finalSubmit").html('<h5 class="purple-text text-center">You Have Successfully Created Invoice</h5>'+localStorage.getItem("invoiceno"));
        setTimeout(function() {
               location.reload();
               }, 3000);
    });
    });
    $('#proforma_template').change(function(e) {
                var id = $('#proforma_template').val();
                $.ajax({
                    url: "../finance_action.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: "edit-si-invoice",
                        id: id
                    },
                    success: function(data) {
                        for (const [key, value] of Object.entries(data[0])) {
                            $('#' + key).val(value);
                        }


                    }

                });
            });


function loadTemplates(){
    $.ajax({
        type: "POST",
        data: {
            action: "proforma_templates"
        },
        dataType:"html",
        url: "../finance_action.php",
        success: function (data) {
            $('#proforma_template').html(data);
        }
    });
    
}
function loadInvoiceTeas(){
    $.ajax({
        type: "POST",
        dataType:"html",
        data: {
            action: "load-invoice-teas-blend",
            invoice: localStorage.getItem("invoiceno")
        },
        cache: true,
        url: "../finance_action.php",
        success: function (data) {
            $("#invoiceTeaList").show();
            $('#invoiceTeaList').html(data);
            $('#added_lots').DataTable({
                "pageLength": 10,
                dom: 'Bfrtip'
            });

        }
    });

}

</script>