<?php
    $path_to_root = "../../";
    $path_to_root1 = "../../";

    include $path_to_root.'templates/header.php';
    include $path_to_root.'models/Model.php';
    require $path_to_root."vendor/autoload.php";
    include $path_to_root1.'/includes/auction_ids.php';
    include $path_to_root1.'widgets/_form.php';

?>
<style>

</style>
<div class="my-3 my-md-5">
    <div class="container-fluid">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="chamu/views/dashboard.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tea Buying</li>
            </ol>
        </div>
        <div class="row">
            <?php include 'views/sub_menu.php' ?>
            <?php
            if(isset($_GET['view'])){
                if($_GET['view']=='grading-details'){
                    include 'views/grading_table.php'; 
                }else if(($_GET['view']=='grading-codes')){
                    include 'views/grading_codes.php';  
                }else if(($_GET['view']=='ppurchases')){
                    include 'views/private_purchases.php';  
                }else if(($_GET['view']=='apurchases')){
                    include 'views/auction_buying.php';  
                }else if(($_GET['view']=='tgrading')){
                    include 'views/tasting_and_grading.php';  
                }else if(($_GET['view']=='targets')){
                    include 'views/auction_targets.php'; 
                }else if(($_GET['view']=='print_out')){
                    include 'views/auction_target_print.php';
                }else{
                    include 'views/grading_codes.php';  
                }
            }
            ?>
        </div>
    </div>
</div>

</body>
<script>
$(function(e) {
    $(".demo-accordion").accordionjs();
    // Demo text. Let's save some space to make the code readable. ;)
    $('.acc_content').not('.nodemohtml').html(
        '<a href="./index.php?view=ppurchases" class="list-group-item list-group-item-action d-flex align-items-center">'
        +' <span class="icon mr-3"><i class="fe fe-pie-chart text-cyan"></i></span>Private Purchases' +
        '</a>' +
        
        '<a href="./index.php?view=apurchases" class="list-group-item list-group-item-action d-flex align-items-center accordion-toggle wave-effect"' +
        'data-toggle="collapse" aria-expanded="true">' +
        ' <span class="icon mr-3"><i class="fe fe-pie-chart text-cyan"></i></span>Auction Purchases' +
        '</a>');
});

$('.select2').select2();


</script>

</html>
<!-- Fullside-menu Js-->
<script src="../../assets/plugins/fullside-menu/jquery.slimscroll.min.js"></script>
<script src="../../assets/plugins/fullside-menu/waves.min.js"></script>
<script src="../../assets/plugins/accordion/accordion.min.js"></script>
<script src="../../assets/plugins/select2/select2.full.min.js"></script>

