<?php
$path_to_root = "../../";
include ($path_to_root.'templates/header.php');
include ($path_to_root.'models/Model.php');
include ($path_to_root.'controllers/WarehouseController.php');
include ($path_to_root.'controllers/BlendingController.php');
include ($path_to_root.'controllers/StockController.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<style>
    .table{
        background-color: white;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<body>
    <div class="page-header">
       
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="card">
                    <div class="expanel expanel-primary">
                        <div class="expanel-heading">
                            <h3 class="expanel-title">Warehouse Ops.</h3>
                        </div>
                        <div class="expanel-body">
                            <div class="list-group  mb-0 mail-inbox">
                                <a href="./index.php?view=packing-material-types" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-shuffle text-blue"></i></span>Material Types
                                </a>
                                <a href="./index.php?view=packing-materials" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-grid text-blue"></i></span>Materials Stock
                                </a>
                                <a href="./index.php?view=shipments" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="mdi mdi-ferry text-lime"></i></span>Shipments
                                </a>
                                <a href="./index.php?view=closeblends" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-shuffle text-success"></i></span>Close Blends
                                </a>
                                <a href="./index.php?view=stock" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-sidebar text-warning"></i></span>Stock
                                </a>
                                <a href="./index.php?view=shippedLots" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="mdi mdi-ferry text-lime"></i></span>View Shipped lots
                                </a>
                                <a href="./index.php?view=openshippments" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="mdi mdi-ferry text-lime"></i></span>Change shippment Status
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

                            case 'warehouse':
                                include('views/manage_warehouses.php');
                                break;

                            case 'packing-materials':
                                    include('views/packing_materials.php');
                            break;
                            case 'packing-material-types':
                                include('views/material_types.php');
                            break;
                            case 'shipments':
                                $sino = isset($_GET['id']) ? $_GET['id'] : '';
                                if(($action=='allocatematerials') && ($sino !=null)){
                                    include('views/allocate_shippment_materials.php');
                                }else{
                                    include('views/shipments.php');
                                }
                                break;
                            case 'closeblends':
                                include('views/close_blends.php');
                                
                                break;

                            case 'stock':
                                include('views/stock.php');
                                break;

                            case 'shippedLots':
                                include('views/shippedLots.php');
                                break;
                            
                            case 'openshippments':
                                include('views/open_shipments.php');
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

</html>
