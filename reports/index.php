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
</style>
<div class="container-fluid p-3">
    <div class="card p-3">
        <div class="row row-cards" id="dashboardWrapper">
            
        </div>
    </div>

</div>



<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../assets/js/vendors/circle-progress.min.js"></script>
<!-- Custom Js-->
<script src="../assets/js/custom.js"></script>
<script src="../assets/js/warehousing.js"></script>

<script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="../assets/js/sweet_alert2.js"></script>
<script>
    print_report("#", "Finance Reports", "fa fa-money text-primary", "cmdfinance");
    print_report("./koolReports/stockbysaleno/stock_by_sale_no.php", "Stock By Sale No    ", "fa fa-calendar text-success", "");
    print_report("link", "txt", "icon", "");
    print_report("link", "txt", "icon", "");

    $("#cmdfinance").click(function(e) {
        $("#dashboardWrapper").html('<iframe src="/chamu/modules/finance/glRP/reporting/reports_main.php?Class=6" width="100%" height="1000" style="border:none;">');
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
       $("#dashboardWrapper").append(content
);             
   }
</script>

</html>