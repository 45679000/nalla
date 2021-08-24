<?php
$path_to_root = "../../";
include $path_to_root . 'templates/header.php';
include $path_to_root . 'includes/auction_ids.php';
?>
<style>

.frame {
        background-color: white;
    }
.mainContainer{
    background-color: white !important;

}
.pdfViewer {
    background-color: white;
}
    @media screen and (max-width:450) {
        .counter {
            margin-bottom: 10px;
        }
    }
</style>
<div class="my-3 my-md-5">
    <div class="container-fluid">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="chamu/modules/stock/index.php?view=dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/chamu/modules/blending/index.php">Issue Teas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Stocks</li>
            </ol>
        </div>
        <div class="row">
            <?php include 'blend_menu.php' ?>
            <?php
            if(isset($_GET['view'])){
                if(($_GET['view']=='blend')){
                    include 'views/blends.php'; 
                }else if(($_GET['view']=='allocate-stock')){
                    include 'allocate_stock.php'; 
                }else if(($_GET['view']=='stock-master')){
                    include 'stock_master.php'; 
                }else if(($_GET['view']=='shipping')){
                    include 'shipping.php'; 
                }else if(($_GET['view']=='amend-stock')){
                    include 'amend_stock.php'; 
                }else if(($_GET['view']=='allocateblendteas')){
                    include 'views/allocate_teas.php'; 
                }else if(($_GET['view']=='straight')){
                    include 'direct_blends.php'; 
                }else{
                    include 'grading_table.php'; 
                }
            }else{
                echo '
                <div>  
                    <div class="card">
                        <h3>Select the option from the menu to assign teas to clients for shippment</h3>
                    </div>
                
                </div>';
            }
            ?>
        </div>
    </div>
</div>