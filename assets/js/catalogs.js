
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
             

        });
        }
    });
}


