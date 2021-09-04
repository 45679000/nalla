
function loadMasterStock(type){
    $(document).ready(function() {

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "stock-action.php",
            data: {
                action:"master-stock",
                type:type,
                saleno:localStorage.getItem("fsaleno"),
                broker:localStorage.getItem("fbroker"),
                mark:localStorage.getItem("fmark"),
                standard:localStorage.getItem("fstandard"),
                gradecode:localStorage.getItem("fgradecode"),

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
                        // Total Value all pages
                        totalValue = api
                            .column( 14 )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );
            
                        // Total value this page
                        pagetotalValue = api
                            .column( 14, { page: 'current'} )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );




            
                        // Total kgs all pages
                        totalkgs = api
                            .column( 12 )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );
            
                        // Total kgs this page
                        pageTotalkgs = api
                            .column( 12, { page: 'current'} )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );

                        // Total pkgs all pages
                        totalpkgs = api
                        .column( 10 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
        
                        // Total pkgs this page
                        pageTotalpkgs = api
                        .column( 10, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                        
            
                        // Update footer
                        $( api.column( 12 ).footer() ).html(
                            ''+pageTotalkgs +' kgs <br>'+totalkgs+' kgs'
                        );
                        $( api.column( 10 ).footer() ).html(
                            ''+pageTotalpkgs +' pkgs <br>'+totalpkgs+' pkgs'
                        );
                        $( api.column( 14 ).footer() ).html(
                            ''+pagetotalValue.toFixed(2) +' USD <br>'+totalValue.toFixed(2)+' USD'
                        );
                    },
                    "pageLength": 30,
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5',
              
                        {
                            extend: "print",
                            customize: function(win)
                            {
                 
                                var last = null;
                                var current = null;
                                var bod = [];
                 
                                var css = '@page { size: landscape; font-size:2pt;}',
                                    head = win.document.head || win.document.getElementsByTagName('head')[0],
                                    style = win.document.createElement('style');
                 
                                style.type = 'text/css';
                                style.media = 'print';
                 
                                if (style.styleSheet)
                                {
                                  style.styleSheet.cssText = css;
                                }
                                else
                                {
                                  style.appendChild(win.document.createTextNode(css));
                                }
                 
                                head.appendChild(style);
                         }
                      },
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
            "pageLength": 50,
            dom: 'Bfrtip'
        });
        $('.select2').select2({});

    },
    error: function (data) {
        $('#stockAllocation').html(data);
        console.log("failed");
    },
});
}
function loadContractWise(PostUrl, type) {
    $.ajax({
          type: "POST",
          dataType: "html",
          url: PostUrl,
          data: {
              action:"contract-wise",
              type:type
          },
      success: function (data) {
          $('#stock-master').html(data);
      }
    });

}