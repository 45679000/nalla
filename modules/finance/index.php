<?php
    $path_to_root = "../../";
    $path_to_root1 = "../../";

    include $path_to_root.'templates/header.php';
    include $path_to_root. 'widgets/_form.php';
    include $path_to_root.'models/Model.php';
    require $path_to_root."vendor/autoload.php";
    include $path_to_root.'modules/cataloguing/Catalogue.php';
    include $path_to_root1.'modules/grading/grading.php';
    include $path_to_root1.'/includes/auction_ids.php';
    require_once $path_to_root1 . 'controllers/StockController.php';


    
    
    $form = new Form();


?>
<style>
    .form-control {
        color: black !important;
        border: 1px solid black !important;
    }

    .dashboard {
        height: 100vH !important;
        padding-bottom: 0px !important;
    
    }

    .card-body {
        background-color: white !important;
    }

    .row-cards {
        padding: 15px;
    
    }
    .cardclickable{
        padding: 10px;
        box-shadow: 5px 10px #888888 !important;
    }
    .dashboardlink:hover{
        opacity: 1;
        border: 1px solid;
        padding: 10px;
        box-shadow: 5px 10px #888888;
    }

</style>
<div class="col-md-12">
    <div class="container-fluid">
        <div class="page-header">
            <ol id="breadcrumbList" class="breadcrumb">
                <li class="breadcrumb-item"><a href="./index.php?view=dashboard">home</a></li>
            </ol>
        </div>
        <div id="global-loader"></div>
        <div class="container-fluid card">
            <div class="col-md-12">
                <div class="card dashboard">
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
                            case 'profoma':
                                include 'views/invoices.php';
                                break;
                            case 'commercial':
                                include 'views/generate_straightline_profoma.php';
                                break;
                            case 'selectTeas':
                                include 'views/generate_straightline_profoma.php';
                                break;
                                default:
                            include('views/dashboard.php');    

                        }
                        
                            
                    }
                
                ?>
                </div>
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


        <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();

            // $('.table').DataTable({
            //     "pageLength": 10,
            //     dom: 'Bfrtip',
            //     buttons: [
            //         'copyHtml5',
            //         'excelHtml5',
            //         'csvHtml5',
            //         'pdfHtml5'
            //     ]
            // });

        });
        </script>




        </html>