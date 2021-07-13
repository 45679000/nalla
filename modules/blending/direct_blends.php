<style>
    .form-group {
        max-height: 10%;
    }

    .form-control {
        border: 1px solid black !important;
        color: black;
    }

    .counter {
        font-family: 'Poppins', sans-serif;
        padding: 0.5px 0 0;
    }

    .card {
        max-height: 45%;
    }

    .table {
        background-color: white !important;
    }
    .allocate{
        background:green; 
        width:50px; 
        color:white;
    }
    .pdfViewer{
        background-color: white !important;
    }
    .deallocate{
        background:red; 
        width:50px; 
        color:white;
    }.frame{
        background-color: white;
    }

    @media screen and (max-width:450) {
        .counter {
            margin-bottom: 10px;
        }
    }
</style>
<div class="col-md-8 col-lg-10">
    <div class="card">
        <div class="card-body p-1">
            <div class="col-md-12">
                <div class="row justify-content-center" style="max-height:20%;">
                    <div class="col-md-3 well">
                        <div class="form-group label-floating">
                            <label class="control-label">Select Client</label>
                            <select id="client" name="buyer_standard" class="form-control select2-show-search well"><small>(required)</small>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="contentwrapper">
        <div class="card ">
            <div class="card-body p-2">
                <div class="col-md-12">
                    <div class="row" style="max-height:20%;">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Client</th>
                                    <th>Lots</th>
                                    <th>Pkgs</th>
                                    <th>kgs</th>
                                    <th>Print Lot Detail</th>
                                    <th>View Allocations</th>
                                    <th>Contract No</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tr>
                                <td  id="clientName"></td>
                                <td class="counter-value" id="totalLots"></td>
                                <td class="counter-value" id="totalPkgs"></td>
                                <td class="counter-value" id="totalkgs"></td>
                                <td id="lotView">PRINT</td>
                                <td id="lotEdit">PRINT</td>
                                <td><input id="contractno" onBlur="updateContractNo(this)"></input></td>
                                <td id="lotStatus">Unconfirmed</td>
                                <td>
                                    <button id="1" style="background-color:green; color:white" onClick="addApproval(this)" class="fa fa-check"></button>
                                </td>

                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="straightTable"></div>
            </div>
        </div>
    </div>
</div>



<script src="../../assets/js/shipping.js"></script>
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../../assets/js/vendors/selectize.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>
<script src="../../assets/plugins/select2/select2.full.min.js"></script>

<!-- counter  -->
<script src="../../assets/plugins/counters/counterup.min.js"></script>
<script src="../../assets/plugins/counters/waypoints.min.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function(){
    clientOptions();
    $('#contentwrapper').hide();
    $('.select2-show-search').select2({placeholder: 'Select an item',});
    var clientId;
    $('#client').change(function(){
        var clientId = $('#client').val();
        localStorage.setItem("clientId", clientId);
        $('#contentwrapper').show();
        allocationSummary(localStorage.getItem("blend_no_contract_no", localStorage.getItem("clientId"))); 
        loadUnallocated(); 
    });
});

function callAction(element){
    var id = $(element).attr("id");
    var siNo = $('#packages').text();
    var method = $(element).attr("class");

if(method=="allocate"){
    AllocationShippment(id, "allocate-shipment", siNo, localStorage.getItem("blend_no_contract_no"), "allocate");
}else{
    removeLotFromShippment("remove-shipment", id, "deallocate");
}
}
$('#lotView').click(function(e){
    e.preventDefault();
    $('#straightTable').html('<iframe class="frame" frameBorder="0" src="../../reports/lot_details.php" width="100%" height="800px"></iframe>');
});
$('#lotEdit').click(function(e){
    e.preventDefault();
    var clientid = localStorage.getItem("clientId");
    showClientAllocation(clientid);
    
});
function updateContractNo(element){
    var blend_no_contract_no = $(element).val();
    localStorage.setItem("blend_no_contract_no", blend_no_contract_no);
    allocationSummary(localStorage.getItem("blend_no_contract_no", localStorage.getItem("clientId"))); 

}
</script>