<style>
    .form-control {
        padding-bottom: 5px !important;
        color: black !important;
        display: block !important;
        width: 100% !important;
        padding: 0.375rem 0.75rem !important;
        padding-bottom: 0.375rem !important;
        font-size: 0.9375rem !important;
        line-height: 1.6 !important;
        color: black !important;
        background-color: #fff !important;
        background-clip: padding-box !important;
        border: 1px solid #eaeaea !important;
        border-radius: 3px !important;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
    }
</style>
<div class="col-md-10 col-lg-10">
    <div class="card">
        <div class="card-header">
            Add Private Purchases
        </div>
        <form method="post" id="prvt_purchase" class="card-body">
            <div class="row">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-md-3">
                            <!-- names should match the database columns -->
                            <div class="form-group"><label class="form-label">Auction</label>
                                <select name="sale_no" id="salenoPRVT" class="form-control select2" data-placeholder="Select">

                                </select>
                            </div>
                            <div class="form-group"><label class="form-label">Broker</label><select name="broker" id="broker" class="form-control  select2" data-placeholder="Select">
                                </select>
                            </div>
                            <div class="form-group"><label class="form-label">Sale Type</label>
                                <select name="category" id="category" class="form-control  select2" data-placeholder="Select">
                                    Select2 with search box<option value="Main">Main</option>
                                    <option value="seco">Secondary</option>
                                </select>
                            </div>
                            <div class="form-group"><label class="form-label">Invoice</label>
                                <input type="text" class="form-control" id="invoice" name="invoice" value="" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-md-3">
                            <div class="form-group"><label class="form-label">Garden</label><select name="mark" id="mark" class="form-control  select2" data-placeholder="Select">

                                </select>
                            </div>
                            <div class="form-group"><label class="form-label">Lot No</label><input type="text" class="form-control" id="lot" name="lot" value="" required></div>
                            <div class="form-group"><label class="form-label">Grade</label><select name="grade" id="grade" class="form-control  select2" data-placeholder="Select">
                                </select>
                            </div>
                            <div class="form-group"><label class="form-label">Gross</label><input type="text" class="form-control" id="gross" name="gross" value=""></div>
                        </div>
                        <div class="col-md-3 col-md-3">
                            <div class="form-group"><label class="form-label">Pkgs</label><input type="text" class="form-control" id="pkgs" name="pkgs" value="" required></div>
                            <div class="form-group"><label class="form-label">Kgs</label><input type="text" class="form-control" id="net" name="net" value="" required></div>
                            <div class="form-group"><label class="form-label">Net</label><input type="text" class="form-control" id="kgs" name="kgs" value="" required></div>
                            <div class="form-group"><label class="form-label">company</label><input type="text" class="form-control" id="company" name="company" value="" required></div>
                        </div>
                        <div class="col-md-3 col-md-3">
                            <div class="form-group"><label class="form-label">Value</label><input type="text" class="form-control" id="value" name="value" value="" required></div>
                            <div class="form-group"><label class="form-label">Pkg Type</label><select name="type" id="type" class="form-control  select2" data-placeholder="Select">
                                    Select2 with search box<option value="BPP">BPP</option>
                                    <option value="TPP">TPP</option>
                                    <option value="PB">PB</option>
                                </select>
                            </div>
                            <div class="form-group"><label class="form-label">Ware House</label><input type="text" class="form-control" id="ware_hse" name="ware_hse" value="" required></div>
                            <div class="form-group"><label class="form-label">Sale Price(In Ksh)</label>
                                <input type="text" class="form-control" id="sale_price" name="sale_price"  placeholder="120" required>
                            </div>
                            <input id="closing_cat_import_id" name="closing_cat_import_id" type="hidden">
                            <input id="buyer_package" name="buyer_package" value="CSS" type="hidden">

                        </div>
                        <button type="submit" id="savePrivate" class="btn btn-success">Save</button>
                        <button type="submit" id="updatePrivate" class="btn btn-success">Update</button>

                    </div>
                </div>

            </div>
        </form>
        <div class="card-footer">
        </div>
        <div class="card-body">
            <div class="card-header">
                <button id="plist" class="btn btn-info btn-sm"><i class="fa fa-file"></i>Print Provisional Purchase List</button>
                <div class="card-options">
                    <button id="addnewPrvt" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add Private Purchase</button>
                </div>
            </div>
            <div id="privatePurchasesGrid" class="table-responsive">

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
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="../../assets/js/sweet-alert.js"></script>
<script id="url" data-name="../../ajax/common.php" src="../../assets/js/common.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/js/sweet_alert2.js"></script>

<script>
    $('#prvt_purchase').hide();
    $('#updatePrivate').hide();

    $(document).ready(function() {
        $('#addnewPrvt').click(function(e) {
            e.preventDefault();
            $('#prvt_purchase').show();
        })
        saleno = '';
        broker = '';
        category = '';
        loadPrivatePurchases(saleno, broker, category);
        $("#savePrivate").click(function(e) {
            e.preventDefault();
            if ($("#invoice").val() == '') {
                alert("invoice number Cannot be empty");
            } else if ($("#pkgs").val() == '') {
                alert("PKgs number Cannot be empty");
                $("#pkgs").addClass("text-danger");
            } else if ($("#kgs").val() == '') {
                alert("Kgs  Cannot be empty");
            } else if ($("#net").val() == '') {
                alert("net Cannot be empty");
            } else if ($("#sale_price").val() == '') {
                alert("Sale Price Cannot be empty");
            } else if ($("#lot").val() == '') {
                alert("Lot Number Cannot be empty");
            } else if ($("#company").val() == '') {
                alert("Company Cannot be empty");
            } else {
                $.ajax({
                    url: "tea_buying_action.php",
                    type: "POST",
                    dataType: "json",
                    data: $("#prvt_purchase").serialize() + "&action=insert",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved Successfully',
                        });
                        $('#prvt_purchase').trigger("reset");
                        loadPrivatePurchases(saleno, broker, category);

                    }
                });
            }

        });

        $("body").on("click", ".editBtn", function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $("#savePrivate").hide();
            $.ajax({
                url: "tea_buying_action.php",
                type: "POST",
                dataType: "json",
                data: {
                    action: "editPrivate",
                    editId: id
                },
                success: function(data) {
                    $('#prvt_purchase').show();
                    $('#updatePrivate').show();
                    $("#closing_cat_import_id").val(data[0].closing_cat_import_id);
                    $("#pkgs").val(data[0].pkgs);
                    $("#kgs").val(data[0].kgs);
                    $("#net").val(data[0].net);
                    $("#lot").val(data[0].lot);
                    $("#broker").val(data[0].broker);
                    $("#value").val(data[0].value);
                    $("#category").val(data[0].category);
                    $("#mark").val(data[0].mark);
                    $("#grade").val(data[0].grade);
                    $("#invoice").val(data[0].invoice);
                    $("#type").val(data[0].type);
                    $("#sale_price").val(data[0].sale_price);
                    $("#ware_hse").val(data[0].ware_hse);

                }
            });
        });



    });

    function loadPrivatePurchases(saleno, broker, category) {
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "tea_buying_action.php",
            data: {
                action: "load-private-purchases",
                saleno: saleno,
                broker: broker,
                category: category
            },
            success: function(data) {
                $('#privatePurchasesGrid').html(data);
                $(".table").DataTable({});

            }
        });
    }
    $("#updatePrivate").click(function(e) {
        e.preventDefault();
        if ($("#invoice").val() == '') {
            alert("invoice number Cannot be empty");
        } else if ($("#pkgs").val() == '') {
            alert("PKgs number Cannot be empty");
            $("#pkgs").addClass("text-danger");
        } else if ($("#kgs").val() == '') {
            alert("Kgs  Cannot be empty");
        } else if ($("#net").val() == '') {
            alert("net Cannot be empty");
        } else if ($("#sale_price").val() == '') {
            alert("Sale Price Cannot be empty");
        } else if ($("#lot").val() == '') {
            alert("Lot Number Cannot be empty");
        } else if ($("#company").val() == '') {
            alert("Company Cannot be empty");
        } else {
            $.ajax({
                url: "tea_buying_action.php",
                type: "POST",
                dataType: "json",
                data: $("#prvt_purchase").serialize() + "&action=update",
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated Successfully',
                    });

                }
            });
        }

    });
    $("body").on("click", ".deleteBtn", function(e) {
        var id = $(this).attr('id');

        e.preventDefault();
        $.ajax({
            url: "tea_buying_action.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "delete",
                id: id
            },
            success: function(data) {
                loadPrivatePurchases(saleno, broker, category);
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted Successfully',
                });


            }
        });
    });
    $("body").on("click", ".confirmBtn", function(e) {
        var id = $(this).attr('id');

        e.preventDefault();
        $.ajax({
            url: "tea_buying_action.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "confirm-private",
                id: id
            },
            success: function(data) {
                loadPrivatePurchases(saleno, broker, category);
                Swal.fire({
                    icon: 'success',
                    title: 'Confirmed Successfully',
                });


            }
        });
    });

    $("#plist").click(function() {
        $("#privatePurchasesGrid").html('<iframe class="frame" frameBorder="0" src="../../reports/purchase_list.php?type=private&filter=true" width="100%" height="800px"></iframe>');

    });
    $("#go_back").click(function() {
        var saleno = localStorage.getItem("saleno");
        var broker = localStorage.getItem("broker");
        var category = localStorage.getItem("category");
        $("#go_back").hide();
        $("#buying_list").show();
        loadGradingTable(saleno, broker, category);

    });
</script>


</html>