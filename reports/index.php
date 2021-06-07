<?php
$path_to_root = "../";
$path_to_root1 = "../";
include $path_to_root.'templates/header.php';

?>
    <div class="my-3 my-md-5" style="margin-top:-20px;">
        <div class="container-fluid">
            <div class="page-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reports</li>
                </ol>
            </div>
            <div class="row">
                <?php  
                include 'sub_menu.php'; 

                if(isset($_GET['rep'])){
                    $report = $_GET['rep'];
                    switch ($report) {
                        case "broker-catalog":
                            include 'rep_broker.php';
                          break;
                        case "blue":
                          echo "Your favorite color is blue!";
                          break;
                        case "green":
                          echo "Your favorite color is green!";
                          break;
                        default:
                          echo "Your favorite color is neither red, blue, nor green!";
                      }



                }            

                ?>

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