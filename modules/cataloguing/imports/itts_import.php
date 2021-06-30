<?php
$path_to_root = "../../../";
$path_to_root1 = "../../../";

require_once $path_to_root.'templates/header.php';
include $path_to_root.'models/Model.php';
require $path_to_root."vendor/autoload.php";
require_once $path_to_root.'modules/cataloguing/Catalogue.php';
include $path_to_root1.'views/includes/auction_ids.php';
$imported = false;

$catalogue = new Catalogue($conn);
    if(!empty($_FILES) && isset($_POST['Upload'])){
        $catalogue->inputFileName = $_FILES['excel']['tmp_name'];
        $catalogue->ittsCatalogueImport("insert");
    }

    $imports = $catalogue->ittsCatalogueImport("display");



    if(isset($_POST['confirm'])){
        $confirmed = $catalogue->ittsCatalogueImport("confirm");
        echo '<script type="text/javascript">window.location = window.location.href.split("?")[0];</script>';
    }
    if(isset($_POST['cancel'])){
        $confirmed = $catalogue->ittsCatalogueImport("cancel");
        echo '<script type="text/javascript">window.location = window.location.href.split("?")[0];</script>';
    }

?>
    <div class="my-3 my-md-5">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">Catalogue Import</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Catalogue Import</li>
                </ol>
            </div>
            <div id="global-loader" ></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">ITTS Import</div>
                        </div>

                        <?php if(empty($imports)){  
                        echo '<div class="card-body p-6">
                            <div class="wizard-container">
                                <div class="wizard-card m-0" id="wizardProfile">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="wizard-navigation">
                                            <ul>

                                                <li><a href="#step3" data-toggle="tab"></a></li>

                                            </ul>
                                        </div>

                                        <div class="tab-content">
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
                                                <input type="submit" class="btn btn-finish btn-fill btn-success btn-wd m-0" name="Upload" value="Upload" />
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
									';
                                        foreach ($imports as $import){
                                            if(!is_numeric($import[0])){
                                                $html.='<thead><tr>';
                                                for($i=0; $i<27; $i++){
                                                    $html.='<th>'.$import[$i].'</th>';
                                                    
                                                }
                                                $html.='</thead></tr>';

                                            }else{
                                                $html.='<tr>';

                                                for($i=0; $i<27; $i++){
                                                  
                                                        $html.='<td>'.$import[$i].'</td>';
     
                                                }
                                                $html.='</tr>';
                                            }
                                            

                                        }
                                $html.= '
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
<script src="../../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../../../assets/js/vendors/selectize.min.js"></script>
<script src="../../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../../assets/js/vendors/circle-progress.min.js"></script>
<script src="../../../assets/plugins/rating/jquery.rating-stars.js"></script>
<!-- forn-wizard js-->
<script src="../../../assets/plugins/forn-wizard/js/material-bootstrap-wizard.js"></script>
<script src="../../../assets/plugins/forn-wizard/js/jquery.validate.min.js"></script>
<script src="../../../assets/plugins/forn-wizard/js/jquery.bootstrap.js"></script>
<!-- file import -->
<script src="../../../assets/plugins/fileuploads/js/dropify.min.js"></script>
<!-- Custom scroll bar Js-->
<script src=../../../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- counter  -->
<script src="../../../assets/plugins/counters/counterup.min.js"></script>
<script src="../../../assets/plugins/counters/waypoints.min.js"></script>
<!-- Custom Js-->
<script src="../../../assets/js/custom.js"></script>
<script src="../../../assets/js/common.js"></script>

<script src="../../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>


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