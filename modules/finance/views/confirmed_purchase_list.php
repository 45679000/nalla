<div class="col-md-12">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header text-center">
                <div id="notificationId">
                </div>
                <div class="card">
                    <form method="post">
                        <div class="row justify-content-center">
                            <div class="col-md-6 well">
                                <div class="form-group form-inline">
                                    <label class="control-label">Select Action from the list</label>
                                    <select id="saleno" name="saleno"
                                        class="form-control select2"><small>(required)</small>
                                        <option disabled="" value="..." selected="">select</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body p-6">
                <div class="expanel expanel-secondary">
                    <div class="card">
                        <div class="card-header">
                            <div id="purchaseListactions" class="card-options">
                            </div>
                            <div id="purchaseListCustomOpt" class="custom-options">
                                <button id="confirmPList" class="btn btn-info btn-sm" type="submit" id="confirm"
                                    name="confirm" value="1">
                                    <i class="fa fa-check"></i> Confirm</button>
                                <button id="editPList" class="btn btn-danger btn-sm" type="submit" id="confirm"
                                    name="confirm" value="1">
                                    <i class="fa fa-pencil"></i> Edit</button>
                                <button id="emailPList" class="btn btn-warning btn-sm" type="submit" id="confirm"
                                    name="confirm" value="1">
                                    <i class="fa fa-envelope"></i> Notify Departments</button>

                            </div>
                        </div>
                        <div style="height:60vH" class="card-body table-responsive">
                            <div id="purchaseList">

                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
</div>
</div>
</body>


</html>
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/sweet_alert2.js"></script>
<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script id="url" data-name="../../ajax/common.php" src="../../assets/js/common.js"></script>


<script src="../../assets/plugins/datatable/dataTables.buttons.min.js"></script>
<script src="../../assets/plugins/datatable/jszip.min.js"></script>
<script src="../../assets/plugins/datatable/pdfmake.min.js"></script>
<script src="../../assets/plugins/datatable/vfs_fonts.js"></script>
<script src="../../assets/plugins/datatable/buttons.html5.min.js"></script>
<script src="../../assets/plugins/datatable/buttons.print.min.js"></script>
<script src="../../assets/plugins/datatable/buttons.colVis.min.js"></script>
<script src="../../assets/plugins/select2/select2.full.min.js"></script>

<script>
$(function() {
    $("#financeSubmenu").hide();
    $('#purchaseListCustomOpt').hide();
    $('select').on('change', function() {
        $('#purchaseListCustomOpt').show();
        var saleno = $('#saleno').find(":selected").text();
        localStorage.setItem("saleno", saleno);
        loadPurchaseList();
        checkActivityStatus(5, localStorage.getItem("saleno"));
    });


    $("body").on("click", ".confirmLot", function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            postToStock(id);
            loadPurchaseList();
    });
    $("body").on("click", ".unconfirmLot", function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            postToStock(id);
            loadPurchaseList();
    });


});

function postToStock(id) {
    $.ajax({
        type: "POST",
        dataType: "html",
        url: "finance_action.php",
        data: {
            action: "add_to_stock",
            id:id,
            saleno: localStorage.getItem("saleno")
        },
        success: function(data) {
            Swal.fire({
                icon: 'success',
                title: 'Posted To Stock',
            });
            loadPurchaseList();
            checkActivityStatus(5, localStorage.getItem("saleno"));
        }

    });

}
function checkActivityStatus(id, saleno){
    var activity;
    var message;
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "finance_action.php",
        data: {
            action: "activity",
            id:id,
            saleno:saleno      
        },
        success: function(data) {
            console.log(data[0]);
            message = data[0].details;
            status = data[0].completed;
            activity = data[0].activity_id;
            emailed = data[0].emailed;
            if((activity=="5") && (status=="1")){
                $("#confirmPList").html("confirmed");
                $('#confirmPList').prop('disabled', true);
                $("#editPList").hide();
            }
            if((activity=="5") && (emailed=="1")){
                $("#emailPList").html("Notification Sent");
                $('#emailPList').prop('disabled', true);
            }

        }

    });
}
function loadPurchaseList(){
    var click = localStorage.getItem("click");

    var formData = {
            saleno: localStorage.getItem("saleno"),
            action: "confirmed-purchase-list"
        };

    $.ajax({
            type: "POST",
            dataType: "html",
            url: "finance_action.php",
            data: formData,
            success: function(data) {
                $('#purchaseList').html(data);
                $(document).ready(function() {
                    var table = $('#purchaseListTable').DataTable({
                        lengthChange: false,
                        select: true,
                        "pageLength": 100,
                        dom: 'Bfrtip',
                        buttons: [{
                                extend: 'copyHtml5',
                                text: 'COPY<i class="fa fa-clipboard"></i>',
                                titleAttr: 'Copy Paste'
                            },
                            {
                                extend: 'excelHtml5',
                                text: 'EXCEL <i class="fa fa-file-excel-o"></i>',
                                titleAttr: 'Excel'
                            },
                            {
                                extend: 'csvHtml5',
                                text: 'CSV <i class="fa fa-file-text"></i>',
                                titleAttr: 'CSV'
                            },
                            {
                                extend: 'pdfHtml5',
                                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                                titleAttr: 'PDF'
                            }
                        ],
                        // "scrollCollapse": true,
                    });
                    if(click> 0){
                    table.buttons().containers().appendTo('#purchaseListactions');
                    }
                });
            },

        });
}
</script>