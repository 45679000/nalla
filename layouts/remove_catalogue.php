<?php
session_start();
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

$imports = $catalogue->closingCatalogue('2021-12', 'ANGL','Main');

if(isset($_POST['confirm'])){
    $removed = $catalogue->removeCatalogue('2021-12');
    if($removed == true){
        echo '<script type="text/javascript">window.location = window.location.href.split("?")[0];</script>';
    }
}


?>
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">View Valuations</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Valuations</li>
                </ol>
            </div>
            <div id="global-loader" ></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <?php 
                           $html= '
                           <div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-body text-center">
                                    <form>
                                    <div class="row justify-content-center">
                                        <div class="col-md-4 well">
                                            <div class="form-group label-floating">
                                                <label class="control-label">AUCTION</label>
                                                <select id="saleno" name="saleno" class="form-control" ><small>(required)</small>
                                                    <option disabled="" value="..." selected="">select</option>
                                                    <option value="2021-01"> 2021-01 </option>
                                                    <option value="2021-12"> 2021-12 </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 well">
                                            <div class="form-group label-floating">
                                                <label class="control-label">BROKER</label>
                                                <select id="broker" name="broker" class="form-control well" ><small>(required)</small>
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
                                        <div class="col-md-4 well">
                                            <div class="form-group label-floating">
                                                <label class="control-label">CATEGORY</label>
                                                <select id="category" name="category" class="form-control well" ><small>(required)</small>
                                                    <option disabled="" value="..." selected="">select</option>
                                                    <option value="Main">Main</option>
                                                    <option value="Sec">Sec</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form action="" method="post">
                                <button type="submit" id="confirm" name="confirm" class="btn btn-success btn-sm">Remove Catalogue</button>
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

<script>
$(function() {

    $('select').on('change', function() {
         var saleno = $('#saleno').find(":selected").text();
         var broker = $('#broker').find(":selected").text();
         var category = $('#category').find(":selected").text();
         console.log("ready "+saleno+" broker "+broker+" category "+category);

         if(saleno !=='select' && broker !== 'select' && category !== 'select'){

            var formData = {
                saleno: saleno,
                broker: broker,
                category: category,
            };

          $.ajax({
                type: "POST",
                dataType: "html",
                url: "",
                data: formData,
            success: function (data) {
                console.log('Submission was successful.');
                location.reload();
                console.log(data);
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });

    }

    });

    
});
    
</script>
<script>
    $(function(e) {
        $('#closingimports').DataTable();
    } );
</script>
       
</html>