<?php
$path_to_root = "../";
$path_to_root1 = "../";

require_once $path_to_root.'templates/header.php';
include $path_to_root.'models/Model.php';
require $path_to_root."vendor/autoload.php";
require_once $path_to_root.'modules/cataloguing/Catalogue.php';
include 'includes/auction_ids.php';

$catalogue = new Catalogue($conn);
if(!empty($_FILES) && isset($_POST['saleno']) && isset($_POST['broker'])){
   
    $catalogue->inputFileName = $_FILES['excel']['tmp_name'];
    $catalogue->saleno = $_POST['saleno'];
    $catalogue->broker = $_POST['broker'];
    $catalogue->user_id = $_SESSION["user_id"];
    $catalogue->is_split = $_POST["split"];

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
        $confirmed = $catalogue->postCatalogueProcess();
        if($confirmed == true){
            echo '<script type="text/javascript">window.location = window.location.href.split("?")[0];</script>';
        }
    }
    if(isset($_POST['cancel'])){
        $confirmed = $catalogue->clearImport();
        if($confirmed == true){
            echo '<script type="text/javascript">window.location = window.location.href.split("?")[0];</script>';
        }
    }

?>
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Catalogue Upload</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Catalogue Upload</li>
                </ol>
            </div>
            <div id="global-loader" ></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Valuation Catalogue Upload</div>
                        </div>

                        <?php if(empty($imports)) {
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
                                                                    ';
                                                                    loadAuction();
                                                                    echo '

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-sm-6">
                                                              <div class="form-group label-floating">
                                                                <label class="control-label">BROKER</label>
                                                                <select id="broker" name="broker" class="form-control"><small>(required)</small>
                                                                    
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
                                                                <input type="checkbox" name="split" value="false">
                                                                <div class="icon">
                                                                    <i class="fa fa-pencil"></i>
                                                                </div>
                                                                <h6>No</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="choice" data-toggle="wizard-checkbox">
                                                                <input type="checkbox" name="split" value="true">
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
                        }else{
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
                                            <button type="submit" id="confirm" name="confirm" class="btn btn-success btn-sm">Process Import</button>
                                            <button type="submit" id="cancel" name="cancel" class="btn btn-success btn-sm">Cancel</button>
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
                                                <th class="wd-25p">Value</th>
                                                <th class="wd-25p">Sale Price</th>
                                                <th class="wd-25p">Buyer Package</th>

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
                                                $html.='<td>'.$import["value"].'</td>';
                                                $html.='<td>'.$import["sale_price"].'</td>';
                                                $html.='<td>'.$import["buyer_package"].'</td>';
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
<script src="../assets/js/common.js"></script>

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