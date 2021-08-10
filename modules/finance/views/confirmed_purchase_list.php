<div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body p-6">
                        <div class="col-md-12">
                            <div class="expanel expanel-secondary">
                           <div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-body text-center">
                                    <form method="post">
                                    <div class="row justify-content-center">
                                        <div class="col-md-3 well">
                                            <div class="form-group form-inline">
                                                <label class="control-label">Select Action from the list</label>
                                                <select id="saleno" name="saleno" class="form-control select2" ><small>(required)</small>
                                                    <option disabled="" value="..." selected="">select</option>
                                                    <?php
                                                        foreach(loadAuctionArray() as $auction_id){
                                                            echo '<option value="'.$auction_id.'">'.$auction_id.'</option>';
                                                        }
                                                   ?>
                                                </select>
                                            </div>
                                        </div>
                            
                                        <div class="col-md-3 well">
                                        <div class="form-group label-floating">

                                        </div>
                                    </div>
                                    </div>
                                </form>
									</div>
								</div>
							</div>
						</div>
                           <div id="purchaseList" class="card">
                                
                           </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
</body>


</html>
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>


<script src="../../assets/plugins/datatable/dataTables.buttons.min.js"></script>
<script src="../../assets/plugins/datatable/jszip.min.js"></script>
<script src="../../assets/plugins/datatable/pdfmake.min.js"></script>
<script src="../../assets/plugins/datatable/vfs_fonts.js"></script>
<script src="../../assets/plugins/datatable/buttons.html5.min.js"></script>
<script src="../../assets/plugins/datatable/buttons.print.min.js"></script>
<script src="../../assets/plugins/select2/select2.full.min.js"></script>

<script>


$(function() {

    $('select').on('change', function() {
         var saleno = $('#saleno').find(":selected").text();
         localStorage.setItem("saleno", saleno);
            var formData = {
                saleno: saleno,
                action: "confirmed-purchase-list"
            };

          $.ajax({
                type: "POST",
                dataType: "html",
                url: "finance_action.php",
                data: formData,
            success: function (data) {
                console.log('Submission was successful.');
                $('#purchaseList').html(data);
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    });
    $('#purchaseListTable').DataTable({
    });


   
    
});
function postToStock(element){     
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "finance_action.php",
            data: {
                action:"approve-purchaselist",
                saleno: localStorage.getItem("saleno")
            },
        success: function (data) {
            Swal.fire({
                            icon: 'success',
                            title: 'Posted To Stock',
                        });
        }
    
    });

}

</script>


    