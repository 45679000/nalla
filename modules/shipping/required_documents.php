<style>
    #ishippingInstructions, #ilotdetails{
        width:100%;
        height:1000px;
        border:none;
    }
    .feature{
        max-height: 50px;;
    }

</style>
<?php 
$viewid = 0; //straightline;
$type = isset($_GET['type']) ? $_GET['type']:'';
if($type == 'Blend Shippment'){
    $viewid = 1; //blend
}

?>
<div class="my-2 my-md-2">
    <div class="container-fluid">
        <div class="page-header">
            <h4 class="page-title">Click The Icons to view and print Documents For this Shippment</h4>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4 features">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="feature">
                                  <button id="lot-details" class="btn btn-success btn-rounded"><i class="fa fa-file"></i></button>
                            <h3>Lot Details</h3>
                            <p>Click to View Lot details Attached to this Shippment</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 features">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="feature">
                        <button id="shippingInstructions" class="btn btn-success btn-rounded"><i class="fa fa-file"></i></button>
                            <h3>Shipping Instructions</h3>
                            <p>Click to view Shipping instructions Created for this Shippment</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 features">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="feature">
                        <button id="profomainvoice" class="btn btn-success btn-rounded"><i class="fa fa-file"></i></button>
                            <h3>Profoma Invoice</h3>
                            <p>Click to view Profoma Invoice Generated from Finanace.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="display" class="row">

        </div>
    </div>
</div>
<div class="text-center">
<a id="previous" href="#" class="previous">&laquo; Previous</a>
<a id="next" href="#" class="next">Next &raquo;</a>
</div>
<script src="<?php echo $path_to_root ?>assets/js/vendors/jquery-3.2.1.min.js"></script>

<script>
        

        $('#ilotdetails').hide();
        $('#ishippingInstructions').hide();
        $('#iprofomainvoice').hide();

        $('#lot-details').click(function(){
            var sino = '<?php echo $_GET['sino']; ?>'
            var viewid = '<?php echo $viewid; ?>'
            // var cNumber = localStorage.getItem("contractno");
            var contractno = localStorage.getItem("contractno");
            // var cNumber = JSON.parse(localStorage.getItem("contractno"));
            var blendno = localStorage.getItem("blendno");

            $('#ishippingInstructions').hide();
                $('#iprofomainvoice').hide();
            if(viewid==0){
             
                $('#display').html('<iframe class="frame" frameBorder="0" src="../../reports/straightline_lots.php?sino='+contractno+'" width="100%" height="800px"></iframe>');
                // $('#display').html('<iframe class="frame" frameBorder="0" src="http://localhost/chamu/reports/TCPDF/files/testReport.php?invoiceNo='+cNumber+'" width="100%" height="600px"></iframe>');

            }else{
                $('#display').html('<iframe class="frame" frameBorder="0" src="../../reports/blend_sheet.php?blendno='+blendno+'" width="100%" height="800px"></iframe>');

            }

            
    });
    
    $('#shippingInstructions').click(function(){
        var sino = '<?php echo $_GET['sino']; ?>'

        $('#display').html('<iframe id="ishippingInstructions"></iframe>');
        $("#ishippingInstructions").attr('src', '../../reports/shipping_instructions.php?sino='+sino);

        $('#ishippingInstructions').show();
        $('#ilotdetails').hide();
        $('#iprofomainvoice').hide();


    });
    $('#profomainvoice').click(function(){
        $('#ishippingInstructions').hide();
        $('#ilotdetails').hide();
        $('#iprofomainvoice').show();
    });
    
    $('#next').click(function(){
        var sino = '<?php echo $_GET['sino']; ?>'
        var siType = '<?php echo $_GET['type']; ?>'

        window.location.href = './index.php?view=summary&sino='+sino+"&type="+siType;
    });

    $('#previous').click(function(){
        var sino = '<?php echo $_GET['sino']; ?>'
        var siType = '<?php echo $_GET['type']; ?>'

        window.location.href="index.php?view=shipment-teas&sino="+sino+"&type="+siType;
    });

    
</script>
