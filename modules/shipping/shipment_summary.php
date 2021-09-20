<?php

$sino = isset($_GET['sino']) ? $_GET['sino']:'';
if($sino != ''){
    $shipments = $shippingCtrl->fetchSiDetails($sino);
    $buyer = '';
    $consignee = '';
    $sidate = '';
    $targetvessel = '';
    $destination = '';

    foreach ($shipments as $shipment) {
        $buyer = $shipment['buyer'];
        $consignee = $shipment['consignee'];
        $sidate = $shipment['si_date'];
        $targetvessel = $shipment['target_vessel'];
        $destination = $shipment['destination_total_place_of_delivery'];
        $contractno = $shipment['contract_no'];

    }

}

?>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Send SI to Warehouse</h3>
        </div>
        <div class="card-body">
            <div class="col-md-6">
                <div class="card">
        
                    <table class="table card-table">
                        <tbody>
                            <tr>
                                <td>Buyer</td>
                                <td id="buyer" class="text-right">
                                    <?= $buyer ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Consignee</td>
                                <td id="consignee" class="text-right">
                                    <?= $consignee ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contract No.</td>
                                <td id ="si_no" class="text-right">
                                    <?= $contractno ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Target Vessel</td>
                                <td id="target_vessel" class="text-right">
                                    <?= $targetvessel ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Destination</td>
                                <td id="target_vessel" class="text-right">
                                    <?= $destination ?>
                                </td>
                            </tr>

                        </tbody>
                    </table>
        
                </div>
            </div>
            
        </div>
        <div class="text-center">
            <div class="row">
                <div class="col-md-2">
                    <button id="senddontnotify"><i class="fa fa-paper-plane"></i>Send without Email Notification</button>
                </div>
                <div class="col-md-2">
                    <button id="sendnotify"><i class="fa fa-envelope"></i>Send and Notify Warehouse on email</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center">
<a id="previous"  class="previous">&laquo; Previous</a>
</div>
</div>

<script src="<?php echo $path_to_root ?>assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="<?php echo $path_to_root ?>assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script>
    $('#sendnotify').click(function(e) {
        var sino = '<?php echo $_GET['sino']; ?>'
        completeShippment(sino, "notify");
        swal('', 'An Email has been sent to the Warehouse', 'success');
        $('.confirm').click(function(){
            window.location.href = './index.php';
        })
    });
    $('#senddontnotify').click(function(e) {
        var sino = '<?php echo $_GET['sino']; ?>'
        completeShippment(sino, "donotify");
        swal('', 'Si Sent Successfully', 'success');
        $('.confirm').click(function(){
            window.location.href = './index.php';
        })
    });
        
    $('#previous').click(function(){
        var sino = '<?php echo $_GET['sino']; ?>'
        var siType = '<?php echo $_GET['type']; ?>'

        window.location.href="index.php?view=documents&sino="+sino+"&type="+siType;
    });

</script>