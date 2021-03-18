<?php
$path_to_root = "../";
$path_to_root1 = "../";

require_once $path_to_root.'templates/header.php';
include $path_to_root.'models/Model.php';
require $path_to_root."vendor/autoload.php";
require_once $path_to_root.'modules/cataloguing/Catalogue.php';
include $path_to_root1.'database/connection.php';
$imported = false;
$db = new Database();
$conn = $db->getConnection();
$catalogue = new Catalogue($conn);
if(!empty($_FILES)){
    $catalogue->inputFileName = $_FILES['excel']['tmp_name'];
    $imported = $catalogue->importClosingCatalogue();
}
    $imports = $catalogue->readImportSummaries();

    $mainlots = $catalogue->summaryCount("closing_cat_import_id", "main")['count'];
    $mainkgs = $catalogue->summaryTotal("kgs", "main")['total'];
    $mainpkgs = $catalogue->summaryTotal("pkgs", "main")['total'];

    $seclots = $catalogue->summaryCount("closing_cat_import_id", "sec")['count'];
    $seckgs = $catalogue->summaryTotal("kgs", "sec")['total'];
    $secpkgs = $catalogue->summaryTotal("pkgs", "sec")['total'];

    if(isset($_POST['confirm'])){
        $catalogue->confirmCatalogue();
    }

?>
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Catalogue Import</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Catalogue Import</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Closing Catalogue Import</div>
                        </div>
                        <?php if(empty($imports))  
                        echo '<div class="card-body p-6">
                            <div class="wizard-container">
                                <div class="wizard-card m-0" id="wizardProfile">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="wizard-navigation">
                                            <ul>
                                                <li><a href="#step1" data-toggle="tab">STEP 1</a></li>
                                                <li><a href="#step2" data-toggle="tab">STEP 2</a></li>
                                                <li><a href="#step3" data-toggle="tab">STEP 3</a></li>

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
                                                <input type="button" class="btn btn-next btn-fill btn-primary btn-wd m-0" name="next" value="Next" />
                                                <input type="submit" class="btn btn-finish btn-fill btn-success btn-wd m-0" name="finish" value="Finish" />
                                            </div>

                                            <div class="pull-left">
                                                <input type="button" class="btn btn-previous btn-fill btn-default btn-wd m-0" name="previous" value="Previous" />
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- wizard container -->
                        </div>'; 
                        else{
                           $html= '
                           <div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-body text-center">
										<div class="row mt-0 well">
											<div class="col-md-6">
												<div class="expanel expanel-success">
													<div class="expanel-heading">Main</div>
                                                        <div class="expanel-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-vcenter text-nowrap">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Lots</td>
                                                                            <td class="counter">'.$mainlots.'</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Kgs</td>
                                                                            <td class="counter">'.$mainkgs.'</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>PKgs</td>
                                                                            <td class="counter">'.$mainpkgs.'</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                        </div>
                                                    </div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="expanel expanel-success">
													<div class="expanel-heading">
														<h3 class="expanel-title">Secondary Category</h3>
													</div>
                                                    <div class="expanel-body">
                                                         <div class="table-responsive">
                                                            <table class="table table-vcenter text-nowrap">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Lots</td>
                                                                        <td class="counter">'.$seclots.'</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Kgs</td>
                                                                        <td class="counter">'.$seckgs.'</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>PKgs</td>
                                                                        <td class="counter">'.$secpkgs.'</td>
                                                                    </tr>
                                                                 </tbody>
                                                            </table>
                                                         </div>
													</div>
												</div>
											</div>
                                        </div>
                                        <form action="" method="post">
                                            <button type="submit" id="confirm" name="confirm" class="btn btn-success btn-sm">Confirm To Stock</button>
                                        </form>
									</div>
								</div>
							</div>
						</div>
                           <div class="card-body">
                                <div class="table-responsive">
									<table id="closingimports" class="table table-striped table-bordered" style="width:100%">
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

											</tr>
										</thead>
                                        <tbody>';
                                        // var_dump($imports);
                                        foreach ($imports as $import){
                                            $html.='<tr>';
                                                $html.='<td>'.$import["lot"].'</td>';
                                                $html.='<td>'.$import["ware_hse"].'</td>';
                                                $html.='<td>'.$import["company"].'</td>';
                                                $html.='<td>'.$import["mark"].'</td>';
                                                $html.='<td>'.$import["grade"].'</td>';
                                                $html.='<td>'.$import["invoice"].'</td>';
                                                $html.='<td>'.$import["pkgs"].'</td>';
                                                $html.='<td>'.$import["type"].'</td>';
                                                $html.='<td>'.$import["net"].'</td>';
                                                $html.='<td>'.$import["gross"].'</td>';
                                                $html.='<td>'.$import["kgs"].'</td>';
                                                $html.='<td>'.$import["tare"].'</td>';

											$html.='</tr>';
                                        }
                                $html.= '</tbody>
                                    </table>
                                </div>
                            </div>';
                            echo $html;
                        }
                        ?>
                        
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
				$('#closingimports').DataTable();
			} );
		</script>
       
</html>