<?php
$path_to_root = "../../";
require_once $path_to_root . 'templates/header.php';
?>
<body class="container-fluid">
	<div id="global-loader"></div>
	<div class="page">
		<div class="page-main">
			<div class="my-3 my-md-5">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-lg-12">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">Buying List</h3>
									<form method="post">
										<div class="row justify-content-center">
											<div class="col-md-6 well">
												<div class="form-group form-inline">
													<label class="control-label">Select Action from the list</label>
													<select id="saleno" name="saleno"
														class="form-control select2"><small>(required)</small>
														<option disabled="" value="..." selected=""></option>
													</select>
												</div>
											</div>
										</div>
									</form>
									<div>
									<button id="postBuyingList" class="btn btn-info btn-sm" type="submit" id="confirm"
                                    name="confirm" value="1">Send Buying List TO Finance
									</div>
								</div>
								<div class="text-center">
									<div class="card-body">
										<div id="listBuying" class="table-responsive">
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Add Record  Modal -->
<div class="modal" id="updateStatus">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Shippment Status</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="formData">
                    <div class="form-group">
                        <label for="name">Status</label>
						<select id="statusChange" name="statusChange" class="form-control select2-show-search">
                            <option disabled="" value="..." selected="">select</option>
							<option  value="Received" >Received To Warehouse</option>
							<option  value="Blended">blended</option>
							<option  value="Shipped">Shipped</option>
                        </select>                    
					</div>
                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-success" id="submit">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<!-- Custom Js-->
<script id="url" data-name="../../ajax/common.php" src="../../assets/js/common.js"></script>

<script src="../../assets/js/custom.js"></script>
<script src="../../assets/js/catalogs.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
$(function() {
	maxSaleNo();
	$("#saleno").change(function(){
		var sale_no = $('#saleno option:selected').text();
		buyingSummary(sale_no);
		localStorage.setItem("saleno",sale_no);
	})
	checkActivityStatus(4, localStorage.getItem("saleno"));

	buyingSummary('');
	$("#postBuyingList").click(function(e){
		$.ajax({
			type: "POST",
			dataType: "json",
			data: {
				action: "post-buyinglist",
				saleno: localStorage.getItem("saleno")
				},
			cache: true,
			url: "catalog_action.php",
			success: function (data) {
				Swal.fire({
                icon: 'success',
                title: data.status,
            });
			}
		});
	})

});
function checkActivityStatus(id, saleno){
    var activity;
    var message;
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "../../modules/finance/finance_action.php",
        data: {
            action: "activity",
            id:id,
            saleno:saleno      
        },
        success: function(data) {
            console.log(data[0]);
            message = data[0].details;
            status = data[0].completed;
            activity = data[0].activity_id;
            emailed = data[0].emailed;

            if((activity=="5") && (status=="1")){
                $("#confirmPList").html("confirmed");
                $('#confirmPList').prop('disabled', true);
                $("#editPList").hide();
            }
            if((activity=="5") && (emailed=="1")){
                $("#emailPList").html("Notification Sent");
                $('#emailPList').prop('disabled', true);
            }

        }

    });
}
function maxSaleNo(){
	$.ajax({
        type: "POST",
        dataType: "json",
        data: {
            action: "get-max-saleno"
	        },
        cache: true,
        url: "catalog_action.php",
        success: function (data) {
			localStorage.setItem("saleno",data.sale_no);
		}
	});
}
</script>
</html>