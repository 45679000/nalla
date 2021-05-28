<?php
    session_start();
    $path_to_root = "../";
    $path_to_root1 = "../";

    include $path_to_root.'templates/header.php';
    include $path_to_root.'models/Model.php';
    require $path_to_root."vendor/autoload.php";
    include $path_to_root.'modules/cataloguing/Catalogue.php';
    include $path_to_root1.'modules/grading/grading.php';

    $catalogue = new Catalogue($conn);
    $grading = new Grading($conn);
    $imports = array();
    if(isset($_POST['saleno']) && isset($_POST['broker']) && isset($_POST['category'])){
        $imports = $catalogue->closingCatalogue($_POST['saleno'], $_POST['broker'], $_POST['category']);
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
<div class="my-3 my-md-5">
    <div class="container-fluid">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reports</li>
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
    
                }elseif(($_GET['view']=='offered-teas')){
                    include 'offered_teas.php'; 
                }elseif(($_GET['view']=='labels')){
                    include 'labels.php'; 
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