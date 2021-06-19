$(document).ready(function() {
    brokerList();
    gardenList();
    gradeList();

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
    function updateValue(tableName, column, value, id){
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "../ajax/common.php",
            data: {
                table:tableName,
                column: column,
                value:value,
                id:id
            },
        success: function (data) {
            $("#brokerCatalogue").html(data);
        }
        });
    }

});

