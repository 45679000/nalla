<style>
    #ishippingInstructions, #ilotdetails{
        width:100%;
        height:1000px;
        border:none;
    }

</style>

<div class="my-3 my-md-5">
    <div class="container-fluid">
        <div class="page-header">
            <h4 class="page-title">Documents</h4>
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
       
            <!-- <iframe id="ilotdetails" src="../../reports/lot_details.php" width="100%" height="1000" style="border:none;">
            </iframe>
            <iframe id="iprofomainvoice" src="../../reports/shipping_instruction.php" width="100%" height="1000" style="border:none;">
            </iframe> -->
        </div>
    </div>
</div>
<div class="text-center">
<a href="#" class="previous">&laquo; Previous</a>
<a id="next" href="#" class="next">Next &raquo;</a>
</div>
<script src="<?php echo $path_to_root ?>assets/js/vendors/jquery-3.2.1.min.js"></script>

<script>
        $('#tab5').click(function(){
            $.ajax({   
                    type: "POST",
                    data : {action:"generate", siId:localStorage.getItem("siId")},
                    dataType: "json", 
                    url: "../../reports/lot_details.php",   
                    success: function(data){

                    }   
            })

        });

        $('#ilotdetails').hide();
        $('#ishippingInstructions').hide();
        $('#iprofomainvoice').hide();

        $('#lot-details').click(function(){
            $('#ishippingInstructions').hide();
            $('#iprofomainvoice').hide();
            $('#display').html('<iframe id="ilotdetails"></iframe>');
            $("#ilotdetails").attr('src', '../../reports/lot_details.php');
            

        
    });
    
    $('#shippingInstructions').click(function(){
        $('#display').html('<iframe id="ishippingInstructions"></iframe>');
        $("#ishippingInstructions").attr('src', '../../reports/shipping_instructions.php');

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
    window.location.href = './index.php?view=summary';
    });
</script>