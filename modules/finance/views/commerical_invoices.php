<?php
       $path_to_root = "../../../";
       $path_to_root1 = "../../../";
       session_start();
   
       include $path_to_root.'templates/header.php';
?>

<style>
    .table {
        background-color: white !important;
    }

    .toolbar-button {
        padding: 0.5px !important;
    }

    .form-control {
        color: black !important;
        border: 1px solid black !important;
    }

    .dashboard {
        height: 130vH !important;
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
    .breadcrumb-item{
        margin-top: 20px;
    }
    .page-header{
    padding: 0px;
    margin: 1.5rem !important;
}
</style>
<?php
$invoicetype = isset($_GET["view"]) ? $_GET["view"] : '';
?>

<?php
if($invoicetype=="straight"){
    include 'commericial_invoice_straight.php';
}else if($invoicetype=="blend"){
    include 'proforma_blend.php';
}else if($invoicetype=="test"){
    include 'test_proforma.php';
}else{
    echo '
<div class="card bg-primary" style="margin-top:20vh; background-color:blue !important;">
    <div class="card-body bg-danger text-center">
    <span>Which Type of invoice are you creating?</span>
        <div>
             <a href="views/commerical_invoices.php?view=straight"> Commercial Invoice Straight Line</a>
        </div>
        <div>
             <a href="views/commerical_invoices.php?view=blend"> Commercial Invoice Blend Tea</a>
        </div>

        <div>
        <a href="views/invoices.php?view=test"> Commercial Invoice Blend Test</a>
        </div>

    </div>
</div>
    
    ';        

}
?>



