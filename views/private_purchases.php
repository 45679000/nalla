<div class="col-md-8 col-lg-10">
                <div class="card">
                    <div class="card-body p-6">
                        <div class="col-md-12">
                            <div class="expanel expanel-secondary">
                                <div class="expanel-heading">
                                                <h3 class="expanel-title">Add Private Purchase</h3>
                                            </div>
                                            <div class="expanel-body">
                                            <div class="card-body p-6">
                                                <?= $form->beginForm() ?>
                                                    <?= $form->formMessage() ?>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-3 col-md-3">
                                                                <!-- names should match the database columns -->
                                                                    <?= $form->formField("dropdownlist", "sale_no", "", "Auction", array("PRVT-01-2021"=>"PRVT-01-2021", "PRVT-02-2021"=>"PRVT-02-2021")) ?>
                                                                    <?= $form->formField("dropdownlist", "broker", "", "Broker", array("ANGL"=>"ANGL", "NCL"=>"NCL")) ?>
                                                                    <?= $form->formField("dropdownlist", "comment", "", "Sale Type", array("Main"=>"Main", "seco"=>"Secondary")) ?>
                                                                </div>
                                                                <div class="col-md-3 col-md-3">
                                                                    <?= $form->formField("text", "mark", "", "Garden") ?>
                                                                    <?= $form->formField("text", "lot", "", "Lot No") ?>
                                                                    <?= $form->formField("text", "grade", "", "Grade") ?>
                                                                    <?= $form->formField("text", "invoice", "", "Invoice") ?>
                                                                </div>
                                                                <div class="col-md-3 col-md-3">
                                                                    <?= $form->formField("text", "pkgs", "", "Pkgs") ?>
                                                                    <?= $form->formField("text", "net", "", "Net Weight") ?>
                                                                    <?= $form->formField("text", "kgs", "", "Kilos") ?>
                                                                </div>
                                                                <div class="col-md-3 col-md-3">
                                                                    <?= $form->formField("text", "value", "", "Valuations") ?>
                                                                    <?= $form->formField("dropdownlist", "type", "", "Pkg Type", array("BPP"=>"BPP", "TPP"=>"TPP")) ?>
                                                                    <?= $form->formField("text", "ware_hse", "", "Ware House") ?>

                                                                </div>
                                                                <?= $form->addButtons() ?>

                                                            </div>
                                                        </div>
                                                       
                                                <?= $form->endForm() ?>
                                            </div>       
                                        </div>
                           <div class="card-body">
                                <div class="table-responsive">
									<table id="closingstocks" class="table table-striped table-bordered" style="width:100%">
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
                                        <tbody>;
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
<!-- file stock -->
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
            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop a file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove': 'Remove',
                    'error': 'Ooops, something wrong appended.'
                },
                error: {
                    'fileSize': 'The file size is too big (2M max).'
                }
            });
        </script>
        <script>
			$('.counter').countUp();
		</script>
        <!-- Data table js -->
		<script>
			$(function(e) {
				$('#closingstocks').DataTable();
			} );
		</script>
       
</html>

