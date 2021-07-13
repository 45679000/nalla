<?php
echo '

<div style="text-align:center;";>
    <form method="post">
        <div class="form-group label-floating">
            <label class="control-label">LOAD FROM A TEMPLATE</label>
            <select id="si-templates" class="template" name="template" class="form-control"><small>(required)</small>
            </select>
        </div>
    </form>
</div>';

print '
<div  class="card-body" style="height:40% !important;">';
$form->beginForm("si_form");

print ' <div class="row">
        <div class="col-md-3 col-md-3">';
$form->formField("dropdownlist", "shippment_type", "", "Shippment Type", array("Blend Shippment" => "Blend Shippment", "Straight Line" => "Straight Line"));
$form->formField("text", "contract_no", "", "Contract No");
$form->formField("text-area", "buyer", "", "Buyer");
$form->formField("text", "si_date", "", "Shipping Date");
$form->formField("text", "target_vessel", "", "Target Vessel");
$form->formField("text", "no_containers_type", "", "No of Containers Type");
$form->formField("text", "pkgs_shipped", "", "Packages Shipped");
$form->formField("text", "packing_materials", "", "Packing Materials");
$form->formField("text", "shipping_marks", "", "Shipping Marks");

print '</div>
        <div class="col-md-3 col-md-3">';
$form->formField("text", "tea_standard_no", "", "Tea Standard No.");
$form->formField("text", "grade_type_of_tea", "", "Grade Type of Tea");
$form->formField("text", "type_of_loading", "", "Type of Loading");
$form->formField("text", "each_net_per_package", "", "Each Net Per Package");
$form->formField("text", "each_gross_per_package", "", "Each Gross Per Package");
$form->formField("text", "ware_hse", "", "Warehouse");
$form->formField("text", "consignment_value", "", "Consignment value");
$form->formField("text", "total_net_weight_per_container", "", "Total Net Weight Per container");
$form->formField("text-area", "additional_instructions", "", "Additional Instructions");

print '</div>
        <div class="col-md-3 col-md-3">';
$form->formField("text", "total_gross_weight_per_container", "", "Total Gross Weight Per container");
$form->formField("text", "destination_total_place_of_delivery", "", "Destination/Place of delivery");
$form->formField("text", "lc_no", "", "Lc No");
$form->formField("text", "date_of_issue", "", "Date of Issue");
$form->formField("text", "negotiating_bank", "", "Negotiating Bank");
$form->formField("text", "marine_insuarance", "", "Marine Insuarance");
$form->formField("text", "qa_inspection", "", "Qa and Inspection");
$form->formField("text", "production_date", "", "Production Date");
$form->formField("text-area", "notify_party", "", "Notify Party");

print '</div>
        <div class="col-md-3 col-md-3">';
$form->formField("text", "expiry_date", "", "Expiry Date");
$form->formField("text-area", "consignee", "", "Consignee");
$form->formField("text-area", "note", "", "Note");
$form->formField("text-area", "shipper", "", "Shipper");
$form->formField("text-area", "2nd_notify_party", "", "2nd Notify Party");
print '</div>';
$form->addButtons('add');
print '
    </div>';
$form->endForm();
print '</div>
';
$sino=1;
?>

<div id="nextid">
    <a id="next" href=""  class="next">Next</a>
</div>
<script src="<?php echo $path_to_root ?>assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="shipping.js"></script>

<script>
    $(document).ready(function() {
        siTemplate();
        editData();
        addSi();
        $('#nextid').hide();
        localStorage.getItem("siId");

    });
</script>
