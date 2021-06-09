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
$stocks = array();
$parking = array();
if(isset($_POST['saleno'])){
    $stock->saleno = $_POST['saleno'];
    $stocks = $stock->readPurchaseList();
}
$scart = $stock->readPurchaseList();
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
    
                }elseif(($_GET['view']=='stock-master')){
                    include 'stock_master.php'; 
                }elseif(($_GET['view']=='shipping')){
                    include 'shipping.php'; 
                }else{
                    include 'grading_table.php'; 
                }
            }
            ?>
        </div>
    </div>
</div>

</body>



</html>