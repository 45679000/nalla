<style>
    .form-control-cstm {
        border: 1px solid !important;
        padding-bottom: 1px !important;
        color: black !important;
        height: 30px !important;
    }

    table {
        margin: 0 auto;
        width: 60%;
        clear: both;
        border-collapse: collapse;
        table-layout: fixed;
        word-wrap: break-word;
    }

    td,
    th {
        width: 20%;
    }

    .form-control-btn {
        height: 50px !important;
        background-color: green;
        color: white;
    }
</style>

<div class="col-md-8 col-lg-10">
    <div class="card">
        <div class="card-body p-6">
            <div class="col-md-12">
                <div class="expanel expanel-secondary">

                    <div class="expanel-heading">
                        <h3 class="expanel-title">Allocate Stock</h3>
                        <?php echo $msg ?>
                    </div>
            

                    <div class="card-body">
                        <div id ="allocatedStock" class="table-responsive">
                          

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>


    <!-- Dashboard js -->
<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../assets/js/vendors/selectize.min.js"></script>
<script src="../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../assets/js/vendors/circle-progress.min.js"></script>
<script src="../assets/plugins/jquery-tabledit/jquery.tabledit.js"></script>
<script src="../assets/js/common.js"></script>
<script src="../assets/plugins/select2/select2.full.min.js"></script>
<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>

<script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>


<script src="../assets/plugins/datatable/dataTables.buttons.min.js"></script>
<script src="../assets/plugins/datatable/jszip.min.js"></script>
<script src="../assets/plugins/datatable/pdfmake.min.js"></script>
<script src="../assets/plugins/datatable/vfs_fonts.js"></script>
<script src="../assets/plugins/datatable/buttons.html5.min.js"></script>
<script src="../assets/plugins/datatable/buttons.print.min.js"></script>
<script>
   $(document).ready(function(){
        var dataList = document.getElementById("remarks");
        loadRemarkOptions(dataList);
   });
function toggleClass(element){
    $(element).removeClass('noedit');
    $(element).addClass('edit');

}
function addRemark(element){
    if(($(element).val() !== null) && ($(element).val() !== "")){
      
            $.ajax({
                type: "POST",
                dataType: "html",
                url: '../modules/stock/stock-action.php',
                data: {
                    action:'add-remark',
                    lot:$(element).attr('id'),
                    remark:$(element).val()
                },
            success: function (data) {
                $(element).removeClass('edit');
                $(element).addClass('noedit');
                return data;
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    }
}
function loadRemarkOptions(element){
            $.ajax({  
                type: "POST",
                dataType: "json",
                url: '../ajax/common.php',
                data: {
                    action:'remark-opt'
                },
            success: function (data) {
              for($i = 0; $i<data.length; $i++){
                $(element).append('<option>'+data[$i].remark+'</option>');

              }

            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
         });
        }


</script>

<script>
var SubmitData = new Object();
var Client = [""],
    Standard = [""],
    table = $('#allocatedStockTable').DataTable({
        columnDefs: [{
            targets: [0],
            "className": "pk",
            visible: true
        }, {
            targets: [11],
            "className": "client"
        }, {
            targets: [12],
            "className": "standard"
        }],
        initComplete: function() {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: ".../modules/stock/stock-action.php",
                data: {action: 'allocation'},
            success: function (data) {
                for(var i=0; i<data.length; i++){
                    Client.push(data[i].code);
                    }
                },
            });

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "../ajax/grading.php",
                data: {action: 'grading-standards'},
            success: function (data) {
                for(var i=0; i<data.length; i++){
                    Standard.push(data[i].standard);
                    }
                },
            });
            

        }
    });


$('#allocatedStockTable tbody').on('click', '.client', function() {
    if (!$('#allocatedStockTable').hasClass("editing")) {
        $('#allocatedStockTable').addClass("editing");
        var thisCell = table.cell(this);

        SubmitData.pkey = $(this).parents('tr').find("td:eq(0)").text();

        thisCell.data($("<select></select>", {
            "class": "changePosition"
        }).append(Client.map(v => $("<option></option>", {
            "text": v,
            "value": v,
            "selected": (v === thisCell.data())
        }))).prop("outerHTML"));

        $('select').on('change', function() {
            SubmitData.fieldValue = this.value;
            SubmitData.fieldName = 'client';
            postData(SubmitData, "");
            console.log(SubmitData);

        });
    }
});
$('#allocatedStockTable tbody').on('click', '.standard', function() {
    if (!$('#allocatedStockTable').hasClass("editing")) {
        $('#allocatedStockTable').addClass("editing");
        var thisCell = table.cell(this);
        thisCell.data($("<select></select>", {
            "class": "changeLocation"
        }).append(Standard.map(v => $("<option></option>", {
            "text": v,
            "value": v,
            "selected": (v === thisCell.data())
        }))).prop("outerHTML"));
    }
    $('select').on('change', function() {
            SubmitData.pkey = $(this).parents('tr').find("td:eq(0)").text();
            SubmitData.fieldName = 'standard';
            SubmitData.fieldValue = this.value;
            postData(SubmitData, "");
            console.log(SubmitData);

    });

});
$('#closingimport tbody').on("change", ".changePosition", () => {
    table.cell($(".changePosition").parents('td')).data($(".changePosition").val());
    $('#closingimport').removeClass("editing");
});
$('#closingimport tbody').on("change", ".changeLocation", () => {
    table.cell($(".changeLocation").parents('td')).data($(".changeLocation").val());
    $('#closingimport').removeClass("editing");
});

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



</script>
    <script>
        lotList();
        standardList();
        loadAllocated();


        $('.select2-show-search').select2({

            placeholder: 'Select an item',
        });
        $('#stock_id').change(function() {
            var stock_id = $('#stock_id').val();
            $.ajax({
                url: "../ajax/common.php",
                type: "POST",
                dataType: "json",
                data: {
                    action: "lot-list",
                    id: stock_id
                },
                success: function(data) {
                    var standard = data[0].standard;
                    if (standard == null) {
                        $('#centralModal').modal('show');
                    }else{
                        $('#std').val(standard);
                    }
                    $("#pkgs").val(data[0].pkgs);
                    $('#pkg_stock').val(data[0].pkgs);
                }

            });
        })
        $('#standard').change(function() {
            $("#std").val($('#standard').val());

        });
        $('#allocate').click(function(e){
            e.preventDefault();
            var standard = $("#std").val();
            var client = $("#clientwithcode").val();
            var stock_id = $("#stock_id").val();
            var pkgs = $("#pkgs").val();
            var mrp = $("#mrpValue").val();
            var warehouseLocation = $("#warehouseLocation").val();

            $.ajax({
                url: "../modules/stock/stock-action.php",
                type: "POST",
                dataType: "html",
                data: {
                    action: "allocate-stock",
                    stock_id: stock_id,
                    pkgs:pkgs,
                    mrp:mrp,
                    warehouseLocation:warehouseLocation,
                    standard:standard,
                    client:client
                },
                success: function(data) {
                    loadAllocated();
                    swal('','Allocated', 'success');

                }

            });

        });
        $('#allocatedStockTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print',
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    },
                    
                ]
        });
    </script>

    </html>