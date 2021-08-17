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
<div  class="card-body" style="height:100% !important;">';
$form->beginForm("invoice");

print ' <div class="row">
        <div class="col-md-6 col-md-6">';
$form->formField("dropdownlist", "invoice_category", "", "Category", array("Blend" => "Blend", "straight" => "Straight Line"));
$form->formField("text", "invoice_no", "", "Invoice No");
$form->formField("dropdownlist", "buyerid", "", "Select Buyer", '');
$form->formField("text-area", "buyer", "", "Buyer");



print '</div>
        <div class="col-md-6 col-md-6">';
        $form->formField("text", "payment_terms", "", "Pay Terms");
        $form->formField("text", "port_of_delivery", "", "Port of Delivery");
        $form->formField("text", "pay_bank", "", "Bank Details");
        $form->formField("text-area", "consignee", "", "Consignee");


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
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="shipping.js"></script>

<script>
    $(document).ready(function(){
        $('#invoice').submit(function(e){
            e.preventDefault();
            $("<input/>").attr("type", "hidden")
                .attr("name", "action")
                .attr("value", "save-invoice")
                .appendTo("#invoice");
            $.ajax({   
                type: "POST",
                data : $(this).serialize(),
                dataType: "json", 
                url: "finance_action.php",   
                success: function(data){
                    
                
                }   
            });   
        });
    });
</script>