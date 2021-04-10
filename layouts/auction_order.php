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
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Auction Order</div>
                        </div>
                       
                           <div class="card-body">
                                <div class="table-responsive">
									<table id="closingstocks" class="table table-striped table-bordered" style="width:100%">
										<thead>
											<tr>
												<th class="wd-15p">Order</th>
												<th class="wd-15p">Auction</th>

											</tr>
										</thead>
                                        <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>2021-01</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>2021-02</td>
                                                </tr>     <tr>
                                                    <td>3</td>
                                                    <td>2021-03</td>
                                                </tr>     <tr>
                                                    <td>4</td>
                                                    <td>2021-04</td>
                                                </tr>     <tr>
                                                    <td>5</td>
                                                    <td>2021-05</td>
                                                </tr>     <tr>
                                                    <td>6</td>
                                                    <td>2021-06</td>
                                                </tr>     <tr>
                                                    <td>7</td>
                                                    <td>2021-07</td>
                                                </tr>     <tr>
                                                    <td>8</td>
                                                    <td>2021-08</td>
                                                </tr>     <tr>
                                                    <td>9</td>
                                                    <td>2021-09</td>
                                                </tr>     <tr>
                                                    <td>10</td>
                                                    <td>2021-10</td>
                                                </tr>     <tr>
                                                    <td>11</td>
                                                    <td>2021-11</td>
                                                </tr>     <tr>
                                                    <td>12</td>
                                                    <td>2021-12</td>
                                                </tr>     <tr>
                                                    <td>13</td>
                                                    <td>2021-13</td>
                                                </tr>     <tr>
                                                    <td>14</td>
                                                    <td>2021-14</td>
                                                </tr>
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