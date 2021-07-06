<?php
$path_to_root = "../";
$path_to_root1 = "../";

require_once $path_to_root.'templates/header.php';
include $path_to_root.'models/Model.php';
require_once $path_to_root.'modules/stock/Stock.php';
include $path_to_root1.'widgets/_form.php';
require_once $path_to_root1.'modules/cataloguing/Catalogue.php';
include $path_to_root1.'controllers/ShippingController.php';
include 'includes/auction_ids.php';



$stock = new Stock($conn);
$stocks = $stock->readStock($condition="WHERE pkgs>0;");
$allocated = $stock->allocatedStock();
$msg = "";
if(isset($_POST['allocate'])){
    $msg ="<p class='success'>Lot Allocated successfully</p>";

    $buyer = isset($_POST['buyer_standard']) ? $_POST['buyer_standard'] : '';
    $stock_id = isset($_POST['stock_id']) ? $_POST['stock_id'] : '';
    $mrpValue = isset($_POST['mrpValue']) ? $_POST['mrpValue'] : '';
    $offerPrice = isset($_POST['offerPrice']) ? $_POST['offerPrice'] : '';
    $allocatedPkgs = isset($_POST['pkgs']) ? $_POST['pkgs'] : '';
    $InstockPkgs = isset($_POST['pkg_stock']) ? $_POST['pkg_stock'] : '';
    if($buyer !='' && $stock_id !='' && ($allocatedPkgs !='' || $allocatedPkgs>$InstockPkgs)){
        $stock->allocateStock($stock_id, $buyer, $mrpValue, $offerPrice, $allocatedPkgs);
        }else{
        $msg ="<p class='danger'>Make sure you have filled all required fields and allocated packages is less than the packages in stock</p>";
    }


}

$parking = array();
$saleNo = isset($_POST['saleno']) ? $_POST['saleno'] : '';
$broker = isset($_POST['broker']) ? $_POST['broker'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$condition = "";
if($saleNo != '' && $broker != '' && $category != ''){
    $condition .=" WHERE sale_no = '".$saleNo. "' AND broker = '$broker' AND category = '$category' AND lot IN(SELECT lot FROM closing_stock)";
    $stocks = $stock->readStock($condition);

}
$scart = array();;

if($saleNo != null){
    $stock->saleno = $saleNo;
    $scart = $stock->readPurchaseList();
}
$parking = $stock->parking();

$form = new Form();
$catalogue = new Catalogue($conn);

$lots = $catalogue->summaryCount("closing_cat_import_id", "main")['count'];
$kgs = $catalogue->summaryTotal("net", "main")['total'];
$pkgs = $catalogue->summaryTotal("pkgs", "main")['total'];

$prvt = $catalogue->privatePurchases();
$formValue = array();
$controller = new ShippingController($conn);
if(isset($_POST['step1'])){
    unset($_POST['step1']);
    $formValue = $controller->saveSI($_POST, 1);

}
$shippingI = $controller->getShippingInstructions();
// if(isset($_POST['packing'])){
//     if(!empty($_POST)){
//         $_SESSION['packing-materials'][] = $_POST;        
//     }
// }

?>
<style>
.form-control{
    color: black !important;
    border:1px solid black !important;
}
.card{
    max-height: 30% !important;
    padding-bottom: 0px !important;
}
.card-body{
    background-color: white !important;
}.clear{
    height: 100%;

}
</style>
<div class="my-3 my-md-5">
    <div class="container-fluid">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reports</li>
            </ol>
        </div>
        <div class="row">
            <?php include 'sub_menu_stock.php' ?>
            <?php
            if(isset($_GET['view'])){
                if($_GET['view']=='purchase-list'){
                    include 'purchase_list.php'; 
                }else if(($_GET['view']=='ppurchase-list')){
                    include 'private_purchases.php'; 
                }else if(($_GET['view']=='allocate-stock')){
                    include 'allocate_stock.php'; 
                }else if(($_GET['view']=='stock-master')){
                    include 'stock_master.php'; 
                }else if(($_GET['view']=='shipping')){
                    include 'shipping.php'; 
                }else if(($_GET['view']=='amend-stock')){
                    include 'amend_stock.php'; 
                }else if(($_GET['view']=='summaries')){
                    $summary = isset($_GET['summary']) ? $_GET['summary'] : '';
                    include 'stock_summaries.php'; 
                }else{
                    include 'grading_table.php'; 
                }
            }
            ?>
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
<!-- Custom Js-->
<script src="../assets/js/custom.js"></script>
<script src="../assets/js/common.js"></script>

<script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>


<script src="../assets/plugins/datatable/dataTables.buttons.min.js"></script>
<script src="../assets/plugins/datatable/jszip.min.js"></script>
<script src="../assets/plugins/datatable/pdfmake.min.js"></script>
<script src="../assets/plugins/datatable/vfs_fonts.js"></script>
<script src="../assets/plugins/datatable/buttons.html5.min.js"></script>
<script src="../assets/plugins/datatable/buttons.print.min.js"></script>


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
				$('.table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print',
                        {
                            extend: 'pdfHtml5',
                            orientation: 'landscape',
                            pageSize: 'LEGAL'
                        },
                        
                    ],
                    "columnDefs": [
                        {"width": "10%", "targets": 0},

                    ],
                    "processing": true,
                    "language": {
                     processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                    },
 
                });
			} );
		</script>
		
       
</html>

