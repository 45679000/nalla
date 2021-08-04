<?php
    $path_to_root = "../../";
    $path_to_root1 = "../../";

    include $path_to_root.'templates/header.php';
    include $path_to_root.'models/Model.php';
    require $path_to_root."vendor/autoload.php";
    include $path_to_root.'modules/cataloguing/Catalogue.php';
    include $path_to_root1.'modules/grading/grading.php';
    include $path_to_root1.'/includes/auction_ids.php';
    require_once $path_to_root1 . 'controllers/StockController.php';


    $scart = array();;

if ($saleNo != null) {
    $stock->saleno = $saleNo;
    $scart = $stock->readPurchaseList();
}


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
                            <h3 class="expanel-title">Tea Purchases</h3>
                        </div>
                        <div class="expanel-body">
                            <div class="list-group  mb-0 mail-inbox">
                                <a href="./index.php?view=confirmpplist" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-send"></i></span>Confirm Purchase List
                                </a>
                            
                                <a href="./index.php?view=confirmedpplist" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-send"></i></span>Confirmed Purchase List
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="expanel expanel-primary">
                        <div class="expanel-heading">
                            <h3 class="expanel-title">Invoices</h3>
                        </div>
                        <div class="expanel-body">
                            <div class="list-group  mb-0 mail-inbox">
                                <a href="./index.php?view=profoma" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-send"></i></span>Profoma Invoice
                                </a>
                            
                                <a href="./index.php?view=commercial" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-send"></i></span>commercial Invoice
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
                            case 'confirmpplist':
                                include 'views/confirm_purchase_list.php';
                                break;
                            case 'confirmedpplist':
                                include 'views/confirmed_purchase_list.php';
                                break;
                            case 'labels':
                                include 'views/labels.php';
                                break;
                                default:
                            include('views/dashboard.php');

                        

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
<script src="../../assets/plugins/select2/select2.full.min.js"></script> --> 


<script type="text/javascript">

    $(document).ready(function() {
        $('.select2').select2();
    });
</script>




</html>