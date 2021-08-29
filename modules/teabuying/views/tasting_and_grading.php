<div class="col-md-8 col-lg-10">
    <div class="my-3 my-md-5">
        <div class="container-fluid">
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
                                                            <option value="Sec">SEC</option>
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
                        <div class="card-body">
                            <div id="gradingTable" class="table-responsive">
                                <div class="card-body">
                                    <div class="dimmer active">
                                        <div class="spinner2">
                                            <div class="cube1"></div>
                                            <div class="cube2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>


        </div>
    </div>

</div>

<!-- Dashboard js -->
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../../assets/js/vendors/selectize.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>
<!-- forn-wizard js-->
<script src="../../assets/plugins/forn-wizard/js/material-bootstrap-wizard.js"></script>
<script src="../../assets/plugins/forn-wizard/js/jquery.validate.min.js"></script>
<script src="../../assets/plugins/forn-wizard/js/jquery.bootstrap.js"></script>
<!-- file import -->
<script src="../../assets/plugins/fileuploads/js/dropify.min.js"></script>
<!-- Custom scroll bar Js-->
<script src=../../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- counter  -->
<script src="../../assets/plugins/counters/counterup.min.js"></script>
<script src="../../assets/plugins/counters/waypoints.min.js"></script>
<!-- Custom Js-->
<script src="../../assets/js/custom.js"></script>
<script id="url" data-name="../../ajax/common.php" src="../../assets/js/common.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/plugins/select2/select2.full.min.js"></script>
<script src="../../assets/plugins/notify/js/rainbow.js"></script>
<!-- <script src="../../assets/plugins/notify/js/sample.js"></script> -->
<script src="../../assets/plugins/notify/js/jquery.growl.js"></script>



<script>
$(".dimmer").hide();

$('select').on('change', function() {

    var saleno = $('#saleno').find(":selected").text();
    var broker = $.trim($('#broker').find(":selected").val());
    var category = $('#category').find(":selected").val();
    console.log("ready " + saleno + " broker " + broker + " category " + category);
    localStorage.setItem("saleno", saleno);
    localStorage.setItem("broker", broker);
    localStorage.setItem("category", category);
    $(".dimmer").show();

    if (saleno !== '...' && broker !== '...' && category !== '...') {

        loadGradingTable(saleno, broker, category);
    }

});

function loadGradingTable(saleno, broker, category){
    $(".dimmer").show();

    $.ajax({
        type: "POST",
        dataType: "html",
        url: "tea_buying_action.php",
        data: {
            action:"grading-table",
            saleno:saleno,
            broker:broker,
            category:category

        },
        success: function(data) {
            $("#gradingTable").html(data);
            $('.select2').select2({});
            $('.table').DataTable();
            $(".dimmer").hide();


        }
    });
}
function updateValue(element){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "tea_buying_action.php",
        data: {
            action:"update-grading",
            fieldName:$(element).attr("name"),
            fieldValue:$(element).val(),
            fieldKey:$(element).attr("id")
        },
        success: function(data) {
                return $.growl.notice({
                    message: $(element).attr("name")+" Updated Successfully"
                });
        
            alert(data.updated);

        }
    });
}

</script>