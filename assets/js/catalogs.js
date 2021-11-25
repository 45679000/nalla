
function buyingSummary(saleno){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "list-buying",
            saleno: saleno
        },
        cache: true,
        url: "tea_buying_action.php",
        success: function (data) {
         $('#listBuying').html(data);
         $(document).ready(function() {
            var table = $('#buyingListTable').DataTable({
                lengthChange: false,
                select: true,
                "pageLength": 100,
                dom: 'Bfrtip',
                "pageLength": 30,
                    dom: 'Bfrtip',
            
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5',
                ],
                // "scrollCollapse": true,
            });
             

        });
        }
    });
}


