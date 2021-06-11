<?php
echo '
<div style="text-align:center;";>
    <button data-toggle="modal" data-target="loadPreviousSi" type="button" 
    style="width:60%; height:30px; font-size:15px; text-align:center; padding:0px; margin:auto;" class="btn btn-success">Copy From A previous SI</button>
</div>';
$form->beginForm("si_form");
$form->formMessage("Saved");
print '

<div class="card-body">

    <div class="row">
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
        $form->addButtons('step1');
        print '
    </div>
</div>
</div>';
$form->endForm();
 

?>

<!-- Edit Record  Modal -->
<div class="modal" id="loadPreviousSi">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Broker</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="EditformData">
                    <input type="hidden" name="id" id="edit-form-id">
                    <div class="form-group">
                        <label for="code">Code:</label>
                        <input type="text" class="form-control" name="code" id="code" placeholder="Enter code" required="">
                    </div>
                    <div class="form-group">
                        <label for="name">Broker Name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Broker Name" required="">
                    </div>
           
                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-primary" id="update">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script src="<?php echo $path_to_root ?>assets/js/vendors/jquery-3.2.1.min.js"></script>

<script>
$(document).ready(function() {

    $("#loadPreviousSi").click(function(){
    alert("Clicked");
});
    
});
</script>
    