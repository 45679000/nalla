
<style>
    .activeLink{
        background-color: green;
    }
</style>
<div class="col-md-12 col-lg-12">
    <div class="card">
        <div class="card-body p-2">
            <div class="col-md-12">
                <div class="expanel expanel-secondary">

                    <div class="expanel-heading">
                        <h3 class="expanel-title">Filter Stock</h3>
                    </div>
                    <div class="expanel-body">
                        <form method="post" class="filter" id="allFilter">
                            <div class="row justify-content-center">
                                <div class="col-md-2 well text-center">
                                    <div class="form-group label-floating">
                                        <label class="control-label">AUCTION</label>
                                        <select id="saleno" name="saleno" class="form-control select2"><small>(required)</small>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 well text-center">
                                    <div class="form-group label-floating">
                                        <label class="control-label">BROKER</label>
                                        <select id="broker" name="broker" class="form-control well select2"><small>(required)</small>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 well text-center">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Garden</label>
                                        <select id="mark" name="category" class="form-control well select2"><small>(required)</small>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 well text-center">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Standard</label>
                                        <select id="standard" name="category" class="form-control well select2"><small>(required)</small>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 well text-center">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Grade Code</label>
                                        <select id="code" name="category" class="form-control well select2"><small>(required)</small>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 well text-center">
                                    <div class="align-middle">
                                        <button id="filter" type="button" class="btn btn-warning btn-sm">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="col-md-12  col-xl-12">
                        <div class="card">
                            <div class="row" style="width:100%;">
                                    <div class="col-md-12">
                                    <button id="purchases" class="btn btn-success btn-sm category">Purchases</button>
                                    <button id="stock" class="btn btn-info btn-sm ml-2 category">Stock</button>
                                    <button id="stocko" class="btn btn-info btn-sm ml-2 category">Stock(Original Teas)</button>
                                    <button id="stockb" class="btn btn-info btn-sm ml-2 category">Stock(Blended Teas)</button>
                                    <button id="stockc" class="btn btn-info btn-sm ml-2 category">Stock(Contract Wise)</button>
                                    <button id="stocka" class="btn btn-info btn-sm ml-2 category">Stock(Awaiting Shipment)</button>
                                    <button id="stockpu" class="btn btn-info btn-sm ml-2 category">Paid Unallocated</button>
                                    <button id="stockuu" class="btn btn-info btn-sm ml-2 category">UnPaid Unallocated</button>
                                    </div>
                                    
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
    <script src="../../assets/js/warehousing.js"></script>

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

$("#stock-master").html(
    '<div class="card-body"><div class="dimmer active"><div class="spinner2"><div class="cube1"></div><div class="cube2"></div><div>Loading....</div></div></div></div>'
);

$('.select2').select2();
var category = "purchases";
// loadMasterStock(category);
initiateFilter();
$(".category").click(function(element){
    
    $("#stock-master").html(
    '<div class="card-body"><div class="dimmer active"><div class="spinner2"><div class="cube1"></div><div class="cube2"></div></div></div></div>'
    );
    category = $(this).attr("id");
    $(".category").removeClass("btn-success");
    $(this).addClass("btn-info");

    $(this).removeClass("btn-info");
    $(this).addClass("btn-success");

    localStorage.setItem("category", category);
    loadMasterStock(category);

})

$('#filter').click(function(e){
    e.preventDefault();
    $("#stock-master").html(
    '<div class="card-body"><div class="dimmer active"><div class="spinner2"><div class="cube1"></div><div class="cube2"></div><div>Loading....</div></div></div></div>'
    );
        var saleno = $('#saleno').val()
        var broker = $('#broker').val();
        var mark = $('#mark').val();
        var standard = $('#standard').val();
        var gradecode = $('#code').val();

        localStorage.setItem("fsaleno", saleno);
        localStorage.setItem("fbroker", broker);
        localStorage.setItem("fmark", mark);
        localStorage.setItem("fstandard", standard);
        localStorage.setItem("fgradecode", gradecode);

        if(localStorage.getItem("category")!==null){
            category = localStorage.getItem("category");
        }

        loadMasterStock(category);

    console.log("filtered "+saleno+" "+broker+" "+mark+" "+standard+" "+gradecode);

});
function initiateFilter() {
    $("#stock-master").html(
    '<div class="card-body"><div class="dimmer active"><div class="spinner2"><div class="cube1"></div><div class="cube2"></div><div>Loading....</div></div></div></div>'
    );
        var saleno = 'All'
        var broker = 'All'
        var mark = 'All'
        var standard = 'All'
        var gradecode = 'All'

        localStorage.setItem("fsaleno", saleno);
        localStorage.setItem("fbroker", broker);
        localStorage.setItem("fmark", mark);
        localStorage.setItem("fstandard", standard);
        localStorage.setItem("fgradecode", gradecode);

        if(localStorage.getItem("category")!==null){
            category = localStorage.getItem("category");
        }

        loadMasterStock(category);
}

$('.table').DataTable({
            "pageLength": 100,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });

});



</script>