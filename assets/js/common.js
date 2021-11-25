$(document).ready(function() {
    var url = document.getElementById("url").getAttribute("data-name");
    if(url ==undefined){
        url="../ajax/common.php";
    }
    var filterType = document.getElementById("allFilter");
    var mark = document.getElementById("mark");
    var broker = document.getElementById("broker");
    var grade = document.getElementById("grade");
    var clientwithcode = document.getElementById("clientwithcode");
    var warehouse = document.getElementById("warehouse");
    var standard = document.getElementById("standard");
    var standard2 = document.getElementById("standard2");
    var saleno = document.getElementById("saleno");
    var salenoPRVT = document.getElementById("salenoPRVT");
    var payment_terms = document.getElementById("payment_terms");
    var buyer = document.getElementById("buyer");
    var code = document.getElementById("code");
    var bank_id = document.getElementById("bank_id");
    var material_type = document.getElementById("material_type");

    

    if(filterType !=undefined){
        filterType = "All";
    }

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
    if(warehouse !=undefined){
        warehouses(url);
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
    if(salenoPRVT !=undefined){
        saleNoPrvt(url);
    }
    if(code !=undefined){
        codeList(url);
    }
    if(bank_id !=undefined){
        bankList(url);
    }
    if(material_type !=undefined){
        materialTypes(url)
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
                action: "list-brokers",
                filterType: filterType
            },
            success: function(response) {
                $("#broker").html(response);
            }

        });
    }
    function standardList(){
        $.ajax({
            url: url,
            type: "POST",
            dataType: "html",
            data: {
                action: "standard-list",
                filterType: filterType
    
            },
            success: function(data) {
                $("#standard").html(data);
                $("#standard2").html(data);     
            }
        });
        
    }
    function codeList($path){
        $.ajax({
            url: $path,
            type: "POST",
            dataType: "html",
            data: {
                action: "codes",
                filterType: filterType

            },
            success: function(data) {
                $("#code").html(data);
    
            }
    
        });
        
    }
    
    function gardenList(url) {
        $.ajax({
            url: url,
            type: "POST",
            dataType: "html",
            data: {
                action: "garden-list",
                filterType: filterType

            },
            success: function(response) {
                $("#mark").html(response);
            }

        });
    }
    function saleNo($path) {
        $.ajax({
            url: $path,
            type: "POST",
            dataType: "html",
            data: {
                action: "sale_no",
                filterType: filterType
    
            },
            success: function(response) {
                $("#saleno").html(response);
            }
    
        });
    }
    function saleNoPrvt($path) {
        $.ajax({
            url: $path,
            type: "POST",
            dataType: "html",
            data: {
                action: "sale_no_prvt",
                filterType: filterType
    
            },
            success: function(response) {
                $("#salenoPRVT").html(response);
            }
    
        });
    }
    function gradeList(columnid="grade") {
        $.ajax({
            url: url,
            type: "POST",
            dataType: "html",
            data: {
                action: "grade-list",
                filterType: filterType

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
            action: "list-brokers",
            filterType: filterType

        },
        success: function(response) {
            $("#broker").html(response);
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
function bankList($path){
    $.ajax({
        url: $path,
        type: "POST",
        dataType: "html",
        data: {
            action: "bank_id"
        },
        success: function(data) {
            $("#bank_id").html(data);

        }

    });
}
function materialTypes($path){
    $.ajax({
        url: $path,
        type: "POST",
        dataType: "html",
        data: {
            action: "material_type"
        },
        success: function(data) {
            $("#material_type").html(data);

        }

    });
}


function warehouses($path){
    $.ajax({
        url: $path,
        type: "POST",
        dataType: "html",
        data: {
            action: "warehouse"
        },
        success: function(data) {
            $("#warehouse").html(data);

        }

    });
    
}