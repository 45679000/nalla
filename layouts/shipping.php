<div class="col-md-8 col-lg-10">
    <div class="card">
        <div class="card-body p-6">
        <div class="wizard-container">
                                <div class="wizard-card m-0" id="wizardProfile">
                                        <div class="wizard-navigation">
                                            <ul>
                                                <li><a href="#step1" data-toggle="tab">Shipping Instructions</a></li>
                                                <li><a href="#step2" data-toggle="tab">Add to cart</a></li>
                                                <li><a href="#step3" data-toggle="tab">Packing Materials</a></li>
                                                <li><a href="#step4" data-toggle="tab">Documentation</a></li>
                                                <li><a href="#step5" data-toggle="tab">Confirm Shipping</a></li>
                                                <li><a href="#step6" data-toggle="tab">Printing</a></li>
                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            <div class="tab-pane" id="step1">
                                                <?= $form->beginForm() ?>
                                                <?= $form->formMessage("Saved") ?>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-3 col-md-3">
                                                            <?= $form->formField("dropdownlist", "shippment_type", "", "Shippment Type", array("Blend Shippment"=>"Blend Shippment","Straight Line"=>"Straight Line")) ?>
                                                            <?= $form->formField("text", "contract_no", "", "Contract No") ?>
                                                            <?= $form->formField("text", "si_date", "", "Shipping Date") ?>
                                                            <?= $form->formField("text", "target_vessel", "", "Target Vessel") ?>
                                                            <?= $form->formField("text", "no_containers_type", "", "No of Containers Type") ?>
                                                            <?= $form->formField("text", "pkgs_shipped", "", "Packages Shipped") ?>
                                                            <?= $form->formField("text", "packing_materials", "", "Packing Materials") ?>
                                                            <?= $form->formField("text", "shipping_marks", "", "Shipping Marks") ?>
                                                        </div>
                                                        <div class="col-md-3 col-md-3">
                                                            <?= $form->formField("text", "tea_standard_no", "", "Tea Standard No.") ?>
                                                            <?= $form->formField("text", "grade_type_of_tea", "", "Grade Type of Tea") ?>
                                                            <?= $form->formField("text", "type_of_loading", "", "Type of Loading") ?>
                                                            <?= $form->formField("text", "each_net_per_package", "", "Each Net Per Package") ?>
                                                            <?= $form->formField("text", "each_gross_per_package", "", "Each Gross Per Package") ?>
                                                            <?= $form->formField("text", "ware_hse", "", "Warehouse") ?>
                                                            <?= $form->formField("text", "consignment_value", "", "Consignment value") ?>
                                                            <?= $form->formField("text", "total_net_weight_per_container", "", "Total Net Weight Per container") ?>

                                                        </div>
                                                        <div class="col-md-3 col-md-3">
                                                            <?= $form->formField("text", "total_gross_weight_per_container", "", "Total Gross Weight Per container") ?>
                                                            <?= $form->formField("text", "destination_total_place_of_delivery", "", "Destination Total Place of delivery") ?>
                                                            <?= $form->formField("text", "lc_no", "", "Lc No") ?>
                                                            <?= $form->formField("text", "date_of_issue", "", "Date of Issue") ?>
                                                            <?= $form->formField("text", "negotiating_bank", "", "Negotiating Bank") ?>
                                                            <?= $form->formField("text", "marine_insuarance", "", "Marine Insuarance") ?>
                                                            <?= $form->formField("text", "qa_inspection", "", "Qa and Inspection") ?>
                                                            <?= $form->formField("text", "production_date", "", "Production Date") ?>
                                                        </div>
                                                        <div class="col-md-3 col-md-3">
                                                            <?= $form->formField("text", "expiry_date", "", "Expiry Date") ?>
                                                            <?= $form->formField("text", "buyer", "", "Buyer") ?>
                                                            <?= $form->formField("text-area", "consignee", "", "Consignee") ?>
                                                            <?= $form->formField("text-area", "note", "", "Note") ?>
                                                            <?= $form->formField("text", "shipper", "", "Shipper") ?>
                                                            <?= $form->formField("text-area", "notify_party", "", "Notify Party") ?>
                                                            <?= $form->formField("text-area", "2nd_notify_party", "", "2nd Notify Party") ?>
                                                            <?= $form->formField("text-area", "additional_instructions", "", "Additional Instructions") ?>
                                                        </div>
                                                        <?= $form->addButtons('step1') ?>

                                                    </div>
                                                    </div>
                                                </div>
                                                <?= $form->endForm() ?>
                                            </div>
                                            <div class="tab-pane" id="step2">
                                              
                                            <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="scart" class="table table-striped table-bordered" style="width:100%">
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
                                                            <th class="wd-25p">Value</th>
                                                            <th class="wd-25p">Add To Cart</th>
                                                            <th class="wd-25p">Comment</th>
                                                            <th class="wd-25p">Standard</th>
            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $html ="";
                                                    foreach ($scart as $scart){
                                                        $html.='<tr>';
                                                            $html.='<td>'.$scart["lot"].'</td>';
                                                            $html.='<td>'.$scart["ware_hse"].'</td>';
                                                            $html.='<td>'.$scart["company"].'</td>';
                                                            $html.='<td>'.$scart["mark"].'</td>';
                                                            $html.='<td>'.$scart["grade"].'</td>';
                                                            $html.='<td>'.$scart["invoice"].'</td>';
                                                            $html.='<td>'.$scart["pkgs"].'</td>';
                                                            $html.='<td>'.$scart["type"].'</td>';
                                                            $html.='<td>'.$scart["net"].'</td>';
                                                            $html.='<td>'.$scart["gross"].'</td>';
                                                            $html.='<td>'.$scart["tare"].'</td>';
                                                            $html.='<td>'.$scart["value"].'</td>';
                                                            if($scart["allocated"]==0){
                                                                $html.='<td><input type="checkbox" id="unallocated" name="allocated" value="0"></td>';
                                                            }else{
                                                                $html.='<td><input type="checkbox" id="allocated" name="allocated" value="1" checked></td>';
                                                            }
                                                            $html.='<td>'.$scart["comment"].'</td>';
                                                            $html.='<td>'.$scart["standard"].'</td>';
                                                        $html.='</tr>';
                                                    }
                                                    $html.= '</tbody>
                                                        </table>
                                                    </div>
                                                </div>';
                                                echo $html;
                                            ?>
                                            </div>
                                            <div class="tab-pane" id="step3">
                                                <div class="row">
                                                <div class="table-responsive">
                                                <table id="parking" class="table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="wd-15p">#</th>
                                                            <th class="wd-15p">Type</th>
                                                            <th class="wd-20p">Total</th>
                                                            <th class="wd-20p">Select</th>
                                                            <th class="wd-20p">No. Used</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $html ="";
                                                    $id = 1;
                                                    foreach ($parking as $parking){
                                                        $html.='<tr>';
                                                            $html.='<td>'.$parking["id"].'</td>';
                                                            $html.='<td>'.$parking["type"].'</td>';
                                                            $html.='<td>'.$parking["total"].'</td>';
                                                            $html.='<td> <input type="checkbox" name="selected" value=""></td>';
                                                            $html.='<td> <input type="number" name="total" value=""></td>';

                                                        $html.='</tr>';
                                                       
                                                    }
                                                    echo $html;
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                    </div>
                                                
                                            </div>
                                        </div>
                                        <div class="wizard-footer">
                                            <div class="pull-right">
                                                <input type="button" class="btn btn-next btn-fill btn-primary btn-wd m-0" name="save" value="Next" />
                                                <!-- <input type="submit" class="btn btn-finish btn-fill btn-success btn-wd m-0" name="finish" value="Finish" /> -->
                                            </div>

                                            <div class="pull-left">
                                                <input type="button" class="btn btn-previous btn-fill btn-default btn-wd m-0" name="previous" value="Previous" />
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                   
                                </div>
                            </div> <!-- wizard container -->
        </div> <!-- wizard container -->
    </div>
</div>


<!-- Dashboard js -->
<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../assets/js/vendors/selectize.min.js"></script>
<script src="../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../assets/js/vendors/circle-progress.min.js"></script>
<script src="../assets/plugins/rating/jquery.rating-stars.js"></script>
<!-- forn-wizard js-->
<script src="../assets/plugins/forn-wizard/js/material-bootstrap-wizard.js"></script>
<script src="../assets/plugins/forn-wizard/js/jquery.validate.min.js"></script>
<script src="../assets/plugins/forn-wizard/js/jquery.bootstrap.js"></script>
<!-- file import -->
<script src="../assets/plugins/fileuploads/js/dropify.min.js"></script>
<!-- Custom scroll bar Js-->
<script src=../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- counter  -->
<script src="../assets/plugins/counters/counterup.min.js"></script>
<script src="../assets/plugins/counters/waypoints.min.js"></script>
<!-- Custom Js-->
<script src="../assets/js/custom.js"></script>

<script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>


<script type="text/javascript">
    
</script>

<!-- Data table js -->
<script>
    $(function(e) {
        $('#scart').DataTable();
        $('#parking').DataTable();
        
    });
</script>

</html>