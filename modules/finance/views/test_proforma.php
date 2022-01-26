<head>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css"> -->



</head>

<style>
* {
    margin: 0;
    padding: 0
}

html {
    height: 100%
}
.tlable{
    font: bold;
}
.tlableh{
    height: 2px !important;
    padding: 0px;
}
table{
    border-collapse: collapse;
    border: 1px solid black;
}

</style>


<div class="container-fluid mt-50">
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Invoice Details
                    </div>
                    <div class="card-body">
                        <div id="id1_1">
                            <table>
                                <tr>
                                    <td class="tlableh" style="width:60vH;">
                                        <p class="tlable">BUYER</p>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    <table style="border:none">
                                        <tr>
                                            <td style="padding-right: 10vH;">
                                                <p>Invoice No:</p>
                                            </td>
                                            <td style="padding-right: 10vH;">
                                                <p>Date:</p>
                                            </td>
                                        </tr>
                                        
                                    </table>
                                    </td>  
                                </tr>
                                <tr>
                                    <td class="tlableh" style="width:60vH;">
                                        <textarea class="ffield" id="address"></textarea>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    <table style="border:none">
                                        <tr>
                                            <td style="padding-right: 10vH;">
                                                <input class="ffield" id="invoice_no" type="text"></input>
                                            </td>
                                            <td style="padding-right: 20vH;">
                                                <input class="ffield" id="date" type="text"></input>
                                            </td>
                                        </tr>
                                        
                                    </table>
                                    </td>  
                                </tr>
                                
                            </table>
                            <div class="card-footer">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                Invoice Preview

                            </div>
                            <div class="card-body">

                                <div class="card-footer">

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
            <script src="<?php echo $path_to_root ?>assets/js/vendors/jquery-3.2.1.min.js"></script>
            <script id="url" data-name="../../../ajax/common.php" src="../../../assets/js/common.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <script src="<?php echo $path_to_root ?>assets/plugins/select2/select2.full.min.js"></script>
            <script src="<?php echo $path_to_root ?>assets/plugins/datatable/jquery.dataTables.min.js"></script>
            <script src="<?php echo $path_to_root ?>assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>


            <script src="<?php echo $path_to_root ?>assets/plugins/datatable/dataTables.buttons.min.js"></script>
            <script src="<?php echo $path_to_root ?>assets/plugins/datatable/jszip.min.js"></script>
            <script src="<?php echo $path_to_root ?>assets/plugins/datatable/pdfmake.min.js"></script>
            <script src="<?php echo $path_to_root ?>assets/plugins/datatable/vfs_fonts.js"></script>
            <script src="<?php echo $path_to_root ?>assets/plugins/datatable/buttons.html5.min.js"></script>
            <script src="<?php echo $path_to_root ?>assets/plugins/datatable/buttons.print.min.js"></script>

            <script>
            $("body").on("blur", ".updateableText", function(e) {
                var value = $(this).val();
                var name = $(this).attr("name");
                $.ajax({
                    type: "POST",
                    data: {
                        action: "update-blend-value",
                        value: value,
                        id: $(this).parent().parent().attr("id"),
                        name: name
                    },
                    cache: true,
                    url: "../finance_action.php",
                    success: function(data) {

                    }
                });
            });
            $(document).ready(function() {
                $('.select2').select2();

                $("#page1Btn").hide();

                var current_fs, next_fs, previous_fs; //fieldsets
                var opacity;
                var current = 1;
                var steps = $("fieldset").length;

                setProgressBar(current);
                loadTemplates();




                $("#loadTeas").click(function(e) {
                    loadInvoiceTeas();
                })
                $("#viewInvoice").click(function(e) {
                    e.preventDefault();
                    $("#invoicePreview").html(
                        '<iframe class="frame" frameBorder="0" src="../../../reports/invoice_proforma_blend.php?invoiceno=' +
                        localStorage.getItem("invoiceno") +
                        '" width="1000px" height="800px"></iframe>');

                });
                $("#Preview").click(function(e) {
                    $("#invoicePreview").html(
                        '<iframe class="frame" frameBorder="0" src="../../../reports/invoice_proforma_blend.php?invoiceno=' +
                        localStorage.getItem("invoiceno") +
                        '" width="1000px" height="800px"></iframe>');
                });
                $(".next").click(function() {

                    current_fs = $(this).parent();
                    next_fs = $(this).parent().next();

                    //Add Class Active
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    //show the next fieldset
                    next_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({
                        opacity: 0
                    }, {
                        step: function(now) {
                            // for making fielset appear animation
                            opacity = 1 - now;

                            current_fs.css({
                                'display': 'none',
                                'position': 'relative'
                            });
                            next_fs.css({
                                'opacity': opacity
                            });
                        },
                        duration: 500
                    });
                    setProgressBar(++current);
                });
                $(".previous").click(function() {

                    current_fs = $(this).parent();
                    previous_fs = $(this).parent().prev();

                    //Remove class active
                    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                    //show the previous fieldset
                    previous_fs.show();

                    //hide the current fieldset with style
                    current_fs.animate({
                        opacity: 0
                    }, {
                        step: function(now) {
                            // for making fielset appear animation
                            opacity = 1 - now;

                            current_fs.css({
                                'display': 'none',
                                'position': 'relative'
                            });
                            previous_fs.css({
                                'opacity': opacity
                            });
                        },
                        duration: 500
                    });
                    setProgressBar(--current);
                });
                $("body").on("blur", ".updateable", function(e) {
                    if ((name == "total_net") || name == "p_cif_rate") {
                        $(this).attr("p_amount").text(Number($(this).attr("total_net")) * Number($(this)
                            .attr(
                                "p_cif_rate")));
                    }

                    var value = $(this).text();
                    var name = $(this).attr("name");
                    $.ajax({
                        type: "POST",
                        data: {
                            action: "update-blend-value",
                            value: value,
                            id: $(this).parent().attr("id"),
                            name: name
                        },
                        cache: true,
                        url: "../finance_action.php",
                        success: function(data) {

                        }
                    });


                    function setProgressBar(curStep) {
                        var percent = parseFloat(100 / steps) * curStep;
                        percent = percent.toFixed();
                        $(".progress-bar")
                            .css("width", percent + "%")
                    }
                    $("#saveBtn").click(function(e) {
                        if ($("#formData")[0].checkValidity()) {
                            e.preventDefault();
                            localStorage.setItem("invoiceno", $("#invoice_no").val());
                            $.ajax({
                                url: "../finance_action.php",
                                type: "POST",
                                data: $("#formData").serialize() +
                                    "&action=save-invoice",
                                dataType: "json",
                                success: function(response) {
                                    if (response.code == 201) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: response.error,
                                        });
                                    }
                                    if (response.code == 200) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: response.success,
                                        });
                                        $("#saveBtn").hide();
                                        $("#page1Btn").show();

                                    }
                                    if (response.code == 500) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: response.error,
                                        });
                                    }
                                },
                                error: function(response) {
                                    console.log(response);
                                    // alert("response= "+response.code);
                                }
                            });
                        }


                    });
                    $("#buyer").change(function(e) {
                        var address = $(this).children(":selected").attr("name");
                        $("#buyer_address").val(address);
                    });
                    $("#bank_id").change(function(e) {
                        var bank_address = $(this).children(":selected").attr("name");
                        $("#pay_bank").val(bank_address);
                    });
                    $("#submitUpdate").click(function(e) {
                        if ($("#EditformData")[0].checkValidity()) {
                            e.preventDefault();
                            $.ajax({
                                url: "../finance_action.php",
                                type: "POST",
                                data: $("#EditformData").serialize() + "&action=update",
                                dataType: "html",
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Record Updated',
                                    });
                                    $("#editModal").modal('hide');
                                    $("#EditformData")[0].reset();
                                }



                            });
                        }
                    });
                    $("body").on("click", ".removeTea", function(e) {
                        e.preventDefault();
                        var id = $(this).attr('id');
                        $.ajax({
                            url: "../finance_action.php",
                            type: "POST",
                            data: {
                                action: "remove-invoice-tea",
                                id: id,
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Tea Removed',
                                });
                                loadInvoiceTeas();
                            }
                        });
                    });
                    $("#submitPI").click(function(e) {
                        $("#finalSubmit").html(
                            '<h5 class="purple-text text-center">You Have Successfully Created Invoice</h5>' +
                            localStorage.getItem("invoiceno"));
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    })

                });
                $('#proforma_template').change(function(e) {
                    var id = $('#proforma_template').val();
                    $.ajax({
                        url: "../finance_action.php",
                        type: "POST",
                        dataType: "json",
                        data: {
                            action: "edit-si-invoice",
                            id: id
                        },
                        success: function(data) {
                            for (const [key, value] of Object.entries(data[0])) {
                                $('#' + key).val(value);
                            }


                        }

                    });
                });
                $("body").on("click", ".deleteBtn", function(e) {
                    e.preventDefault();
                    var deleteId = $(this).attr('id');
                    $.ajax({
                        url: "../finance_action.php",
                        type: "POST",
                        data: {
                            deleteId: deleteId
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Record deleted successfully',
                            });
                        }
                    });
                });
                $("body").on("blur", ".profoma_amount", function(e) {
                    var id = $(this).attr('id');
                    var value = $(this).text();
                    $.ajax({
                        type: "POST",
                        data: {
                            action: "update-invoice-value",
                            value: value,
                            id: id
                        },
                        cache: true,
                        url: "finance_action.php",
                        success: function(data) {

                        }
                    });
                });
                $("body").on("click", "#add", function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        data: {
                            action: "add-line",
                            id: localStorage.getItem("invoiceno")

                        },
                        dataType: "html",
                        url: "../finance_action.php",
                        success: function(data) {
                            loadInvoiceTeas();
                        }
                    })
                });
                $("body").on("click", ".remove", function(e) {
                    e.preventDefault();
                    var id = $(this).attr('id');
                    $.ajax({
                        type: "POST",
                        data: {
                            action: "remove-line",
                            id: id
                        },
                        dataType: "html",
                        url: "../finance_action.php",
                        success: function(data) {
                            loadInvoiceTeas();
                        }
                    });
                });
                $("#submitPI").click(function(e) {
                    $("#finalSubmit").html(
                        '<h5 class="purple-text text-center">You Have Successfully Created Invoice</h5>' +
                        localStorage.getItem("invoiceno"));
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                });

                function loadInvoiceTeas() {
                    $.ajax({
                        type: "POST",
                        dataType: "html",
                        data: {
                            action: "load-invoice-teas-blend",
                            invoice: localStorage.getItem("invoiceno")
                        },
                        cache: true,
                        url: "../finance_action.php",
                        success: function(data) {
                            $("#invoiceTeaList").show();
                            $('#invoiceTeaList').html(data);
                            $('#added_lots').DataTable({
                                "pageLength": 10,
                                dom: 'Bfrtip'
                            });

                        }
                    });

                }

            });
            </script>







































            <script>
            $(document).ready(function() {
                $("#page1Btn").hide();

                var current_fs, next_fs, previous_fs; //fieldsets
                var opacity;
                var current = 1;
                var steps = $("fieldset").length;

                setProgressBar(current);
                loadTemplates();
                loadInvoiceTeas();
                $("#Preview").click(function(e) {
                    $("#invoicePreview").html(
                        '<iframe class="frame" frameBorder="0" src="../../reports/invoice_proforma_blend.php?invoiceno=' +
                        localStorage.getItem("invoiceno") +
                        '" width="1000px" height="800px"></iframe>');
                });
                $(".next").click(function() {

                    current_fs = $(this).parent();
                    next_fs = $(this).parent().next();

                    //Add Class Active
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    //show the next fieldset
                    next_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({
                        opacity: 0
                    }, {
                        step: function(now) {
                            // for making fielset appear animation
                            opacity = 1 - now;

                            current_fs.css({
                                'display': 'none',
                                'position': 'relative'
                            });
                            next_fs.css({
                                'opacity': opacity
                            });
                        },
                        duration: 500
                    });
                    setProgressBar(++current);
                });

                $(".previous").click(function() {

                    current_fs = $(this).parent();
                    previous_fs = $(this).parent().prev();

                    //Remove class active
                    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                    //show the previous fieldset
                    previous_fs.show();

                    //hide the current fieldset with style
                    current_fs.animate({
                        opacity: 0
                    }, {
                        step: function(now) {
                            // for making fielset appear animation
                            opacity = 1 - now;

                            current_fs.css({
                                'display': 'none',
                                'position': 'relative'
                            });
                            previous_fs.css({
                                'opacity': opacity
                            });
                        },
                        duration: 500
                    });
                    setProgressBar(--current);
                });

                function setProgressBar(curStep) {
                    var percent = parseFloat(100 / steps) * curStep;
                    percent = percent.toFixed();
                    $(".progress-bar")
                        .css("width", percent + "%")
                }
                $("#saveBtn").click(function(e) {
                    if ($("#formData")[0].checkValidity()) {
                        e.preventDefault();
                        localStorage.setItem("invoiceno", $("#invoice_no").val());
                        $.ajax({
                            url: "../finance_action.php",
                            type: "POST",
                            data: $("#formData").serialize() + "&action=save-invoice",
                            dataType: "json",
                            success: function(response) {
                                if (response.code == 201) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: response.error,
                                    });
                                }
                                if (response.code == 200) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: response.success,
                                    });
                                    $("#saveBtn").hide();
                                    $("#page1Btn").show();

                                }
                                if (response.code == 500) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: response.error,
                                    });
                                }
                            },
                            error: function(response) {
                                console.log(response);
                                // alert("response= "+response.code);
                            }
                        });
                    }


                });
                $("body").on("blur", ".updateable", function(e) {
                    if ((name == "total_net") || name == "p_cif_rate") {
                        $(this).attr("p_amount").text(Number($(this).attr("total_net")) * Number($(this)
                            .attr(
                                "p_cif_rate")));
                    }

                    var value = $(this).text();
                    var name = $(this).attr("name");
                    $.ajax({
                        type: "POST",
                        data: {
                            action: "update-blend-value",
                            value: value,
                            id: $(this).parent().attr("id"),
                            name: name
                        },
                        cache: true,
                        url: "../finance_action.php",
                        success: function(data) {

                        }
                    })

                });
                $("#submitUpdate").click(function(e) {
                    if ($("#EditformData")[0].checkValidity()) {
                        e.preventDefault();
                        $.ajax({
                            url: "../finance_action.php",
                            type: "POST",
                            data: $("#EditformData").serialize() + "&action=update",
                            dataType: "html",
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Record Updated',
                                });
                                $("#editModal").modal('hide');
                                $("#EditformData")[0].reset();
                            }



                        });
                    }
                });
                $("body").on("click", ".removeTea", function(e) {
                    e.preventDefault();
                    var id = $(this).attr('id');
                    $.ajax({
                        url: "../finance_action.php",
                        type: "POST",
                        data: {
                            action: "remove-invoice-tea",
                            id: id,
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Tea Removed',
                            });
                            loadInvoiceTeas();
                        }
                    });
                });
                $("body").on("click", ".addTea", function(e) {
                    e.preventDefault();
                    var stockid = $(this).attr('id');
                    $(this).parent().text(localStorage.getItem("invoiceno"));

                    $.ajax({
                        url: "../finance_action.php",
                        type: "POST",
                        data: {
                            action: "select-invoice",
                            stockid: stockid,
                            invoiceid: localStorage.getItem("invoiceno")
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Tea Added',
                            });
                        }
                    });
                });
                //Delete Record
                $("body").on("click", ".deleteBtn", function(e) {
                    e.preventDefault();
                    var deleteId = $(this).attr('id');
                    $.ajax({
                        url: "../finance_action.php",
                        type: "POST",
                        data: {
                            deleteId: deleteId
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Record deleted successfully',
                            });
                        }
                    });
                });
                $("body").on("blur", ".profoma_amount", function(e) {
                    var id = $(this).attr('id');
                    var value = $(this).text();
                    $.ajax({
                        type: "POST",
                        data: {
                            action: "update-invoice-value",
                            value: value,
                            id: id
                        },
                        cache: true,
                        url: "finance_action.php",
                        success: function(data) {

                        }
                    });
                });
                $("body").on("click", "#add", function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        data: {
                            action: "add-line",
                            id: localStorage.getItem("invoiceno")

                        },
                        dataType: "html",
                        url: "../finance_action.php",
                        success: function(data) {
                            loadInvoiceTeas();
                        }
                    })
                });
                $("body").on("click", ".remove", function(e) {
                    e.preventDefault();
                    var id = $(this).attr('id');
                    $.ajax({
                        type: "POST",
                        data: {
                            action: "remove-line",
                            id: id
                        },
                        dataType: "html",
                        url: "../finance_action.php",
                        success: function(data) {
                            loadInvoiceTeas();
                        }
                    });
                });
                $("#submitPI").click(function(e) {
                    $("#finalSubmit").html(
                        '<h5 class="purple-text text-center">You Have Successfully Created Invoice</h5>' +
                        localStorage.getItem("invoiceno"));
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                });
            });
            $('#proforma_template').change(function(e) {
                var id = $('#proforma_template').val();
                $.ajax({
                    url: "../finance_action.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: "edit-si-invoice",
                        id: id
                    },
                    success: function(data) {
                        for (const [key, value] of Object.entries(data[0])) {
                            $('#' + key).val(value);
                        }


                    }

                });
            });


            function loadTemplates() {
                $.ajax({
                    type: "POST",
                    data: {
                        action: "proforma_templates"
                    },
                    dataType: "html",
                    url: "../finance_action.php",
                    success: function(data) {
                        $('#proforma_template').html(data);
                    }
                });

            }

            function loadInvoiceTeas() {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    data: {
                        action: "load-invoice-teas-blend",
                        invoice: localStorage.getItem("invoiceno")
                    },
                    cache: true,
                    url: "../finance_action.php",
                    success: function(data) {
                        $("#invoiceTeaList").show();
                        $('#invoiceTeaList').html(data);
                        $('#added_lots').DataTable({
                            "pageLength": 10,
                            dom: 'Bfrtip'
                        });

                    }
                });

            }
            </script>