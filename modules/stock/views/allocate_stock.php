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
    .split{
        height: 20%;
    }
</style>

<div class="col-md-12 col-lg-12">
    <div class="card">
        <div class="card-body p-6">
            <div class="col-md-12">
                <div class="expanel expanel-secondary">

                    <div class="expanel-heading">
                        <h3 class="expanel-title">Allocate Stock</h3>
                    </div>
                    <div class="card">
                            <div class="card-header">
                                <div class="card-options">
                                    <button id="waitingtoAllocate" class="btn btn-primary btn-sm">Waiting to allocate</button>
                                    <button id="allocated" class="btn btn-secondary btn-sm ml-2">Allocated</button>
                                   
                                </div>
                            </div>
                    <div class="card-body">
                        <div id ="stockAllocation" class="table-responsive">
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Record  Modal -->
<div class="modal" id="splitModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Split Lot</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="splitLot">
                    <div class="row">
                        <div class="col-md-3 well">
                            <div class="form-group label-floating">
                                <label class="control-label">Lot</label>
                                <input id="lot"></input>
                            </div>
                            <div class="form-group label-floating">
                                <label class="control-label">Pkgs</label>
                                <input id="pkgs"></input>
                            </div>
                            <div class="form-group label-floating">
                                <label class="control-label">Net</label>
                                <input id="net"></input>
                            </div>
                            <div class="form-group label-floating">
                                <label class="control-label">Pkgs</label>
                                <input id="kgs"></input>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 form-group float-right">
                            <button type="submit" class="btn btn-success" id="submitUpdate">Save</button>
                        </div>
                        <div class="col-md-3 form-group float-right">
                             <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </form>
            </div>

            </div>
        </div>
    </div>
</div>
</body>



    <!-- Dashboard js -->
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>


<script src="../../assets/plugins/datatable/dataTables.buttons.min.js"></script>
<script src="../../assets/plugins/datatable/jszip.min.js"></script>
<script src="../../assets/plugins/datatable/pdfmake.min.js"></script>
<script src="../../assets/plugins/datatable/vfs_fonts.js"></script>
<script src="../../assets/plugins/datatable/buttons.html5.min.js"></script>
<script src="../../assets/plugins/datatable/buttons.print.min.js"></script>
<script src="../../assets/js/stock.js"></script>


<script>
loadStockAllocation("unallocated");
function splitLot(element){
    var id = $(element).attr("id");
    $('#splitModal').show(); 

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "stock-action.php",
        data: {
            action:"getlot",
            id:id
        },
    success: function (data) {
        $('#pkgs').html(data[0].pkgs);
        $('#kgs').html(data[0].kgs);
        $('#lot').html(data[0].lot);
        $('#net').html(data[0].net);

        
    },
    error: function (data) {
        console.log('An error occurred.');
        console.log(data);
    },
    });
}
$(document).ready(function(){
  
});
function appendSelectOptions(element){
    var id= $(element).attr("id");
    if($("#"+id+" select").length==0){
        $.ajax({  
                type: "POST",
                dataType: "json",
                url: '../../ajax/common.php',
                data: {
                    action:'client-opt'
                },
                success: function (data) {
                    console.log(data[0])
                    myrecord = data;
                    const options = [];
                    for(let i = 0; i<myrecord.length; i++){
                        options[i] =  $('<option />', {value : myrecord[i].debtor_no, text : myrecord[i].short_name});
                    
                    }
                    console.log(options);
                    $('<select />',{
                    name   : 'test',
                    on     : {
                        change : function() { alert("allocated")}
                        },
                        append : options
                    }).appendTo('#'+id);
                }
        });
    }
}
function loadRemarkOptions(element){
            $.ajax({  
                type: "POST",
                dataType: "json",
                url: '../ajax/common.php',
                data: {
                    action:'clients'
                },
            success: function (data) {
              for($i = 0; $i<data.length; $i++){
                $(element).append('<option>'+data[$i].remark+'</option>');

              }

            }
         });
        }

</script>

    </html>