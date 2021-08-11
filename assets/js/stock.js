$(document).ready(function() {
    loadPurchaseList();
    $('#purchaseListTable tbody').on('click', '#allocated', function() {
        var thisCell = table.cell(this);
        alert("table Clicked");
        SubmitData.lot = $(this).parents('tr').find("td:eq(0)").text();
        SubmitData.check = 0;
        console.log(SubmitData);
        // postData(SubmitData, "");

});

    function loadPurchaseList() {
        $.ajax({
            url: "../../modules/stock/stock-action.php",
            type: "POST",
            dataType: "html",
            data: {
                action: "purchase-list"
            },
            success: function(response) {
                $("#purchaseList").html(response);

            }

        });
    }
    function checkedRow(){
        var trs = document.querySelectorAll("tr");
        for (var i = 0; i < trs.length; i++)
        (function (e) {
            trs[e].addEventListener("click", function () {
                alert("cliked");
            console.log({
                "lot": this.querySelectorAll("*")[0].innerHTML.trim(),
            });
            }, false);
        })(i);

    }




function postData(formData, PostUrl) {
          $.ajax({
                type: "POST",
                dataType: "html",
                url: PostUrl,
                data: formData,
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
}

});

function loadMasterStock(type){
    $(document).ready(function() {

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "stock-action.php",
            data: {
                action:"master-stock",
                type:type,
                saleno:localStorage.getItem("sale_no"),
                broker:localStorage.getItem("broker"),
                mark:localStorage.getItem("mark")
            },
            success: function (data) {
                $('#stock-master').html(data);
                $('.table').DataTable({
                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;
            
                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };
            
                        // Total kgs all pages
                        totalkgs = api
                            .column( 10 )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );
            
                        // Total kgs this page
                        pageTotalkgs = api
                            .column( 10, { page: 'current'} )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );

                        // Total pkgs all pages
                        totalpkgs = api
                        .column( 8 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
        
                        // Total pkgs this page
                        pageTotalpkgs = api
                        .column( 8, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
            
                        // Update footer
                        $( api.column( 10 ).footer() ).html(
                            ''+pageTotalkgs +' kgs \n'+totalkgs+' kgs'
                        );
                        $( api.column( 8 ).footer() ).html(
                            ''+pageTotalpkgs +' pkgs <br>'+totalpkgs+' pkgs'
                        );
                    },
                    "pageLength": 100,
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]
                });
                
            }
        });
    });
}

function loadStockAllocation(type){
    $.ajax({
        type: "POST",
        dataType: "html",
        url: "stock-action.php",
        data: {
            action:"stock-allocation",
            type:type
        },
    success: function (data) {
        $('#stockAllocation').html(data);
        $('#allocatedStockTable').DataTable({
            "pageLength": 100,
            dom: 'Bfrtip'
        });
    },
    error: function (data) {
        $('#stockAllocation').html(data);
        console.log("failed");
    },
});
}