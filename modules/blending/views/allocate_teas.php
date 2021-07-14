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
<?php 
    $blendno = isset($_GET['blendno']) ? $_GET['blendno'] : '';

?>
<div class="col-md-8 col-lg-10">
    <div id="contentwrapper">
        <div class="card ">
            <div class="card-body p-2">
                <div class="col-md-12">
                    <div class="row" id="tableData" style="max-height:20%;">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="blendTable"></div>
            </div>
        </div>
    </div>
</div>



<script src="../../assets/js/blending.js"></script>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
// $(document).ready(function(){
 
  
// });
loadUnallocated();
    // $('.select2-show-search').select2({placeholder: 'Select an item',});
    var blendno = '<?php echo $blendno ?>'
    showBlend(blendno);

    BlendAllocationSummary(blendno);


function callAction(element){
    var blendno = '<?php echo $blendno ?>'
    var allocationid = $(element).attr("id");
    var allocatedpackages = $('#allocatedpackages').text();
    var availablepackages = $('#availablepackages').text();
    showBlend(blendno);

    method = $(element).attr("class");
    if(allocatedpackages>availablepackages){
        alert("You cannot allocate more Packages than what is in stock"+allocatedpackages+" "+availablepackages, method);
    }else{
        if(method=="allocate"){
            addLotToBlend(allocationid, "add-blend-teas",  blendno, allocatedpackages, method);
            BlendAllocationSummary(blendno)
        }else if(method=="deallocate"){
            removeLotFromBlend(allocationid, "remove-blend-teas");
            BlendAllocationSummary(blendno);

        }
    }
    }

$('#lotEdit').click(function(e){
    e.preventDefault();
    var clientid = localStorage.getItem("clientId");
    showClientAllocation(clientid);
    
});
function viewAllocations(){
    var blendno = '<?php echo $blendno ?>'
    currentAllocation(blendno);
    // $('#blendTable').html('<iframe class="frame" frameBorder="0" src="../../reports/blend_sheet.php?blendno='+blendno+'" width="100%" height="800px"></iframe>');
}
function approveBlend(){
    var blendno = '<?php echo $blendno ?>'
    $.ajax({
            url: "blend_action.php",
            type: "POST",
            dataType: "html",
            data: {
                action: "approve-blend",
                blendno: blendno
            },
            success: function(response) {
                showBlend(blendno);
                Swal.fire({
                            icon: 'success',
                            title: 'Blend Confirmed Successfully',
                });
            }

        });

}
function editBlend(){
    var blendno = '<?php echo $blendno ?>'
    $.ajax({
            url: "blend_action.php",
            type: "POST",
            dataType: "html",
            data: {
                action: "edit-blend",
                blendno: blendno
            },
            success: function(response) {
                showBlend(blendno);
                location.reload()
            }

        });

}

</script>