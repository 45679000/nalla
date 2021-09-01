<?php
$path_to_root = "../../";
require_once $path_to_root . 'templates/header.php';
?>
<div class="col-md-10 col-lg-10">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Confirm Provisional Purchase List</h3>
            <form method="post">
                <div class="row justify-content-center">
                    <div class="col-md-6 well">
                        <div class="form-group form-inline">
                            <label class="control-label">Select Action from the list</label>
                            <select id="saleno" name="saleno" class="form-control select2"><small>(required)</small>
                                <option disabled="" value="..." selected=""></option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <div>
                <button id="postBuyingList" class="btn btn-info btn-sm" type="submit" id="confirm" name="confirm"
                    value="1">Confirm Provisional Purchase List(Notify Finance)</button>
                    <button id="plist" class="btn btn-info btn-sm"><i class="fa fa-file"></i> Print Provisional Purchase List</button>
            </div>
        </div>
        <div class="text-center">
            <div class="card-body">
                <div id="listBuying" class="table-responsive">

                </div>
            </div>
        </div>
    </div>
</div>

<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<!-- Custom Js-->
<script id="url" data-name="../../ajax/common.php" src="../../assets/js/common.js"></script>

<script src="../../assets/js/custom.js"></script>
<script src="../../assets/js/catalogs.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
$(function() {
    buyingSummary('');
    $("body").on("click", ".confirmLot", function(e) {
        e.preventDefault();
        var lot = $(this).attr('id');
        addLot(lot);
    });
    $("body").on("click", ".unconfirmLot", function(e) {
        e.preventDefault();
        var lot = $(this).attr('id');
        removeLot(lot);
    });
    var sale_no = maxSaleNo();
    $("#saleno").change(function() {
        var sale_no = $('#saleno option:selected').text();
        buyingSummary(sale_no);
        localStorage.setItem("saleno", sale_no);
    })
    // checkActivityStatus(4, localStorage.getItem("saleno"));

    $("#postBuyingList").click(function(e) {
        $.ajax({
            type: "POST",
            dataType: "json",
            data: {
                action: "post-buyinglist",
                saleno: localStorage.getItem("saleno")
            },
            cache: true,
            url: "tea_buying_action.php",
            success: function(data) {
                buyingSummary(localStorage.getItem("saleno"));
                Swal.fire({
                    icon: 'success',
                    title: data.status,
                });
            }
        });
    });

    $("#plist").click(function(){
        $("#listBuying").html('<iframe class="frame" frameBorder="0" src="../../reports/purchase_list.php?type=auction&filter=true&saleno='+localStorage.getItem("saleno")+'" width="100%" height="800px"></iframe>');
                 
    });

});

function addLot(lot) {
    localStorage.setItem("click", "0");
    $.ajax({
        type: "POST",
        dataType: "html",
        url: "tea_buying_action.php",
        data: {
            action: "add-lot",
            lot: lot
        },
        success: function(data) {
            buyingSummary(localStorage.getItem("saleno"));
            console.log('Submission was successful.');
        }

    });
}

function removeLot(lot) {
    localStorage.setItem("click", "0");

    $.ajax({
        type: "POST",
        dataType: "html",
        url: "tea_buying_action.php",
        data: {
            action: "remove-lot",
            lot: lot
        },
        success: function(data) {
            buyingSummary(localStorage.getItem("saleno"));
            console.log('Submission was successful.');
        }

    });
}

function checkActivityStatus(id, saleno) {
    var activity;
    var message;
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "../../modules/finance/finance_action.php",
        data: {
            action: "activity",
            id: id,
            saleno: saleno
        },
        success: function(data) {
            console.log(data[0]);
            message = data[0].details;
            status = data[0].completed;
            activity = data[0].activity_id;
            emailed = data[0].emailed;

            if ((activity == "5") && (status == "1")) {
                $("#confirmPList").html("confirmed");
                $('#confirmPList').prop('disabled', true);
                $("#editPList").hide();
            }
            if ((activity == "5") && (emailed == "1")) {
                $("#emailPList").html("Notification Sent");
                $('#emailPList').prop('disabled', true);
            }

        }

    });
}

function maxSaleNo() {
    $.ajax({
        type: "POST",
        dataType: "json",
        data: {
            action: "get-max-saleno"
        },
        cache: true,
        url: "tea_buying_action.php",
        success: function(data) {
            localStorage.setItem("saleno", data.sale_no);
        }
    });
}
</script>

</html>