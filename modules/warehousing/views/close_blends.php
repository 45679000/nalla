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
<?php
        $blend_no = $_GET["blendno"];

if(!isset($_GET["blendno"])){
        $blend_no = $_GET["blendno"];
?>
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

<?php 
}else{
?>

 <div  id="outturncard" class="card">
                <!-- Modal Header -->
                <div class="card-header bg-teal">
                    <h4 class="modal-title">Blend Out Turn Form</h4>
                </div>
                <div class="card-body">
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
                        <div class="card"  id="confirm-table">
                            <div id="preview">
                                
                            </div>
                        <div class="form-group float-right">
                            <button  class="btn btn-success btn-sm" id="add"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                        <hr>
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary btn-sm" id="post">Close Blend</button>
                        </div>
                    </form>
             
                </div>
            </div>


            
<?php }?>
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
        var blendno = '<?php echo $blend_no ?>';
        loadBlendLines(blendno);
        $("#unclosed").click(function(){
            showAllBlends("show-unclosed");

        });
        $("#closed").click(function(){
            showAllBlends("closed");
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            data: {
                action: "close-parameter",
                id:blendno,
            },
            cache: true,
            url: "warehousing_action.php",
            success: function (data) {
              $("#shippment").val(data.shippment);
              $("#inputkgs").val(data.inputkgs);
            }
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

        $("#add").click(function(e){
            e.preventDefault();
            $.ajax({
            type: "POST",
            dataType: "html",
            data: {
                action: "add-line",
                id:blendno,
            },
            cache: true,
            url: "warehousing_action.php",
            success: function (data) {
                loadBlendLines(blendno);

            }
        });

        })
        
    });
    
    $("body").on("blur", ".editable", function(e) {
        var blendno = '<?php echo $blend_no ?>';

        var id = $(this).parent().parent().attr("id");
        var fieldName = $(this).attr("name");
        var fieldValue = $(this).val();

        $.ajax({
            type: "POST",
            dataType: "json",
            data: {
                action: "update-field",
                fieldName: fieldName,
                fieldValue: fieldValue,
                id:id,
            },
            cache: true,
            url: "warehousing_action.php",
            success: function (data) {
                loadBlendLines(blendno);
            }
        });
        
    });
    $("body").on("click", ".remove", function(e) {
        var blendno = '<?php echo $blend_no ?>';
        var id = $(this).parent().parent().attr("id");

        $.ajax({
            type: "POST",
            dataType: "json",
            data: {
                action: "remove-line",
                id:id,
            },
            cache: true,
            url: "warehousing_action.php",
            success: function (data) {
                loadBlendLines(blendno);
            }
        });
        
    });
    $("body").on("change", ".mark", function(e) {
        var id = $(this).parent().parent().attr("id");
        $.ajax({
            type: "POST",
            dataType: "json",
            data: {
                action: "update-field",
                id:id,
                fieldName: 'mark',
                fieldValue: $(this).val(),
            },
            cache: true,
            url: "warehousing_action.php",
            success: function (data) {
                loadBlendLines(blendno);
            }
        });
        
    });

    

    
    function loadBlendLines(id){
    $.ajax({
            type: "POST",
            dataType: "html",
            data: {
                action: "load-blend-lines",
                id:id,
            },
            cache: false,
            url: "warehousing_action.php",
        success: function (data) {
            $("#preview").html(data);

        }
    });
    
}


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
        var blendRemant = Number(blendOutput)- Number(shippment);
        $("#blendremnant").val(blendRemant);
        $("#gainLoss").val((Number(blendOutput)+Number(pulucon)+Number(Sweeping)+Number(Cyclone)+Number(Dust)+Number(Fiber)) - Number(blendInput));


    });
    $("#post").click(function(e){
        e.preventDefault();
        var blendno = '<?php echo $blend_no ?>';
        var id = blendno;
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
            dataType: "json",
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
                Swal.fire(
                    'Congratulations',
                    data.status,
                    'success'
                    ); 
                setTimeout(function() {
                    location.href = '/chamu/modules/warehousing/index.php?view=closeblends'; 
            }, 2000);
                          
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