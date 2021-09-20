<div class="card" style="margin-top:20px;">
<div class="card-header">
            <h3 class="card-title">Shipping Process</h3>
        </div>
    <div class="card-header">
        <button id="createSi" class="btn btn-success btn-sm">Create New SI</button>
        <button id="editSi" class="btn btn-danger btn-sm">Edit an Existing SI</button>
        <button id="viewSi" class="btn btn-secondary btn-sm">View Created SI</button>
        <div class="clearfix" id="template-form">
            <span class="pl-4 pt-2 float-left">CREATE FROM TEMPLATE</span>
            <form class="pl-4 float-right" method="post" style="width:300px;">
                <div class="form-group">
                    <select id="si-templates" class="template select2" name="template">
                        <option disabled="" value="..." selected="">select</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body p-6">
        <div class="card-body" style="height:40% !important;">
            <form method="post" id="si_form" class="card-body">
                <div class="row">
                    <div class="col-md-3 col-md-3">
                        <div class="form-group"><label class="form-label">Shippment Type</label>
                            <select name="shippment_type" id="shippment_type" class="form-control  select2-show-search" data-placeholder="Select)"> Select2 with search box<option value="Blend Shippment">Blend Shippment</option>
                                <option value="Straight Line">Straight Line</option>
                            </select>
                        </div>
                        <div id="contractDiv" class="form-group"><label class="form-label">Contract No</label>
                            <input type="text" class="form-control" id="contract_no" name="contract_no" value="">
                        </div>
                        <div class="form-group"><label class="form-label">Select Buyer</label>
                            <select name="buyerid" id="buyerid" class="form-control  select2" data-placeholder="Select)">
                                <option disabled="" value="..." selected="">select</option>
                            </select>
                        </div>
                        <div class="form-group"><label class="form-label">Buyer</label><textarea type="text-area" class="form-control" rows="5" cols="5" id="buyer" name="buyer" value=""></textarea></div>
                        <div class="form-group"><label class="form-label">Shipping Date</label><input type="text" class="form-control" id="si_date" name="si_date" value=""></div>
                        <div class="form-group"><label class="form-label">Target Vessel</label><input type="text" class="form-control" id="target_vessel" name="target_vessel" value=""></div>
                        <div class="form-group"><label class="form-label">No of Containers Type</label><input type="text" class="form-control" id="no_containers_type" name="no_containers_type" value=""></div>
                        <div class="form-group"><label class="form-label">Packages Shipped</label><input type="text" class="form-control" id="pkgs_shipped" name="pkgs_shipped" value=""></div>
                        <div class="form-group"><label class="form-label">Packing Materials</label><input type="text" class="form-control" id="packing_materials" name="packing_materials" value=""></div>
                        <div class="form-group"><label class="form-label">Shipping Marks</label><input type="text" class="form-control" id="shipping_marks" name="shipping_marks" value=""></div>
                    </div>
                    <div class="col-md-3 col-md-3">
                        <div class="form-group"><label class="form-label">Tea Standard No.</label><input type="text" class="form-control" id="tea_standard_no" name="tea_standard_no" value=""></div>
                        <div class="form-group"><label class="form-label">Grade Type of Tea</label><input type="text" class="form-control" id="grade_type_of_tea" name="grade_type_of_tea" value=""></div>
                        <div class="form-group"><label class="form-label">Type of Loading</label><input type="text" class="form-control" id="type_of_loading" name="type_of_loading" value=""></div>
                        <div class="form-group"><label class="form-label">Each Net Per Package</label><input type="text" class="form-control" id="each_net_per_package" name="each_net_per_package" value=""></div>
                        <div class="form-group"><label class="form-label">Each Gross Per Package</label><input type="text" class="form-control" id="each_gross_per_package" name="each_gross_per_package" value=""></div>
                        <div class="form-group"><label class="form-label">Warehouse</label><input type="text" class="form-control" id="ware_hse" name="ware_hse" value=""></div>
                        <div class="form-group"><label class="form-label">Consignment value</label><input type="text" class="form-control" id="consignment_value" name="consignment_value" value=""></div>
                        <div class="form-group"><label class="form-label">Total Net Weight Per container</label><input type="text" class="form-control" id="total_net_weight_per_container" name="total_net_weight_per_container" value=""></div>
                        <div class="form-group"><label class="form-label">Additional Instructions</label><textarea type="text-area" class="form-control" rows="5" cols="5" id="additional_instructions" name="additional_instructions" value=""></textarea></div>
                    </div>
                    <div class="col-md-3 col-md-3">
                        <div class="form-group"><label class="form-label">Total Gross Weight Per container</label><input type="text" class="form-control" id="total_gross_weight_per_container" name="total_gross_weight_per_container" value=""></div>
                        <div class="form-group"><label class="form-label">Destination/Place of delivery</label><input type="text" class="form-control" id="destination_total_place_of_delivery" name="destination_total_place_of_delivery" value=""></div>
                        <div class="form-group"><label class="form-label">Lc No</label><input type="text" class="form-control" id="lc_no" name="lc_no" value=""></div>
                        <div class="form-group"><label class="form-label">Date of Issue</label><input type="text" class="form-control" id="date_of_issue" name="date_of_issue" value=""></div>
                        <div class="form-group"><label class="form-label">Negotiating Bank</label><textarea type="text-area" class="form-control" rows="5" cols="5" id="negotiating_bank" name="negotiating_bank" value=""></textarea></div>
                        <div class="form-group"><label class="form-label">Marine Insuarance</label><input type="text" class="form-control" id="marine_insuarance" name="marine_insuarance" value=""></div>
                        <div class="form-group"><label class="form-label">Qa and Inspection</label><input type="text" class="form-control" id="qa_inspection" name="qa_inspection" value=""></div>
                        <div class="form-group"><label class="form-label">Production Date</label><input type="text" class="form-control" id="production_date" name="production_date" value=""></div>
                        <div class="form-group"><label class="form-label">Notify Party</label><textarea type="text-area" class="form-control" rows="5" cols="5" id="notify_party" name="notify_party" value=""></textarea></div>
                    </div>
                    <div class="col-md-3 col-md-3">
                        <div class="form-group"><label class="form-label">Expiry Date</label><input type="text" class="form-control" id="expiry_date" name="expiry_date" value=""></div>
                        <div class="form-group"><label class="form-label">Consignee</label><textarea type="text-area" class="form-control" rows="5" cols="5" id="consignee" name="consignee" value=""></textarea></div>
                        <div class="form-group"><label class="form-label">Note</label><textarea type="text-area" class="form-control" rows="5" cols="5" id="note" name="note" value=""></textarea></div>
                        <div class="form-group"><label class="form-label">Shipper</label><textarea type="text-area" class="form-control" rows="5" cols="5" id="shipper" name="shipper" value=""></textarea></div>
                        <div class="form-group"><label class="form-label">2nd Notify Party</label><textarea type="text-area" class="form-control" rows="5" cols="5" id="2nd_notify_party" name="2nd_notify_party" value=""></textarea></div>
                    </div>
                    <div class="text-wrap mt-6">
                        <button type="submit" name="add" class="btn btn-success btn-sm">Save and Continue</button>

                    </div>
                </div>
            </form>
            <div id="si_view" class="row">
                <div class="col-md-2">
                    <div id="sis"></div>
                </div>
                <div class="col-md-10">
                    <div id="display"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="nextid">
    <a id="next" href="" class="next">Next</a>
</div>
<script src="<?php echo $path_to_root ?>assets/js/vendors/jquery-3.2.1.min.js"></script>
<script id="url" data-name="../ajax/common.php" src="../assets/js/common.js"></script>
<script src="../assets/plugins/select2/select2.full.min.js"></script>

<script src="shipping.js"></script>

<script>
    $(document).ready(function() {
        siTemplate();
        editData();
        addSi();
        loadClients();
        $('#nextid').hide();
        $("#template-form").hide();
        localStorage.getItem("siId");
        $("#createSi").click(function(){
            $("#si_view").hide();
            $("#si_form").show();
            $("#template-form").show();
        });
        $("#editSi").click(function(){
            $("#si_view").hide();
            $("#si_form").show();

            var selectCont ='<select id="contract" class="template select2" name="contract_no">';
            selectCont += '<option disabled="" value="..." selected="">select</option>';
            selectCont += '</select>';
            $("#contractDiv").html(selectCont);
            loadContracts();
            contractChange();

        });
        $("#viewSi").click(function(){
            $("#si_form").hide();
            $("#si_view").show();

            viewSis();
        });
        $("body").on("click", ".contractno", function(e) {
            e.preventDefault();
            var sino = $(this).attr("id");
            $('#display').html('<iframe class="frame" frameBorder="0" src="../../reports/shipping_instructions.php?sino='+sino+'" width="100%" height="1500px"></iframe>');
        });


    });
    $('#buyerid').change(function() {
        var address = $('#buyerid').val();
        $('#buyer').val(address);
    })
</script>