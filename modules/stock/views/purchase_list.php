<style>
.navbuttons {
    display: inline-block;
    overflow: auto;
    overflow-y: hidden;

    max-width: 50%;
    margin: 0 0 1em;
    height: 50px;

    white-space: nowrap;

}

.navbuttons li {
    display: inline-block;
    vertical-align: top;
    padding: 5px;
    
}
.navigation{
    max-width: 200%;
    margin: 0 0 1em;
    height: 50px;

    white-space: nowrap;
}

</style>

<div class="col-md-12 col-lg-12">
    <div class="card">
        <div class="card-header text-center">
            <div id="notificationId">
                <span>Purchase List</span>
            </div>
        </div>
        <div class="card-body p-6">
            <div class="expanel expanel-secondary">
                <div class="card-header">
                <div class="navigation">
                    <ul id="sale_nav" class="navbuttons">
                      
                    </ul>
                </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div id="purchaseListactions" class="card-options">
                        </div>
                    </div>
                    <div style="height:60vH" class="card-body table-responsive">
                        <div id="purchaseList">

                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>

    </html>
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
    $(function() {
        var saleno = '2021-35';
        loadPlist(saleno)
        salenoListing();

        $(document).on('click','.plist', function(){
             click = localStorage.getItem("click");

            var saleno = $(this).attr("id");
            loadPlist(saleno);
        });

        var formData = {
                saleno: saleno,
                action: "confirmed-purchase-list"
            
            };
        $(".plist").click(function(element){
            $(this).attr('class', 'label label-success text-white p-2');
            var saleno = $(this).attr("id");

            var click = localStorage.getItem("click");
            loadPlist(saleno);
        })

        $('select').on('change', function() {
            var saleno = $('#saleno').find(":selected").text();
            localStorage.setItem("saleno", saleno);
            var formData = {
                saleno: saleno,
                action: "confirmed-purchase-list"
            
            };
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "../../modules/finance/finance_action.php",
                data: formData,
                success: function(data) {
                    $('#purchaseList').html(data);
                    $(document).ready(function() {
                        var table = $('#purchaseListTable').DataTable({
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
                            "columnDefs": [
                                {
                                    "targets": [ 20 ],
                                    "visible": false,
                                    "searchable": false
                                }
                            ]
                            // "scrollCollapse": true,
                        });
                        table.buttons().containers().appendTo(
                            '#purchaseListactions');

                    });
                },

            });
        });

        function loadPlist(saleno){
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "../../modules/finance/finance_action.php",
                data: {
                    action:"confirmed-purchase-list",
                    saleno:saleno,
                    type: 'A'
                },
                success: function(data) {
                    $('#purchaseList').html(data);
                    $(document).ready(function() {
                        var table = $('#purchaseListTable').DataTable({
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
                            "columnDefs": [
                                {
                                    "targets": [ 20 ],
                                    "visible": false,
                                    "searchable": false
                                }
                            ]
                            // "scrollCollapse": true,
                        });
                        if(click> 0){
                            table.buttons().containers().appendTo('#purchaseListactions');
                        }

                    });
                },

            });
        }
        function salenoListing(){
            var mynav = "";
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "../../modules/finance/finance_action.php",
                data: {
                    action:"get-sale-no",
                    type: 'A'
                },
                success: function(data) {
                    for(let i = 0; i<data.length; i++){
                         $('#sale_nav').append(
                            $('<li>').append(
                                $('<a>').attr({'id': data[i].sale_no,'class':'plist label label-primary text-white p-2', 'href':'#'}).append(
                                    $('<span>').attr('class', 'tab').append(data[i].sale_no)
                        ))); 

                    }

                }
            });
        }
    });
    </script>