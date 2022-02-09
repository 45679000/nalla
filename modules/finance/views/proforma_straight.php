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
        margin-bottom: 1px;
        margin-top: 2px;
        width: 100%;
        box-sizing: border-box;
        font-family: montserrat;
        color: #2C3E50;
        background-color: #ECEFF1;
        font-size: 16px;
        letter-spacing: 1px
    }
    #msform label{
        font-size: 1rem !important;
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
</style>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-12 text-center">
            <div class="card px-4 pt-4 pb-0 mt-3 mb-3 p-4 mt-3 mb-2">
                <h2 id="heading">Create Profoma Invoice Straight Line</h2>
                <p>Fill all form field to go to next step</p>
                <form id="msform" class="p-1">
                   
                    <br> <!-- fieldsets -->
                    <fieldset id="formData">
                        <div class="form-card">
                            <div class="row" style="display: flex; justify-content:space-between;">
                                <div>
                                    <h2 class="fs-title">Invoice Details: <span id="invoiceNumbe"></span></h2>
                                </div>
                                <div>
                                    <div id="selectTeas"><a href="#selectTeasDiv" class="btn btn-success">Select your teas</a></div>
                                </div>
                                <div>
                                    <div id="selectTeas"><a href="#viewTeasDiv" class="btn btn-success">View and Edit Teas you have selected</a></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Load From a Template</label>
                                    <select id="proforma_template" name="proforma_template"><small>(required)</small>
                                        
                                    </select>
                                </div>

                            </div>
                            <div style="display: flex; width: 100%;">
                                <div style="width: 40%;">
                                    <div class="" style="display: flex; width: 100%; justify-content: space-evenly;">
                                        <div class="form-group">
                                            <label class="control-label">Buyer:</label>
                                            <select id="buyer" name="buyer" class="select2"><small>(required)</small>
                                            </select>
                                            <textarea class="form-control" name="buyer_address" id="buyer_address" cols="20" rows="3"></textarea>
                                            <label class="control-label">HS CODE:</label>
                                            <input type="text" class="form-control" name="hs_code" id="hs_code" placeholder="HS CODE" required="">
                                        </div>
                                
                                        <div class="form-group">
                                            <label class="control-label">Invoice No:</label>
                                            <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Invoice No" required="">
                                            <label class="control-label">Date:</label>
                                            <input type="text" class="form-control" name="date_captured" id="date_captured" placeholder="Date" required="">
                                            <label class="control-label">Buyer's Contract No:</label>
                                            <input type="text" class="form-control" name="buyer_contract_no" id="buyer_contract_no" placeholder="Buyer's Contract No" required="">
                                        </div>
                                    </div>
                                    <div class="" style="display: flex; width: 100%; justify-content: space-evenly;">
                                        <div class="form-group">
                                            <label class="control-label">Container no:</label>
                                            <input id="container_no" type="text" class="form-control" name="container_no" placeholder="Container No" required="">
                                            <label class="control-label">Shipping Marks:</label>
                                            <input type="text" class="form-control" name="shipping_marks" id="shipping_marks" placeholder="shipping marks" required="">
                                            <label class="control-label">BL No:</label>
                                            <input type="text" class="form-control" name="bl_no" id="bl_no" placeholder="BL NO" required="">
                                    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Bank:</label>
                                            <select id="bank_id" name="bank_id" class="select2"><small>(required)</small>
                                            </select>
                                            <label class="control-label" for="pay_bank">Our Bank Detail:</label>
                                            <textarea class="form-control" name="pay_bank" id="pay_bank" cols="20" rows="6"></textarea>
                                        </div>                           
                                    </div>
                        
                                    <div class="" style="display: flex; width: 100%; justify-content: space-evenly;">
                                        <div class="form-group">
                                            <label class="control-label" for="port_of_delivery">Port Of
                                                Discharge:</label>
                                            <textarea class="form-control" name="port_of_delivery" id="port_of_delivery" cols="20" rows="3"></textarea>
                                            <label class="control-label" for="description_of_goods">Description of Goods:</label>
                                            <textarea class="form-control" name="good_description" id="good_description" cols="20" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="final_destination">Final
                                                Destination:</label>
                                            <textarea class="form-control" name="final_destination" id="final_destination" cols="20" rows="3"></textarea>
                                            <label class="control-label" for="other_reference">Other
                                                reference:</label>
                                            <textarea class="form-control" name="other_references" id="other_references" cols="20" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="" style="display: flex; width: 100%; justify-content: space-evenly;">
                                        <div class="form-group">
                                            <label class="control-label" for="consignee">Consignee:</label>
                                            <textarea class="form-control" name="consignee" id="consignee" cols="20" rows="3"></textarea>
                                            <label class="control-label" for="buyer_bank">Buyer
                                                Bank:</label>
                                            <textarea class="form-control" name="buyer_bank" id="buyer_bank" cols="20" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="pay_details">
                                                Terms of Delivery and Payment:</label>
                                            <textarea class="form-control" name="pay_details" id="pay_details" cols="20" rows="3"></textarea>
                                            <input type="hidden" class="form-control" id="invoice_category" name="invoice_category" placeholder="Invoice No" value="straight">

                                        </div>
                                    </div>
                                    <div class="" style="display: flex; width: 100%; justify-content: space-evenly;">
                                        <div class="form-group float-right">
                                            <button id="saveBtn" type="submit" class="btn btn-success btn-lg" id="submit">Save</button>
                                        </div>
                                    </div>
                                    </div>
                                <div class="card-body" style="width: 50%;">
                                    <button id="reloadPreview" class="btn btn-primary-lg">Refresh pdf</button>
                                    <p>Showing invoice of whose Invoice No. is: <span id="showInvoiceNo" class="text-secondary"></span></p>
                                    <div id="invoicePreview"></div>
                                </div>
                            </div>
                            <div><p class="text-danger" style="font-size: 1.5rem; margin: 0.5rem 0; text-align:center;">*Make sure to save data you have inputed above before you proceed to Select your teas</p></div>
                        </div>
                        <div class="form-card" id="selectTeasDiv">
                            <div class="row">
                                <div>
                                    <h2 class="fs-title">Select Teas For This Profoma: <span id="invoiceNumb"></span></h2>
                                </div>
                            </div>
                            <div class ="col-md-8 p-3">
                                <div id="stocklist">
                                    <span>Loading....</span>
                                </div>
                            </div>

                        </div>
                        <div class="form-card" id="viewTeasDiv">
                            <div class="row">
                                <div class="">
                                    <h2 class="fs-title">Invoice Teas: <span id="invoiceNumber"></span></h2>
                                </div>
                            </div>
                            <div class ="col-md-8 p-3">
                                <button id="loadTeas" class="btn btn-danger">Load teas</button>
                                <div id="invoiceTeaList">
                                    <span>Loading....</span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="splitModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Split Lot</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="splitLot">
                    <div class="row">
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Lot</label>
                                <input disabled id="elot"></input>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Mark</label>
                                <input disabled id="emark"></input>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Invoice</label>
                                <input disabled id="invoice"></input>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Current Allocation==></label>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Pkgs</label>
                                <input id="pkgs"></input>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Net</label>
                                <input id="net" disabled></input>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Kgs</label>
                                <input id="kgs"></input>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Enter Packages to split==></label>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Pkgs</label>
                                <input type="number" step="5" min="5" id="newpkgs"></input>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Net</label>
                                <input id="newnet" disabled></input>
                            </div>
                        </div>
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Kgs</label>
                                <input type="number" min="5" id="newkgs"></input>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-3 form-group float-right">
                    <button type="submit" class="btn btn-success btn-sm" id="saveSplit">Save</button>
                </div>
                <div class="col-md-3 form-group float-right">
                    <button type="button" class="btn btn-danger btn-sm" id="closeModal">Close</button>
                </div>
                <input hidden id="stock_id"></input>

            </div>
            </form>
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
    document.getElementById('invoiceNumber').innerHTML = localStorage.getItem("invoiceno")
    document.getElementById('invoiceNumbe').innerHTML = localStorage.getItem("invoiceno")
    document.getElementById('invoiceNumb').innerHTML = localStorage.getItem("invoiceno")
    let loadPreview = (invoiceNum) =>{
        $("#invoicePreview").html(`<p class="text-danger">Click refresh pdf button before you download it</p><a href="../../../reports/TCPDF/files/profomaInvoiceStraight.php?invoiceNo=${invoiceNum}" class="btn btn-danger">Download</a><iframe class="frame" frameBorder="0" src="../../../reports/TCPDF/files/profomaInvoiceStraight.php?invoiceNo=${invoiceNum}" width="1000px" height="800px"></iframe>`);
    }
    let reloadPreview = document.getElementById('reloadPreview');
    let showInvoiceNo = document.getElementById('showInvoiceNo')
    reloadPreview.addEventListener('click', (e)=>{
        e.preventDefault()
        loadPreview(localStorage.getItem("invoiceno"))
        showInvoiceNo.innerText = localStorage.getItem("invoiceno")
    })
    $("#stocklist").show();
    $(document).ready(function() {
        $('.select2').select2();
        let invoiceNum = localStorage.getItem("invoiceno")
        $("#page1Btn").hide();
        loadPreview()
        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        var current = 1;
        var steps = $("fieldset").length;

        setProgressBar(current);
        loadTemplates();
        loadStock("", "", "", "");
        $("#loadTeas").click(function(e){
            e.preventDefault()
            loadInvoiceTeas();
        })
        $("#viewInvoice").click(function(e){
            e.preventDefault();
            $("#invoicePreview").html('<iframe class="frame" frameBorder="0" src="../../../reports/invoice_profoma_straight.php?invoiceno='+localStorage.getItem("invoiceno")+'" width="1000px" height="800px"></iframe>');
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
            document.getElementById('invoiceNumber').innerHTML = localStorage.getItem("invoiceno")
            document.getElementById('invoiceNumbe').innerHTML = localStorage.getItem("invoiceno")
            document.getElementById('invoiceNumb').innerHTML = localStorage.getItem("invoiceno")
            $.ajax({
                url: "../finance_action.php",
                type: "POST",
                data: $("#formData").serialize() + "&action=save-invoice",
                dataType: "json",
                success: function(response) {
                    console.log(response);
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
                        loadPreview(localStorage.getItem("invoiceno"))
                        document.getElementById('invoiceNumber').innerHTML = localStorage.getItem("invoiceno")
                        document.getElementById('invoiceNumbe').innerHTML = localStorage.getItem("invoiceno")
                        document.getElementById('invoiceNumb').innerHTML = localStorage.getItem("invoiceno")
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
                    alert("response= "+response.responseText);
                    // $("#invoicePreview").html('<iframe class="frame" frameBorder="0" src="../../../reports/invoice_profoma_straight.php?invoiceno='+localStorage.getItem("invoiceno")+'" width="1000px" height="800px"></iframe>');
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
            // remove-invoice-tea
            data: {
                action: "remove-invoice",
                id: id,
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Tea Removed',
                });
                loadPreview(localStorage.getItem("invoiceno"))
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
                console.log(response)
                Swal.fire({
                    icon: 'success',
                    title: 'Tea Added',
                });
                // console.log(stockid);
                loadInvoiceTeas()
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
    $("body").on("click", ".splitLot", function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        splitLot(id);
    });

    $("body").on("blur", ".profoma_amount", function(e){
        var id = $(this).parent().attr('id');
        var value = $(this).text();
        var fieldName = $(this).attr('class'); 
        $.ajax({
        type: "POST",
        data: {
            action: "update-invoice-value",
            value:value,
            id:id,
            fieldName:fieldName
        },
        cache: true,
        url: "../finance_action.php",
        success: function (data) {
            loadPreview(localStorage.getItem("invoiceno"))
        }
    });
    });
    $('#saveSplit').click(function(e) {
        e.preventDefault();
        var stockId = $('#stock_id').val();
        var Pkgs = $('#pkgs').val();
        var Kgs = $('#kgs').val();
        var NewKgs = $('#newkgs').val();
        var NewPkgs = $('#newpkgs').val();
        if ((stockId != null) && (Pkgs != null) && (Kgs != null) && (NewKgs != null) && (NewPkgs !=
                null)) {
            insertSplit(stockId, Pkgs, Kgs, NewKgs, NewPkgs);
        } else {
            alert("You Must Enter packages to split");
        }
    });
    $("#invoicenocreated").click(function(e){
        e.preventDefault();
        loadUnallocated("", "", "", "");
    });
    $('#mark').change(function(e) {
        var mark = $('#mark').val();
        var grade = $('#grade').val();
        var lot = $('#lot').val();
        var saleno = $('#saleno').val();
        loadUnallocated(mark, lot, grade, saleno);
    });
    $('#grade').change(function(e) {
        var mark = $('#mark').val();
        var grade = $('#grade').val();
        var lot = $('#lot').val();
        var saleno = $('#saleno').val();
        loadUnallocated(mark, lot, grade, saleno);
    });
    $('#lot').focusout(function(e) {
        var mark = $('#mark').val();
        var grade = $('#grade').val();
        var lot = $('#lot').val();
        var saleno = $('#saleno').val();
        loadUnallocated(mark, lot, grade, saleno);
    });
    $('#closeModal').click(function(e) {
        $('#splitModal').hide();
    });
    $('#newpkgs').change(function(e) {
        var lotPkgs = localStorage.getItem("lotPkgs");
        var newPkgs = $('#newpkgs').val();
        var previousPkgs = lotPkgs;
        var previousKgs = $('#kgs').val();
        var net = $('#net').val();
        if(previousPkgs>=0){
            $('#pkgs').val(previousPkgs - newPkgs);
            $('#kgs').val((previousPkgs - newPkgs) * net);
            $('#newkgs').val(previousKgs - ((previousPkgs - newPkgs) * net));
        }else{
            alert("Lot cannot be splitted to zero");
        }     
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
        let invNo
        $.ajax({
            url: "../finance_action.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "edit-si-invoice",
                id: id
            },
            success: function(data) {
                invNo = data[0].invoice_no
                loadPreview(invNo)
                for (const [key, value] of Object.entries(data[0])) {
                    $('#' + key).val(value);
                    
                }
                

            }

        });
    });

function loadStock(mark, lot, grade, saleno) {
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
        url: "../finance_action.php",
        success: function (data) {
            $("#stocklist").show();
            $('#stocklist').html(data);
            $('#direct_lot').DataTable({
                "pageLength": 10,
                dom: 'Bfrtip'
            });

        }
    });
}
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
function splitLot(id) {
    $('#splitModal').show();
    $('#newpkgs').val(0);
    $('#newkgs').val(0);

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "../../stock/stock-action.php",
        data: {
            action: "getlot",
            id: id
        },
        success: function(data) {
            var lots = data[0];
            $('#pkgs').val(lots.pkgs);
            $('#kgs').val(lots.kgs);
            $('#elot').val(lots.lot);
            $('#net').val(lots.net);
            $('#emark').val(lots.mark);
            $('#invoice').val(lots.invoice);
            $('#newnet').val(lots.net);
            $('#stock_id').val(lots.stock_id);
            $("#newpkgs").attr({"max" : lots.pkgs});
            localStorage.setItem("lotPkgs", lots.pkgs);

        },
        error: function(data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}

function insertSplit(stockId, Pkgs, Kgs, NewKgs, NewPkgs) {
    $.ajax({
        type: "POST",
        dataType: "html",
        url: '../../stock/stock-action.php',
        data: {
            action: 'split',
            stockId: stockId,
            Pkgs: Pkgs,
            Kgs: Kgs,
            NewKgs: NewKgs,
            NewPkgs: NewPkgs
        },
        success: function(data) {
            Swal.fire({
                icon: 'success',
                title: 'Lot Splitted Successfully',
            });
            $('#splitModal').trigger("reset");
            $("#splitModal").hide();
            loadUnallocated("", "", "", "");

        }
    });
}
function loadInvoiceTeas(){
    $.ajax({
        type: "POST",
        dataType:"html",
        data: {
            action: "load-invoice-teas",
            invoice: localStorage.getItem("invoiceno")
        },
        // cache: true,
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
// function getBuyerAddress(id){

// }

</script>