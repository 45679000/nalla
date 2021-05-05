<?php
$path_to_root = "../";
$path_to_root1 = "../";

require_once $path_to_root.'templates/header.php';
include $path_to_root.'models/Model.php';
require_once $path_to_root.'modules/stock/Stock.php';
include $path_to_root1.'database/connection.php';
include $path_to_root1.'widgets/_form.php';
require_once $path_to_root1.'modules/cataloguing/Catalogue.php';
include $path_to_root1.'controllers/ShippingController.php';



$db = new Database();
$conn = $db->getConnection();
$stock = new Stock($conn);
$stocks = array();
$parking = array();
if(isset($_POST['saleno']) && isset($_POST['broker'])){
    $stock->saleno = $_POST['saleno'];
    $stock->broker = $_POST['broker'];
    $stocks = $stock->readStock();
}
$scart = $stock->readAllStock();
$parking = $stock->parking();

$form = new Form();
$catalogue = new Catalogue($conn);
$prvt = $catalogue->privatePurchases();
$formValue = array();
if(isset($_POST['step1'])){
    $controller = new ShippingController($conn);
    unset($_POST['step1']);
    unset($_POST['scart_length']);
    unset($_POST['allocated']);
    $formValue = $controller->saveSI($_POST, 1);
}
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
                    include 'stock.php'; 
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