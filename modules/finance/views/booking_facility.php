<style>
a {
    text-decoration: none;
    display: inline-block;
    padding: 8px 16px;
}

a:hover {
    background-color: #ddd;
    color: black;
}

.previous {
    background-color: #f1f1f1;
    color: black;
}

.next {
    background-color: #04AA6D;
    color: white;
}

.round {
    border-radius: 50%;
}

form .error {
    color: #ffff;
}

.form-control {
    color: black !important;
    padding: 1px !important;
}

.required:after {
    content: " *";
}
</style>


<div class="card" style="margin-top:20px;">
    <div class="card-header">
        <h3 class="card-title">Booking Facility</h3>
    </div>
    <div class="card-header">
        <button id="createSi" class="btn btn-success btn-sm">Create Facility</button>
        <button id="page_1" class="btn btn-success btn-sm">Print Cover Page</button>
        <button id="page_2" class="btn btn-success btn-sm">Print Schedule 2</button>
        <button id="page_3" class="btn btn-success btn-sm">Print Schedule Of Assets</button>
        <button id="page_4" class="btn btn-success btn-sm">Print Lot Details</button>
        <div class="clearfix" id="template-form">
            <span class="pl-4 pt-2 float-left">CREATE FROM TEMPLATE/EDIT/VIEW AN EXISTING BF </span>
            <form class="pl-4 float-right" method="post" style="width:300px;">
                <div class="form-group">
                    <select id="bk-templates" class="template select2" name="template">
                        <option disabled="" value="..." selected="">select</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body p-6">
        <div class="card-body" style="height:40% !important;">
            <form method="post" id="bookingFacility" class="card-body">
                <div class="row">
                    <div class="col-md-4 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Facility No</label>
                            <input required type="text" class="form-control required" id="facility_no"
                                name="facility_no" value="">
                        </div>
                    </div>
                    <div class="col-md-4 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Facility Reference</label>
                            <textarea required type="text" class="form-control required" id="facility_ref"
                                name="facility_ref" value=""></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Amount</label>
                            <input required type="text" class="form-control required" id="amount" name="amount"
                                value="">
                        </div>
                    </div>
                    <div class="col-md-4 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Value Date</label>
                            <input required type="text" class="form-control required" id="value_date" name="value_date"
                                value="">
                        </div>
                    </div>
                    <div class="col-md-4 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Tenure</label>
                            <input required type="text" class="form-control required" id="tenure" name="tenure"
                                value="">
                        </div>
                    </div>
                    <div class="col-md-4 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Beneficiary Name</label>
                            <input required type="text" class="form-control required" id="beneficiary_name"
                                name="beneficiary_name" value="">
                        </div>
                    </div>
                    <div class="col-md-4 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Beneficiary Bank</label>
                            <input required type="text" class="form-control required" id="beneficiary_bank"
                                name="beneficiary_bank" value="">
                        </div>
                    </div>
                    <div class="col-md-4 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Account Number</label>
                            <input required type="text" class="form-control required" id="account_number"
                                name="account_number" value="">
                        </div>
                    </div>
                    <div class="col-md-4 col-md-4">
                        <div class="form-group">
                            <label class="form-label">SWIFT Code</label>
                            <input required type="text" class="form-control required" id="swift_code" name="swift_code"
                                value="">
                        </div>
                    </div>
                    <div class="text-wrap mt-6">
                        <button type="submit" name="add" id="save" class="btn btn-success btn-sm">Save To Select
                            Lots</button>

                    </div>
                </div>
                <input type="hidden" class="form-control required" id="action" name="action"
                    value="create_booking_facility">

            </form>
            <div>
                <div id="plistContainer" class="col-md-12">
                    <div id="purchase_list_view"></div>
                </div>
            </div>
            <div id="previewFacility">

            </div>
        </div>
    </div>
</div>

<script src="<?php echo $path_to_root ?>assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="<?php echo $path_to_root ?>/assets/plugins/select2/select2.full.min.js"></script>


<script>
$(document).ready(function() {
    loadFacilityTemplates();

    function loadFacilityTemplates() {
        $.ajax({
            type: "POST",
            data: {
                action: "bk-templates"
            },
            dataType: "html",
            url: "finance_action.php",
            success: function(data) {
                $('#bk-templates').html(data);
            }
        });

    }


    $("#plistContainer").hide();

    $("#bookingFacility").on('submit', (function(e) {
        localStorage.setItem("fc_no", $("#facility_no").val());
        e.preventDefault();
        $.ajax({
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            url: "finance_action.php",
            success: function(data) {
                loadUnbookedLots();
                $("#plistContainer").show();
            }
        });

    }));

    function loadUnbookedLots() {
        $.ajax({
            type: "POST",
            dataType: "html",
            url: 'finance_action.php',
            data: {
                action: 'unbooked_lots',
            },
            success: function(data) {
                $("#purchase_list_view").html(data);
                $("#purchaseListTable").DataTable({
                    scrollX: '50vh',
                    scrollCollapse: false,
                    paging: true,
                    scrollY: '50vh',

                });

            }
        });

    }

    $("#page_1").click(function(e) {
        $("#bookingFacility").hide();
        $("#previewFacility").html(
            '<iframe class="frame" frameBorder="0" src="../../reports/booking_facility_cover_page.php?fc_no=' +
            localStorage.getItem("fc_no") + '" width="1000px" height="800px"></iframe>');
    });
    $("#page_2").click(function(e) {
        $("#bookingFacility").hide();
        $("#previewFacility").html(
            '<iframe class="frame" frameBorder="0" src="../../reports/booking_schedule_2.php?fc_no=' +
            localStorage.getItem("fc_no") + '" width="1000px" height="800px"></iframe>');
    });
    $('#bk-templates').change(function(e) {
        var id = $('#bk-templates').val();
        $.ajax({
            url: "finance_action.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "edit-facility",
                id: id
            },
            success: function(data) {
                for (const [key, value] of Object.entries(data[0])) {
                    $('#' + key).val(value);
                }


            }

        });
    });

});
</script>