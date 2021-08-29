<style>
.modal {
    position: absolute;
    top: 10px;
    right: 100px;
    bottom: 0;
    left: 0;
    z-index: 10040;
    overflow: auto;
    overflow-y: auto;
}
</style>
<div class="col-md-8 col-lg-10">
    <div class="card">
        <div class="card-header p-6">
        <span> Grading Codes </span>
        </div>
        <div class="card-body p-6">
            <div class="col-md-12">
                <div id="grading-codes" class="expanel expanel-secondary">

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
<!-- Custom Js-->
<script src="../../assets/js/custom.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script>
$(function(e) {
    $.ajax({
        type: "POST",
        dataType: "html",
        url: "tea_buying_action.php",
        data: {
            action: "grading-codes"
        },
        success: function(data) {
            $('#grading-codes').html(data);
            $(".table").DataTable({});

        }
    });

});
</script>