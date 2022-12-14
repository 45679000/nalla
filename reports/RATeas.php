<?php
$path_to_root = "../";
require_once $path_to_root.'templates/header.php';

?>
    <div class="my-3 my-md-5">
        <div class="container-fluid">
            <div class="page-header">
                <h4 class="page-title">View Catalog</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/techteas/views/dashboard.php">home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"></li>
                </ol>
            </div>
            <div id="global-loader" ></div>

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
                                                <select id="saleno" name="saleno" class="select2 form-control" ><small>(required)</small> 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 well">
                                            <div class="form-group label-floating">
                                                <label class="control-label">BROKER</label>
                                                <select id="broker" name="broker" class="select2 form-control well" ><small>(required)</small>
                                                   
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 well">
                                            <div class="form-group label-floating">
                                                <label class="control-label">CATEGORY</label>
                                                <select id="category" name="category" class="select2 form-control well" ><small>(required)</small>
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
                                <div id="catalogview" class="table-responsive">
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
$(function() {

    $('select').on('change', function() {
         var saleno = $('#saleno').find(":selected").text();
         var broker = $.trim($('#broker').find(":selected").val());
         var category = $('#category').find(":selected").val();
         console.log("ready "+saleno+" broker "+broker+" category "+category);

         if(saleno !=='select' && broker !== 'select' && category !== 'select'){

            var formData = {
                saleno: saleno,
                broker: broker,
                category: category,
                action:"view-catalog"
            };

          $.ajax({
                type: "POST",
                dataType: "html",
                url: "../catalog_action.php",
                data: formData,
            success: function (data) {
                $('#catalogview').html(data);
                $('#closingimports').DataTable();
                console.log(data);
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });

    }

    });

    
});
    
</script>
       
</html>