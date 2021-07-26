<?php
$path_to_root = "../";
$path_to_root1 = "../";
include $path_to_root . 'templates/header.php';
include $path_to_root1.'includes/auction_ids.php';
include 'rep_broker.php';

?>
<style>
    .col-lg-10 {
        margin: auto !important;

    }
    .frame{
        background-color: white;
        color:white;
    }
    
</style>
<div class="my-3 my-md-5" style="margin-top:-20px;">
    <div class="container-fluid">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reports</li>
            </ol>
        </div>
        <div  class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div  class="expanel expanel-secondary">
                            <div  class="expanel-body">
                                <form id="brokerCatalog" method="post">
                                    <div class="row justify-content-center">
                                        <div class="col-md-3 well">
                                            <div class="form-group label-floating">
                                                <label class="control-label">AUCTION</label>
                                                <select id="saleno" name="saleno" class="form-control"><small>(required)</small>
                                                    <option disabled="" value="..." selected="">select</option>
                                                    <?php
                                                    foreach (loadAuctionArray() as $auction_id) {
                                                        echo '<option value="' . $auction_id . '">' . $auction_id . '</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 well">
                                            <div class="form-group label-floating">
                                                <label class="control-label">BROKER</label>
                                                <select id="broker" name="broker" class="form-control well"><small>(required)</small>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 well">
                                            <div class="form-group label-floating">
                                                <label class="control-label">CATEGORY</label>
                                                <select id="category" name="category" class="form-control well"><small>(required)</small>
                                                    <option disabled="" value="..." selected="">select</option>
                                                    <option value="main">Main</option>
                                                    <option value="dust">DUST</option>
                                                    <option value="leaf">LEAFY</option>
                                                    <option value="sec">Sec</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3 well">
                                            <button type="submit" id="gen-broker-cat" class="btn btn-success">Generate</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id ="catalogPrint" class="col-md-8">
                    <div class="card-body">
                            <div class="dimmer active">
                                <div class="lds-hourglass"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
        <script src="../assets/js/common.js"></script>

        <script>
            $(document).ready(function() {
                $('.dimmer').hide();
                $("#gen-broker-cat").click(function(e) {
                    $('.dimmer').show();
                    e.preventDefault();
                    var saleno = $("#saleno").val();
                    var broker = $("#broker").val();
                    var category = $("#category").val();
                    $("#catalogPrint").html('<iframe class="frame" frameBorder="0" src="rep_broker.php?saleno='+saleno+'&broker='+broker+'&category='+category+'&filter=true" width="80%" height="800px"></iframe>');
                    $('.dimmer').hide();

                });
            });

            $('.frame').ready(function () {
                $('.dimmer').hide();
            });
            $('.frame').load(function () {
                $('.dimmer').show();
            });

        </script>