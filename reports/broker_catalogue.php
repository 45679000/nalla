<?php
$path_to_root = "../";
$path_to_root1 = "../";
include $path_to_root.'templates/header.php';
include '../views/includes/auction_ids.php';

?>
<style>
  
    .col-lg-10{
        margin: auto !important;

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
            <div class="row">
                <div class="col-md-12">
                <?php
                        $html= '<div class="expanel-heading">
                                    <h3 class="expanel-title">Print Catalogue</h3>
                                </div>
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body p-6">
                            <div class="col-md-12">
                             <div style="heigth:20% !important;" class="expanel expanel-secondary">
                                <div style="heigth:20% !important;" class="expanel-body">
                                    <form  id="brokerCatalog" method="post">
                                        <div class="row justify-content-center">
                                            <div class="col-md-3 well">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">AUCTION</label>
                                                    <select id="saleno" name="saleno" class="form-control" ><small>(required)</small>
                                                        <option disabled="" value="..." selected="">select</option>';
                                                        foreach(loadAuctionArray() as $auction_id){
                                                          $html.= '<option value="'.$auction_id.'">'.$auction_id.'</option>';
                                                      }
                                                 $html.= '

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 well">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">BROKER</label>
                                                    <select id="broker" name="broker" class="form-control well" ><small>(required)</small>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 well">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">CATEGORY</label>
                                                    <select id="category" name="category" class="form-control well" ><small>(required)</small>
                                                        <option disabled="" value="..." selected="">select</option>
                                                        <option value="Main">Main</option>
                                                        <option value="dust">DUST</option>
                                                        <option value="leaf">LEAFY</option>
                                                        <option value="Sec">Sec</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3 well">
                                                <button type="submit" id="gen-broker-cat" class="btn btn-success">Generate</button>
                                            </div>
                                        </div>
                                    </form>
                                  <div id="brokerCatalogue">
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';

                                echo $html;
                ?>
                      </div>
        </div>
</div>
<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../assets/js/common.js"></script>

<script>

$(document).ready(function() {
    $("#gen-broker-cat").click(function(e) {
        e.preventDefault();
                $.ajax({
                    url: "rep_broker.php",
                    type: "POST",
                    data: $("#brokerCatalog").serialize() + "&action=filter",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Customer Updated successfully',
                        });
                       
                    }
                });

      });
    });
</script>