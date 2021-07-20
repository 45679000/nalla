<style>
   .table {
        background-color: white !important;
        width:100% !important;
    }
    .toolbar-button{
        padding: 0.5px !important;
    }
    .modal {
        text-align: center;
    width:100% !important;
    }

@media screen and (min-width: 768px) { 
  .modal:before {
    display: inline-block;
    vertical-align: middle;
    content: " ";
    height: 100%;
  }
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
  width:1000%;
}
 
</style>
<div class="col-md-12 col-lg-12">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="table-responsive" id="tableData">
                    <h3 class="text-center text-success" style="margin-top: 150px;">Loading...</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="blendClose">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Blend Closing...</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
         <!-- Modal body -->
         <div id="preview" class="modal-body">
                
                <div class="form-group float-right">
                        <button type="submit" class="btn btn-primary" id="update">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
            </div>
        </div>
    </div>
</div>

<script src="../../assets/js/blending.js"></script>
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<!-- Custom Js-->
<script src="../../assets/js/custom.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        showAllBlends();
        //View Record
        function showAllBlends() {
            $.ajax({
                url: "warehousing_action.php",
                type: "POST",
                data: {
                    action: "show-unclosed"
                },
                success: function(response) {
                    $("#tableData").html(response);
                    $("table").DataTable({
                        order: [0, 'ASC']
                    });
                }

            });
        }
        
    });
    function closeBlend(element){
                var id = $(element).attr("id");
                var blendShipment = $("#"+id+"shipment").text();
                var blendInput = $("#"+id+"input").text();
                var blendOutput = $("#"+id+"output").text();
                var pulucon = $("#"+id+"pulucon").text();
                var Sweeping = $("#"+id+"sweeping").text();
                var Cyclone = $("#"+id+"cyclone").text();
                var Dust = $("#"+id+"dust").text();
                var Fiber = $("#"+id+"fiber").text();

                $("#"+id+"blendRemnant").text(Number(blendOutput)-Number(blendShipment));
                $("#"+id+"gainLoss").text((Number(blendOutput)+Number(pulucon)+Number(Sweeping)+Number(Cyclone)+Number(Dust)+Number(Fiber)) - Number(blendInput));
                var BlendRemnant = $("#"+id+"blendRemnant").text();
                var GainLoss = $("#"+id+"gainLoss").text();



            $.ajax({
            type: "POST",
            dataType: "html",
            data: {
                action: "close_blend",
                blendid:id,
                blendOutput:blendOutput,
                blendInput:blendInput,
                blendShipment:blendShipment,
                Sweeping:Sweeping,
                Cyclone:Cyclone,
                Dust:Dust,
                Fiber:Fiber,
                BlendRemnant:BlendRemnant,
                GainLoss:GainLoss

            },
            cache: true,
            url: "warehousing_action.php",
            success: function (data) {
                $('#blendClose').show();
                $('#preview').html(data);

            }
        });
        }



    
</script>