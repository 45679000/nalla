<?php
$path_to_root = "../";
$path_to_root1 = "../";

require_once $path_to_root.'templates/header.php';
include $path_to_root.'models/Model.php';
require_once $path_to_root.'modules/stock/Stock.php';
include $path_to_root1.'database/connection.php';

$db = new Database();
$conn = $db->getConnection();
$stock = new Stock($conn);
if(isset($_POST['saleno']) && isset($_POST['broker'])){
    $stock->saleno = $_POST['saleno'];
    $stock->broker = $_POST['broker'];
    $stocks = $stock->readStock();
}
?>
    <div class="my-3 my-md-12">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Purchase List</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Purchase List</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Purchase List</div>
                        </div>
                        <?php if(empty($stocks))  
                        echo '<div class="card-body p-6">
                            <div class="wizard-container">
                                    <form action="" method="post" enctype="multipart/form-data">
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
                                                                    <option value="2021-10"> 2021-10 </option>
                                                                    <option value="2021-11"> 2021-11 </option>
                                                                    <option value="2021-12"> 2021-12 </option>
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
                                        </div>
                                        <div class="wizard-footer">
                                            <div class="text-center">
                                                <input type="submit" class="btn btn-finish btn-fill btn-success btn-sm" name="filter" value="Retrieve" />
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                            </div> <!-- wizard container -->
                        </div>'; 
                        else{
                           $html= '
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
                                        <tbody>';
                                        // var_dump($stocks);
                                        foreach ($stocks as $stock){
                                            $html.='<tr>';
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