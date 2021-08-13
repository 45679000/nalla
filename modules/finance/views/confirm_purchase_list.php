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
                        <div class="card">
                            <div class="card-header">
                                    <div class="card-options">
                                        <button class="btn btn-info btn-sm" onClick="confirmPurchaseList(this)"  type="submit" id="confirm" name="confirm" value="1">Confirm Selected</button>                                    
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="purchaseList" class="card-body"></div>
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

<script>
$(function() {

    $('select').on('change', function() {
         var saleno = $('#saleno').find(":selected").text();
         localStorage.setItem("saleno", saleno);
            var formData = {
                saleno: saleno,
                action: "unconfirmed-purchase-list"
            };
          $.ajax({
                type: "POST",
                dataType: "html",
                url: "finance_action.php",
                data: formData,
            success: function (data) {
                console.log('Submission was successful.');
                $('#purchaseList').html(data);
                $('.table').DataTable({
                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;
            
                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };
            
                        // Total kgs all pages
                        totalkgs = api
                            .column( 10 )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );
            
                        // Total kgs this page
                        pageTotalkgs = api
                            .column( 10, { page: 'current'} )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );

                        // Total pkgs all pages
                        totalpkgs = api
                        .column( 12 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
        
                        // Total pkgs this page
                        pageTotalpkgs = api
                        .column( 12, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
            
                        // Update footer
                        $( api.column( 10 ).footer() ).html(
                            ''+pageTotalkgs +' kgs <br>'+totalkgs+' kgs'
                        );
                        $( api.column( 12 ).footer() ).html(
                            ''+pageTotalpkgs +' pkgs <br>'+totalpkgs+' pkgs'
                        );
                    },
                    "pageLength": 100,
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]
                });
            },
            
        });
    });
    
  
    
});

function addLot(element){
    var lot = $(element).attr("id");
    $(element).html("Remove");

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "finance_action.php",
            data: {
                action:"add-lot",
                lot:lot
            },
        success: function (data) {
            console.log('Submission was successful.');
        }
    
    });
}
function removeLot(element){
    var lot = $(element).attr("id");
    $(element).html("Add");

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "finance_action.php",
            data: {
                action:"remove-lot",
                lot:lot
            },
        success: function (data) {
            console.log('Submission was successful.');
        }
    
    });
}
function updateInvoice(element){
        var lot = $(element).attr("class");
        var value = $(element).text();
        
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "finance_action.php",
            data: {
                action:"update-field",
                lot:lot,
                field:"broker_invoice",
                value:value,
                saleno: localStorage.getItem("saleno")
            },
        success: function (data) {
            console.log('Submission was successful.');
        }
    
    });

}
function updatePkgs(element){
        var lot = $(element).attr("class");
        var value = $(element).text();
        
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "finance_action.php",
            data: {
                action:"update-field",
                lot:lot,
                field:"pkgs",
                value:value,
                saleno: localStorage.getItem("saleno")
            },
        success: function (data) {
            console.log('Submission was successful.');
        }
    
    });

}
function updateKgs(element){
        var lot = $(element).attr("class");
        var value = $(element).text();
        
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "finance_action.php",
            data: {
                action:"update-field",
                lot:lot,
                field:"kgs",
                value:value,
                saleno: localStorage.getItem("saleno")
            },
        success: function (data) {
            console.log('Submission was successful.');
        }
    
    });

}

function updateNet(element){
        var lot = $(element).attr("class");
        var value = $(element).text();
        
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "finance_action.php",
            data: {
                action:"update-field",
                lot:lot,
                field:"net",
                value:value,
                saleno: localStorage.getItem("saleno")
            },
        success: function (data) {
            console.log('Submission was successful.');
        }
    
    });

}
function updateHammer(element){
        var lot = $(element).attr("class");
        var value = $(element).text();
        
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "finance_action.php",
            data: {
                action:"update-field",
                lot:lot,
                field:"sale_price",
                value:value,
                saleno: localStorage.getItem("saleno")
            },
        success: function (data) {
            console.log('Submission was successful.');
        }
    
    });

}

function confirmPurchaseList(element){     
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "finance_action.php",
            data: {
                action:"confirm-purchaselist",
                saleno: localStorage.getItem("saleno")
            },
        success: function (data) {
            Swal.fire({
                icon: 'success',
                title: 'Confirmed',
            });
            location.reload(); 
            console.log('Submission was successful.');
        }
    
    });

}


</script>
    