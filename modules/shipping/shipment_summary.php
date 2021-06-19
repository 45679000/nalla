<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Confirm Shipment</h3>
        </div>
        <div class="card-body">
            <div class="row row-cards">
                <div class="col-sm-12 col-lg-3">
                    <div class="card bg-primary card-img-holder text-white">
                        <div class="card-body">
                            <img src="<?php echo $path_to_root ?>assets/images/circle.svg" class="card-img-absolute" alt="circle-image">
                            <h4 class="font-weight-normal  mb-3">Total Lots
                                <i class="fa fa-user-o fs-30 float-right"></i>
                            </h4>
                            <h2 id="totalLots" class="mb-0">0</h2>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3">
                    <div class="card bg-warning card-img-holder text-white">
                        <div class="card-body">
                            <img src="<?php echo $path_to_root ?>assets/images/circle.svg" class="card-img-absolute" alt="circle-image">
                            <h4 class="font-weight-normal  mb-3">Total Packages
                                <i class="fa fa-heart-o fs-30 float-right"></i>
                            </h4>
                            <h2 id="totalPackages" class="mb-0">0</h2>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3">
                    <div class="card bg-info card-img-holder text-white">
                        <div class="card-body">
                            <img src="<?php echo $path_to_root ?>assets/images/circle.svg" class="card-img-absolute" alt="circle-image">
                            <h4 class="font-weight-normal mb-3">Total Kgs
                                <i class="fa fa-comment-o fs-30 float-right"></i>
                            </h4>
                            <h2 id="totalKilos" class="mb-0">0</h2>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3">
                    <div class="card bg-success card-img-holder text-white">
                        <div class="card-body">
                            <img src="<?php echo $path_to_root ?>assets/images/circle.svg" class="card-img-absolute" alt="circle-image">
                            <h4 class="font-weight-normal  mb-3">Total Amount
                                <i class="fa fa-paper-plane-o fs-30 float-right"></i>
                            </h4>
                            <h2 id="totalAmount" class="mb-0">0</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Shipping Summary</h2>
                    </div>
                    <table class="table card-table">
                        <tbody>
                            <tr>
                                <td>Buyer</td>
                                <td id="buyer" class="text-right">
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>Consignee</td>
                                <td id="consignee" class="text-right">

                                </td>
                            </tr>
                            <tr>
                                <td>SI No.</td>
                                <td id ="si_no" class="text-right">
                                   
                                </td>
                            </tr>
                            <tr>
                                <td>Target Vessel</td>
                                <td id="target_vessel" class="text-right">
                                   
                                </td>
                            </tr>

                        </tbody>
                    </table>
        
                </div>
            </div>
            
        </div>
        <div style="padding:0px;" class="card-footer bg-info br-br-7 br-bl-7">
            <div style="padding:0px;" class="text-white">
                <button style="padding:0px;" id="shipit" class="btn btn-success btn-lg btn-block">confirm shippment</button>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo $path_to_root ?>assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="<?php echo $path_to_root ?>assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script>
    $('#shipit').click(function(e) {
        completeShippment(localStorage.getItem("siType"));
        swal('', 'Shipment Completed Successfully', 'success');
    });
    $('#tab6').click(function(){
        $.ajax({   
        type: "POST",
        dataType:"json",
        data : {action:"shippment-summary", type:"blend"},
        cache: true,  
        url: "shipping_action.php",   
        success: function(data){
            $('#totalLots').text(data.totalLots);
            $('#totalPackages').html(data.totalkgs);
            $('#totalKilos').html(data.totalpkgs);
            $('#totalAmount').html(data.totalAmount);
            $('#buyer').html(data.shippingDetails.contract_no);
            $('#consignee').html(data.shippingDetails.consignee);
            $('#si_no').html(data.shippingDetails.contract_no);
            $('#target_vessel').html(data.shippingDetails.contract_no);
        }   
    }); 
    });

</script>