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
                                        <input disabled id="lot"></input>
                                    </div>
                                </div>
                                <div class="col-md-3 well">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Mark</label>
                                        <input disabled id="mark"></input>
                                    </div>
                                </div>
                                <div class="col-md-3 well">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Invoice</label>
                                        <input disabled id="invoice"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 well">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Current Allocation==></label>
                                    </div>
                                </div>
                                <div class="col-md-3 well">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Pkgs</label>
                                        <input id="pkgs"></input>
                                    </div>
                                </div>
                                <div class="col-md-3 well">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Net</label>
                                        <input id="net" disabled></input>
                                    </div>
                                </div>
                                <div class="col-md-3 well">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Kgs</label>
                                        <input id="kgs" ></input>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 well">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Enter Packages to split==></label>
                                    </div>
                                </div>
                                <div class="col-md-3 well">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Pkgs</label>
                                        <input id="newpkgs"></input>
                                    </div>
                                </div>
                                <div class="col-md-3 well">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Net</label>
                                        <input id="newnet" disabled></input>
                                    </div>
                                </div>
                                <div class="col-md-3 well">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Kgs</label>
                                        <input id="newkgs" ></input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-md-3 form-group float-right">
                            <button type="submit" class="btn btn-success btn-sm" id="saveSplit">Save</button>
                        </div>
                        <div class="col-md-3 form-group float-right">
                             <button type="button" class="btn btn-danger btn-sm" id="closeModal">Close</button>
                        </div>
                        <input hidden id="stock_id"></input>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>



<script>
$(document).ready(function(){
    loadStockAllocation("unallocated");
    localStorage.setItem("tab", "unallocated");
    $('#closeModal').click(function(e){
        $('#splitModal').hide();
    });
    $('#newpkgs').change(function(e){
        var newPkgs = $('#newpkgs').val();
        var previousPkgs = $('#pkgs').val();
        var previousKgs = $('#kgs').val();
        var net = $('#net').val();
        $('#pkgs').val(previousPkgs-newPkgs);
        $('#kgs').val((previousPkgs-newPkgs) * net);
        $('#newkgs').val(previousKgs-((previousPkgs-newPkgs) * net));  
    })

    $('#saveSplit').click(function(e){
        e.preventDefault();
        var stockId = $('#stock_id').val();
        var Pkgs = $('#pkgs').val();
        var Kgs = $('#kgs').val();
        var NewKgs = $('#newkgs').val();
        var NewPkgs = $('#newpkgs').val();
        if((stockId !=null) && (Pkgs !=null) && (Kgs !=null) && (NewKgs !=null) && (NewPkgs !=null)){
            insertSplit(stockId, Pkgs, Kgs, NewKgs, NewPkgs);
        }else{
            alert("You Must Enter packages to split");
        }
    })
});
$('#waitingtoAllocate').click(function(e){
    loadStockAllocation("unallocated");
    localStorage.setItem("tab", "unallocated");
})
$('#allocated').click(function(e){
    loadStockAllocation("allocated");
    localStorage.setItem("tab", "allocated");

})
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
        var lots = data[0]; 
        $('#pkgs').val(lots.pkgs);
        $('#kgs').val(lots.kgs);
        $('#lot').val(lots.lot);
        $('#net').val(lots.net);
        $('#mark').val(lots.mark);
        $('#invoice').val(lots.invoice);
        $('#newnet').val(lots.net);
        $('#stock_id').val(lots.stock_id);


        
    },
    error: function (data) {
        console.log('An error occurred.');
        console.log(data);
    },
    });
}

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
                    myrecord = data;
                    const options = [];
                    for(let i = 0; i<myrecord.length; i++){
                        options[i] =  $('<option />', {value : myrecord[i].debtor_no, text : myrecord[i].short_name});
                    
                    }
                    console.log(options);
                    $('<select />',{
                    name   : 'debtor_ref',
                    id     : id+'stock',
                    on     : {
                        change : function(element){
                            var fieldValue  = $('#'+id+'stock').val();
                            updateStock(id, "client_id", fieldValue);                             
                            }
                        },
                        append : options
                    }).appendTo('#'+id);
                }
        });
    }
}
function updateStock(stockId, fieldName, fieldValue){
    $.ajax({  
            type: "POST",
            dataType: "json",
            url: '../stock/stock-action.php',
            data: {
                action:'allocate-stock',
                stockId:stockId,
                fieldName:fieldName,
                fieldValue:fieldValue
            },
        success: function (data) {
        
        }
    });
}
function insertSplit(stockId, Pkgs, Kgs, NewKgs, NewPkgs){
    $.ajax({  
            type: "POST",
            dataType: "html",
            url: '../stock/stock-action.php',
            data: {
                action:'split',
                stockId:stockId,
                Pkgs:Pkgs,
                Kgs:Kgs,
                NewKgs:NewKgs,
                NewPkgs:NewPkgs
            },
        success: function (data) {
            Swal.fire({
                icon: 'success',
                title: 'Lot Splitted Successfully',
            });
            $("#splitModal").hide();
            if(localStorage.getItem("tab")=="allocated"){
                loadStockAllocation("allocated");
            }else{
                loadStockAllocation("unallocated");
            }
        }
    });
}

</script>

    </html>

