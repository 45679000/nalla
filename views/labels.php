<div class="col-md-8 col-lg-10">
                <div class="card">
                    <div class="card-body p-6">
                        <div class="col-md-12">
                            <div style="text-align: center;">
                                <button style="width:15%; height:40px;" class="btn btn-primary">Load</button>
                            </div>
                            <div class="expanel expanel-secondary">
                                <iframe src="../reports/files/labels.pdf" width="100%" height="800px">
                                </iframe>
                            </div>
                        </div>

                    </div>
                </div>
            </div>



            <!-- Dashboard js -->
<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../assets/js/vendors/selectize.min.js"></script>
<script src="../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../assets/js/vendors/circle-progress.min.js"></script>
<script src="../assets/plugins/rating/jquery.rating-stars.js"></script>
<!-- forn-wizard js-->
<script src="../assets/plugins/forn-wizard/js/material-bootstrap-wizard.js"></script>
<script src="../assets/plugins/forn-wizard/js/jquery.validate.min.js"></script>
<script src="../assets/plugins/forn-wizard/js/jquery.bootstrap.js"></script>
<!-- file import -->
<script src="../assets/plugins/fileuploads/js/dropify.min.js"></script>
<!-- Custom scroll bar Js-->
<script src=../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- counter  -->
<script src="../assets/plugins/counters/counterup.min.js"></script>
<script src="../assets/plugins/counters/waypoints.min.js"></script>
<!-- Custom Js-->
<script src="../assets/js/custom.js"></script>

<script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>

<script>
    $(function(e) {
        $('#tasting').DataTable();
    });
</script>
<script>
$(document).ready(function () {    
    $.ajax({
                type: "POST",
                dataType: "json",
                url: "../ajax/grading.php",
                data: {action: 'generate-lables'},
            success: function (data) {
                console.log('Submission was successful.');
                // location.reload();
                console.log(data);
                return data;
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
      

});

</script>

