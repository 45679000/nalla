<?php
$path_to_root = "../../";
include ($path_to_root.'templates/header.php');
include ($path_to_root.'models/Model.php');
include ($path_to_root.'controllers/WarehouseController.php');
include ($path_to_root.'controllers/BlendingController.php');
include ($path_to_root.'modules/stock/Stock.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<style>
    .table{
        background-color: white;
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
                            <h3 class="expanel-title">Warehouse Ops.</h3>
                        </div>
                        <div class="expanel-body">
                            <div class="list-group  mb-0 mail-inbox">
                                <a href="./index.php?view=warehouse" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-list"></i></span>Manage Warehouses
                                </a>
                                <a href="./index.php?view=packing-materials" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-file-text"></i></span>Add Packing materials
                                </a>
                                <a href="./index.php?view=shipments" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-file-text"></i></span>Shipments
                                </a>
                                <a href="./index.php?view=closeblends" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-shuffle"></i></span>Close Blends
                                </a>
                                <a href="./index.php?view=grades" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-sidebar"></i></span>Stock
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

                            case 'shipments':
                                if(($_GET['action']=='allocatematerials') && ($_GET['id'] !=null)){
                                    $sino = $_GET["id"];

                                    include('views/allocate_shippment_materials.php');

                                }else{
                                    include('views/shipments.php');

                                }
                                break;

                            case 'closeblends':
                                include('views/close_blends.php');
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
