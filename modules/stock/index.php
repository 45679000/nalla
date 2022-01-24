<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$path_to_root = "../../";
$path_to_root1 = "../../";

require_once $path_to_root . 'templates/header.php';
include $path_to_root . 'models/Model.php';
require_once $path_to_root . 'controllers/StockController.php';
include $path_to_root1 . 'widgets/_form.php';
require_once $path_to_root1 . 'modules/cataloguing/Catalogue.php';
include $path_to_root1 . 'controllers/ShippingController.php';
include $path_to_root1 .'includes/auction_ids.php';


?>
<style>
.navbuttons {
    display: inline-block;
    overflow: auto;
    overflow-y: hidden;

    max-width: 100%;
    margin: 0 0 1em;
    height: 50px;

    white-space: nowrap;

}

.navbuttons LI {
    display: inline-block;
    vertical-align: top;
    padding: 10px;
    
}
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
    .page-header{
         padding: 0px;
         margin: 1.5rem !important;
    }
</style>
<body>
<div class="page-header">
        <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/chamu/modules/stock/index.php?view=dashboard">home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Stocks</li>
		</ol>		
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
                                    <span class="icon mr-3"><i class="fe fe-list text-info fw-bold"></i></span>Purchase List
                                </a>
                                <a href="./index.php?view=purchaselistPrivate" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-list text-info fw-bold"></i></span>Private Purchases
                                </a>
                                <a href="./index.php?view=stock-master" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-file-text text-danger fw-bold"></i></span> Master Stock
                                </a>
                            
                            </div>
                        </div>
                        <div class="expanel-heading">
                            <h3 class="expanel-title">Stock Management</h3>
                        </div>
                        <div class="expanel-body">
                            <div class="list-group  mb-0 mail-inbox">
                                <a href="./index.php?view=allocate-stock" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-file-text"></i></span>Allocate Stock
                                </a>
                                <a href="../blending/index.php" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-file-text"></i></span>Issue Teas
                                </a>
                            
                            </div>
                        </div>
                        <div class="expanel-heading">
                            <h3 class="expanel-title">Issued Teas</h3>
                        </div>
                        <div class="expanel-body">
                            <div class="list-group  mb-0 mail-inbox">
                                <a href="./index.php?view=blendsheets" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-file-text"></i></span>Blend Sheets
                                </a>
                                <a href="./index.php?view=lot-details" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-file-text"></i></span>Lot Details
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
                            case 'purchaselistPrivate':
                                include 'views/private_purchases.php';
                                break;
                            case 'closeblends':
                                include 'stock_master.php';
                                break;
                            case 'blendsheets':
                                include 'views/blend_sheets.php';
                                break;
                            case 'lot-details':
                                include 'views/lot_details.php';
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

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>


<script src="../../assets/plugins/datatable/dataTables.buttons.min.js"></script>
<script src="../../assets/plugins/datatable/jszip.min.js"></script>
<script src="../../assets/plugins/datatable/pdfmake.min.js"></script>
<script src="../../assets/plugins/datatable/vfs_fonts.js"></script>
<script src="../../assets/plugins/datatable/buttons.html5.min.js"></script>
<script src="../../assets/plugins/datatable/buttons.print.min.js"></script>
<script src="../../assets/plugins/select2/select2.full.min.js"></script>

<!-- Charts Plugin -->
<!-- <script src="../../assets/plugins/highcharts/highcharts.js"></script>
<script src="../../assets/plugins/highcharts/highcharts-3d.js"></script>
<script src="../../assets/plugins/highcharts/exporting.js"></script>
<script src="../../assets/plugins/highcharts/export-data.js"></script>
<script src="../../assets/plugins/highcharts/histogram-bellcurve.js"></script>
<script src="../../assets/plugins/highcharts/solid-gauge.js"></script> -->

<!-- Index Scripts -->
<!-- <script src="../../assets/js/highcharts.js"></script> -->



<script type="text/javascript">

    $(document).ready(function() {
        $('.select2').select2();
        
    });
</script>




</html>