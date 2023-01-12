<?php
$path_to_root = "../";
require_once $path_to_root . 'templates/header.php';
?>
<style>
    .card-body {
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        margin: 0;
        padding: 0.5rem 0.5rem !important;
        position: relative;
    }
    .datePicker {
        display: none;
    }
    .error-mess {
        color: white;
        border-radius: 5px;
    }
</style>
<div class="container-fluid p-3">
    <div class="row row-cards" id="" style="padding: 10px;">
        <div class="col-sm-12 col-lg-1 col-md-1 d-flex align-items-stretch">
            <div id="printRA" class="card dashboardlink h-100">
            <div class="card-body">
                <div class="card-box tilebox-one">
                    <i class="icon-layers  text-muted"><a href="#"><i class="fa fa-file-pdf-o text-info" aria-hidden="true"></i></a></i>
                    <h6 class="text-drak text-uppercase mt-0">Print RA Teas</h6>
                </div>
            </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-1 col-md-1 d-flex align-items-stretch">
            <div id="cmdfinance" class="card dashboardlink h-100">
                <div class="card-body">
                    <div class="card-box tilebox-one">
                        <i class="icon-layers  text-muted"><a href="#"><i class="fa fa-money text-primary" aria-hidden="true"></i></a></i>
                        <h6 class="text-drak text-uppercase mt-0">Finance Reports</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-1 col-md-1 d-flex align-items-stretch">
            <div id="purchaseList" class="card dashboardlink h-100">
                <div class="card-body">
                    <div class="card-box tilebox-one">
                        <i class="icon-layers  text-muted"><a href="#"><i class="fa fa-file" aria-hidden="true"></i></a></i>
                        <h6 class="text-drak text-uppercase mt-0">Buying List</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card p-3">
        <form method="POST" class="datePicker">
            <div class="date-group row col-12">
                <div class="col-3">
                    <label for="from">Start date:</label>
                    <input type="date" id="from" name="startDate" class="form-control">
                </div>
                <div class="col-3">
                    <label for="to">End date:</label>
                    <input type="date" id="to" name="endDate" class="form-control">
                </div>
            </div>
            <p class="col-12 col-sm-6 error-mess p-2 bg-danger" style="display: none;" id="helpText"><span class="mx-2"><i class="fa fa-exclamation-triangle"></i></span> Select start and end dates</p>                
            <button class="btn btn-success" id="selectDate">Select</button>
            
        </form>
        <div class="row row-cards" id="dashboardWrapper" style="padding: 10px;">
        
        </div>
        
    </div>

</div>



<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script> -->
<script src=”https://code.jquery.com/jquery-3.3.1.slim.min.js”> </script>
<script src= “https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js”></script>
<script src=”https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js”></script>
<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../assets/js/vendors/circle-progress.min.js"></script>
<!-- Custom Js-->
<script src="../assets/js/custom.js"></script>
<script src="../assets/js/warehousing.js"></script>

<script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="../assets/js/sweet_alert2.js"></script>


<script src="../assets/plugins/datatable/dataTables.buttons.min.js"></script>
<script src="../assets/plugins/datatable/jszip.min.js"></script>
<script src="../assets/plugins/datatable/pdfmake.min.js"></script>
<script src="../assets/plugins/datatable/vfs_fonts.js"></script>
<script src="../assets/plugins/datatable/buttons.html5.min.js"></script>
<script src="../assets/plugins/datatable/buttons.print.min.js"></script>
<script src="../assets/plugins/datatable/buttons.colVis.min.js"></script>


<script>
    // print_report("#", "Finance Reports", "fa fa-money text-primary", "cmdfinance");
    // // print_report("./koolReports/stockbysaleno/stock_by_sale_no.php", "Stock By Sale No    ", "fa fa-calendar text-success", "");
    // print_report("#", "Print RA Teas", " fa fa-file-pdf-o text-info", "printRA");
    // print_report("#", "Buying List", "fa fa-file", "purchaseList");
    $("#cmdfinance").click(function(e) {
        $("#dashboardWrapper").html('<iframe src="/techteas/modules/finance/glRP/reporting/reports_main.php?Class=6" width="100%" height="1000" style="border:none;">');
    });
    $("#printRA").click(function(e) {
        e.preventDefault();
        $.ajax({
				type: "POST",
				data: {
					action: "printRA",
				},
				cache: true,
				url: "reportAction.php",
				success: function (data) {
					$("#dashboardWrapper").html(data);
					$(".table").dataTable({
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
                    });
				}
			});

    });
        // loadBuyingList()
        $('#selectDate').click(function(e) {
            e.preventDefault();
            var from = $('#from').val();
            var to = $('#to').val();
            if(from != 0 && to != 0){
                loadBuyingList(from, to);
            }else{
                document.getElementById('helpText').style.display = ''
            }
            
        });
    function loadBuyingList(from, to) {
        $.ajax({
            url: "reportAction.php",
            type: "POST",
            data: {
                action: "purchaseList",
                startDate: from,
                endDate: to,
            },
            success: function (data) {
					$("#dashboardWrapper").html(data);
					$(".table").dataTable({
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
                    });
                    document.getElementById('helpText').style.display = 'none'
				}
        });
    }
    
    $("#purchaseList").click(function(e) {
        e.preventDefault();
        $(".datePicker").removeClass();
        $("#closingimports_filter").appendChild(saP);
        if($("#closingimports_filter")){console.log('holla')}
    });

   function print_report(link, txt, icon, id){
       var content ='<div class="col-sm-12 col-lg-1 col-md-1 d-flex align-items-stretch">';
        if(id !=null){
            content+='<div id="'+id+'" class="card dashboardlink h-100">';
        }else{
            content+='<div  class="card dashboardlink h-100">';

        }
        content+='<div class="card-body">'
        content+='<div class="card-box tilebox-one">'
        content+='<i class="icon-layers  text-muted"><a href="'+link+'"><i class="'+icon+'" aria-hidden="true"></i></a></i>'
        content+='<h6 class="text-drak text-uppercase mt-0">'+txt+'</h6>'
        content+='</div>'
        content+='</div>'
        content+='</div>'
       $("#dashboardWrapper").append(content);             
   }
</script>

</html>