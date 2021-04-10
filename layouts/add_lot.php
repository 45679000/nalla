<?php
session_start();
$path_to_root = "../";
$path_to_root1 = "../";

require_once $path_to_root.'templates/header.php';
include $path_to_root.'models/Model.php';
include $path_to_root.'widgets/_form.php';
require_once $path_to_root.'modules/cataloguing/Catalogue.php';
include $path_to_root1.'database/connection.php';

$db = new Database();
$conn = $db->getConnection();
$form = new Form();
$catalogue = new Catalogue($conn);
if(!empty($_POST)){
    $insertRecord = $catalogue->addLot($_POST, "closing_cat");
    if(!empty($insertRecord)){
        $form->messageType="success";
        $form->formMessage="New Lot Has been added ";
    }
}
?>
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Add Lot</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New Lot</li>
                </ol>
            </div>
            <div id="global-loader" ></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">New Lot</div>
                        </div>
                            <div class="card-body p-6">
                            <?= $form->beginForm() ?>
                                <?= $form->formMessage() ?>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6">
                                            <!-- names should match the database columns -->
                                                <?= $form->formField("dropdownlist", "sale_no", "", "Auction", array("2021-41"=>"2021-41", "2021-42"=>"2021-42")) ?>
                                                <?= $form->formField("dropdownlist", "broker", "", "Broker", array("ANGL"=>"ANGL", "NCL"=>"NCL")) ?>
                                                <?= $form->formField("dropdownlist", "comment", "", "Sale Type", array("Main"=>"Main", "seco"=>"Secondary")) ?>
                                                <?= $form->formField("text", "mark", "", "Garden") ?>
                                                <?= $form->formField("text", "lot", "", "Lot No") ?>
                                                <?= $form->formField("text", "grade", "", "Grade") ?>
                                                <?= $form->formField("text", "invoice", "", "Invoice") ?>

                                            </div>
                                            <div class="col-md-6 col-lg-6">
                                                <?= $form->formField("text", "pkgs", "", "Pkgs") ?>
                                                <?= $form->formField("text", "net", "", "Net Weight") ?>
                                                <?= $form->formField("text", "kgs", "", "Kilos") ?>
                                                <?= $form->formField("text", "value", "", "Valuations") ?>
                                                <?= $form->formField("dropdownlist", "type", "", "Pkg Type", array("BPP"=>"BPP", "TPP"=>"TPP")) ?>
                                                <?= $form->formField("text", "ware_hse", "", "Ware House") ?>

                                            </div>
                                        </div>
                                    </div>
                                    <?= $form->addButtons() ?>
                            <?= $form->endForm() ?>
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
<!-- file import -->
<script src="../assets/plugins/fileuploads/js/dropify.min.js"></script>
<!-- Custom scroll bar Js-->
<script src="../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- counter  -->
<script src="../assets/plugins/counters/counterup.min.js"></script>
<script src="../assets/plugins/counters/waypoints.min.js"></script>
<!-- Custom Js-->
<script src="../assets/js/custom.js"></script>

<script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>

<!--Select2 js -->
<script src="../assets/plugins/select2/select2.full.min.js"></script>

<script src="../assets/js/select2.js"></script>

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
				$('#closingimports').DataTable();
			} );
		</script>
       
</html>