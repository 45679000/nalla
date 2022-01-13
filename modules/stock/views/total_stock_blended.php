<style>
.filter {
    max-height: 12vH;
}
.table{
    white-space:nowrap; 
}

</style>
<div class="col-md-12 col-lg-12">
    <div class="card">
        <div class="card-body p-2">
            <div class="col-md-12">
                <div class="expanel expanel-secondary">

                    <div class="expanel-heading">
                        <h3 class="expanel-title">Total Stock Blended Tea</h3>
                    </div>
                    <div class="expanel-body">


                    </div>

                    <div class="col-md-12  col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <form method="post" class="filter" id="allFilter">
                                    <div class="row justify-content-center">
                                        <div class="col-md-2 well text-center">
                                            <div class="form-group label-floating">
                                                <label class="control-label">AUCTION</label>
                                                <select id="saleno" name="bl.sale_no"
                                                    class="form-control select2"><small>(required)</small>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 well text-center">
                                            <div class="form-group label-floating">
                                                <label class="control-label">BROKER</label>
                                                <select id="broker" name="broker"
                                                    class="form-control well select2"><small>(required)</small>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 well text-center">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Garden</label>
                                                <select id="mark" name="mark"
                                                    class="form-control well select2"><small>(required)</small>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 well text-center">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Standard</label>
                                                <select id="standard" name="standard"
                                                    class="form-control well select2"><small>(required)</small>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 well text-center">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Grade Code</label>
                                                <select id="code" name="comment"
                                                    class="form-control well select2"><small>(required)</small>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div id="stock-master" class="table-responsive">


                                    </div>
                                    <div>
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    </body>

    <script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
    <script src="../../assets/js/sweet_alert2.js"></script>

    <script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
    <script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
    <script id="url" data-name="../../ajax/common.php" src="../../assets/js/common.js"></script>


    <script src="../../assets/plugins/datatable/dataTables.buttons.min.js"></script>
    <script src="../../assets/plugins/datatable/jszip.min.js"></script>
    <script src="../../assets/plugins/datatable/pdfmake.min.js"></script>
    <script src="../../assets/plugins/datatable/vfs_fonts.js"></script>
    <script src="../../assets/plugins/datatable/buttons.html5.min.js"></script>
    <script src="../../assets/plugins/datatable/buttons.print.min.js"></script>
    <script src="../../assets/plugins/datatable/buttons.colVis.min.js"></script>
    <script src="../../assets/plugins/select2/select2.full.min.js"></script>
    <script>
    $(document).ready(function() {
        const filter = {};
        $("#stock-master").html(
            '<div class="card-body"><div class="dimmer active"><div class="spinner2"><div class="cube1"></div><div class="cube2"></div><div>Loading....</div></div></div></div>'
        );

        $('.select2').select2();

        loadMasterStock("tsblend");
        $("#saleno, #broker, #mark, #standard, #code").change(function(e) {
            var key = $(this).attr("name");
            var value = $(this).val();
            if(value=="All"){
                delete thisIsObject[key]; 
            }
            filter[key] = value;
            loadMasterStock("tsblend");


        });


        function loadMasterStock(type) {
            $(document).ready(function() {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    url: "stock-action.php",
                    data: {
                        action: "master-stock",
                        type: type,
                        filter: filter

                    },
                    success: function(data) {
                        $('#stock-master').html(data);
                        $('.table').DataTable({
                            "footerCallback": function(row, data, start, end,
                                display) {
                                var api = this.api(),
                                    data;

                                // Remove the formatting to get integer data for summation
                                var intVal = function(i) {
                                    return typeof i === 'string' ?
                                        i.replace(/[\$,]/g, '') * 1 :
                                        typeof i === 'number' ?
                                        i : 0;
                                };
                                // Total Value all pages
                                totalValue = api
                                    .column(14)
                                    .data()
                                    .reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                // Total value this page
                                pagetotalValue = api
                                    .column(14, {
                                        page: 'current'
                                    })
                                    .data()
                                    .reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                // Total kgs all pages
                                totalkgs = api
                                    .column(12)
                                    .data()
                                    .reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                // Total kgs this page
                                pageTotalkgs = api
                                    .column(12, {
                                        page: 'current'
                                    })
                                    .data()
                                    .reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                // Total pkgs all pages
                                totalpkgs = api
                                    .column(10)
                                    .data()
                                    .reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                // Total pkgs this page
                                pageTotalpkgs = api
                                    .column(10, {
                                        page: 'current'
                                    })
                                    .data()
                                    .reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);


                                // Update footer
                                $(api.column(12).footer()).html(
                                    '' + pageTotalkgs + ' kgs <br>' +
                                    totalkgs + ' kgs'
                                );
                                $(api.column(10).footer()).html(
                                    '' + pageTotalpkgs + ' pkgs <br>' +
                                    totalpkgs + ' pkgs'
                                );
                                $(api.column(14).footer()).html(
                                    '' + pagetotalValue.toFixed(2) +
                                    ' USD <br>' + totalValue.toFixed(2) +
                                    ' USD'
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
                                    customize: function(win) {

                                        var last = null;
                                        var current = null;
                                        var bod = [];

                                        var css =
                                            '@page { size: landscape; font-size:2pt;}',
                                            head = win.document.head || win
                                            .document.getElementsByTagName(
                                                'head')[0],
                                            style = win.document
                                            .createElement('style');

                                        style.type = 'text/css';
                                        style.media = 'print';

                                        if (style.styleSheet) {
                                            style.styleSheet.cssText = css;
                                        } else {
                                            style.appendChild(win.document
                                                .createTextNode(css));
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


    });
    </script>