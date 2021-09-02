<?php
require_once "SalesByCustomer.php";
$path_to_root = "../../";
$path_to_root1 = "../../";

require_once $path_to_root . 'templates/header.php';
?>

<div class="expanel expanel-secondary">
    <div class="card">
        <div class="card-header">
            <div id="purchaseListactions" class="card-options">
            </div>
        </div>
        <div style="height:60vH" class="card-body table-responsive">
            <div id="purchaseList">
                <?php
                    $salesByCustomer = new SalesByCustomer;
                    $salesByCustomer->run()->render();
                ?>
            </div>
        </div>
    </div>

</div>








<!-- Dashboard js -->
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../../assets/js/vendors/selectize.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>
<!-- Custom Js-->

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>


<script src="../../assets/plugins/datatable/dataTables.buttons.min.js"></script>
<script src="../../assets/plugins/datatable/jszip.min.js"></script>
<script src="../../assets/plugins/datatable/pdfmake.min.js"></script>
<script src="../../assets/plugins/datatable/vfs_fonts.js"></script>
<script src="../../assets/plugins/datatable/buttons.html5.min.js"></script>
<script src="../../assets/plugins/datatable/buttons.print.min.js"></script>
<script src="../../assets/plugins/select2/select2.full.min.js"></script>

<script>
$(document).ready(function() {
    $('.table').DataTable();
});
</script>