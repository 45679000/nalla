<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<script>
$(document).ready(function() {
    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    setProgressBar(current);
    loadTemplates();
    loadStock("", "", "", "");

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
    $("#page1Btn").click(function(e) {
        if ($("#formData")[0].checkValidity()) {
            e.preventDefault();
            localStorage.setItem("invoiceno", $("#invoice_no").val());
            $.ajax({
                url: "finance_action.php",
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
                        moveNext(current);
                        $("#invoicenocreated").html(localStorage.getItem("invoiceno"));

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

    $("#submitUpdate").click(function(e) {
        if ($("#EditformData")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: "finance_action.php",
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
        var stockid = $(this).attr('id');
        $.ajax({
            url: "finance_action.php",
            type: "POST",
            data: {
                action: " select-invoice",
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
    $("body").on("click", ".addTea", function(e) {
        e.preventDefault();
        var stockid = $(this).attr('id');
        $(this).parent().text(localStorage.getItem("invoiceno"));

        $.ajax({
            url: "finance_action.php",
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
            url: "finance_action.php",
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
    $("#invoicenocreated").click(function(e) {
        e.preventDefault();
        loadUnallocated("", "", "", "");
    })

});
$('#proforma_template').change(function(e) {
    var id = $('#proforma_template').val();
    $.ajax({
        url: "finance_action.php",
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

function loadStock(mark, lot, grade, saleno) {
    $.ajax({
        type: "POST",
        data: {
            action: "load-unallocated",
            type: "straight",
            mark: mark,
            lot: lot,
            grade: grade,
            saleno: saleno
        },
        cache: true,
        url: "finance_action.php",
        success: function(data) {
            $("#stocklist").show();
            $('#stocklist').html(data);
            $('#direct_lot').DataTable({
                "pageLength": 10,
                dom: 'Bfrtip'
            });

        }
    });
}

function loadTemplates() {
    $.ajax({
        type: "POST",
        data: {
            action: "proforma_templates"

        },
        dataType: "html",
        url: "finance_action.php",
        success: function(data) {
            $('#proforma_template').html(data);
        }
    });

}

function moveNext(current) {

    setProgressBar(current);
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
   
}
function loadInvoiceTeas(){
    $.ajax({
        type: "POST",
        data: {
            action: "load-invoice-teas",
           
        },
        cache: true,
        url: "finance_action.php",
        success: function(data) {
            $("#stocklist").show();
            $('#stocklist').html(data);
            $('#direct_lot').DataTable({
                "pageLength": 10,
                dom: 'Bfrtip'
            });

        }
    });
}
</script>