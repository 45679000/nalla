<div class="col-md-8 col-lg-10">
    <div class="card">
        <div class="card-body p-6">
            <div class="wizard-container">
                <div class="wizard-card m-0" id="wizardProfile">
                    <div class="wizard-navigation">
                        <ul>
                            <li><a id="shipping_instruction_tab" href="#step1" data-toggle="tab">Shipping Instructions</a></li>
                            <li><a id="add_to_cart_tab" href="#step2" data-toggle="tab">Add to cart</a></li>
                            <li><a id="packing_materials_tab" href="#step3" data-toggle="tab">Packing Materials</a></li>
                            <li><a id="documentation_tab" href="#step4" data-toggle="tab">Documentation</a></li>
                            <li><a id="confirm_shipping_tab" href="#step5" data-toggle="tab">Confirm Shipping</a></li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane" id="step1">
                            <div class="card-body">
                                <div class="row">
                                    <?php if (!empty($formValue)) {
                                        $html = '<div class="table-responsive">
                                                <table id="parking" class="table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="wd-15p">#</th>
                                                            <th class="wd-15p">SI NO</th>
                                                            <th class="wd-20p">Client</th>
                                                            <th class="wd-20p">Cosignee</th>
                                                            <th class="wd-20p">Print</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $html ="";
                                                    $id = 1';
                                        foreach ($formValue as $value) {
                                            // var_dump($value);

                                            $html .= '<tr>';
                                            $html .= '<td>' . $value['instruction_id'] . '</td>';
                                            $html .= '<td>' . $value['contract_no'] . '</td>';
                                            $html .= '<td>' . $value["buyer"] . '</td>';
                                            $html .= '<td>' . $value["consignee"] . '</td>';
                                            $html .= '<td><button>Print</button></td>';


                                            $html .= '</tr>';
                                        }


                                        $html .= ' </tbody>
                                                </table>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                           ';

                                        echo $html;
                                    } else {
                                        $form->beginForm();
                                        $form->formMessage("Saved");
                                        print '
                                                <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3 col-md-3">';
                                        $form->formField("dropdownlist", "shippment_type", "", "Shippment Type", array("Blend Shippment" => "Blend Shippment", "Straight Line" => "Straight Line"));
                                        $form->formField("text", "contract_no", "", "Contract No");
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
                                        print '</div>
                                                    <div class="col-md-3 col-md-3">';
                                        $form->formField("text", "total_gross_weight_per_container", "", "Total Gross Weight Per container");
                                        $form->formField("text", "destination_total_place_of_delivery", "", "Destination Total Place of delivery");
                                        $form->formField("text", "lc_no", "", "Lc No");
                                        $form->formField("text", "date_of_issue", "", "Date of Issue");
                                        $form->formField("text", "negotiating_bank", "", "Negotiating Bank");
                                        $form->formField("text", "marine_insuarance", "", "Marine Insuarance");
                                        $form->formField("text", "qa_inspection", "", "Qa and Inspection");
                                        $form->formField("text", "production_date", "", "Production Date");
                                        print '</div>
                                                    <div class="col-md-3 col-md-3">';
                                        $form->formField("text", "expiry_date", "", "Expiry Date");
                                        $form->formField("text", "buyer", "", "Buyer");
                                        $form->formField("text-area", "consignee", "", "Consignee");
                                        $form->formField("text-area", "note", "", "Note");
                                        $form->formField("text", "shipper", "", "Shipper");
                                        $form->formField("text-area", "notify_party", "", "Notify Party");
                                        $form->formField("text-area", "2nd_notify_party", "", "2nd Notify Party");
                                        $form->formField("text-area", "additional_instructions", "", "Additional Instructions");
                                        print '</div>';
                                        $form->addButtons('step1');
                                        print '</div>
                                                    </div>
                                                </div>';
                                        $form->endForm();
                                        print '</div>';
                                        print '</div>';
                                        print '</div>';
                                    }
                                    ?>

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
                                                        $html = "";
                                                        foreach ($scart as $scart) {
                                                            $html .= '<tr>';
                                                            $html .= '<td>' . $scart["lot"] . '</td>';
                                                            $html .= '<td>' . $scart["ware_hse"] . '</td>';
                                                            $html .= '<td>' . $scart["company"] . '</td>';
                                                            $html .= '<td>' . $scart["mark"] . '</td>';
                                                            $html .= '<td>' . $scart["grade"] . '</td>';
                                                            $html .= '<td>' . $scart["invoice"] . '</td>';
                                                            $html .= '<td>' . $scart["pkgs"] . '</td>';
                                                            $html .= '<td>' . $scart["type"] . '</td>';
                                                            $html .= '<td>' . $scart["net"] . '</td>';
                                                            $html .= '<td>' . $scart["gross"] . '</td>';
                                                            $html .= '<td>' . $scart["tare"] . '</td>';
                                                            $html .= '<td>' . $scart["value"] . '</td>';
                                                            if ($scart["allocated"] == 0) {
                                                                $html .= '<td><input type="checkbox" id="unallocated" name="allocated" value="0"></td>';
                                                            } else {
                                                                $html .= '<td><input type="checkbox" id="allocated" name="allocated" value="1" checked></td>';
                                                            }
                                                            $html .= '<td>' . $scart["comment"] . '</td>';
                                                            $html .= '<td>' . $scart["standard"] . '</td>';
                                                            $html .= '</tr>';
                                                        }
                                                        $html .= '</tbody>
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
                                                                $html = "";
                                                                $id = 1;
                                                                foreach ($parking as $parking) {
                                                                    $html .= '<tr>';
                                                                    $html .= '<td>' . $parking["id"] . '</td>';
                                                                    $html .= '<td>' . $parking["type"] . '</td>';
                                                                    $html .= '<td>' . $parking["total"] . '</td>';
                                                                    $html .= '<td> <input type="checkbox" name="selected" value=""></td>';
                                                                    $html .= '<td> <input type="number" name="total" value=""></td>';

                                                                    $html .= '</tr>';
                                                                }
                                                                echo $html;
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="tab-pane" id="step4">
                                                <div class="row">
                                                    <div class="row">
                                                      <ul style="list-style-type: none;";>
                                                       <li>
                                                                <a href="../reports/lot_details.php">Stock List</a>
                                                        </li>
                                                        <li>
                                                                <a href="../reports/shipping_instruction.php">Shipping Instructions</a>
                                                        </li>
                                                      </ul>
                                                       
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="tab-pane" id="step5">
                                                <div class="row">
                                                    <div class="table-responsive">
                                                        <div class="card" style="width:100px; height:100px;">
                                                                <form>
                                                                <button style="width:100px; height:100px;">SHIP IT</button>
                                                                </form>
                                                        </div>
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

                    $('#tasting tbody').on('click', '#unallocated', function() {
                        var thisCell = table.cell(this);
                        SubmitData.lot = $(this).parents('tr').find("td:eq(0)").text();
                        SubmitData.check = 1;
                        console.log(SubmitData);
                        postData(SubmitData, "");

                    });
                    $('#tasting tbody').on('click', '#allocated', function() {
                        var thisCell = table.cell(this);
                        SubmitData.lot = $(this).parents('tr').find("td:eq(0)").text();
                        SubmitData.check = 0;
                        console.log(SubmitData);
                        postData(SubmitData, "");

                    });


                    function postData(formData, PostUrl) {
                        $.ajax({
                            type: "POST",
                            dataType: "html",
                            url: PostUrl,
                            data: formData,
                            success: function(data) {
                                console.log('Submission was successful.');
                                // location.reload();
                                console.log(data);
                                return data;
                            },
                            error: function(data) {
                                console.log('An error occurred.');
                                console.log(data);
                            },
                        });


                    }
                </script>

                    <script>
                        $(document).ready(function(){
                            $('a[data-toggle="tab"]').on('click', function () {
                                var currentId = $(this).attr("id");
                                var href = $(this).attr("href");

                                localStorage.setItem("selected_id",currentId);
                                localStorage.setItem("id",href);

                            });

                            var tabElement = document.getElementById("step1");
                            tabElement.classList.remove("active");

                            // var hrefElement = document.getElementById("shipping_instruction_tab");
                            // hrefElement.classList.remove("active");
                            // hrefElement.classList.remove("show");
                            $(localStorage.getItem("selected_id")).attr("class","active show");
                            // $("#add_to_cart_tab").attr("class","active show");
                            $(localStorage.getItem("id")).attr("class","tab-pane active show");
                            if(localStorage.getItem("id")=="#step2"){
                                $('.moving-tab').css({'transform': 'translate3d(273.9px, 0px, 0px)'});
                            }else if(localStorage.getItem("id")=="#step3"){
                                $('.moving-tab').css({'transform': 'translate3d(547.8px, 0px, 0px)'});
                            }else if(localStorage.getItem("id")=="#step4"){
                                $('.moving-tab').css({'transform': 'translate3d(821.7px, 0px, 0px)'});
                            }else if(localStorage.getItem("id")=="#step5"){
                                $('.moving-tab').css({'transform': 'translate3d(1103.6px, 0px, 0px)'});
                            }else{
                                $('.moving-tab').css({'transform': 'transform: translate3d(-8px, 0px, 0px)'});

                            }                           

                        });
                        

                    

                            // var test = document.getElementById("step1");
                            // var testClass = test.className;

                            // switch (testClass) {
                            // case "class1":
                            //     test.innerHTML = "I have class1";
                            //     break;
                            // case "class2":
                            //     test.innerHTML = "I have class2";
                            //     break;
                            // case "class3":
                            //     test.innerHTML = "I have class3";
                            //     break;
                            // case "class4":
                            //     test.innerHTML = "I have class4";
                            //     break;
                            // default:
                            //     test.innerHTML = "";
                            // }
                    
                    </script>

                </html>
                