<?php
    $path_to_root = "../";
    $path_to_root1 = "../";

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
        $grading->addToBuyingList($_POST['lot'], $_POST['check'], "allocated");

    }


?>
<style>
    .noedit{
        outline: none;
        border: 0px;
        background-color: inherit;
    }
    .edit{
        border: 0.5px;
        background-color: white;
        width:30%;
    }
    .form-control{
        color: black !important;
        border:1px solid black !important;
    }
    .card{
        max-height: 30% !important;
        padding-bottom: 0px !important;
    }
    .card-body{
        background-color: white !important;
    }.clear{
        height: 100%;
    }
    list-group:hover{
    background-color: brown !important;
    }
    .pdfViewer{
        background-color: white !important;
    }
</style>
<div class="my-3 my-md-5">
    <div class="container-fluid">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tasting</li>
            </ol>
        </div>
        <div class="row">
            <?php include 'sub_menu.php' ?>
            <?php
            if(isset($_GET['view'])){
                if($_GET['view']=='grading'){
                    include 'grading_table.php'; 
                }else if(($_GET['view']=='comment')){
                    include 'grading_comments.php';  
                }else if(($_GET['view']=='targets')){
                    include 'auction_targets.php'; 
                }else if(($_GET['view']=='print_out')){
                    include 'auction_target_print.php';
                }else{
                    include 'grading_table.php'; 
                }
            }
            ?>
        </div>
    </div>
</div>

</body>
<script>
    $('.list-group-item').click(function(element){
        $(element).addClass('list-group-item-active');
    });
</script>
</html>