$(document).ready(function() {
    brokerList();
    gardenList();
    gradeList();
    clientWithcodeList();
    wareHouseLocation();

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
            url: "../ajax/common.php",
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
    
    function gardenList() {
        $.ajax({
            url: "../ajax/common.php",
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
    function gradeList() {
        $.ajax({
            url: "../ajax/common.php",
            type: "POST",
            dataType: "html",
            data: {
                action: "grade-list"
            },
            success: function(response) {
                $("#grade").html(response);
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
        url: "../ajax/common.php",
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
        url: "../ajax/common.php",
        type: "POST",
        dataType: "html",
        data: {
            action: "standard-list"
        },
        success: function(data) {
            $("#standard").html(data);

        }

    });
    
}

function clientWithcodeList(){
    $.ajax({
        url: "../ajax/common.php",
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
        url: "../ajax/common.php",
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