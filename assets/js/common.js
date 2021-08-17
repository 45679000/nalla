$(document).ready(function() {
    var url = document.getElementById("url").getAttribute("data-name");
    if(url ==undefined){
        url="../ajax/common.php";
    }
    var mark = document.getElementById("mark");
    var broker = document.getElementById("broker");
    var grade = document.getElementById("grade");
    var clientwithcode = document.getElementById("clientwithcode");
    var warehouseLocation = document.getElementById("warehouseLocation");
    var standard = document.getElementById("standard");
    var standard2 = document.getElementById("standard2");
    var saleno = document.getElementById("saleno");
    var payment_terms = document.getElementById("payment_terms");
    var buyer = document.getElementById("buyer");

    if(mark !=undefined){
        gardenList(url);
    }
    if(broker !=undefined){
        brokerList(url);
    }
    if(grade !=undefined){
        gradeList(url);
    }
    if(clientwithcode !=undefined){
        clientWithcodeList(url);
    }
    if(warehouseLocation !=undefined){
        wareHouseLocation(url);
    }
    if(standard !=undefined){
        standardList(url);
    }
    if(standard2 !=undefined){
        standardList(url);
    }
    if(saleno !=undefined){
        saleNo(url);
    }
    if(payment_terms !=undefined){
        paymentTerms(url);
    }
    if(buyer !=undefined){
        buyerList(url);
    }

    $('.select2').select2();

    $("#gen-broker-cat").click(function(e) {
        var form = {
              saleno: $('#saleno').val(),
              broker: $('#broker').val(),
              category: $('#category').val(),
              filter:'filters',

          };
          e.preventDefault();
          postData(form);

      });
    //View Record
    function brokerList() {
        $.ajax({
            url: url,
            type: "POST",
            dataType: "html",
            data: {
                action: "list-brokers"
            },
            success: function(response) {
                $("#broker").html(response);
            }

        });
    }
    
    function gardenList(url) {
        $.ajax({
            url: url,
            type: "POST",
            dataType: "html",
            data: {
                action: "garden-list"
            },
            success: function(response) {
                $("#mark").html(response);
            }

        });
    }
    function gradeList(columnid="grade") {
        $.ajax({
            url: url,
            type: "POST",
            dataType: "html",
            data: {
                action: "grade-list"
            },
            success: function(response) {
                $("#grade").html(response);
                // $("#grade2").html(response);

            }

        });
    }

    function postData(form){
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "rep_broker.php",
            data: form,
        success: function (data) {
            $("#brokerCatalogue").html(data);
        }
        });
    }
    
});
function lotList(){
    $.ajax({
        url: url,
        type: "POST",
        dataType: "html",
        data: {
            action: "lot-list"
        },
        success: function(data) {
            $("#stock_id").html(data);

        }

    });
}
function standardList(){
    $.ajax({
        url: url,
        type: "POST",
        dataType: "html",
        data: {
            action: "standard-list"
        },
        success: function(data) {
            $("#standard").html(data);
            $("#standard2").html(data);

            
        }

    });
    
}

function clientWithcodeList(){
    $.ajax({
        url: url,
        type: "POST",
        dataType: "html",
        data: {
            action: "clients"
        },
        success: function(data) {
            $("#clientwithcode").html(data);

        }

    });
    
}
function wareHouseLocation(){
    $.ajax({
        url: url,
        type: "POST",
        dataType: "html",
        data: {
            action: "warehouseLocation"
        },
        success: function(data) {
            $("#warehouseLocation").html(data);

        }

    });
    
}



function loadAllocated(){
    $.ajax({
        url: "../modules/stock/stock-action.php",
        type: "POST",
        dataType: "html",
        data: {
            action: "stock-allocation"
        },
        success: function(data) {
            $("#allocatedStock").html(data);
            
        }

    });
    
}
function brokerList($path) {
    $.ajax({
        url: $path,
        type: "POST",
        dataType: "html",
        data: {
            action: "list-brokers"
        },
        success: function(response) {
            $("#broker").html(response);
        }

    });
}
function saleNo($path) {
    $.ajax({
        url: $path,
        type: "POST",
        dataType: "html",
        data: {
            action: "sale_no"
        },
        success: function(response) {
            $("#saleno").html(response);
        }

    });
}
function paymentTerms($path){
    $.ajax({
        url: $path,
        type: "POST",
        dataType: "html",
        data: {
            action: "payment-terms"
        },
        success: function(data) {
            $("#payment_terms").html(data);

        }

    });
    
}
function buyerList($path){
    $.ajax({
        url: $path,
        type: "POST",
        dataType: "html",
        data: {
            action: "buyers"
        },
        success: function(data) {
            $("#buyer").html(data);

        }

    });
    
}