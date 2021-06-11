$(document).ready(function() {
    brokerList();
    gardenList();
    gradeList();

    $("#gen-broker-cat").click(function(e) {
        var form = {
              saleno: "2021-12",
              broker: "ANJL",
              category: "Main",
              filter:'filter',

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

