<?php
$path_to_root = "../";
$path_to_root1 = "../";

require_once $path_to_root.'templates/header.php';
include $path_to_root.'models/Model.php';
require $path_to_root."vendor/autoload.php";
require_once $path_to_root.'modules/cataloguing/Catalogue.php';
include $path_to_root1.'database/connection.php';

if(!empty($_FILES)){
    $db = new Database();
    $conn = $db->getConnection();
    $catalogue = new Catalogue($conn);
    $catalogue->inputFileName = $_FILES['excel']['tmp_name'];
    $catalogue->importClosingCatalogue();
}

?>
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Catalogue Import</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">closing Catalogue Import</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Closing Catalogue Upload Process</div>
                        </div>
                        <div class="card-body p-6">
                            <div class="wizard-container">
                                <div class="wizard-card m-0" id="wizardProfile">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="wizard-navigation">
                                            <ul>
                                                <li><a href="#step1" data-toggle="tab">STEP 1</a></li>
                                                <li><a href="#step2" data-toggle="tab">STEP 2</a></li>
                                                <li><a href="#step3" data-toggle="tab">STEP 3</a></li>
                                                <li><a href="#step4" data-toggle="tab">STEP 4</a></li>

                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            <div class="tab-pane" id="step1">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">SALE NO</label>
                                                                <select name="saleno" class="form-control" ><small>(required)</small>
                                                                    <option disabled="" value="..." selected="">select</option>
                                                                    <option value="2021-01"> 2021-01 </option>
                                                                    <option value="2021-02"> 2021-02 </option>
                                                                    <option value="2021-03"> 2021-03 </option>
                                                                    <option value="2021-04"> 2021-04 </option>
                                                                    <option value="2021-05"> 2021-05 </option>
                                                                    <option value="2021-06"> 2021-06 </option>
                                                                    <option value="2021-07"> 2021-07 </option>
                                                                    <option value="2021-08"> 2021-08 </option>
                                                                    <option value="2021-09"> 2021-09 </option>
                                                                    <option value="2021-09"> 2021-09 </option>
                                                                    <option value="2021-09"> 2021-09 </option>
                                                                    <option value="2021-09"> 2021-09 </option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">BROKER</label>
                                                                <select name="broker" class="form-control"><small>(required)</small>
                                                                    <option disabled="" value="..." selected="">select</option>
                                                                    <option value="ANGL"> ANGL </option>
                                                                    <option value="ATLC"> ATLC </option>
                                                                    <option value="BICL"> BICL </option>
                                                                    <option value="CENT"> CENT </option>
                                                                    <option value="CTBL"> CTBL </option>
                                                                    <option value="VENS"> VENS </option>
                                                                    <option value="UNTB"> UNTB </option>
                                                                    <option value="TBE"> TBE </option>
                                                              </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="tab-pane" id="step2">
                                                <h4 class="info-text"> Is the Opening Catalogue Split ? </h4>
                                                <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="choice" data-toggle="wizard-checkbox">
                                                                <input type="checkbox" name="no" value="no">
                                                                <div class="icon">
                                                                    <i class="fa fa-pencil"></i>
                                                                </div>
                                                                <h6>No</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="choice" data-toggle="wizard-checkbox">
                                                                <input type="checkbox" name="yes" value="yes">
                                                                <div class="icon">
                                                                    <i class="fa fa-terminal"></i>
                                                                </div>
                                                                <h6>Yes</h6>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="step3">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h4 class="info-text"> Select Catalogue </h4>
                                                    </div>
                                                 </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <input type="file" name="excel" class="dropify" style="width:60%;" data-height="180" />
                                                        </div>
                                                    </div>
                                                
                                            </div>
                                        </div>
                                        <div class="wizard-footer">
                                            <div class="pull-right">
                                                <input type='button' class='btn btn-next btn-fill btn-primary btn-wd m-0' name='next' value='Next' />
                                                <input type='submit' class='btn btn-finish btn-fill btn-success btn-wd m-0' name='finish' value='Finish' />
                                            </div>

                                            <div class="pull-left">
                                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd m-0' name='previous' value='Previous' />
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- wizard container -->
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
<script src=../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- counter  -->
<script src="../assets/plugins/counters/counterup.min.js"></script>
<script src="../assets/plugins/counters/waypoints.min.js"></script>
<!-- Custom Js-->
<script src="../assets/js/custom.js"></script>

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
</html>