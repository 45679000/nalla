<?php
$path_to_root = "../../../";
$path_to_root1 = "../../../";

require_once $path_to_root.'templates/header.php';
include $path_to_root.'models/Model.php';
require $path_to_root."vendor/autoload.php";
require_once $path_to_root.'modules/cataloguing/Catalogue.php';
include $path_to_root1.'includes/auction_ids.php';
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
                <h4 class="page-title">Post Auction Catalog Import</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/chamu/modules/cataloguing/index.php?view=dashboard">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Post Auction Catalog Import</li>
                </ol>
            </div>
            <div id="global-loader" ></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                        <i id="helpBlend" style="float:left; font-size:large" class="fa fa-question-circle">help</i>
                                <div id="help" style="display:none; margin-left:30px;">
                                <span class="label">
                                    <pre>Step1. Download Post Auction Catalog From ITTS.
                                        Step2. Click the drop box to locate the file in your File System Or drag and drop the excel file 
                                        On the drop Box.
                                        Step3. Click Upload then process the file
                                    </pre>
                                
                                </span>
                        </div>
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
                           <table id="closingimports" class="table table-striped table-bordered table-sm" style="width:100%">
                               <thead class="thead-light">
                                   <tr>
                                       <th class="wd-15p">SN#</th>
                                       <th class="wd-15p">Lot No</th>
                                       <th class="wd-15p">Broker</th>
                                       <th class="wd-15p">Auction Date</th>
                                       <th class="wd-15p">Ware Hse.</th>
                                       <th class="wd-20p">Company</th>
                                       <th class="wd-15p">Mark</th>
                                       <th class="wd-10p">Grade</th>
                                       <th class="wd-25p">Invoice</th>
                                       <th class="wd-25p">Pkgs</th>
                                       <th class="wd-25p">Kgs</th>
                                       <th class="wd-25p">Buyer</th>
                                       <th class="wd-25p">Hammer</th>

                                   </tr>
                               </thead>
                               <tbody>';
                                   // var_dump($imports);
                                   foreach ($imports as $import) {
                                       $html .= '<tr>';
                                       $html .= '<td>' . $import["Sno"] . '</td>';
                                       $html .= '<td>' . $import["Lot_no"] . '</td>';
                                       $html .= '<td>' . $import["broker"] . '</td>';
                                       $html .= '<td>' . $import["auction_date"] . '</td>';
                                       $html .= '<td>' . $import["warehouse"] . '</td>';
                                       $html .= '<td>' . $import["producer"] . '</td>';
                                       $html .= '<td>' . $import["mark"] . '</td>';
                                       $html .= '<td>' . $import["grade"] . '</td>';
                                       $html .= '<td>' . $import["invoice_no"] . '</td>';
                                       $html .= '<td>' . $import["packages"] . '</td>';
                                       $html .= '<td>' . $import["net"] . '</td>';
                                       $html .= '<td>' . $import["buyer"] . '</td>';
                                       $html .= '<td>' . $import["sale_price"]*100 . '</td>';

                                       $html .= '</tr>';
                                   }
               $html .= '</tbody>
                           </table>
                       </div>
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
            $('#helpBlend').click(function(e){
                 $("#help").toggle();
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