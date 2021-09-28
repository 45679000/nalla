function loadUnclosedBlends() {
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "show-unclosed"
        },
        cache: true,
        url: "../modules/blending/blend_action.php",
        success: function (data) {
            $('#tableData').html(data);

        }
    });
}
function dashboardSummaryTotals(){
    $.ajax({
        type: "POST",
        dataType: "json",
        data: {
            action: "dashboard-summary-totals"
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
            if(data.awaitingShipment==null){ $('#awaitingShipment').html("0 KGS");}else{$('#awaitingShipment').html(data.awaitingShipment);}
            if(data.shippedKgs==null){ $('#shipped').html("0 KGS");}else{$('#shipped').html(data.shippedKgs);}
            if(data.kgsInstock==null){ $('#availableStock').html("0 KGS");}else{$('#availableStock').html(data.kgsInstock);}
            if(data.unclosedBlends==null){ $('#unclosedBlend').html("0 KGS");}else{$('#unclosedBlend').html(data.unclosedBlends);}

        }
    });
}
function shipmentStatus(){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "shipments"
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#shippmentStatus').html(data);
         $("#dashboard").DataTable({});

        }
    });
}
function updateStatus(element){
    var sino = $(element).attr("id");
    console.log(sino);
    localStorage.setItem("si_no", sino);
    
}
function loadWarehouses(){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "load-warehouses"
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#warehouseTable').html(data);

        }
    });
}
function loadPackingMaterials(){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "load-packing-materials"
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#packingMaterial').html(data);
         $("#packing-materials").DataTable({});

        }

    });
}

function shippment(){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "shipment"
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#shippments').html(data);
         $("#shippment").DataTable({})

        }
    });
}
function loadOneShipment(sino){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "shipment",
            sino:sino
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#shippments').html(data);

        }
    });
}
function loadSiAllocation(sino){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "load-si-allocation",
            sino:sino
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#thisAllocation').html(data);
         $('#alloct').DataTable({});
        }
    });
}

function loadPackingMaterialsToAlloacate(){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "load-packing-materials-to-allocate"
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#stock').html(data);

        }
    });
}
function showPackingMaterialAlloacated(){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "allocated-materials"
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#materialAllocation').html(data);
         $('#alloctions').DataTable({});

        }
    });
}
function loadMasterStock(type){
    $(document).ready(function() {

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "../../modules/stock/stock-action.php",
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
