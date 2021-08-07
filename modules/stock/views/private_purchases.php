<style>
    .form-control{
        border: 1px solid !important;
        padding-bottom: 5px !important;
        color:black !important;
    }

</style>
<div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body p-6">
                        <div class="col-md-12">
                            <div class="expanel expanel-secondary">
                                <div class="expanel-heading">
                                                <h3 class="expanel-title">Add Private Purchase</h3>
                                            </div>
                                            <div class="expanel-body">
                                            <div class="card-body p-6">
                                                <?= $form->beginForm("prvt_purchase") ?>
                                                    <?= $form->formMessage() ?>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-3 col-md-3">
                                                                <!-- names should match the database columns -->
                                                                    <?= $form->formField("dropdownlist", "sale_no", "", "Auction", loadPrivateAuctionArray()) ?>
                                                                    <?= $form->formField("dropdownlist", "broker", "", "Broker", '') ?>
                                                                    <?= $form->formField("dropdownlist", "category", "", "Sale Type", array("Main"=>"Main", "seco"=>"Secondary")) ?>
                                                                    <?= $form->formField("text", "invoice", "", "Invoice") ?>

                                                                </div>
                                                                <div class="col-md-3 col-md-3">
                                                                    <?= $form->formField("dropdownlist", "mark", "", "Garden", '') ?>
                                                                    <?= $form->formField("text", "lot", "", "Lot No") ?>
                                                                    <?= $form->formField("dropdownlist", "grade", "", "Grade", '') ?>
                                                                    <?= $form->formField("text", "gross", "", "Gross") ?>

                                                                </div>
                                                                <div class="col-md-3 col-md-3">
                                                                    <?= $form->formField("text", "pkgs", "", "Pkgs") ?>
                                                                    <?= $form->formField("text", "net", "", "Net Weight") ?>
                                                                    <?= $form->formField("text", "kgs", "", "Kilos") ?>
                                                                    <?= $form->formField("text", "company", "", "company") ?>

                                                                </div>
                                                                <div class="col-md-3 col-md-3">
                                                                    <?= $form->formField("text", "value", "", "Valuations") ?>
                                                                    <?= $form->formField("dropdownlist", "type", "", "Pkg Type", array("BPP"=>"BPP", "TPP"=>"TPP", "PB"=>"PB")) ?>
                                                                    <?= $form->formField("text", "ware_hse", "", "Ware House") ?>
                                                                    <?= $form->formField("text", "sale_price", "", "Sale Price") ?>

                                                                </div>
                                                                <button type="submit" id="savePrivate" class="btn btn-success">Save</button>
                                                            </div>
                                                        </div>
                                                       
                                                <?= $form->endForm() ?>
                                            </div>       
                                        </div>
                           <div class="card-body">
                                <div class="table-responsive">
									<table id="privatePurchase" class="table table-striped table-bordered" style="width:100%">
										<thead>
											<tr>
												<th class="wd-15p">Lot No</th>
												<th class="wd-15p">Ware Hse.</th>
												<th class="wd-20p">Company</th>
												<th class="wd-15p">Mark</th>
												<th class="wd-10p">Grade</th>
                                                <th class="wd-25p">Invoice</th>
                                                <th class="wd-25p">Pkgs</th>
												<th class="wd-25p">Type</th>
												<th class="wd-25p">Net</th>
                                                <th class="wd-25p">Gross</th>
                                                <th class="wd-25p">Kgs</th>
                                                <th class="wd-25p">Tare</th>
                                                <th class="wd-25p">Value</th>

											</tr>
										</thead>
                                        <tbody>
                                        <?php
                                        foreach ($prvt as $stock){
                                            $html='<tr>';
                                                $html.='<td>'.$stock["lot"].'</td>';
                                                $html.='<td>'.$stock["ware_hse"].'</td>';
                                                $html.='<td>'.$stock["company"].'</td>';
                                                $html.='<td>'.$stock["mark"].'</td>';
                                                $html.='<td>'.$stock["grade"].'</td>';
                                                $html.='<td>'.$stock["invoice"].'</td>';
                                                $html.='<td>'.$stock["pkgs"].'</td>';
                                                $html.='<td>'.$stock["type"].'</td>';
                                                $html.='<td>'.$stock["net"].'</td>';
                                                $html.='<td>'.$stock["gross"].'</td>';
                                                $html.='<td>'.$stock["kgs"].'</td>';
                                                $html.='<td>'.$stock["tare"].'</td>';
                                                $html.='<td>'.$stock["value"].'</td>';

											$html.='</tr>';

                                            echo $html;
                                        }
                                        
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<!-- Dashboard js -->
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="../../assets/js/sweet-alert.js"></script>
<script>

$.ajax({
    url: "../../ajax/common.php",
    type: "POST",
    dataType: "html",
    data: {
        action: "grade-list"
    },
    success: function(response) {
        $("#grade").html(response);

    }

});
$.ajax({
    url: "../../ajax/common.php",
    type: "POST",
    dataType: "html",
    data: {
        action: "garden-list"
    },
    success: function(response) {
        $("#mark").html(response);
    }
});

$.ajax({
    url: "../../ajax/common.php",
    type: "POST",
    dataType: "html",
    data: {
        action: "list-brokers"
    },
    success: function(response) {
        $("#broker").html(response);
    }

});
    

</script>


<script>
    $(document).ready(function() {
        $("#savePrivate").click(function(e) {
            e.preventDefault();
            $.ajax({
                    url: "stock-action.php",
                    type: "POST",
                    dataType: "json",
                    data: $("#prvt_purchase").serialize() + "&action=insert",
                    success: function(response) {
                        swal('','Saved Successfully', 'success');
                        $('#prvt_purchase').trigger("reset");
                    }
                });
        });

    })
</script>
       
</html>

