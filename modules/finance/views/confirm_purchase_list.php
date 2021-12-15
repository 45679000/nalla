<div class="col-md-12">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header text-center">
                <div id="notificationId">
                </div>
                <div  class="card">
                    <div id="auctionNumber" class="card-header">
                    </div>
                </div>
            </div>
            <div class="card-body p-6">
                <div class="expanel expanel-secondary">
                    <div class="card">
                        <div class="card-header">
                            <div id="purchaseListactions" class="card-options">
                            </div>
                            <div id="purchaseListCustomOpt" class="custom-options">
                                <button id="confirmPList" class="btn btn-info btn-sm" type="submit" id="confirm"
                                    name="confirm" value="1">
                                    <i class="fa fa-check"></i>Confirm Selected</button>
                            </div>
                        </div>
                        <div style="height:60vH" class="card-body table-responsive">
                            
                            <div id="purchaseList">

                            </div>
                        </div>
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
<script src="../../assets/js/sweet_alert2.js"></script>
<script id="url" data-name="../../ajax/common.php" src="../../assets/js/common.js"></script>


<script>
$(function() {

    unconfirmedSales();
    $("#breadcrumbList").append("<li class='breadcrumb-item active' aria-current='page'>Purchase List</li>");
    $("#confirmPList").hide();
    $("body").on("click", ".confirmLot", function(e) {
            e.preventDefault();
            var lot = $(this).attr('id');
            addLot(lot);
    });
    $("body").on("click", ".unconfirmLot", function(e) {
            e.preventDefault();
            var lot = $(this).attr('id');
            removeLot(lot);
    });
    $("#confirmPList").click(function(e){
        confirmPurchaseList();
    });
    
});
function loadUnconfirmedPurchaseList(saleno){
    // $("#purchaseListactions").remove(); 
    var click = localStorage.getItem("click");
    $.ajax({
            type: "POST",
            dataType: "html",
            url: "finance_action.php",
            data: {
                saleno: saleno,
                action: "unconfirmed-purchase-list"
            },
        success: function(data) {
            $("#confirmPList").show();
            $('#purchaseList').html(data);
            $(document).ready(function() {
                var table = $('#purchaseListTable').DataTable({
                    lengthChange: false,
                    select: true,
                    "pageLength": 100,
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copyHtml5',
                            text: 'COPY<i class="fa fa-clipboard"></i>',
                            titleAttr: 'Copy Paste'
                        },
                        {
                            extend: 'excelHtml5',
                            text: 'EXCEL <i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Excel'
                        },
                        {
                            extend: 'csvHtml5',
                            text: 'CSV <i class="fa fa-file-text"></i>',
                            titleAttr: 'CSV'
                        },
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                            titleAttr: 'PDF'
                        }
                    ],
                    // "scrollCollapse": true,
                });
                 if(click> 0){
                    table.buttons().containers().appendTo('#purchaseListactions');
                 }

            });
        }
    });
                
}

function addLot(lot){
    localStorage.setItem("click", "0");
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "finance_action.php",
            data: {
                action:"add-lot",
                lot:lot
            },
        success: function (data) {
            loadUnconfirmedPurchaseList(localStorage.getItem("saleno"));
            console.log('Submission was successful.');
        }
    
    });
}
function removeLot(lot){
    localStorage.setItem("click", "0");

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "finance_action.php",
            data: {
                action:"remove-lot",
                lot:lot
            },
        success: function (data) {
            loadUnconfirmedPurchaseList(localStorage.getItem("saleno"));
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

function confirmPurchaseList(){     
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
            $(".swal2-confirm").click(function(e){
                window.location.href="./index.php?view=confirmedpplist";
            })
        }
    
    });

}
function unconfirmedSales(){
    $.ajax({
            type: "POST",
            dataType: "json",
            url: "finance_action.php",
            data: {
                action:"get-unconfirmed-auctions"
            },
        success: function (data) {
            for(let i = 0; i<data.length; i++){
                $('#auctionNumber').append('<button onClick = "loadLots(this)" id="'+data[i].sale_no+'"  class="btn btn-primary btn-sm auctionnumber">' +data[i].sale_no+ "  "+ 
                '<span class="badge badge-pill badge-success">'+ 
                "  Lots "+data[i].totalLots+
                "  Pkgs "+data[i].totalPkgs+
                "  Kgs "+data[i].totalKgs+

                '</span></button>');

            }

        }
    });
}
function loadLots(element){
    var saleno = $(element).attr('id');
    localStorage.setItem("saleno", saleno);
    loadUnconfirmedPurchaseList(saleno);
}


</script>
    