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

<script src="../../assets/js/custom.js"></script>
<script id="url" data-name="../../ajax/common.php" src="../../assets/js/common.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/plugins/select2/select2.full.min.js"></script>
<script src="../../assets/plugins/notify/js/rainbow.js"></script>
<script src="../../assets/plugins/notify/js/jquery.growl.js"></script>

<script>
$(document).ready(function() {
    $('select').on('change', function() {
        var saleno = $('#saleno').find(":selected").text();
        var broker = $.trim($('#broker').find(":selected").val());
        var category = $('#category').find(":selected").val();

        $(".dimmer").show();

        if (saleno !== '...' && broker !== '...' && category !== '...') {
            $("#gradingTable").html(
                '<iframe class="frame" frameBorder="0" src="../../reports/auction_list.php?saleno=' +
                saleno + '&broker=' + broker + ' &category=' + category +
                '&filter=true" width="100%" height="800px"></iframe>');

        }

    });

});
</script>