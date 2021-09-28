<style>
    .modal-dialog{
        background-color: rgba(217, 245, 255,0.5);
        border: 1px solid;
    }
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
        <div class="card">
            <div class="card-header">
                <span>Blend Closing</span>
                <div class="card-options">
                    <button id="unclosed" class="btn btn-info btn-sm ml-2">Unclosed</button>
                    <button id="closed" class="btn btn-info btn-sm ml-2">Closed</button>
                </div>
            </div>

            <div class=" card-body col-lg-12 col-md-12 col-sm-12">
                <div class="table-responsive" id="tableData">
                    <h3 class="text-center text-success" style="margin-top: 150px;">Loading...</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Record  Modal -->
<div class="modal" id="blendClose">
<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Blend Out Turn</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="closingForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="value">Blend Output</label>
                                <input  type="text" class="form-control" name="boutput" value="" id="boutput" placeholder="0" value="0" required="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="value">Sweeping</label>
                                <input  type="text" class="form-control" name="bsweepings" value="" id="bsweepings" placeholder="0" value="0" required="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="value">Cyclone</label>
                                <input  type="text" class="form-control" name="bcyclone" value="" id="bcyclone" placeholder="0" value="0" required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="value">Dust</label>
                                <input  type="text" class="form-control" name="bdust" value="" id="bdust" placeholder="0" value="0" required="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="value">Polucon</label>
                                <input  type="text" class="form-control" name="bpolucon" value="" id="bpolucon" placeholder="0" value="0" required="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="value">Fiber</label>
                                <input  type="text" class="form-control" name="bfiber" value="" id="bfiber" placeholder="0" value="0" required="">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="value">Gain/Loss</label>
                                <input disabled="true" type="text" class="form-control" name="gainLoss" value="" id="gainLoss" placeholder="0" value="0" required="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="value">Blend Remnant</label>
                                <input disabled="true" type="text" class="form-control" name="blendremnant" value="" id="blendremnant" placeholder="0" value="0" required="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="value">Input Kgs</label>
                                <input disabled="true" type="text" class="form-control" name="inputkgs" value="" id="inputkgs" placeholder="0" value="0" required="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="value">Shippment</label>
                                <input disabled="true" type="text" class="form-control" name="shippment" value="" id="shippment" placeholder="0" value="0" required="">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-primary btn-sm" id="post">Post</button>
                        <button type="submit" class="btn btn-danger btn-sm" id="close">Close</button>
                    </div>
                </form>
                <div class="card" style="display: none;" id="confirm-table">
                    <div id="preview"></div>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-danger btn-sm" id="confirm">Confirm</button>
                    </div>
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
        showAllBlends("unclosed");

        $("#unclosed").click(function(){
            showAllBlends("show-unclosed");

        });
        $("#closed").click(function(){
            showAllBlends("closed");

        });
        //View Record
        function showAllBlends(type) {
            $.ajax({
                url: "warehousing_action.php",
                type: "POST",
                data: {
                    action: "blend-status",
                    type:type
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
    $("body").on("click", ".close", function(e) {
        var currentRow = $(this).closest("tr");
        var shippment = currentRow.find(".shippment").html();
        var inputkgs = currentRow.find(".inputpkgs").html();
        $("#shippment").val(shippment);
        $("#inputkgs").val(inputkgs);

        var blendid = $(this).attr("id");
        localStorage.setItem("blendid", blendid);
        localStorage.setItem("shippment", shippment);
        localStorage.setItem("inputkgs", inputkgs);

        $("#blendClose").show();
    });

    $("#boutput, #bpolucon, #bsweepings, #bcyclone, #bdust, #bfiber").on( "blur", function(e){
        var blendOutput = $("#boutput").val();
        var pulucon = $("#bpolucon").val();
        var Sweeping = $("#bsweepings").val();
        var Cyclone = $("#bcyclone").val();
        var Dust = $("#bdust").val();
        var Fiber = $("#bfiber").val();
        var blendid = localStorage.getItem("blendid");
        var blendInput = localStorage.getItem("inputkgs");
        var shippment = localStorage.getItem("shippment");
        var blendRemant = Number(blendInput)- Number(shippment);
        $("#blendremnant").val(blendRemant);
        $("#gainLoss").val((Number(blendOutput)+Number(pulucon)+Number(Sweeping)+Number(Cyclone)+Number(Dust)+Number(Fiber)) - Number(blendInput));


    });
    $("#post").click(function(e){
        e.preventDefault();
        var id = localStorage.getItem("blendid", blendid);
        var blendOutput = $("#boutput").val();
        var pulucon = $("#bpolucon").val();
        var Sweeping = $("#bsweepings").val();
        var Cyclone = $("#bcyclone").val();
        var Dust = $("#bdust").val();
        var Fiber = $("#bfiber").val();
        var blendid = localStorage.getItem("blendid");
        var blendInput = localStorage.getItem("inputkgs");
        var blendShipment = localStorage.getItem("shippment");
        var blendRemant = $("#blendremnant").val();
        var GainLoss = $("#gainLoss").val();
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
                BlendRemnant:blendRemant,
                GainLoss:GainLoss,
                pulucon:pulucon

            },
            cache: true,
            url: "warehousing_action.php",
            success: function (data) {
                $("#closingForm").hide();
                $("#confirm-table").show();
                $('#preview').html(data);

            }
        });
        
    });
    
    
$('#confirm').click(function(e){
    Swal.fire({
                icon: 'success',
                title: 'Confirmed to stock',
            });
    $('#blendClose').hide();
    showAllBlends("unclosed");


});
$('#cancel').click(function(e){
    $('#blendClose').hide();

});
$('#close').click(function(e){
    $('#blendClose').hide();

});




    
</script>