$(document).ready(function() {
    brokerList();
    gardenList();
    gradeList()
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
});

mark