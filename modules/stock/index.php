<?php
$path_to_root = "../../";
$path_to_root1 = "../../";

require_once $path_to_root . 'templates/header.php';
include $path_to_root . 'models/Model.php';
require_once $path_to_root . 'controllers/StockController.php';
include $path_to_root1 . 'widgets/_form.php';
require_once $path_to_root1 . 'modules/cataloguing/Catalogue.php';
include $path_to_root1 . 'controllers/ShippingController.php';
include $path_to_root1 .'includes/auction_ids.php';



$stock = new Stock($conn);
$stocks = $stock->readStock();

$allocated = $stock->allocatedStock();
$msg = "";
if (isset($_POST['allocate'])) {
    $msg = "<p class='success'>Lot Allocated successfully</p>";

    $buyer = isset($_POST['buyer_standard']) ? $_POST['buyer_standard'] : '';
    $stock_id = isset($_POST['stock_id']) ? $_POST['stock_id'] : '';
    $mrpValue = isset($_POST['mrpValue']) ? $_POST['mrpValue'] : '';
    $offerPrice = isset($_POST['offerPrice']) ? $_POST['offerPrice'] : '';
    $allocatedPkgs = isset($_POST['pkgs']) ? $_POST['pkgs'] : '';
    $InstockPkgs = isset($_POST['pkg_stock']) ? $_POST['pkg_stock'] : '';
}

$parking = array();
$saleNo = isset($_POST['saleno']) ? $_POST['saleno'] : '';
$broker = isset($_POST['broker']) ? $_POST['broker'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$condition = "";
if ($saleNo != '' && $broker != '' && $category != '') {
    $condition .= " WHERE sale_no = '" . $saleNo . "' AND broker = '$broker' AND category = '$category' AND lot IN(SELECT lot FROM closing_stock)";
    $stocks = $stock->readStock("stock", $condition);
}
$scart = array();;

if ($saleNo != null) {
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
if (isset($_POST['step1'])) {
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
    .form-control {
        color: black !important;
        border: 1px solid black !important;
    }

    .card {
        max-height: 30% !important;
        padding-bottom: 0px !important;
    }

    .card-body {
        background-color: white !important;
    }

    .clear {
        height: 100%;

    }
</style>
<body>
    <div class="page-header">
       
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="card">
                    <div class="expanel expanel-primary">
                        <div class="expanel-heading">
                            <h3 class="expanel-title">Stock Listing</h3>
                        </div>
                        <div class="expanel-body">
                            <div class="list-group  mb-0 mail-inbox">
                                <a href="./index.php?view=purchaselist" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-list"></i></span>Purchase List
                                </a>
                                <a href="./index.php?view=ppurchases" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-file-text"></i></span>Private Purchases
                                </a>
                                <a href="./index.php?view=stock-master" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-file-text"></i></span>Stock Master
                                </a>
                            
                            </div>
                        </div>
                        <div class="expanel-heading">
                            <h3 class="expanel-title">Stock Management</h3>
                        </div>
                        <div class="expanel-body">
                            <div class="list-group  mb-0 mail-inbox">
                                <a href="./index.php?view=amend-stock" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-list"></i></span>Stock Amendment
                                </a>
                                <a href="./index.php?view=allocate-stock" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-file-text"></i></span>Allocate Stock
                                </a>
                                <a href="../blending/index.php" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-file-text"></i></span>Issue Teas
                                </a>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <?php 
                    if(isset($_GET['view'])){
                        $view=$_GET['view'];

                        switch($view){
                            case 'dashboard':
                                include('views/dashboard.php');
                                break;
                            case 'purchaselist':
                                include 'views/purchase_list.php';
                                break;
                            case 'ppurchases':
                                include 'views/private_purchases.php';
                                break;
                            case 'stock-master':
                                include 'views/stock_master.php';
                                break;
                            case 'amend-stock':
                                include 'views/amend_stock.php';
                                break;
                            case 'allocate-stock':
                                include 'views/allocate_stock.php';
                                break;
                            case 'closeblends':
                                include 'stock_master.php';
                                break;
                            default:
                            include('views/gardens.php');

                        }
                            
                    }
                
                ?>
            </div>
        </div>
    </div>


    
</body>


<!-- Dashboard js -->
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../../assets/js/vendors/selectize.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>
<!-- Custom Js-->
<script src="../../assets/js/custom.js"></script>
<script src="../../assets/js/common.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>


<script src="../../assets/plugins/datatable/dataTables.buttons.min.js"></script>
<script src="../../assets/plugins/datatable/jszip.min.js"></script>
<script src="../../assets/plugins/datatable/pdfmake.min.js"></script>
<script src="../../assets/plugins/datatable/vfs_fonts.js"></script>
<script src="../../assets/plugins/datatable/buttons.html5.min.js"></script>
<script src="../../assets/plugins/datatable/buttons.print.min.js"></script>
<script src="../../assets/plugins/select2/select2.full.min.js"></script>




<script type="text/javascript">

    $(document).ready(function() {
        $('.select2').select2();

        $('.table').DataTable({
            "pageLength": 100,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
    });
</script>




</html>