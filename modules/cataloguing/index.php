<?php
    $path_to_root = "../../";
    $path_to_root1 = "../../";

    include $path_to_root.'templates/header.php';
    include $path_to_root.'models/Model.php';
    require $path_to_root."vendor/autoload.php";
    include $path_to_root.'modules/cataloguing/Catalogue.php';
    include $path_to_root1.'modules/grading/grading.php';
    include $path_to_root1.'/includes/auction_ids.php';


    $catalogue = new Catalogue($conn);
    $grading = new Grading($conn);
    $imports = array();
    $saleNo = isset($_POST['saleno']) ? $_POST['saleno'] : '';
    $broker = isset($_POST['broker']) ? $_POST['broker'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : 'All';

    if($saleNo!==''){
        $imports = $catalogue->closingCatalogue($saleNo, $broker, $category);
    }
    if(isset($_POST['pkey'])){
        $grading->grade($_POST['pkey'], $_POST['fieldValue'], $_POST['fieldName']);
    }
    if(isset($_POST['addcomment'])){
        $grading->addComment($_POST['comment'], $_POST['description']);
    }
    $comments = $grading->readComments();

    if(isset($_POST['lot'])){
        $grading->grade($_POST['lot'], $_POST['check'], "allocated");

    }
    $offered = $grading->readOffers();


?>
<style>
    .form-control {
        color: black !important;
        border: 1px solid black !important;
    }

    .card-body {
        background-color: white !important;
    }
.page-header{
    padding: 0px;
    margin: 1.5rem !important;
}
</style>
<body>
    <div class="page-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/chamu/modules/cataloguing/index.php?view=dashboard">home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Catalogs</li>
                </ol>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="card">
                    <div class="expanel expanel-primary">
                        <div class="expanel-heading">
                            <h3 class="expanel-title">Labels</h3>
                        </div>
                        <div class="expanel-body">
                            <div class="list-group  mb-0 mail-inbox">
                                            <a href="./index.php?view=offered-teas" class="list-group-item list-group-item-action d-flex align-items-center">
                                                <span class="icon mr-3"><i class="fa fa-spinner"></i></span>Generate Labels
                                            </a>
                                        
                                            <a href="./index.php?view=labels" class="list-group-item list-group-item-action d-flex align-items-center">
                                                <span class="icon mr-3"><i class="fa fa-th"></i></span>Print Labels
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
                            case 'offered-teas':
                                include 'views/offered_teas.php';
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
    });
</script>




</html>