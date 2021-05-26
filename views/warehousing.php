<?php
session_start();
if(!defined('ROOT')) define('ROOT', dirname(__DIR__) . '/');
include (ROOT.'templates/header.php');


?>
<div class="my-3 my-md-5">
    <div class="container-fluid">
        <div class="page-header">
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card" style="margin-top: -80px !important;">
                    <div class="expanel expanel-secondary">
                        <div class="expanel-heading">
                            <h3 class="expanel-title"></h3>
                        </div>
                        <div class="expanel-body">
                            <div class="row">
                                <div class="col">
                                    <ul>
                                        <div class="text-center">
                                            <a href="#"><i style="font-size:10px; color: Dodgerblue;" class="fa fa-home"></i></a>
                                            <a href="warehousing.php?view=warehouses">Warehouses</a>
                                        </div>
                                    </ul>
                                </div>
                                <div class="col">
                                    <ul>
                                        <div class="text-center">
                                            <a href="#"><i style="font-size:10px; color: Dodgerblue;" class="fa fa-address-card"></i></a>
                                            <a href="warehousing.php?view=packing-materials">Packing Materials</a>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php
            if (isset($_GET['view'])) {
                if ($_GET['view'] == 'warehouses') {
                    include 'warehouse-view.php';
                } else if (($_GET['view'] == 'packing-materials')) {
                    include 'packaging_materials.php';
                } elseif (($_GET['view'] == 'offered-teas')) {
                    include 'offered_teas.php';
                } elseif (($_GET['view'] == 'labels')) {
                    include 'labels.php';
                } else {
                    include 'grading_table.php';
                }
            }
            ?>
        </div>
    </div>
</div>

</body>



</html>