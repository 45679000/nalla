<?php
$path_to_root = "../../../";
$path_to_root1 = "../../../";

require_once $path_to_root.'templates/header.php';
include $path_to_root.'models/Model.php';
require $path_to_root."vendor/autoload.php";
require_once $path_to_root.'modules/cataloguing/Catalogue.php';
$imported = false;
include $path_to_root1.'includes/auction_ids.php';


$imports = [];
$catalogue = new Catalogue($conn);
if(isset($_POST['filter'])){
    $_SESSION['sale_no'] = $_POST['saleno'];
    $imports = $catalogue->closingCatalogue($_POST['saleno'], $_POST['broker'] , $_POST['category']);
}

?>
<div class="my-3 my-md-5">
    <div class="container-fluid">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Generate Lables</li>
            </ol>
        </div>
        <div id="global-loader"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <form method="post">
                                        <div class="row justify-content-center">
                                            <div class="col-md-3 well">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">AUCTION</label>
                                                    <select id="saleno" name="saleno"
                                                        class="select2 form-control"><small>(required)</small>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 well">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">BROKER</label>
                                                    <select id="broker" name="broker"
                                                        class="select2 form-control well"><small>(required)</small>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 well">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">CATEGORY</label>
                                                    <select id="category" name="category"
                                                        class="select2 form-control well"><small>(required)</small>
                                                        <option disabled="" value="..." selected="">select</option>
                                                        <option value="dust">DUST</option>
                                                        <option value="leaf">LEAF</option>
                                                        <option value="Sec">Sec</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 well">

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <button class="btn btn-info btn-sm" id="print_labels"><i class="fa fa-file-o">Print Lables</i></button>
                        <button class="btn btn-danger btn-sm" id="clear"><i class="fa fa-times">Clear Selection</i></button>

                        <div class="card-options">
                            <button class="btn btn-info btn-sm" id="go_back"><i class="fa fa-reply">Go Back</i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="lableView" class="table-responsive">
                        </div>
                    </div>



                </div>
            </div>
        </div>


    </div>
</div>
</div>
</body>


<!-- Dashboard js -->
<script src="../../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../../../assets/js/vendors/selectize.min.js"></script>
<script src="../../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../../assets/js/vendors/circle-progress.min.js"></script>
<script src="../../../assets/plugins/rating/jquery.rating-stars.js"></script>
<!-- forn-wizard js-->
<script src="../../../assets/plugins/forn-wizard/js/material-bootstrap-wizard.js"></script>
<script src="../../../assets/plugins/forn-wizard/js/jquery.validate.min.js"></script>
<script src="../../../assets/plugins/forn-wizard/js/jquery.bootstrap.js"></script>
<!-- file import -->
<script src="../../../assets/plugins/fileuploads/js/dropify.min.js"></script>
<!-- Custom scroll bar Js-->
<script src=../../../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- counter  -->
<script src="../../../assets/plugins/counters/counterup.min.js"></script>
<script src="../../../assets/plugins/counters/waypoints.min.js"></script>
<!-- Custom Js-->
<script src="../../../assets/js/custom.js"></script>
<script id="url" data-name="../../../ajax/common.php" src="../../../assets/js/common.js"></script>

<script src="../../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="../../../assets/plugins/select2/select2.full.min.js"></script>
<script src="../../../assets/js/sweet_alert2.js"></script>



<script>

$("#clear").hide();
$("#go_back").hide();


$('select').on('change', function() {
    var saleno = $('#saleno').find(":selected").text();
    var broker = $.trim($('#broker').find(":selected").val());
    var category = $('#category').find(":selected").val();
    console.log("ready " + saleno + " broker " + broker + " category " + category);
    localStorage.setItem("saleno", saleno);
    localStorage.setItem("broker", broker);
    localStorage.setItem("category", category);

    if ((saleno !== 'select' && saleno !== '') && broker !== 'select' && category !== 'select') {
        loadLabels(saleno, broker, category);   
    }

});

$("body").on("click", ".unallocated", function(element) {
    var id = $(this).attr('id');
    $.ajax({
        type: "POST",
        dataType: "html",
        url: "../catalog_action.php",
        data: {
            action: "offer",
            id: id,
            columnValue: 1
        },
        success: function(data) {
            // loadLabels();
        }
    });
});

$("body").on("click", ".allocated", function(element) {
    var id = $(this).attr('id');
    $.ajax({
        type: "POST",
        dataType: "html",
        url: "../catalog_action.php",
        data: {
            action: "offer",
            id: id,
            columnValue: 0
        },
        success: function(data) {
            // loadLabels();       
         }
    });
});


$("#go_back").click(function(element){
    var saleno = localStorage.getItem("saleno");
    var broker = localStorage.getItem("broker");
    var category = localStorage.getItem("category");
    $("#clear").hide();
    $("#go_back").hide();

    $("#print_labels").show();
    loadLabels(saleno, broker, category);   


})
$("#print_labels").click(function(element){
    var saleno = localStorage.getItem("saleno");
    $("#clear").show();
    $("#print_labels").hide();
    $("#go_back").show();

    $('#lableView').html('<iframe width="100%" height="800px" class="frame" frameBorder="0" src="../../../reports/packing_labels.php?saleno='+saleno+'"></iframe>');
});

$("#clear").click(function(element){
    var saleno = localStorage.getItem("saleno");
    $("#clear").hide();
    $("#print_labels").show();
    $("#go_back").show();
    $.ajax({
            type: "POST",
            dataType: "html",
            url: "../catalog_action.php",
            data: {
                saleno: saleno,
                action: "clear-selected"
            },
            success: function(data) {
                $('#lableView').html('<iframe width="100%" height="800px" class="frame" frameBorder="0" src="../../../reports/packing_labels.php?saleno='+saleno+'"></iframe>');

            }
        });

});


function loadLabels(saleno, broker, category){
    $.ajax({
            type: "POST",
            dataType: "html",
            url: "../catalog_action.php",
            data: {
                saleno: saleno,
                broker: broker,
                category: category,
                action: "view-labels"
            },
            success: function(data) {
                $('#lableView').html(data);
                $('.table').DataTable();
            }
        });
}
</script>
